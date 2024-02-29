<?php
/* EDIT LOGO LOGIN */
remove_action('login_head', 'virgin_my_custom_login_logo');
add_action('login_head', 'virginChild_my_custom_login_logo');
function virginChild_my_custom_login_logo() {
    echo '<style type="text/css">
    h1 a { background-image:url('.get_stylesheet_directory_uri().'/img/logo.webp) !important; }
    </style>';
}
add_action('login_head', 'virginChild_my_custom_login_logo', 20);

/* API */
require_once('inc/api.php');