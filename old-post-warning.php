<?php
/*
Plugin Name: Old Post Warning
Plugin URI: https://github.com/lostfocus/instagram-embed-fix
Description: Embedding Instagram posts is broken at the moment. This plugin provides a temporary and dirty solution.
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