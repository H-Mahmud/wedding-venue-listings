<?php
defined('ABSPATH') || exit;
/**
 * Venue Analytics class
 */
class WVL_Venue_Analytics
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Venue_Analytics
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

        add_action('wp_footer', array($this, 'send_analytical_data'));


        add_action('wp_ajax_wvl_analytics', array($this, 'data_collection'));
        add_action('wp_ajax_nopriv_wvl_analytics', array($this, 'data_collection'));
    }

    public function send_analytical_data()
    { ?>
        <script>
            jQuery(document).ready(function($) {
                const venues = $('.venue-item');
                const venues_array = [];
                venues.each(function() {
                    venue = $(this);
                    venues_array.push(venue.data('id'));
                });
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'wvl_analytics',
                        nonce: '<?php echo wp_create_nonce('wvl_analytics_nonce'); ?>',
                        data: venues_array
                    }
                });
            })
        </script>

<?php
    }

    public function data_collection()
    {
        check_ajax_referer('wvl_analytics_nonce', 'nonce');

        if (empty($_POST['data'])) {
            wp_send_json_error('No data');
        }
        $event_types = ['impression', 'view', 'unique_view', 'contact_click', 'lead'];
        $data = array(
            'action' => 'wvl_analytics',
            'nonce' => wp_create_nonce('wvl_analytics_nonce'),
            'data' => $_POST['data'],
        );
        echo json_encode($data);
        wp_die();
    }

    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Venue_Analytics The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

WVL_Venue_Analytics::get_instance();
