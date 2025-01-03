<?php
defined('ABSPATH') || exit;

/**
 * Class WVL_Handle_Collected_Data
 */
class WVL_Handle_Collected_Data
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Handle_Collected_Data
     * @access private
     */
    private static $_instance = null;

    /**
     * Private constructor to prevent instantiation from outside of the class.
     * 
     * @access private
     * @final
     */
    private final function __construct()
    {
        add_filter('cron_schedules', array($this, 'cron_intervals'));
        add_action('wp', array($this, 'cron_schedule'));
        add_action('wvl_collection_data_processing_event', array($this, 'process_data_cron'));
    }

    public function cron_intervals($schedules)
    {
        $schedules['every_minute'] = array(
            'interval' => 60, // 60 seconds
            'display'  => esc_html__('Every Minute'),
        );
        return $schedules;
    }

    public function cron_schedule()
    {
        if (! wp_next_scheduled('wvl_collection_data_processing_event')) {
            wp_schedule_event(time(), 'every_minute', 'wvl_collection_data_processing_event');
        }
    }


    public function process_data_cron()
    {
        $collection_status = get_option('wvl_collection_status');
        if (!$collection_status) {
            $collection_status = [
                'status' => '',
                'date' => time()
            ];
        }

        if ($collection_status['status'] == 'done' && date('Y-m-d', $collection_status['date']) == date('Y-m-d', time())) {
            wp_clear_scheduled_hook('wvl_collection_data_processing_event');
            return;
        }
        $this->store_the_day_collected_data();
    }

    public function store_the_day_collected_data()
    {
        $venue_ids = get_posts([
            'post_type' => 'venue',
            'post_status' => 'publish',
            'numberposts' => -1,
            'fields' => 'ids'
        ]);

        $each_data_process = 2;
        $data_processed = intval(get_option('wvl_collected_data_index', 0));

        for ($i = $data_processed; $i < count($venue_ids); $i++) {
            $venue_id = $venue_ids[$i];

            $this->collect_impression($venue_id);
            if ($this->collect_unique_view($venue_id)) {
                $this->collect_view($venue_id);
            }
            $this->collect_contact_click($venue_id);
            $this->collect_lead($venue_id);

            --$each_data_process;
            if ($each_data_process == 0)  break;
        }
        update_option('wvl_collected_data_index', $i);

        if ($i >= count($venue_ids)) {
            update_option('wvl_collection_status', [
                'status' => 'done',
                'date' => time()
            ]);

            update_option('wvl_collected_data_index', 0);
        }
    }

    /**
     * Collects impression data for a given venue.
     *
     * This function retrieves the daily count of impression data for the 
     * specified venue ID, inserts the count into the analytics storage, 
     * and then deletes the daily impression data.
     *
     * @param int $venue_id The ID of the venue for which to process impression data.
     *
     * @return void
     */

    private function collect_impression($venue_id)
    {
        $count_impression = WVL_Analytic_Data_Storage::get_daily_data_count($venue_id, 'impression');
        WVL_Analytic_Data_Storage::insert($venue_id, 'impression', $count_impression);
        WVL_Analytic_Data_Storage::delete_daily_data($venue_id, 'impression');
    }

    /**
     * Collects unique view data for a given venue.
     *
     * This function retrieves the daily count of unique view data for the 
     * specified venue ID, inserts the count into the analytics storage, and
     * returns true.
     *
     * @param int $venue_id The ID of the venue for which to process unique view data.
     *
     * @return bool Returns true if the data was collected successfully.
     */
    private function collect_unique_view($venue_id)
    {
        $count_unique_view = WVL_Analytic_Data_Storage::get_daily_data_unique_count($venue_id, 'view');
        WVL_Analytic_Data_Storage::insert($venue_id, 'unique_view', $count_unique_view);
        return true;
    }

    /**
     * Collects view data for a given venue.
     *
     * This function retrieves the daily count of view data for the 
     * specified venue ID, inserts the count into the analytics storage, and
     * then deletes the daily view data.
     *
     * @param int $venue_id The ID of the venue for which to process view data.
     *
     * @return bool Returns true if the data was collected successfully.
     */
    private function collect_view($venue_id)
    {
        $count_view = WVL_Analytic_Data_Storage::get_daily_data_count($venue_id, 'view');
        WVL_Analytic_Data_Storage::insert($venue_id, 'view', $count_view);
        WVL_Analytic_Data_Storage::delete_daily_data($venue_id, 'view');
        return true;
    }

    /**
     * Collects contact click data for a given venue.
     *
     * This function retrieves the daily count of contact click data for the 
     * specified venue ID, inserts the count into the analytics storage, and
     * then deletes the daily contact click data.
     *
     * @param int $venue_id The ID of the venue for which to process contact click data.
     *
     * @return bool Returns true if the data was collected successfully.
     */
    private function collect_contact_click($venue_id)
    {
        $count_contact_click = WVL_Analytic_Data_Storage::get_daily_data_count($venue_id, 'contact_click');
        WVL_Analytic_Data_Storage::insert($venue_id, 'contact_click', $count_contact_click);
        WVL_Analytic_Data_Storage::delete_daily_data($venue_id, 'contact_click');
    }

    /**
     * Collects lead data for a given venue.
     *
     * This function retrieves the daily count of form submissions for the 
     * specified venue ID from the contact form table, inserts the count 
     * into the analytics storage as 'lead' data.
     *
     * @param int $venue_id The ID of the venue for which to process lead data.
     *
     * @return void
     */
    private function collect_lead($venue_id)
    {

        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_form';
        $today_date = date('Y-m-d');

        // count total form entries
        $results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT COUNT(*) as total FROM $table_name WHERE venue_id = %d AND DATE(submission_date) = %s",
                $venue_id,
                $today_date
            ),
            ARRAY_A
        );
        $total = isset($results[0]['total']) ? $results[0]['total'] : 0;

        WVL_Analytic_Data_Storage::insert($venue_id, 'lead', $total);
    }

    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Handle_Collected_Data The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

WVL_Handle_Collected_Data::get_instance();
