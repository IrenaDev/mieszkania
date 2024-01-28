<?php

/* Parent class for all admin menu classes */
abstract class AIOWPS_CB_Admin_Menu
{
    /**
     * Shows postbox for settings menu
     *
     * @param string $id css ID for postbox
     * @param string $title title of the postbox section
     * @param string $content the content of the postbox
     **/
    public function postbox_toggle($id, $title, $content) 
    {
        //Always send string with translation markers in it
        ?>
        <div id="<?php echo $id; ?>" class="postbox">
            <div class="handlediv" title="Click to toggle"><br /></div>
            <h3 class="hndle"><span><?php echo esc_html( $title ); ?></span></h3>
            <div class="inside">
            <?php echo esc_html( $content ); ?>
            </div>
        </div>
        <?php
    }
    
    public function postbox($title, $content) 
    {
        //Always send string with translation markers in it
        ?>
        <div class="postbox">
        <h3><label for="title"><?php echo esc_html( $title ); ?></label></h3>
        <div class="inside">
            <?php echo esc_html( $content ); ?>
        </div>
        </div>
        <?php
    }

    public static function show_msg_record_deleted_st()
    {
        echo '<div id="message" class="updated fade"><p><strong>';
        _e('The selected record(s) deleted successfully!','all-in-one-wp-security-and-firewall-premium');
        echo '</strong></p></div>';
    }
    
    public function show_msg_updated($msg)
    {
        echo '<div id="message" class="updated fade"><p><strong>';
        echo esc_html( $msg );
        echo '</strong></p></div>';
    }
    
    public static function show_msg_updated_st($msg)
    {
        echo '<div id="message" class="updated fade"><p><strong>';
        echo esc_html( $msg );
        echo '</strong></p></div>';
    }
    
    public function show_msg_error($error_msg)
    {
        echo '<div id="message" class="error"><p><strong>';
        echo esc_html( $error_msg );
        echo '</strong></p></div>';
    }
    
    public static function show_msg_error_st($error_msg)
    {
        echo '<div id="message" class="error"><p><strong>';
        echo esc_html( $error_msg );
        echo '</strong></p></div>';
    }
    
    public function start_buffer()
    {
        ob_start();
    }
    
    public function end_buffer_and_collect()
    {
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }    
}
