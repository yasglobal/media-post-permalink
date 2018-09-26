<?php
/**
 * @package MediaPostPermalink\Admin
 */

final class Media_Post_Permalink_Settings {

  /**
   * Call Attachment Settings Function.
   */
  function __construct() {
    $this->attachment_settings();
  }

  /**
   * Admin Settings Page for Attachments.
   *
   * @access private
   * @since 0.1
   *
   * @return void
   */
  private function attachment_settings() {
    if ( ! current_user_can( 'administrator' ) )  {
      wp_die(
        __( 'You do not have sufficient permissions to access this page.' )
      );
    }

    if ( isset( $_POST['submit'] ) ) {
      $post_parent_enable = 'off';
      if ( isset( $_POST['post_parent'] )
        && 'on' == $_POST['post_parent'] ) {
        $post_parent_enable = 'on';
      }
      $user_friendly_enable = 'off';
      if ( isset( $_POST['user_friendly'] )
        && 'on' == $_POST['user_friendly'] ) {
        $user_friendly_enable = 'on';
      }
      $settings = array(
        'post_prefix' => $this->sanitize_string(
          $_POST['post_name_prefix'], $user_friendly_enable
        ),
        'post_suffix' => $this->sanitize_string(
          $_POST['post_name_suffix'], $user_friendly_enable
        ),
        'post_parent'   => $post_parent_enable,
        'user_friendly' => $user_friendly_enable,
      );
      update_option( 'media_post_permalink_settings', serialize( $settings ) );
    }
    $media_post_settings = unserialize(
      get_option('media_post_permalink_settings')
    );

    $media_post_prefix     = '';
    $media_post_suffix     = '';
    $parent_post_checked   = '';
    $user_friendly_checked = '';
    if ( isset( $media_post_settings['post_prefix'] )
      && ! empty( $media_post_settings['post_prefix'] ) ) {
      $media_post_prefix = $media_post_settings['post_prefix'];
    }
    if ( isset( $media_post_settings['post_suffix'] )
      && ! empty( $media_post_settings['post_suffix'] ) ) {
      $media_post_suffix = $media_post_settings['post_suffix'];
    }
    if ( isset( $media_post_settings['post_parent'] )
      && 'on' == $media_post_settings['post_parent'] ) {
      $parent_post_checked = 'checked';
    }
    if ( isset( $media_post_settings['user_friendly'] )
      && 'on' == $media_post_settings['user_friendly'] ) {
      $user_friendly_checked = 'checked';
    }
    $plugin_url = plugins_url( '/admin', MEDIA_POST_PERMALINK_FILE );
    wp_enqueue_style( 'style', $plugin_url . '/css/admin-style.min.css' );
    ?>
    <div class="wrap">
      <h2><?php _e( 'Media Post Permalink Settings', 'media-post-permalink' ); ?></h2>
      <div><?php _e( 'Make your Media/Attachment Post Permalinks customize so, it doesn\'t conflict with your future/planned page permalinks.', 'media-post-permalink' ); ?></div>
      <form enctype="multipart/form-data" method="POST" action="" id="media-post-permalink">
        <table class="media-post-admin-table">
          <caption>
            <?php _e( 'Post Permalink Changes <b>(Optional)</b>', 'media-post-permalink' ); ?>
          </caption>
          <tr>
            <th>
              <label for="post-prefix">
                <?php _e( 'Post Prefix', 'media-post-permalink' ); ?> :
              </label>
            </th>
            <td>
              <input type="text" name="post_name_prefix" id="post_prefic_name" class="regular-text" value="<?php echo $media_post_prefix; ?>" />
              <small><?php _e( 'Example: media-prefix', 'media-post-permalink' ); ?></small>
            </td>
          </tr>
          <tr>
            <th>
              <label for="post-suffix">
                <?php _e( 'Post Suffix :', 'media-post-permalink' ); ?>
              </label>
            </th>
            <td>
              <input type="text" name="post_name_suffix" id="post_suffix_name" class="regular-text" value="<?php echo $media_post_suffix; ?>" />
              <small>
                <?php _e( 'Example: media-suffix', 'media-post-permalink' ); ?>
              </small>
            </td>
          </tr>
        </table>
        <table class="media-post-admin-table">
          <caption>
            <?php _e( 'Parent Post <b>(Recommended)</b>', 'media-post-permalink' ); ?>
          </caption>
          <tbody>
            <tr>
              <td class="extra-space"></td>
              <td>
                <input type="checkbox" name="post_parent" value="on" <?php echo $parent_post_checked; ?> />
                <strong>
                  <?php _e( 'Don\'t Attach the Media with any Post</strong><br><small>When you upload the Featured Image in Post, That post becomes the Parent Post of the Media or in other words that media would attach to the respective post.', 'media-post-permalink' ); ?>
                </small>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="media-post-admin-table">
          <caption>
            <?php _e( 'Make URL User-Friendly <b>(Recommended)</b>', 'media-post-permalink' ); ?>
          </caption>
          <tbody>
            <tr>
              <td class="extra-space"></td>
              <td>
                <input type="checkbox" name="user_friendly" value="on" <?php echo $user_friendly_checked; ?> />
                <strong>
                  <?php _e( 'Replaces UnderScore(_) with Dash(-)', 'media-post-permalink' ); ?>
                </strong>
                <br>
                <small>
                  <?php _e( 'This check will replace all the underscore with dash in the permalink. According to SEO, Underscore should not be included in the URL.', 'media-post-permalink' ); ?>
                </small>
              </td>
            </tr>
          </tbody>
        </table>
        <p>
          <strong><?php _e( 'Note:', 'media-post-permalink' ); ?></strong>
          <?php _e( 'Don\'t use special characters. You can only use Numeric, Alphabets, Dash(<b>-</b>) and underscore(<b>_</b>). If you used some other keywords Like Plus(<b>+</b>), Slash(<b>/</b>) etc, it\'s removed automatically. Underscore can be used but it should not be used as per SEO.', 'media-post-permalink' ); ?>
        </p>
        <p class="submit">
          <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'make-paths-relative' ); ?>" />
        </p>
      </form>
    </div>
    <?php
  }

  /**
   * Sanitize the String (Make the CAPITAL letters to SMALL,
   * Remove special characters, Replace Undersocre with Dash )
   *
   * @access private
   * @since 0.1
   *
   * @param string $used_string
   *   String which may or may not be sanitized
   * @param string $user_friendly
   *   Either User Friendly URLs or not
   *
   * @return string $used_string
   *   Sanitized String
   */
  private function sanitize_string( $used_string, $user_friendly ) {
    $used_string = strtolower( $used_string );
    $used_string = preg_replace( '/[^a-z0-9_\s-]/', '', $used_string );
    $used_string = preg_replace( '/[\s-]+/', ' ', $used_string );
    if ( 'on' == $user_friendly ) {
      $used_string = preg_replace( '/[\s_]/', '-', $used_string );
    } else {
      $used_string = preg_replace( '/[\s]/', '-', $used_string );
    }
    $used_string = trim( $used_string, '-' );

    return $used_string;
  }
}
