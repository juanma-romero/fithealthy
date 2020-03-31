<?php
/**
 * Comments
 *
 * @package     Zoo Theme
 * @version     1.0.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 Zootemplate
 * @license     GPL v2
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
/* DISPLAY THE COMMENTS
================================================== */
?>


<?php if (have_comments()) : ?>
    <div id="comments-list" class="comments post-comments">
        <div class="container">
            <div class="col-xs-12 col-sm-9">
                <h4 class="title-block">
                    <?php comments_number(esc_html__('0 Comments', 'fona'), esc_html__('1 Thought', 'fona'), esc_html__('% Thoughts', 'fona'));
                    echo esc_html__(' on', 'fona');
                    echo esc_html(' "') . get_the_title() . esc_html('"');
                    ?>
                </h4><?php
                $ping_count = $comment_count = 0;
                foreach ($comments as $comment)
                    get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
                if (!empty($comments_by_type['comment'])) : ?>
                    <ol class="wrap-comments">
                        <?php
                        wp_list_comments(array(
                            'type' => 'pings',
                            'short_ping' => true,
                            'callback' => 'zoo_custom_pings',
                        ));
                        wp_list_comments(array(
                            'type' => 'comment',
                            'callback' => 'zoo_custom_comments',
                        )); ?>
                    </ol>
                    <?php $total_pages = get_comment_pages_count();
                    if ($total_pages > 1) : ?>
                        <div id="comments-nav-below" class="comments-navigation">
                            <div class="wrap-pagination clearfix">
                                <?php paginate_comments_links(array('type' => 'list', 'prev_text' => '<i class="cs-font clever-icon-prev-arrow-1"></i>',
                                    'next_text' => '<i class="cs-font clever-icon-next-arrow-1"></i>')); ?></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif ?>
<div class="wrap-comment-form">
    <div class="container">
        <div class="col-xs-12 col-sm-9">
            <div class="row">
                <?php

                /* COMMENT ENTRY FORM
                ================================================== */
                $req = get_option('require_name_email');
                $aria_req = ($req ? " aria-required='true'" : '');
                $zoo_comment_args = array(
                    'fields' => apply_filters('comment_form_default_fields', array(
                        'author' => '<div class="wrap-text-field col-xs-12 col-sm-4"><label class="label-pleaceholder">' . esc_html__('Your name', 'fona') . '<span class="required">*</span></label><input id="author"  class="ipt text-field" name="author" aria-required="true" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /><span class="line"></span></div>',
                        'email' => '<div class="wrap-text-field col-xs-12 col-sm-4"><label class="label-pleaceholder">' . esc_html__('Email', 'fona') . '<span  class="required">*</span></label><input id="email"  class="ipt text-field" name="email" aria-required="true" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" ' . $aria_req . ' /><span class="line"></span></div>',
                        'url' => '<div class="wrap-text-field  col-xs-12 col-sm-4"><label class="label-pleaceholder">' . esc_html__('Website', 'fona') . '</label><input id="url"  class="ipt text-field" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '"/><span class="line"></span></div>',
                    )),
                    'comment_field' => '<div class="wrap-text-field col-xs-12"><label class="label-pleaceholder">' . esc_html__('Comment', 'fona') . '<span  class="required">*</span></label><textarea id="comment" class="textarea text-field"  name="comment" cols="45" rows="8"  aria-required="true"></textarea><span class="line"></span> </div>',
                    'class_submit' => 'btn btn-submit',
                    'label_submit' => esc_attr__('Post Comment', 'fona'),
                    'comment_notes_after'=>'<div class="wrap-text-field gdpr-consent col-xs-12">'.zoo_gdpr_consent().'</div>'
                );
                comment_form($zoo_comment_args);
                ?>
            </div>
        </div>
    </div>
</div>