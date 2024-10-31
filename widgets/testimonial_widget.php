<?php 
/**
 * Testimonials Widget Format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Serenity_Testimonial_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 
            'classname' => 'serenity-testimonial-widget', 
            'description' => __('Add a testimonial to the Testimonials section of the One-page Template.', 'serenity-lite') 
        );
        parent::__construct( 'serenity_testimonial', __('Testimonial Widget', 'serenity-lite'), $widget_ops );
        
        //setup default widget data
        $this->defaults = array(
            'title'         => '',
            'subtitle'      => '',
            'textarea'      => '',
            'image_url'     => '',
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
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $subtitle = apply_filters( 'widget_title', empty( $instance['subtitle'] ) ? '' : $instance['subtitle'], $instance, $this->id_base );
        $textarea = apply_filters( 'widget_textarea', empty( $instance['textarea'] ) ? '' : $instance['textarea'], $instance );
        $image_url = $instance['image_url'];
        echo $before_widget;
        // Display the widget
        // Check if textarea is set
        if( $textarea ) { echo '<div class="card-body quote-body pt-7 px-5 pb-5">' . wpautop($textarea) . ''; }
        // Check if image is set
        if( $image_url) {
          echo '<div class="quote-image img-fluid rounded-circle float-left mr-2" style="background:url('.$image_url.') no-repeat center top;background-size: 100% auto;"></div>';
        }
        // Check if title is set
        if ( $title ) { echo '<h6 class="quote-author pt-1 mb-0">&#8212; '.$title.'</h6>';}
        if ( $subtitle ) { echo '<p class="quote-subtitle small font-italic text-muted mb-0">'.$subtitle.'</p>';}
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
        $instance['subtitle'] = sanitize_text_field($new_instance['subtitle']);
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
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Author Name', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php esc_html_e('Author Subtitle (Position, Company, Profession or Location)', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($instance['subtitle']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php esc_html_e('Testimonial Content', 'serenity-lite'); ?></label>
        <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo wp_kses_post($instance['textarea']); ?></textarea>
        <i><?php esc_html_e('No limit on the amount of text and HTML is allowed.', 'serenity-lite'); ?></i>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php esc_html_e('Author Image', 'serenity-lite'); ?></label>
        <br /><i><?php esc_html_e('You can also display a image or profile photo of the testimonial author. Minimum size of 150 x 150 pixels (square).', 'serenity-lite'); ?></i>
        <input id="<?php echo $this->get_field_id('image_url'); ?>" type="text" class="image-url" name="<?php echo $this->get_field_name('image_url'); ?>" value="<?php echo esc_url($instance['image_url']); ?>" style="width: 100%;" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button upload_image_button" type="button" value="<?php esc_html_e('Upload','serenity-lite') ?>" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button clear_image_button" type="button" value="<?php esc_html_e('Clear','serenity-lite') ?>" />
    </p>
<?php
    }
}
// End of Plugin Class
add_action( 'widgets_init', function() {
    register_widget( 'Serenity_Testimonial_Widget' );
} );
?>