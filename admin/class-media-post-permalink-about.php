<?php
/**
 * @package MediaPostPermalink\Admin\About
 */

final class Media_Post_Permalink_About {

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->more_plugins();
  }

  /**
   * More Plugins HTML.
   *
   * @access private
   * @since 0.2
   *
   * @return void
   */
  private function more_plugins() {
    $plugin_url = plugins_url( '/admin', MEDIA_POST_PERMALINK_FILE );
    $img_src    = $plugin_url . '/images';
    wp_enqueue_style( 'style', $plugin_url . '/css/about-plugins.min.css' );
    $plugin_name = __( 'Media Post Permalink', 'media-post-permalink' );
    $button_text = __( 'Check it out', 'media-post-permalink' );
    $five_star   = '<span class="star">
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 53.867 53.867" width="15" height="15">
                      <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798
                          10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                      </svg>
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 53.867 53.867" width="15" height="15">
                      <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798
                          10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                      </svg>
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 53.867 53.867" width="15" height="15">
                      <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798
                          10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                      </svg>
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 53.867 53.867" width="15" height="15">
                      <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798
                          10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                      </svg>
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 53.867 53.867" width="15" height="15">
                      <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798
                          10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                      </svg>
                    </span>';
    ?>

    <div class="wrap">
      <div class="float">
        <h1><?php echo $plugin_name . ' v' . MEDIA_POST_PERMALINK_PLUGIN_VERSION; ?></h1>
        <div class="tagline">
          <p><?php _e('Thank you for choosing Media Post Permalink! I hope, that it helps you distinguish the permalinks of the attachment with PostType and Taxonomy Permalinks.', 'media-post-permalink' ); ?></p>
          <p><?php printf( __( 'To support future development and help to make it even better by just leaving a <a href="%s" title="Media Post Permalink Rating" target="_blank">%s</a> rating with a nice message to me :)', 'media-post-permalink' ), 'https://wordpress.org/support/plugin/media-post-permalink/reviews/?rate=5#new-post', $five_star ); ?></p>
        </div>
      </div>

      <div class="float">
        <img src= "<?php echo $img_src; ?>/media-post-permalink.png" style="transform:scale(1.5)"  width="128" height="128" />
      </div>

      <div class="product">
        <h2><?php _e( 'More from Sami Ahmed Siddiqui', 'media-post-permalink' ); ?></h2>
        <span><?php _e('Our List of Plugins provides the services which helps you to manage your site URLs(Permalinks), Prevent your site from XSS Attacks, Brute force attacks, increase your site visitors by adding Structured JSON Markup and so on.', 'media-post-permalink' ); ?></span>

        <div class="box recommended">
          <div class="img">
            <img src= "<?php echo $img_src; ?>/permalinks-customizer.svg" />
          </div>

          <h3><?php _e( 'Permalinks Customizer', 'make-paths-relative' ); ?></h3>
          <p><?php _e( 'Allows you to either define different Permalink Structure or define same Permalink Structure for default and Custom PostTypes, Taxonomies. Plugin automatically creates the user-friendly URLs as per your defined structured that can be edited from the single post/page.', 'make-paths-relative' ); ?></p>
          <a href="https://wordpress.org/plugins/permalinks-customizer/" title="Permalinks Customizer" class="checkout-button" target="_blank"><?php echo $button_text; ?></a>
        </div>

        <div class="box recommended">
          <div class="img">
            <img src= "<?php echo $img_src; ?>/prevent-xss-vulnerability.png" style="transform:scale(1.5)" />
          </div>

          <h3><?php _e( 'Prevent XSS Vulnerability', 'media-post-permalink' ); ?></h3>
          <p><?php _e( 'Secure your site from the <strong>XSS Attacks</strong> so, your users won\'t lose any kind of information or not redirected to any other site by visiting to your site with the <strong>malicious code</strong> in the URL or so. In this way, users can open your site URLs without any hesitation.', 'media-post-permalink' ); ?></p>
          <a href="https://wordpress.org/plugins/prevent-xss-vulnerability/" title="Prevent XSS Vulnerability" class="checkout-button" target="_blank"><?php echo $button_text; ?></a>
        </div>

        <div class="box recommended">
          <div class="img">
            <img src= "<?php echo $img_src; ?>/http-auth.svg" />
          </div>

          <h3><?php _e( 'HTTP Auth', 'media-post-permalink' ); ?></h3>
          <p><?php _e( 'Allows you apply <strong>HTTP Auth</strong> on your site. You can apply HTTP Authentication all over the site or only the admin pages. It helps to stop cralwing on your site while on development or persist the <strong>Brute Attacks</strong> by locking the Admin Pages.', 'media-post-permalink' ); ?></p>
          <a href="https://wordpress.org/plugins/http-auth/" title="HTTP Auth" class="checkout-button" target="_blank"><?php echo $button_text; ?></a>
        </div>

        <div class="box">
          <div class="img">
            <img src= "<?php echo $img_src; ?>/custom-permalinks.svg" />
          </div>

          <h3><?php _e( 'Custom Permalinks', 'media-post-permalink' ); ?></h3>
          <p><?php _e( 'Custom Permalinks helps you to make your permalinks customized for <em>individual</em> posts, pages, tags or categories. It will <strong>NOT</strong> apply whole permalink structures, or automatically apply a category\'s custom permalink to the posts within that category.', 'media-post-permalink' ); ?></p>
          <a href="https://www.custompermalinks.com/" title="Custom Permalinks" class="checkout-button" target="_blank"><?php echo $button_text; ?></a>
        </div>

        <div class="box">
          <div class="img">
            <img src= "<?php echo $img_src; ?>/schema-for-article.svg" />
          </div>

          <h3><?php _e( 'SCHEMA for Article', 'media-post-permalink' ); ?></h3>
          <p><?php _e( 'Simply the easiest solution to add valid schema.org as a JSON script in the head of blog posts or articles. You can choose the schema either to show with the type of Article or NewsArticle from the settings page.', 'media-post-permalink' ); ?></p>
          <a href="https://wordpress.org/plugins/schema-for-article/" title="SCHEMA for Article" class="checkout-button" target="_blank"><?php echo $button_text; ?></a>
        </div>

        <div class="box">
          <div class="img">
            <img src= "<?php echo $img_src; ?>/make-paths-relative.svg" />
          </div>

          <h3><?php _e( 'Make Paths Relative', 'media-post-permalink' ); ?></h3>
          <p><?php _e( 'Convert the paths(URLs) to relative instead of absolute. You can make <strong>Post</strong>, <strong>Category</strong>, <strong>Archive</strong>, <strong>Image</strong> URLs and <strong>Script</strong> and <strong>Style</strong> src as per your requirement. You can choose which you want to be relative from the settings Page.', 'media-post-permalink' ); ?></p>
          <a href="https://wordpress.org/plugins/make-paths-relative/" title="Make Paths Relative" class="checkout-button" target="_blank"><?php echo $button_text; ?></a>
        </div>

        <div class="box">
          <div class="img">
            <img src= "<?php echo $img_src; ?>/json-structuring-markup.svg" />
          </div>

          <h3><?php _e( 'JSON Structuring Markup', 'media-post-permalink' ); ?></h3>
          <p><?php _e( 'Simply the easiest solution to add valid schema.org as a JSON script in the head of posts and pages. It provides you multiple <strong>SCHEMA</strong> types like Article, News Article, Organization and Website Schema.', 'media-post-permalink' ); ?></p>
          <a href="https://wordpress.org/plugins/json-structuring-markup/" title="JSON Structuring Markup" class="checkout-button" target="_blank"><?php echo $button_text; ?></a>
        </div>

        <div class="box">
          <div class="img">
            <img src= "<?php echo $img_src; ?>/remove-links-and-scripts.svg" />
          </div>

          <h3><?php _e( 'Remove Links and Scripts', 'media-post-permalink' ); ?></h3>
          <p><?php _e( 'It removes some meta data from the wordpress header so, your header keeps clean of useless information like <strong>shortlink</strong>, <strong>rsd_link</strong>, <strong>wlwmanifest_link</strong>, <strong>emoji_scripts</strong>, <strong>wp_embed</strong>, <strong>wp_json</strong>, <strong>emoji_styles</strong>, <strong>generator</strong> and so on.', 'media-post-permalink' ); ?></p>
          <a href="https://wordpress.org/plugins/remove-links-and-scripts/" title="Remove Links and Scripts" class="checkout-button" target="_blank"><?php echo $button_text; ?></a>
        </div>
      </div>
    </div>
    <?php
  }
}
