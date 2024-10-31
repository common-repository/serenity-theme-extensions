<?php 
/**
 * WordPress Widget Format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Serenity_Bar_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 
            'classname' => 'serenity-bar-widget', 
            'description' => __('Add a progress bar to the Progress Bars section of the One-page Template.', 'serenity-lite') 
        );
        parent::__construct( 'serenity_bar', __('Progress Bar Widget', 'serenity-lite'), $widget_ops );
        
        //setup default widget data
		$this->defaults = array(
  		'title'     => '',
        'number'    => '',
        'color'     => '',
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
        $title = $instance['title'];
        $number = apply_filters('widget_number', $instance['number']);
        $color = $instance['color'];
        echo $before_widget;
        // Check if text is set
        if( $title ) {
          echo '<p class="font-weight-bold mb-2">'.$title.'<span class="float-right">'.$number.'&#37;</span></p>';
        }
        // Display the widget
        echo '<div class="progress">';
        // Check if number is set
        if ( $number ) {
          echo '<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="'.$number.'" aria-valuemin="0" aria-valuemax="100" style="background-color:'.$color.';width:'.$number.'%"></div>';
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
        $instance['number'] = sanitize_text_field($new_instance['number']);
        $instance['color'] = esc_attr($new_instance['color']);

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
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Bar Title', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        <i><?php esc_html_e('Enter the name or title of the progress bar.', 'serenity-lite'); ?></i>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Bar Percentage Number', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($instance['number']); ?>" />
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
        <label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php esc_html_e('Bar Color', 'serenity-lite'); ?></label>
        <input class="color-picker" type="text" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="<?php echo esc_attr( $instance['color'] ); ?>" data-default-color="#007bff" />                       
    </p>
<?php
    }
}
// End of Widget Class
add_action( 'widgets_init', function() {
    register_widget( 'Serenity_Bar_Widget' );
} );
?>