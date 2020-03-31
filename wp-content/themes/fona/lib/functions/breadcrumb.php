<?php
/**
 * Breadcrumb functionality
 *
 * @package    Lib\Functions
 */

/**
* zoo_breadcrumbs
*/
if (!function_exists('zoo_breadcrumbs'))
{
    function zoo_breadcrumbs($separator = '', $icon_class = '')
    {
        $breadcrumb = new Zoo_Breadcrumbs($separator, $icon_class);

        $breadcrumb->render($GLOBALS['wp_query']);
    }
}
