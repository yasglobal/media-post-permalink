<?php
/**
 * Plugin Name: Media Post Permalink
 * Plugin URI: https://wordpress.org/plugins/media-post-permalink/
 * Description: Media Post Permalink is simply the easiest solution to separate your media/attachment Permalinks and make it User Friendly.
 * Version: 0.1
 * Author: Sami Ahmed Siddiqui
 * Author URI: https://www.yasglobal.com/web-design-development/wordpress/media-post-permalink/
 * License: GPLv3
 *
 * Text Domain: media-post-permalink
 * Domain Path: /languages/
 *
 * @package MediaPostPermalink
 */

 /**
 *  Media Post Permalink - Separate Permalinks for Attachments Plugin
 *  Copyright (C) 2017-2018, Sami Ahmed Siddiqui <sami.siddiqui@yasglobal.com>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Make sure we don't expose any info if called directly
if ( ! defined( 'ABSPATH' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

final class Media_Post_Permalink {

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->setup_constants();
    $this->includes();
  }

  /**
   * Setup plugin constants
   *
   * @access private
   * @since 0.2
   *
   * @return void
   */
  private function setup_constants() {
    if ( ! defined( 'MEDIA_POST_PERMALINK_FILE' ) ) {
      define( 'MEDIA_POST_PERMALINK_FILE', __FILE__ );
    }

    if( ! defined( 'MEDIA_POST_PERMALINK_PLUGIN_VERSION' ) ) {
      define( 'MEDIA_POST_PERMALINK_PLUGIN_VERSION', '0.2' );
    }

    if( ! defined( 'MEDIA_POST_PERMALINK_PATH' ) ) {
      define( 'MEDIA_POST_PERMALINK_PATH',
        plugin_dir_path( MEDIA_POST_PERMALINK_FILE )
      );
    }

    if ( ! defined( 'MEDIA_POST_PERMALINK_BASENAME' ) ) {
      define( 'MEDIA_POST_PERMALINK_BASENAME',
        plugin_basename( MEDIA_POST_PERMALINK_FILE )
      );
    }
  }

  /**
   * Include required files
   *
   * @access private
   * @since 0.2
   *
   * @return void
   */
  private function includes() {
    require_once(
      MEDIA_POST_PERMALINK_PATH . 'frontend/class-media-post-permalink.php'
    );
    $mpp_frontend = new Media_Post_Permalink_Frontend();
    $mpp_frontend->init();

    if ( is_admin() ) {
      require_once(
        MEDIA_POST_PERMALINK_PATH . 'admin/class-media-post-permalink-admin.php'
      );
      new Media_Post_Permalink_Admin();

      add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
    }
  }

  /**
   * Loads the plugin language files
   *
   * @access public
   * @since 0.2
   *
   * @return void
   */
  public function load_textdomain() {
    load_plugin_textdomain( 'media-post-permalink', FALSE,
      basename( dirname( MEDIA_POST_PERMALINK_FILE ) ) . '/languages/'
    );
  }
}

new Media_Post_Permalink();
