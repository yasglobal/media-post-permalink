<?php
/**
 * @package MediaPostPermalink\Admin
 */

final class Media_Post_Permalink_Admin {

  /**
   * Initializes WordPress hooks.
   */
  function __construct() {
    add_action( 'admin_menu', array( $this, 'admin_menu' ) );
  }
  
  /**
   * Permalink Settings Menu
   */
  public static function admin_menu() {
	  add_menu_page( 'Media Post Permalink Settings', 'Media Permalinks',
      'administrator', 'media-post-permalink-settings',
      array( $this, 'settings_page' )
    );
    add_submenu_page( 'media-post-permalink-settings',
      'Media Post Permalink Settings', 'Media Permalinks',
      'administrator', 'media-post-permalink-settings',
      array( $this, 'settings_page' )
    );
    add_submenu_page( 'media-post-permalink-settings',
      'About Media Post Permalink', 'About', 'install_plugins',
      'media-post-permalink-about-plugins', array( $this, 'about_plugin' )
    );

    add_filter( 'plugin_action_links_' . MEDIA_POST_PERMALINK_BASENAME,
      array( $this, 'settings_link' )
    );

    add_action( 'admin_init', array( $this, 'mpp_privacy_policy' ) );
  }

  /**
   * This Function Calls the another Function which shows
   * the Settings Page for Attachments.
   *
   * @access public
   * @since 0.2
   *
   * @return void
   */
  public function settings_page() {
    require_once(
      MEDIA_POST_PERMALINK_PATH . 'admin/class-media-post-permalink-settings.php'
    );
    new Media_Post_Permalink_Settings();
    add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
  }

  /**
   * Add About Plugins Page.
   *
   * @access public
   * @since 0.2
   *
   * @return void
   */
  public function about_plugin() {
    require_once(
      MEDIA_POST_PERMALINK_PATH . 'admin/class-media-post-permalink-about.php'
    );
    new Media_Post_Permalink_About();
    add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
  }

  /**
   * Add Plugin Support and Follow Message in the footer of Admin Pages.
   *
   * @access public
   * @since 0.2
   *
   * @return string
   */
  public function admin_footer_text() {
    $footer_text = sprintf(
      __( 'Media Post Permalink version %s by <a href="%s" title="Sami Ahmed Siddiqui Website" target="_blank">Sami Ahmed Siddiqui</a> - <a href="%s" title="Support forums" target="_blank">Support forums</a> - Follow on Twitter: <a href="%s" title="Follow Sami Ahmed Siddiqui on Twitter" target="_blank">Sami Ahmed Siddiqui</a>', 'media-post-permalink' ),
      MEDIA_POST_PERMALINK_PLUGIN_VERSION, 'https://www.yasglobal.com',
      'https://wordpress.org/support/plugin/media-post-permalink',
      'https://twitter.com/samisiddiqui91'
    );

    return $footer_text;
  }

  /**
   * Plugin About, Contact and Settings Link on the Plugin Page under
   * the Plugin Name.
   *
   * @access public
   * @since 0.2
   *
   * @param array $links
   *   Contains the Plugin Basic Link (Activate/Deactivate/Delete)
   *
   * @return array $links
   *   Returns the Plugin Basic Links and added some custome link for Settings,
   *   Contact and About.
   */
  public function settings_link( $links ) {
    $about = sprintf(
      __( '<a href="%s" title="About">About</a>', 'media-post-permalink' ),
      'admin.php?page=media-post-permalink-about-plugins'
    );
    $contact = sprintf(
      __( '<a href="%s" title="Contact">Contact</a>', 'media-post-permalink' ),
      'https://www.yasglobal.com/#request-form'
    );
    $settings_link = sprintf(
      __( '<a href="%s" title="Settings">Settings</a>', 'media-post-permalink'
      ), 'admin.php?page=media-post-permalink-settings'
    );
    array_unshift( $links, $settings_link );
    array_unshift( $links, $contact );
    array_unshift( $links, $about );

    return $links;
  }

  /**
   * Add Privacy Policy about the Plugin.
   *
   * @access public
   * @since 0.2.0
   *
   * @return void
   */
  public function mpp_privacy_policy() {
    if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
      return;
    }
    $content = sprintf(
      __( 'This plugin doesn\'t collects/store any user related information.' .
        'To have any kind of further query please feel free to' .
        '<a href="%s" target="_blank">contact us</a>.',
        'media-post-permalink'
      ), 'https://www.yasglobal.com/#request-form'
    );
    wp_add_privacy_policy_content( 'Media Post Permalink',
      wp_kses_post( wpautop( $content, false ) )
    );
  }
}
