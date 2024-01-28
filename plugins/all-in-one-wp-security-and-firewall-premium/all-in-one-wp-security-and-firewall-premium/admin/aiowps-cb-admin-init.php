<?php
/* 
 * Inits the admin dashboard side of things.
 * Main admin file which loads all settings panels and sets up admin menus. 
 */
class AIOWPS_CB_Admin_Init
{
    public $settings_menu;

    public function __construct()
    {
		
        $this->admin_includes();
        add_action('admin_print_styles', array($this, 'admin_menu_page_styles'));
        add_action('aiowpsecurity_admin_menu_created', array($this, 'create_admin_menus'));
		
		add_action('end_main_dashboard_content',array($this, 'add_dashboard_widget'));
        add_filter('list_404_get_columns',array($this, 'list_404_add_columns'));
        add_filter('list_404_get_sortable_columns',array($this, 'list_404_add_sortable_columns'));
    }
    
    public function admin_includes()
    {
        include_once('aiowps-cb-admin-menu.php');
		include_once('smart-404-admin-menu.php');
    }
    
    public function admin_menu_page_styles() 
    {
        wp_enqueue_style('dashboard');
        wp_enqueue_style('thickbox');
        wp_enqueue_style('global');
        wp_enqueue_style('wp-admin');
		wp_enqueue_style('aiowps-cb-admin-css', AIOWPS_PREMIUM_URL. '/css/aiowps-premium-styles.css');
		
    } 
    
    public function create_admin_menus()
    {
        global $aio_wp_security;
		
        $aiowps_main_menu = $aio_wp_security->admin_init->main_menu_page;  //new AIOWPSecurity_Admin_Init();
        add_submenu_page(AIOWPSEC_MAIN_MENU_SLUG, __('Country Blocking', 'all-in-one-wp-security-and-firewall-premium'),  __('Country Blocking', 'all-in-one-wp-security-and-firewall-premium') , apply_filters('aios_management_permission', 'manage_options'), AIOWPS_CB_SETTINGS_MENU_SLUG, array($this, 'handle_settings_menu_rendering'));
		add_submenu_page(AIOWPSEC_MAIN_MENU_SLUG, __('Smart 404', 'all-in-one-wp-security-and-firewall-premium'),  __('Smart 404', 'all-in-one-wp-security-and-firewall-premium') , apply_filters('aios_management_permission', 'manage_options'), AIOWPS_SMART_404_SETTINGS_MENU_SLUG, array($this, 'handle_settings_menu_rendering_404'));
    }
    
    public function handle_settings_menu_rendering()
    {
        include_once('aiowps-cb-settings-menu.php');
        $this->settings_menu = new AIOWPS_CB_Settings_Menu();
		
        
    }
	
	public function handle_settings_menu_rendering_404()
    {
        include_once('smart-404-settings-menu.php');
		$this->settings_menu = new AIOWPS_SMART_404_Settings_Menu();
        
    }
 

    /**
     * Adds the smart404 widget to the main AIOWPS dashboard page
     */
    public function add_dashboard_widget()
    {
        global $wpdb;
        $sql = $wpdb->prepare('SELECT * FROM '.AIOWPSEC_TBL_PERM_BLOCK.' WHERE block_reason=%s', '404');
        $total_res = $wpdb->get_results($sql);
        //Get number of 404 events for today
        $events_404_today = AIOWPS_Premium_Utilities::get_todays_404_events();
        $num_404_today = empty($events_404_today)?0:count($events_404_today);
        $todays_blocked_count = 0;

        if(empty($total_res)){
            $total_count = '0';
            $msg = '<p><strong>'.__('You currently have no IP addresses permanently blocked due to 404.', 'all-in-one-wp-security-and-firewall-premium').'</strong></p>';
        }else {
            $total_count = count($total_res);
            foreach ($total_res as $blocked_item) {
                $now = current_time('mysql');
                $now_date_time = new DateTime($now);
                $blocked_date = new DateTime($blocked_item->blocked_date);
                if ($blocked_date->format('Y-m-d') == $now_date_time->format('Y-m-d')) {
                    //there was an IP added to permanent block list today
                    ++$todays_blocked_count;
                }
            }
            if(empty($todays_blocked_count)) $todays_blocked_count='0';
        }
        ob_start();
        ?>
        <div class="aiowps_dashboard_box_small">
            <div class="postbox">
                <h3 class="hndle"><label
                        for="title"><?php _e('Smart 404', 'all-in-one-wp-security-and-firewall-premium');?></label>
                </h3>

                <div class="inside">
                    <div class="aio_yellow_box">
                        <p><strong><?php echo __('# 404 Events Today: ', 'all-in-one-wp-security-and-firewall-premium').$num_404_today; ?></strong></p>
                        <p><strong><?php echo __('# IPs Permanently Blocked Today: ', 'all-in-one-wp-security-and-firewall-premium').$todays_blocked_count; ?></strong></p>
                        <hr><p><strong><?php echo __('All Time Total IPs Blocked: ', 'all-in-one-wp-security-and-firewall-premium').$total_count; ?></strong></p>
                    </div>
                    <p><a class="button" href="admin.php?page=<?php echo AIOWPS_SMART_404_SETTINGS_MENU_SLUG; ?>&tab=tab2" target="_blank"><?php _e('View Blocked IPs','all-in-one-wp-security-and-firewall-premium'); ?></a></p>
                </div>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }

    /**
     * Uses the AIOWPS filter
     * Will add a country column to the 404 list table in the main AIOWPS plugin
     * @param $columns
     */
    public function list_404_add_columns($columns)
    {
        if(empty($columns))return;
        $columns['country_code'] = 'Country';
        return $columns;
    }

    /**
     * Uses the AIOWPS filter
     * Will make country column sortable in the 404 list table in the main AIOWPS plugin
     * @param $sortable_columns
     */
    public function list_404_add_sortable_columns($sortable_columns)
    {
        if(empty($sortable_columns))return;
        $sortable_columns['country_code'] = array('country_code', false);
        return $sortable_columns;

    }

 
}//End of class
