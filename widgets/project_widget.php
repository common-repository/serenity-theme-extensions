<?php 
/**
 * WordPress Widget Format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Serenity_Project_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 
            'classname' => 'serenity-project-widget', 
            'description' => __('Add a project to the Projects section of the One-page Template.', 'serenity-lite') 
        );
        parent::__construct( 'serenity_project', __('Project Widget', 'serenity-lite'), $widget_ops );
        
        //setup default widget data
		$this->defaults = array(
			'gallery'         => '',
            'title'         => '',
			'textarea'   	=> '',
            'project_date'   	=> '',
            'project_client'   	=> '',
            'project_skills'   	=> '',
            'project_url'   	=> '',
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
        $gallery = $instance['gallery'];
        $title = apply_filters('widget_title', $instance['title']);
        $textarea = apply_filters( 'widget_textarea', empty( $instance['textarea'] ) ? '' : $instance['textarea'], $instance );
        $project_date = $instance['project_date'];
        $project_client = $instance['project_client'];
        $project_skills = $instance['project_skills'];
        $project_url = $instance['project_url'];
        $has_details = !(!$project_date && !$project_client && !$project_skills && !$project_url);

        echo $before_widget;
        // Display the widget
        echo '<div class="col-md-12 project">';
        echo '<div class="row">';
        echo '<div class="col-md-5 description">';
        // Check if title is set
        if ( $title ) {
          echo $before_title . $title . $after_title;
        }
        // Check if textarea is set
        if( $textarea ) { 
            echo '<p>' . str_replace("\n", "<br>", $textarea) . '</p>';
        }
        if($has_details) {
            echo '<div class="details">';

            if ( $project_date ) { echo '<p>Date: <span>' . $project_date . '</span></p>';}
            if ( $project_client ) {echo '<p>Client: <span>' . $project_client . '</span></p>';}
            if ( $project_skills ) {echo '<p>Skills: <span>' . $project_skills . '</span></p>';}
            if ( $project_url ) {echo '<p><a target="_blank" href="' . $project_url . '">View Project &#8594;</a></p>';}

            echo '</div>';
        }
        echo '</div>';
        if ($gallery) { 
            echo '<div class="col-md-7 project-gallery slider">';
            $myGalleryIDs = explode(',', $gallery);
            foreach($myGalleryIDs as $myPhotoID){
              echo '<div><img src="' . wp_get_attachment_url( $myPhotoID ) .'" class="img-responsive center-block" alt=""></div>';
            }
            echo '</div>';
        }
        echo '</div></div>';
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
        $instance['gallery'] = sanitize_text_field($new_instance['gallery']);
            $instance['title'] = sanitize_text_field($new_instance['title']);
            if ( current_user_can('unfiltered_html') )
                $instance['textarea'] =  $new_instance['textarea'];
            else $instance['textarea'] = wp_kses_post($new_instance['textarea']);
        $instance['project_date'] = sanitize_text_field($new_instance['project_date']);
        $instance['project_client'] = sanitize_text_field($new_instance['project_client']);
        $instance['project_skills'] = sanitize_text_field($new_instance['project_skills']);
        $instance['project_url'] = esc_url($new_instance['project_url']);

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
        <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php esc_html_e('Project Images/Gallery', 'serenity-lite'); ?></label>
        <br /><i><?php esc_html_e('Create a new gallery by selecting existing or uploading new images using the WordPress native uploader', 'serenity-lite'); ?></i>
        <fieldset>
            <div class="screenshot">
            <?php 
                {
                $ids = explode( ',', $instance['gallery'] );
                    foreach ( $ids as $attachment_id ) {
                        $img = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
                        echo '<img src="' . $img[0] . '" alt="" target="_blank" rel="external" />';
                    }
                }
            ?>
            </div>
        <input id="edit-gallery" class="button upload_gallery_button" type="button" value="<?php esc_html_e('Add/Edit Gallery','serenity-lite') ?>" />
        <input id="clear-gallery" class="button upload_gallery_button" type="button" value="<?php esc_html_e('Clear','serenity-lite') ?>" />
        <input type="hidden" class="gallery_values" name="<?php echo $this->get_field_name('gallery'); ?>" value="<?php echo esc_attr($instance['gallery']); ?>">
        </fieldset>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Project Name', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php esc_html_e('Project Description', 'serenity-lite'); ?></label>
        <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo wp_kses_post($instance['textarea']); ?></textarea>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('project_date'); ?>"><?php esc_html_e('Project Date', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('project_date'); ?>" name="<?php echo $this->get_field_name('project_date'); ?>" type="date" value="<?php echo esc_attr($instance['project_date']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('project_client'); ?>"><?php esc_html_e('Project Client', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('project_client'); ?>" name="<?php echo $this->get_field_name('project_client'); ?>" type="text" value="<?php echo esc_attr($instance['project_client']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('project_skills'); ?>"><?php esc_html_e('Project Skills', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('project_skills'); ?>" name="<?php echo $this->get_field_name('project_skills'); ?>" type="text" value="<?php echo esc_attr($instance['project_skills']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('project_url'); ?>"><?php esc_html_e('Project URL', 'serenity-lite'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('project_url'); ?>" name="<?php echo $this->get_field_name('project_url'); ?>" type="text" value="<?php echo esc_url($instance['project_url']); ?>" />
    </p> 
       
<?php
    }
}
// End of Plugin Class
add_action( 'widgets_init', function() {
    register_widget( 'Serenity_Project_Widget' );
} );
?>