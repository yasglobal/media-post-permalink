<?php

/**
 * @package MediaPostPermalink\Admin
 */

class Media_Post_Permalink_Admin {
  
  private static $initiated = false;

  /**
	 * Initializes WordPress hooks
	 */
  public static function init() {
    if ( ! self::$initiated ) {
			self::$initiated = true;

      add_action( 'admin_menu', array('Media_Post_Permalink_Admin', 'media_post_permalink_menu') );
		}
  }
  
  /**
   * Permalink Settings Menu
   */
  public static function media_post_permalink_menu() {
	  add_menu_page('Media Post Permalink Settings', 'Media Permalinks', 'administrator', 'media-post-permalink-settings', array('Media_Post_Permalink_Admin', 'media_post_permalink_settings_page'));
  }

  /**
   * Permalink Setting Page
   */
  public static function media_post_permalink_settings_page() {
    if ( !current_user_can( 'administrator' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

    if( isset($_POST['submit']) ) {
      $user_friendly_enable = "off";
      if($_POST['user_friendly'] == "on") {
        $user_friendly_enable = "on";
      }
      $media_post_permalink_settings =  array(
        'post_prefix'  =>  Media_Post_Permalink_Admin::media_post_permalink_sanitize($_POST['post_name_prefix'], $user_friendly_enable),
        'post_suffix'  =>  Media_Post_Permalink_Admin::media_post_permalink_sanitize($_POST['post_name_suffix'], $user_friendly_enable),
        'post_parent'  =>  $_POST['post_parent'],
        'user_friendly'  =>  $_POST['user_friendly'],
      );
      update_option('media_post_permalink_settings', serialize( $media_post_permalink_settings ) );
    }
    $media_post_settings = unserialize( get_option('media_post_permalink_settings') );
    
    $media_post_prefix = "";
    $media_post_suffix = "";
    $parent_post_checked = "";
    $user_friendly_checked = "";
    if(isset($media_post_settings['post_prefix']) && !empty($media_post_settings['post_prefix'])) {
      $media_post_prefix = $media_post_settings['post_prefix'];
    }
    if(isset($media_post_settings['post_suffix']) && !empty($media_post_settings['post_suffix'])) {
      $media_post_suffix = $media_post_settings['post_suffix'];
    }
    if(isset($media_post_settings['post_parent']) && !empty($media_post_settings['post_parent'])) {
      $parent_post_checked = "checked";
    }
    if(isset($media_post_settings['user_friendly']) && !empty($media_post_settings['user_friendly'])) {
      $user_friendly_checked = "checked";
    }
    wp_enqueue_style( 'style', plugins_url('/css/admin-style.min.css', __FILE__) );
    ?>
    <div class="wrap">
    <h2>Media Post Permalink Settings</h2>
    <div>Make your Media/Attachment Post Permalinks customize so, it doesn't conflict with your future/planned page permalinks.</div>
    <form enctype="multipart/form-data" method="POST" action="" id="media-post-permalink">
      <table class="media-post-admin-table">
          <caption>Post Permalink Changes <b>(Optional)</b></caption>
          
          <tr>
            <th><label for="post-prefix">Post Prefix :</label></th>
            <td>
              <input type="text" name="post_name_prefix" id="post_prefic_name" class="regular-text" value="<?php echo $media_post_prefix; ?>" />
              <small>Example: media-prefix</small>
            </td>
          </tr>
          <tr>
            <th><label for="post-suffix">Post Suffix :</label></th>
            <td>
              <input type="text" name="post_name_suffix" id="post_suffix_name" class="regular-text" value="<?php echo $media_post_suffix; ?>" />
              <small>Example: media-suffix</small>
            </td>
          </tr>           
        </table>
        <table class="media-post-admin-table">
          <caption>Parent Post <b>(Recommended)</b></caption>
          <tbody>
            <tr>
              <td class="extra-space"></td>
              <td><input type="checkbox" name="post_parent" value="on" <?php echo $parent_post_checked; ?> /><strong>Don't Attach the Media with any Post</strong><br><small>When you upload the Featured Image in Post, That post becomes the Parent Post of the Media or in other words that media would attach to the respective post.</small></td>
            </tr>
          </tbody>
        </table>
        <table class="media-post-admin-table">
          <caption>Make URL User-Friendly <b>(Recommended)</b></caption>
          <tbody>
            <tr>
              <td class="extra-space"></td>
              <td><input type="checkbox" name="user_friendly" value="on" <?php echo $user_friendly_checked; ?> /><strong>Replaces UnderScore(_) with Dash(-)</strong><br><small>This check will replace all the underscore with dash in the permalink. According to SEO, Underscore should not be included in the URL.</small></td>
            </tr>
          </tbody>
        </table>
        <p><strong>Note:</strong> Don't use special characters. You can only use Numeric, Alphabets, Dash(<b>-</b>) and underscore(<b>_</b>). If you used some other keywords Like Plus(<b>+</b>), Slash(<b>/</b>) etc, it's removed automatically. Underscore can be used but it should not be used as per SEO.</p>
      <?php submit_button(); ?>
    </form>
    </div>
    <?php
  }
  
  /**
   * Sanitize the String(Make the CAPITAL letters to SMALL, Remove special characters, Replace Undersocre with Dash )
   */ 
  public static function media_post_permalink_sanitize($sanitize_string, $user_friendly) {
    $sanitize_string = strtolower($sanitize_string);
    $sanitize_string = preg_replace("/[^a-z0-9_\s-]/", "", $sanitize_string);
    $sanitize_string = preg_replace("/[\s-]+/", " ", $sanitize_string);
    if($user_friendly == "on") {
      $sanitize_string = preg_replace("/[\s_]/", "-", $sanitize_string);
    } else {
      $sanitize_string = preg_replace("/[\s]/", "-", $sanitize_string);
    }
    $sanitize_string = trim($sanitize_string, "-");

    return $sanitize_string;
  }
}
