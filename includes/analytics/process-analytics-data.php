<?php
defined('ABSPATH') || exit;
/**
 * Venue WVL_Process_Analytics_Data class
 */
class WVL_Process_Analytics_Data
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Process_Analytics_Data
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

        add_action('wp_head', array($this, 'start_data_collection'), 1);
        add_action('wp_footer', array($this, 'send_data_collection'));
    }

    /**
     * Starts the data collection process by creating the global WVL_COLLECTIONS 
     * object that will hold the data that will be sent to the server via an AJAX 
     * request. This object is populated by the various functions in this class.
     *
     * @return void
     */
    public function start_data_collection()
    {
        echo <<<HTML
            <script>
                const WVL_COLLECTIONS = {
                    DATA_1  : [],
                    DATA_2  :[]
                }
            </script>
        HTML;
    }

    /**
     * Sends the data collection to the server
     *
     * @return void
     */
    public function send_data_collection()
    {
        $ajax_url = admin_url('admin-ajax.php');
        $nonce = wp_create_nonce('wvl_analytics_nonce');
        echo <<<HTML
        <script>
            jQuery(document).ready(function($) {
                $.ajax({
                    url: '$ajax_url',
                    type: 'POST',
                    data: {
                        action: 'wvl_collections',
                        nonce: '$nonce',
                        data: WVL_COLLECTIONS,
                    }
                });
            })
        </script>
        HTML;
    }

    /**
     * Outputs JavaScript to append encoded data to a specific collection type.
     *
     * This function takes a type and data, encodes the data in base64 after
     * JSON encoding it, and then outputs a JavaScript snippet to append the 
     * encoded data to either the DATA_1 or DATA_2 collection in the global 
     * WVL_COLLECTIONS object.
     *
     * @param string $type The type of data collection, either 'data_1' or 'data_2'.
     * @param array $data The data to be encoded and added to the collection.
     *
     * @return void
     */
    public static function print($type, $data)
    {
        if (!$data || count($data) == 0 || !is_array($data)) return;

        $data =  base64_encode(json_encode($data));
        if ($type == 'data_1') {
            echo <<<HTML
                <script>
                    WVL_COLLECTIONS.DATA_1.push('...$data');
                </script>
            HTML;
        } else if ($type == 'data_2') {
            echo <<<HTML
                <script>
                    WVL_COLLECTIONS.DATA_2.push('...$data');
                </script>
            HTML;
        }
    }

    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Process_Analytics_Data The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

WVL_Process_Analytics_Data::get_instance();
