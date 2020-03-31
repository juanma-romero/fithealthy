#!/bin/bash
#
# Script to deploy from Github to WordPress.org Plugin Repository
# A modification of Dean Clatworthy's deploy script as found here: https://github.com/deanc/wordpress-plugin-git-svn
# The difference is that this script lives in the plugin's git repo & doesn't require an existing SVN repo.
# Source: https://github.com/thenbrent/multisite-user-management/blob/master/deploy.sh

#prompt for plugin slug
echo -e "Plugin Slug: \c"
read PLUGINSLUG

# main config, set off of plugin slug
CURRENTDIR=`pwd`
# CURRENTDIR="$CURRENTDIR/$PLUGINSLUG"
MAINFILE="$PLUGINSLUG.php" # this should be the name of your main php file in the wordpress plugin

if [ ! -f $MAINFILE ]; then
    MAINFILE="index.php"
fi

# git config
GITPATH="$CURRENTDIR" # this file should be in the base of your git repository

# svn config
SVNPATH="/tmp/$PLUGINSLUG" # path to a temp SVN repo. No trailing slash required and don't add trunk.
SVNURL="HTTP://plugins.svn.wordpress.org/$PLUGINSLUG/" # Remote SVN repo on WordPress.org, with no trailing slash
SVNUSER="tomspocket" # your svn username

# Let's begin...
echo ".........................................."
echo
echo "Preparing to deploy WordPress plugin"
echo
echo ".........................................."
echo

echo ".........................................."
echo
echo "REMEMBER!!"
echo
echo "Don't change the lines: "
echo
echo "'Requires at least' and 'Tested up To' on readme.txt unless you have tested with the version you are changing to."
echo
echo ".........................................."
echo

# Check version in readme.txt is the same as plugin file
README_VERSION=`grep "^Stable tag" $GITPATH/readme.txt | awk -F' ' '{print $3}'`
README_LINENUMBER=`grep -nr "^Stable tag" $GITPATH/readme.txt | awk -F':' '{print $1}'`
echo "readme version: $README_VERSION"

MAINFILE_VERSION=`grep "^Version" $GITPATH/$MAINFILE | awk -F' ' '{print $2}'`
MAINFILE_LINENUMBER=`grep -nr "^Version" $GITPATH/$MAINFILE | awk -F':' '{print $1}'`
echo "$MAINFILE version: $MAINFILE_VERSION"

PLUGINFILE_LINENUMBER=`grep -nr 'protected $version' $GITPATH/lib/Plugin.php | awk -F':' '{print $1}'`

echo "Old Version: [$README_VERSION] - What is the new version of the plugin?"
read NEWVERSION

echo "Updating versions..."
# Changing the version on readme.txt
awk -v newversion="Stable tag: ${NEWVERSION}" 'BEGIN { re = "Stable tag: [0-9].[0-9].?[0-9]{0,2}" } { sub(re, newversion); print}' $GITPATH/readme.txt > $GITPATH/tmp.txt
rm $GITPATH/readme.txt && mv $GITPATH/tmp.txt $GITPATH/readme.txt
# Changing the version on index.php
perl -pi -e "s/[0-9]\.[0-9]\.?[0-9]{0,2}/$NEWVERSION/g" "$GITPATH/${MAINFILE}"
# Changing the version on Plugin.php
perl -pi -e "s/[0-9]\.[0-9]\.?[0-9]{0,2}/$NEWVERSION/g" "$GITPATH/lib/Plugin.php"

if [ "$README_VERSION" != "$MAINFILE_VERSION" ]; then echo "Versions don't match. Exiting...."; exit 1; fi
echo "Versions match in readme.txt and PHP file. Let's proceed..."

cd $GITPATH
echo -e "Enter a commit message for this new version: \c"
read COMMITMSG
git commit -am "$COMMITMSG"

echo "Tagging new version in git"
git tag -a "$NEWVERSION" -m "Tagging version $NEWVERSION"

echo "Pushing latest commit to origin, with tags"
git push origin master
git push origin master --tags

echo "Building asset files"
npm run build

echo
echo "Creating local copy of SVN repo ..."
svn co $SVNURL $SVNPATH

echo "Ignoring github specific files and deployment script"
cp -R .svnignore $SVNPATH/trunk
cd $SVNPATH/trunk
svn propset svn:ignore -F .svnignore .

#export git -> SVN
echo "Exporting the HEAD of master from git to the trunk of SVN"
cd $GITPATH
git checkout-index -a -f --prefix=$SVNPATH/trunk/

echo "Copying js build folder to SVN trunk."
cp -R dist $SVNPATH/trunk/

echo "Changing directory to SVN and committing to trunk"
cd $SVNPATH/trunk/

# Add all new files that are not set to be ignored
svn status | grep -v "^.[ \t]*\..*" | grep "^?" | awk '{print $2}' | xargs svn add
svn commit --username=$SVNUSER -m "$COMMITMSG"

echo "Creating new SVN tag & committing it"
cd $SVNPATH
svn copy trunk/ tags/$NEWVERSION/
cd $SVNPATH/tags/$NEWVERSION
svn commit --username=$SVNUSER -m "Tagging version $NEWVERSION"

echo "Removing temporary directory $SVNPATH"
rm -fr $SVNPATH/

echo "*** FIM :-) Let's keeping rock!! ***"
