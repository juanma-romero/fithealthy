<?php
/**
 * Zoo_Breadcrumbs
 *
 * @package    Zoo_Theme\Lib\Main
 */
final class Zoo_Breadcrumbs
{
    /**
     * Breadcrumb separator
     *
     * @var    string
     */
    private $separator;

    /**
     * Home icon
     *
     * @var    string
     */
    private $home_icon;

    /**
     * Constructor
     */
    function __construct( $home_icon = '',$sep = '')
    {
        $this->separator = $sep ? $sep : '';
        $this->home_icon = $home_icon ?$home_icon : '';
    }

    /**
     * Render
     *
     * @param  object  $query  \WP_Query
     */
    function render(\WP_Query $query)
    {
        if (!empty($this->separator)) {
            $this->separator = '<span role="presentation" class="zoo-breadcrumb-separator"> <i class="' . esc_attr($this->separator) . '"></i></span>';
        } else {
            $this->separator = '<span role="presentation" class="zoo-breadcrumb-separator">&rang;</span>';
        }
        ?><div class="zoo-breadcrumb-container">
            <span>
                <a class="zoo-breadcrumb-url zoo-breadcrumb-home" href="<?php echo esc_url(home_url('/')) ?>">
                    <?php
                        if (!$this->home_icon) {
                            echo wp_strip_all_tags(get_option('blogname'));
                        } else {
                            echo ent2ncr('<i class="' . esc_attr($this->home_icon) . '" role="presentation"></i>');
                        }
                    ?>
                </a>
            </span>
            <?php echo ent2ncr($this->separator) ?>
            <span>
                <?php
                $this->theCrumbs($query) ?>
            </span>
        </div><?php
    }
    /**
     * Compile crumbs
     */
    private function theCrumbs(\WP_Query $query)
    {
    	if ($query->is_category) {
    		return $this->theCatCrumb($query);
        } elseif ($query->is_tag) {
            return $this->theTagCrumb($query);
        } elseif ($query->is_tax) {
            return $this->theTaxCrumb($query);
        } elseif ($query->is_year) {
            return $this->theYearCrumb($query);
        } elseif ($query->is_month) {
            return $this->theMonthCrumb($query);
        } elseif ($query->is_day) {
            return $this->theDayCrumb($query);
        } elseif ($query->is_post_type_archive) {
            return $this->thePostTypeArchiveCrumb($query);
        } elseif ($query->is_page) {
    		return $this->thePageCrumb($query);
    	} elseif ($query->is_author) {
    		return $this->theAuthorCrumb($query);
    	} elseif ($query->is_search) {
    		return $this->theSearchCrumb($query);
    	} elseif ($query->is_404) {
            return $this->the404Crumb($query);
        } elseif ($query->is_single && ('attachment' !== $query->post->post_type)) {
            return $this->thePostCrumb($query);
        } elseif ($query->is_attachment) {
            return $this->theAttachmentCrumb($query);
        } else {
            return $this->theBlog();
        }
    }
    /**
     * Blog crumb
     */
    private function theBlog()
    {
        echo  esc_html__('Blog', 'fona');
    }
    /**
     * Category archive crumb
     */
    private function theCatCrumb(\WP_Query $query, $crumb = '')
    {
        if ($query->queried_object->category_parent) {
            $crumb .= $this->getParentTax($query->post, $query->queried_object->category_parent, $this->getSep() );
        }
        echo ent2ncr($this->getTypeCrumb($query) . $crumb . $label = esc_html__('Categorized as', 'fona') . ': ' . htmlspecialchars($query->queried_object->name, ENT_QUOTES));
    }
    /**
     * Tag archive crumb
     */
    private function theTagCrumb(\WP_Query $query)
    {
        echo ent2ncr($this->getTypeCrumb($query) . esc_html__('Tagged with', 'fona') . ': ' . htmlspecialchars($query->queried_object->name, ENT_QUOTES));
    }
    /**
     * Custom taxonomy archive crumb
     */
    private function theTaxCrumb(\WP_Query $query)
    {
        echo ent2ncr($this->getTypeCrumb($query) . esc_html__('Classified as', 'fona') . ': ' . htmlspecialchars($query->queried_object->name, ENT_QUOTES));
    }
    /**
     * Yearly archive crumb
     */
    private function theYearCrumb(\WP_Query $query)
    {
        echo ent2ncr($this->getTypeCrumb($query) . esc_html__('Posted in', 'fona') . ': ' . $query->query_vars['year']);
    }
    /**
     * Monthly archive crumb
     */
    private function theMonthCrumb(\WP_Query $query)
    {
        $year = $query->query_vars['year'];
        $month = date_i18n( 'F', mktime(0, 0, 0, $query->query_vars['monthnum'], 1) );
        echo ent2ncr($this->getCrumbLink( get_year_link($year), $year ) . $this->getSep() . esc_html__('Posted on', 'fona') . ': ' . $month);
    }
    /**
     * Daily archive crumbs
     */
    private function theDayCrumb(\WP_Query $query)
    {
        $year = $query->query_vars['year'];
        $month = $query->query_vars['monthnum'];
        $yearlink = $this->getCrumbLink( get_year_link($year), $year );
        $localmonth = date_i18n('F', mktime(0, 0, 0, $month, 1) );
        $monthlink = $this->getCrumbLink( get_month_link($year, $month), $localmonth );
        echo ent2ncr($yearlink . $this->getSep() . $monthlink . $this->getSep() . $query->query_vars['day']);
    }
    /**
     * Custom post type archive crumb
     */
    private function thePostTypeArchiveCrumb($query)
    {
        echo ent2ncr($GLOBALS['wp_post_types'][$query->post->post_type]->labels->name);
    }
    /**
     * Author archive crumb
     */
    private function theAuthorCrumb(\WP_Query $query)
    {
        echo esc_html__('Posted by', 'fona') . ': ' . $query->queried_object->display_name;
    }
    /**
     * Single page crumb
     */
    private function thePageCrumb(\WP_Query $query, $crumb = '')
    {
        if ($query->post->post_parent) {
            $parent_ids = array_reverse( array_values($query->post->ancestors) );
            foreach ($parent_ids as $id) {
                $crumb .= $this->getCrumbLink( get_permalink($id), get_the_title($id) ) . $this->getSep();
            }
        }
        $crumb .= htmlspecialchars($query->post->post_title, ENT_QUOTES);
        echo ent2ncr($crumb);
    }
    /**
     * Search results page crumb
     */
    private function theSearchCrumb(\WP_Query $query)
    {
        echo esc_html__('Search results for', 'fona') . ': ' . htmlspecialchars($query->query_vars['s'], ENT_QUOTES);
    }
    /**
     * 404 crumb
     */
    private function the404Crumb(\WP_Query $query)
    {
        echo esc_html__('404 Not Found', 'fona');
    }
    /**
     * Single post crumb
     */
    private function thePostCrumb(\WP_Query $query, $tax_ids = array(), $crumb = '')
    {
        $taxonomies = get_the_terms( $query->post, $this->getHierTax($query->post) );
        if ($taxonomies) {
            foreach ($taxonomies as $tax_obj) {
                $tax_ids[] = $tax_obj->term_id;
            }
            rsort($tax_ids); // To get latest hierarchical taxonomy.
            $crumb .= $this->getParentTax( $query->post, $tax_ids[0], $this->getSep() );
        }
        echo ent2ncr($this->getTypeCrumb($query) . $crumb . htmlspecialchars($query->post->post_title, ENT_QUOTES));
    }
    /**
     * Single attachment crumb
     */
    private function theAttachmentCrumb(\WP_Query $query, $crumb = '')
    {
        if ($query->post->post_parent) {
            $parent_post = \WP_Post::get_instance($query->post->post_parent);
            $hierar_tax = $this->getHierTax($parent_post);
            $terms = get_the_terms($parent_post, $hierar_tax);
            if ($terms) {
                $crumb .= $this->getCrumbLink( get_term_link($terms[0]->term_id), $terms[0]->name ) . $this->getSep();
            }
            $crumb .= $this->getCrumbLink( get_permalink($query->post->post_parent), get_the_title($query->post->post_parent) ) . $this->getSep();
        }
        $crumb .= htmlspecialchars($query->post->post_title, ENT_QUOTES);
        echo ent2ncr($this->getTypeCrumb($query) . $crumb);
    }
    /**
     * Get crumb link
     *
     * @param   string  $url     The value of href attribute.
     * @param   string  $anchor  The anchor text of crumb link.
     *
     * @return  string
     */
    private function getCrumbLink($url, $anchor)
    {
        return '<a class="zoo-breadcrumb-url" href="' . $url . '">' . htmlspecialchars($anchor, ENT_QUOTES) . '</a>';
    }
    /**
     * Get combo separator
     *
     * @return  string
     */
    private function getSep()
    {
        return '</span> ' . $this->separator . ' <span>';
    }
    /**
     * Get type crumb
     *
     * @return  string
     */
    private function getTypeCrumb(\WP_Query $query)
    {
        if ( empty($query->posts) ) {
            return '';
        }

        $post_type = $query->post->post_type;
        $page_for_posts = get_option('page_for_posts');
        if ( empty($GLOBALS['wp_post_types'][$post_type]) || ( ('post' === $post_type) && !$page_for_posts) ) {
            return;
        }
        $post_type_label = ('post' === $post_type) ? get_the_title($page_for_posts) : $GLOBALS['wp_post_types'][$post_type]->label;
        $post_type_url = ('post' === $post_type) ? get_permalink($page_for_posts) : get_post_type_archive_link($post_type);

        return $this->getCrumbLink($post_type_url, $post_type_label) . $this->getSep();
    }
    /**
     * Get the first hierarchical taxonomy
     *
     * @return  string
     */
    private function getHierTax(\WP_Post $post)
    {
        $taxonomies = (array)$GLOBALS['wp_taxonomies'];
        foreach ($taxonomies as $tax_name => $tax_obj) {
            if ( array_intersect( (array)$post->post_type, (array)$tax_obj->object_type) && $taxonomies[$tax_name]->hierarchical ) {
                return $tax_name;
            } else {
                $tax = false;
            }
        }
        return $tax;
    }
    /**
     * Get parent crumb(s) of a taxonomy recursively
     *
     * @param  int  $id  Term's ID.
     * @param  array  $visited  Visited terms.
     *
     * @return  string
     */
    private function getParentTax(\WP_Post $post, $id, $sep = '/', &$visited = array(), $chain = '')
    {
        $hierar_tax = $this->getHierTax($post);
        $parent_term = \WP_Term::get_instance($id, $hierar_tax);
        if ( ($parent_term instanceof WP_Error) || !$parent_term ) return;
        if ( $parent_term->parent && !in_array($parent_term->parent, $visited) ) {
            $visited[] = $parent_term->parent;
            $chain .= $this->getParentTax($post, $parent_term->parent, $this->getSep(), $visited);
        }
        $term_url = get_term_link($parent_term, $hierar_tax);
        $chain .= $this->getCrumbLink($term_url, $parent_term->name) . $this->getSep();

        return $chain;
    }
}
