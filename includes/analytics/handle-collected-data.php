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
        $this->store_the_day_collected_data();
    }

    public function store_the_day_collected_data()
    {
        if (!isset($_GET['store'])) return;
        $venue_ids = get_posts([
            'post_type' => 'venue',
            'post_status' => 'publish',
            'numberposts' => -1,
            'fields' => 'ids'
        ]);

        $each_data_process = 10;
        $data_processed = get_option('wvl_the_day_data_collected', 0);
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
        update_option('wvl_the_day_data_collected', $i);
    }

    private function collect_impression($venue_id)
    {
        $count_impression = WVL_Analytic_Data_Storage::get_daily_data_count($venue_id, 'impression');
        WVL_Analytic_Data_Storage::insert($venue_id, 'impression', $count_impression);
        WVL_Analytic_Data_Storage::delete_daily_data($venue_id, 'impression');
    }

    private function collect_unique_view($venue_id)
    {
        $count_unique_view = WVL_Analytic_Data_Storage::get_daily_data_unique_count($venue_id, 'view');
        WVL_Analytic_Data_Storage::insert($venue_id, 'unique_view', $count_unique_view);
        return true;
    }

    private function collect_view($venue_id)
    {
        $count_view = WVL_Analytic_Data_Storage::get_daily_data_count($venue_id, 'view');
        WVL_Analytic_Data_Storage::insert($venue_id, 'view', $count_view);
        WVL_Analytic_Data_Storage::delete_daily_data($venue_id, 'view');
        return true;
    }

    private function collect_contact_click($venue_id)
    {
        $count_contact_click = WVL_Analytic_Data_Storage::get_daily_data_count($venue_id, 'contact_click');
        WVL_Analytic_Data_Storage::insert($venue_id, 'contact_click', $count_contact_click);
        WVL_Analytic_Data_Storage::delete_daily_data($venue_id, 'contact_click');
    }

    private function collect_lead($venue_id) {}

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
