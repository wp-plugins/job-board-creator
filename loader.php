<?php

/**

 * Plugin Name: Job Board Creator
 * Description: Job Board Platform for WordPress
 * Plugin URI: http://jbcreator.com
 * Version: 1.0.4
 * License: GPL
 * Text Domain: jbc

 */
 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

define ('JBC_DIR', plugin_dir_path( __FILE__ ));


require_once('inc/relative-timestamp.php');
require_once('inc/jobs-tax.php');
require_once('inc/jobs-cpt.php');
require_once('inc/tax-metadata.php');
require_once('inc/transactions-cpt.php');
require_once('inc/wp-advanced-search/wpas.php');
require_once('inc/post-counter.php');
require_once('inc/read-unread.php');
require_once('inc/applications.php');
require_once('inc/widgets.php');
require_once('inc/settings/options-framework.php');
require_once('inc/options.php');
require_once('inc/wp-cron.php');
require_once('inc/activation/default-pages.php');
require_once('inc/mail/defaults.php');

require_once('inc/shortcodes.php');
require_once('inc/profile-fields.php');
require_once('inc/restrictions.php');

register_activation_hook( __FILE__, 'jbc_activate' );
