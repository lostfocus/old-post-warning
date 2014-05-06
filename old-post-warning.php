<?php
/*
Plugin Name: Old Post Warning
Plugin URI: https://github.com/lostfocus/instagram-embed-fix
Description: Puts a warning on old wordpress posts
Version: 0.1
Author: Dominik Schwind
Author URI: http://lostfocus.de/
License: GPL2
*/

define('OPW_DIR', dirname(__FILE__));
require_once(OPW_DIR.'/opw.php');

function opw_init(){
    $opw = new opw();
    $opw->init();
}

add_action('init', 'opw_init');