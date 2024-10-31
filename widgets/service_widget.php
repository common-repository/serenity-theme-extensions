<?php 
/**
 * WordPress Widget Format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Serenity_Service_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
      $widget_ops = array(
          'classname' => 'serenity-service-widget', 
          'description' => __('Add a service to the Services section of the One-page Template.', 'serenity-lite')
      );
      parent::__construct( 'serenity_service', __('Service Widget', 'serenity-lite'), $widget_ops );
      
      //setup default widget data
  		$this->defaults = array(
    			'title'      => '',
    			'link_text'  => '',
    			'image_url'  => '',
          'link_url'  => '',
    			'textarea'   => '',
  		);
    }

    /**
    * Outputs the HTML for this widget.
    *
    * @param array  An array of standard parameters for widgets in this theme
    * @param array  An array of settings for this widget instance
    * @return void Echoes it's output
    **/
    function widget( $args, $instance ) {
        wp_reset_postdata();
        extract( $args, EXTR_SKIP );
        // these are the widget options
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $link_text = apply_filters( 'widget_text', $instance['link_text']);
        $link_url = apply_filters( 'widget_text', $instance['link_url']);
        $image_url = apply_filters( 'widget_text', $instance['image_url']);
        $textarea = apply_filters( 'widget_textarea', empty( $instance['textarea'] ) ? '' : $instance['textarea'], $instance );
        echo $before_widget;
        // Display the widget
        if( $image_url) {
        echo '<img class="img-fluid rounded" src="'.$image_url.'">';
        }
        echo '<div class="card-body py-5">';
        // Check if title is set
        if ( $title ) {
        echo $before_title . $title . $after_title;
        }
        // Check if textarea is set
        if( $textarea ) { echo wpautop($textarea); }
        if ( $link_text ) {
        echo '<a href="'.$link_url.'" class="btn btn-md btn-outline-primary px-4 py-2 mt-1">'.$link_text.'</a>';
        }
        echo '</div>';
        echo $after_widget;
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     **/
    function update( $new_instance, $old_instance ) {

      // update logic goes here
      $instance = $old_instance;
      // Fields
      $instance['title'] = sanitize_text_field($new_instance['title']);
      $instance['link_text'] = sanitize_text_field($new_instance['link_text']);
      $instance['link_url'] = esc_url($new_instance['link_url']);
      $instance['image_url'] = esc_url($new_instance['image_url']);
      if ( current_user_can('unfiltered_html') )
          $instance['textarea'] =  $new_instance['textarea'];
      else $instance['textarea'] = wp_kses_post($new_instance['textarea']);
        
      return $instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, $this->defaults );
?>
	<p>
      <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php esc_html_e('Service Image', 'serenity-lite'); ?></label>
      <input id="<?php echo $this->get_field_id('image_url'); ?>" type="text" class="image-url" name="<?php echo $this->get_field_name('image_url'); ?>" value="<?php echo esc_url($instance['image_url']); ?>" style="width: 100%;" />
      <input data-title="Image in Widget" data-btntext="Select it" class="button upload_image_button" type="button" value="<?php esc_html_e('Upload','serenity-lite') ?>" />
      <input data-title="Image in Widget" data-btntext="Select it" class="button clear_image_button" type="button" value="<?php esc_html_e('Clear','serenity-lite') ?>" />
  </p>
  <p class="img-prev">
    <img src="<?php echo esc_url($instance['image_url']); ?>" style="max-width: 100%;">
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Service Title', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php esc_html_e('Service Description', 'serenity-lite'); ?></label>
      <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo wp_kses_post($instance['textarea']); ?></textarea>
      <i><?php esc_html_e('No limit on the amount of text and HTML is allowed.', 'serenity-lite'); ?></i>
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('link_text'); ?>"><?php esc_html_e('Service Button Text', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo esc_attr($instance['link_text']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('link_url'); ?>"><?php esc_html_e('Service Button Link', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('link_url'); ?>" name="<?php echo $this->get_field_name('link_url'); ?>" type="text" value="<?php echo esc_attr($instance['link_url']); ?>" />
  </p>
<?php
    }
}
// End of Plugin Class
add_action( 'widgets_init', function() {
    register_widget( 'Serenity_Service_Widget' );
} );
?>