<?php
//mimic the actual admin-ajax
define('DOING_AJAX', true);

if (!isset($_POST['action']) || !isset($_POST['abspath'])) {
    exit('-1');
}

//make sure you update this line
//to the relative location of the wp-load.php
$ABSPATH = rtrim(realpath($_POST['abspath']), DIRECTORY_SEPARATOR);

if (file_exists($ABSPATH . DIRECTORY_SEPARATOR . 'wp-load.php')) {
    require_once $ABSPATH . DIRECTORY_SEPARATOR . 'wp-load.php';
} else {
    exit(0);
}

//Typical headers
header('Content-Type: text/html');
send_nosniff_header();

//Disable caching
header('Cache-Control: no-cache');
header('Pragma: no-cache');

$action = esc_attr(trim($_POST['action']));

//A bit of security
$allowed_actions = array(
    'async_adaptive_images',
);

if (in_array($action, $allowed_actions, true)) {
    if(is_user_logged_in()) {
        do_action('zoo_ajax_'.$action);
    } else {
        do_action('zoo_ajax_nopriv_'.$action);
    }
} else {
    exit(0);
}
