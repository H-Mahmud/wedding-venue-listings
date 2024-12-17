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
            $this->collect_view($venue_id);
            $this->collect_contact_click($venue_id);
            $this->collect_lead($venue_id);

            --$each_data_process;
            if ($each_data_process == 0)  break;
        }
        // update_option('wvl_the_day_data_collected', $data_processed);
    }

    private function collect_impression($venue_id)
    {
        $count_impression = WVL_Analytic_Data_Storage::get_daily_data_count($venue_id, 'impression');
        WVL_Analytic_Data_Storage::insert($venue_id, 'impression', $count_impression);
    }

    private function collect_view($venue_id) {}

    private function collect_contact_click($venue_id) {}

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
