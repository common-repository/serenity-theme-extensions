<?php 
/**
 * WordPress Widget Format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Serenity_Pricing_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 
            'classname' => 'serenity-pricing-widget', 
            'description' => __('Add a pricing table to the Pricing Tables section of the One-page Template.', 'serenity-lite') 
        );
        parent::__construct( 'serenity_pricing', __('Pricing Table Widget', 'serenity-lite'), $widget_ops );
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     * @return void Echoes it's output
     **/
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $price = $instance['price'];
        $currency = $instance['currency'];
        $price_sub_text = $instance['price_sub_text'];
        $feature_1 = $instance['feature_1'];
        $feature_2 = $instance['feature_2'];
        $feature_3 = $instance['feature_3'];
        $feature_4 = $instance['feature_4'];
        $feature_5 = $instance['feature_5'];
        $feature_6 = $instance['feature_6'];
        $feature_7 = $instance['feature_7'];
        $feature_8 = $instance['feature_8'];
        $feature_9 = $instance['feature_9'];
        $feature_10 = $instance['feature_10'];
        $button_text = $instance['button_text'];
        $button_url = $instance['button_url'];
        $color = $instance['color'];

        echo $before_widget;
        // Display the widget
        echo '';
        echo '<div class="pt">';
        echo '<div class="pt_main">';
        if ($title) { echo '<h4 class="mb-3">'.$title.'</h4>';}
        echo '<p class="display-4 mb-0"><span class="currency">'.$currency.'</span>'.$price.'</p>';
        echo '<p class="text-muted">'.$price_sub_text.'</p>';
        echo '</div>';
        echo '<ul class="pt_list mx-4 mb-4">';
        if ($feature_1) { echo '<li><i class="fa far fas fa-check fa-xs mr-3"></i>'.$feature_1.'</li>';}
        if ($feature_2) { echo '<li><i class="fa far fas fa-check fa-xs mr-3"></i>'.$feature_2.'</li>';}
        if ($feature_3) { echo '<li><i class="fa far fas fa-check fa-xs mr-3"></i>'.$feature_3.'</li>';}
        if ($feature_4) { echo '<li><i class="fa far fas fa-check fa-xs mr-3"></i>'.$feature_4.'</li>';}
        if ($feature_5) { echo '<li><i class="fa far fas fa-check fa-xs mr-3"></i>'.$feature_5.'</li>';}
        if ($feature_6) { echo '<li><i class="fa far fas fa-check fa-xs mr-3"></i>'.$feature_6.'</li>';}
        if ($feature_7) { echo '<li><i class="fa far fas fa-check fa-xs mr-3"></i>'.$feature_7.'</li>';}
        if ($feature_8) { echo '<li><i class="fa far fas fa-check fa-xs mr-3"></i>'.$feature_8.'</li>';}
        if ($feature_9) { echo '<li><i class="fa far fas fa-check fa-xs mr-3"></i>'.$feature_9.'</li>';}
        if ($feature_10) { echo '<li><i class="fa far fas fa-check fa-xs mr-3"></i>'.$feature_10.'</li>';}
        echo '</ul>';
        if ($button_text  && !$color) { echo '<div class="pt_button"><a href="'.$button_url.'" style="background-color:'.$color.';border-color:'.$color.';" class="btn btn-md btn-outline-primary px-4 py-2">'.$button_text.'</a></div>';}
        else if ($button_text && $color) {
            echo '<div class="pt_button"><a href="'.$button_url.'" style="color:#fff;background-color:'.$color.';border-color:'.$color.';" class="btn btn-md btn-outline-primary px-4 py-2">'.$button_text.'</a></div>';
        }
        echo '</div>';
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
      $instance['title'] = sanitize_text_field($new_instance['title']);
      $instance['price'] = sanitize_text_field($new_instance['price']);
      $instance['currency'] = sanitize_text_field($new_instance['currency']);
      $instance['price_sub_text'] = sanitize_text_field($new_instance['price_sub_text']);
      $instance['feature_1'] = sanitize_text_field($new_instance['feature_1']);
      $instance['feature_2'] = sanitize_text_field($new_instance['feature_2']);
      $instance['feature_3'] = sanitize_text_field($new_instance['feature_3']);
      $instance['feature_4'] = sanitize_text_field($new_instance['feature_4']);
      $instance['feature_5'] = sanitize_text_field($new_instance['feature_5']);
      $instance['feature_6'] = sanitize_text_field($new_instance['feature_6']);
      $instance['feature_7'] = sanitize_text_field($new_instance['feature_7']);
      $instance['feature_8'] = sanitize_text_field($new_instance['feature_8']);
      $instance['feature_9'] = sanitize_text_field($new_instance['feature_9']);
      $instance['feature_10'] = sanitize_text_field($new_instance['feature_10']);
      $instance['button_text'] = sanitize_text_field($new_instance['button_text']);
      $instance['button_url'] = esc_url($new_instance['button_url']);
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
        extract($instance);

