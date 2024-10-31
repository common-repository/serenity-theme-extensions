<?php 
/**
 * WordPress Widget Format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Serenity_Counter_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 
            'classname' => 'serenity-counter-widget', 
            'description' => __('Add a animated counter to the Counters section of the One-page Template.', 'serenity-lite') 
        );
        parent::__construct( 'serenity_counter', __('Counter Widget', 'serenity-lite'), $widget_ops );
        
        //setup default widget data
    		$this->defaults = array(
      			'number'    => '',
      			'text'      => '',
            'color'      => '',
      			'image_url' => '',
            'prefix'    => '',
            'suffix'   	=> '',
            'textarea'  => '',
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
        $number = apply_filters('widget_number', $instance['number']);
        $text = $instance['text'];
        $color = $instance['color'];
        $image_url = $instance['image_url'];
        $prefix = $instance['prefix'];
        $suffix = $instance['suffix'];
        $textarea = apply_filters( 'widget_textarea', empty( $instance['textarea'] ) ? '' : $instance['textarea'], $instance );
        echo $before_widget;

        // Display the widget
        echo '';

        // Check if text is set
        if( $text ) {
          echo '<i class="fa far fas '.$text.' fa-3x icon text-green" style="color:'.$color.' !important;"></i>';
        }
        if( $image_url) {
          echo '<img  src="'.$image_url.'" class="image">';
        }

        // Check if number is set
        if ( $number ) {
          echo '<div class="number display-4 my-4 text-green" style="color:'.$color.' !important;"><p><span class="prefix">'. $prefix .'</span><span class="counter">'. $number .'</span><span class="sufix">'. $suffix .'</span></p></div>';
        }

        // Check if textarea is set
        if( $textarea ) { 
            echo '<div class="text-uppercase font-weight-bold">';
            echo wpautop($textarea);
            echo '</div>';
        }
        echo '';
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
        $instance['number'] = sanitize_text_field($new_instance['number']);
        $instance['text'] = sanitize_text_field($new_instance['text']);
        $instance['color'] = esc_attr($new_instance['color']);
        $instance['image_url'] = esc_url($new_instance['image_url']);
        $instance['prefix'] = sanitize_text_field($new_instance['prefix']);
        $instance['suffix'] = sanitize_text_field($new_instance['suffix']);
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
        <label for="<?php echo $this->get_field_id('text'); ?>"><?php esc_html_e('Counter Icon Class', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($instance['text']); ?>" />
        <i><?php esc_html_e('Copy and paste the required icon class from the', 'serenity-lite'); ?> <a href="<?php echo esc_url('https://fortawesome.github.io/Font-Awesome/cheatsheet/'); ?>" target="_blank"><?php esc_html_e('Fontawesome Icons List', 'serenity-lite'); ?></a> <?php esc_html_e('and choose from 600+ icons. Example: Enter', 'serenity-lite'); ?> <strong><?php esc_html_e('fa-smile', 'serenity-lite'); ?></strong> <?php esc_html_e('to display a smiley face icon.', 'serenity-lite'); ?></i>
    </p>
    <p>
        <script>
            ( function( $ ){
                function initColorPicker( widget ) {
                    widget.find( '.color-picker' ).wpColorPicker( {
                        change: _.throttle( function() {
                            $(this).trigger( 'change' );
                        }, 3000 )
                    });
                }

                function onFormUpdate( event, widget ) {
                    initColorPicker( widget );
                }

                $( document ).on( 'widget-added widget-updated', onFormUpdate );

                $( document ).ready( function() {
                    $( '#widgets-right .widget:has(.color-picker)' ).each( function () {
                        initColorPicker( $( this ) );
                    } );
                } );
            }( jQuery ) );
        </script>
        <label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php esc_html_e('Counter Icon Color', 'serenity-lite'); ?></label>
        <input class="color-picker" type="text" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="<?php echo esc_attr( $instance['color'] ); ?>" data-default-color="#12dabd" />                       
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php esc_html_e('Counter Image', 'serenity-lite'); ?></label>
        <br /><i><?php esc_html_e('Instead of using Fontawesome to display an icon you can also upload an image.', 'serenity-lite'); ?></i>
        <input id="<?php echo $this->get_field_id('image_url'); ?>" type="text" class="image-url" name="<?php echo $this->get_field_name('image_url'); ?>" value="<?php echo esc_url($instance['image_url']); ?>" style="width: 100%;" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button upload_image_button" type="button" value="<?php esc_html_e('Upload','serenity-lite') ?>" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button clear_image_button" type="button" value="<?php esc_html_e('Clear','serenity-lite') ?>" />
	</p>
	<p class="img-prev">
		<?php if (isset($image_url) && $image_url) { echo '<img src="'.$image_url.'" style="max-width: 100%;">';} ?>
	</p>
    <p>
        <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Counter Number', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($instance['number']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('prefix'); ?>"><?php esc_html_e('Counter Prefix', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('prefix'); ?>" name="<?php echo $this->get_field_name('prefix'); ?>" type="text" value="<?php echo esc_attr($instance['prefix']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('suffix'); ?>"><?php esc_html_e('Counter Suffix', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('suffix'); ?>" name="<?php echo $this->get_field_name('suffix'); ?>" type="text" value="<?php echo esc_attr($instance['suffix']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php esc_html_e('Counter Description', 'serenity-lite'); ?></label>
        <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo wp_kses_post($instance['textarea']); ?></textarea>
    <i><?php esc_html_e('No limit on the amount of text and HTML is allowed.', 'serenity-lite'); ?></i>
    </p>
<?php
    }
}
// End of Widget Class
add_action( 'widgets_init', function() {
    register_widget( 'Serenity_Counter_Widget' );
} );
?>