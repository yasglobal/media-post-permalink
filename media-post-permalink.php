<?php 

/**
 * @package MediaPostPermalink\Main
 */

/**
 * Plugin Name: Media Post Permalink
 * Plugin URI: https://wordpress.org/plugins/media-post-permalink/
 * Description: Media Post Permalink is simply the easiest solution to separate your media/attachment Permalinks and make it User Friendly.
 * Version: 0.1
 * Donate link: https://www.paypal.me/yasglobal
 * Author: Sami Ahmed Siddiqui
 * License: GPL v3
 */

/**
 *  Media Post Permalink Plugin
 *  Copyright (C) 2017, Sami Ahmed Siddiqui <sami.siddiqui@yasglobal.com>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.

 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.

 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Make sure we don't expose any info if called directly
if( !defined('ABSPATH') ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

if( !function_exists("add_action") || !function_exists("add_filter") ) {
  header( 'Status: 403 Forbidden' );
  header( 'HTTP/1.1 403 Forbidden' );
  exit();
}

if( !defined('MEDIA_POST_PERMALINK_PLUGIN_VERSION') ) {
  define('MEDIA_POST_PERMALINK_PLUGIN_VERSION', '0.1');
}

if( !defined('MEDIA_POST_PERMALINK__PLUGIN_DIR') ) {
  define('MEDIA_POST_PERMALINK__PLUGIN_DIR', plugin_dir_path( __FILE__ ));
}

if( is_admin() ) {
  require_once(MEDIA_POST_PERMALINK__PLUGIN_DIR.'admin/class.media-post-permalink.php');   
  add_action( 'init', array( 'Media_Post_Permalink_Admin', 'init' ) );

  $plugin = plugin_basename(__FILE__); 
  add_filter( "plugin_action_links_$plugin", "media_post_permalink_settings_link" );
}

function media_post_permalink_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=media-post-permalink-settings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

function media_post_permalink_change_postname($media_post) {
  $media_post_settings = unserialize( get_option('media_post_permalink_settings') );

  $change_post_name = $media_post['post_name'];
  if(empty($change_post_name)) {
    $change_post_name = $media_post['post_title'];
  } 

  if(isset($media_post_settings['post_prefix']) && !empty($media_post_settings['post_prefix']) && strpos($change_post_name, $media_post_settings['post_prefix']) !== 0) {
    $change_post_name = $media_post_settings['post_prefix'] .'-'. $change_post_name;
  } 
  
  $check_post_suffix  = strlen($media_post_settings['post_suffix']);
  if(isset($media_post_settings['post_suffix']) && !empty($media_post_settings['post_suffix']) && $check_post_suffix > 0 && substr($change_post_name, -$check_post_suffix) != $media_post_settings['post_suffix']) {
    $change_post_name = $change_post_name .'-'. $media_post_settings['post_suffix'];
  }
  require_once(MEDIA_POST_PERMALINK__PLUGIN_DIR.'admin/class.media-post-permalink.php');
  if(isset($media_post_settings['user_friendly']) && $media_post_settings['user_friendly'] == "on") {
    $change_post_name = Media_Post_Permalink_Admin::media_post_permalink_sanitize($change_post_name, "on");
  } else {
    $change_post_name = Media_Post_Permalink_Admin::media_post_permalink_sanitize($change_post_name, "off");
  }

  if( $change_post_name != $media_post['post_name'] ) {
    global $wpdb;
    $check_existing_name = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_name = '".$change_post_name."' LIMIT 1");
    if( !empty($check_existing_name) ) {
      $i = 2;
      while(1) {
        $change_post_name_permalink = $change_post_name.'-'.$i;
        $check_existing_name = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_name = '".$change_post_name_permalink."' LIMIT 1");
        if(empty($check_existing_name)) {
          break;
        }
        $i++;
      }
      $change_post_name = $change_post_name_permalink;
    }
    $media_post['post_name'] = $change_post_name;
  }

  if(isset($media_post_settings['post_parent']) && $media_post_settings['post_parent'] == "on") {
    $media_post['post_parent'] = 0;
  }

  return $media_post;
}
add_filter('wp_insert_attachment_data', 'media_post_permalink_change_postname');