?>
  
  <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('price'); ?>"><?php esc_html_e('Price', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('price'); ?>" name="<?php echo $this->get_field_name('price'); ?>" type="text" value="<?php echo esc_attr($instance['price']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('currency'); ?>"><?php esc_html_e('Currency', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('currency'); ?>" name="<?php echo $this->get_field_name('currency'); ?>" type="text" value="<?php echo esc_attr($instance['currency']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('price_sub_text'); ?>"><?php esc_html_e('Price Sub Text', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('price_sub_text'); ?>" name="<?php echo $this->get_field_name('price_sub_text'); ?>" type="text" value="<?php echo esc_attr($instance['price_sub_text']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('feature_1'); ?>"><?php esc_html_e('Feature 1', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('feature_1'); ?>" name="<?php echo $this->get_field_name('feature_1'); ?>" type="text" value="<?php echo esc_attr($instance['feature_1']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('feature_2'); ?>"><?php esc_html_e('Feature 2', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('feature_2'); ?>" name="<?php echo $this->get_field_name('feature_2'); ?>" type="text" value="<?php echo esc_attr($instance['feature_2']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('feature_3'); ?>"><?php esc_html_e('Feature 3', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('feature_3'); ?>" name="<?php echo $this->get_field_name('feature_3'); ?>" type="text" value="<?php echo esc_attr($instance['feature_3']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('feature_4'); ?>"><?php esc_html_e('Feature 4', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('feature_4'); ?>" name="<?php echo $this->get_field_name('feature_4'); ?>" type="text" value="<?php echo esc_attr($instance['feature_4']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('feature_5'); ?>"><?php esc_html_e('Feature 5', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('feature_5'); ?>" name="<?php echo $this->get_field_name('feature_5'); ?>" type="text" value="<?php echo esc_attr($instance['feature_5']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('feature_6'); ?>"><?php esc_html_e('Feature 6', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('feature_6'); ?>" name="<?php echo $this->get_field_name('feature_6'); ?>" type="text" value="<?php echo esc_attr($instance['feature_6']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('feature_7'); ?>"><?php esc_html_e('Feature 7', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('feature_7'); ?>" name="<?php echo $this->get_field_name('feature_7'); ?>" type="text" value="<?php echo esc_attr($instance['feature_7']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('feature_8'); ?>"><?php esc_html_e('Feature 8', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('feature_8'); ?>" name="<?php echo $this->get_field_name('feature_8'); ?>" type="text" value="<?php echo esc_attr($instance['feature_8']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('feature_9'); ?>"><?php esc_html_e('Feature 9', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('feature_9'); ?>" name="<?php echo $this->get_field_name('feature_9'); ?>" type="text" value="<?php echo esc_attr($instance['feature_9']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('feature_10'); ?>"><?php esc_html_e('Feature 10', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('feature_10'); ?>" name="<?php echo $this->get_field_name('feature_10'); ?>" type="text" value="<?php echo esc_attr($instance['feature_10']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('button_text'); ?>"><?php esc_html_e('Button Text', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo esc_attr($instance['button_text']); ?>" />
  </p>
  <p>
      <label for="<?php echo $this->get_field_id('button_url'); ?>"><?php esc_html_e('Button URL', 'serenity-lite'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" type="text" value="<?php echo esc_url($instance['button_url']); ?>" />
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
    <label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php esc_html_e('Button Color', 'serenity-lite'); ?></label>
    <input class="color-picker" type="text" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="<?php echo esc_attr( $instance['color'] ); ?>" data-default-color="#12dabd" />                       
  </p>
<?php
    }
}
// End of Plugin Class
add_action( 'widgets_init', function() {
    register_widget( 'Serenity_Pricing_Widget' );
} );
?>