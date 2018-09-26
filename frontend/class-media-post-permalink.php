<?php
/**
 * @package MediaPostPermalink\Frontend
 */

final class Media_Post_Permalink_Frontend {

  /**
   * Initialize WordPress Hooks
   */
  public function init() {
    add_filter( 'wp_insert_attachment_data',
      array( $this, 'change_postname' )
    );
  }

  /**
   * Change postname of the attachment.
   *
   * @access public
   * @since 0.1
   *
   * @param array $data
   *   An array of sanitized attachment post data.
   *
   * @return array $data
   *   An array of sanitized attachment post data with changing postname.
   */
  function change_postname( $data ) {
    $settings = unserialize( get_option('media_post_permalink_settings') );

    $postname = $data['post_name'];
    if ( empty( $postname ) ) {
      $postname = $data['post_title'];
    }

    if ( isset( $settings['post_prefix'] )
      && ! empty( $settings['post_prefix'] )
      && strpos( $postname, $settings['post_prefix'] ) !== 0 ) {
      $postname = $settings['post_prefix'] . '-' . $postname;
    }

    $check_post_suffix  = strlen($settings['post_suffix']);
    if ( isset( $settings['post_suffix'] )
      && ! empty( $settings['post_suffix'] ) && $check_post_suffix > 0
      && substr( $postname, -$check_post_suffix) != $settings['post_suffix'] ) {
      $postname = $postname . '-' . $settings['post_suffix'];
    }

    if ( isset( $settings['user_friendly'] )
      && $settings['user_friendly'] == 'on' ) {
      $postname = $this->sanitize_string( $postname, 'on' );
    } else {
      $postname = $this->sanitize_string( $postname, 'off' );
    }

    if ( $postname != $data['post_name'] ) {
      global $wpdb;
      $check_existing_name = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_name = '" . $postname . "' LIMIT 1" );
      if ( ! empty( $check_existing_name ) ) {
        $i = 2;
        while ( 1 ) {
          $postname_permalink = $postname . '-' . $i;
          $check_existing_name = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_name = '" . $postname_permalink . "' LIMIT 1" );
          if ( empty( $check_existing_name ) ) {
            break;
          }
          $i++;
        }
        $postname = $postname_permalink;
      }
      $data['post_name'] = $postname;
    }

    if ( isset( $settings['post_parent'] )
      && $settings['post_parent'] == 'on' ) {
      $data['post_parent'] = 0;
    }

    return $data;
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
