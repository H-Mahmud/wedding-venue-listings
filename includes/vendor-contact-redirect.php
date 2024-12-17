<?php
defined('ABSPATH') || exit;
class WVL_Vendor_Contact_Redirect
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Vendor_Contact_Redirect
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
        add_action('init', array($this, 'vendor_contact_redirect'));
        add_action('template_redirect', array($this, 'vendor_contact_redirect_handle'));

        add_filter('wvl_contact_link', array($this, 'modify_contact_links'));
    }

    /**
     * Add a custom rewrite rule and tags for vendor contact redirect.
     *
     * The rewrite rule is: ^redirect/vendor-contact/?$ => index.php?contact_redirect=1
     *
     * The tags are: %contact_redirect%, %link%.
     *
     * This is used to redirect the user to the contact link after click on the vendor contact link.
     *
     * @since 1.0.0
     * @access public
     */
    public function vendor_contact_redirect()
    {
        add_rewrite_rule('^redirect/vendor-contact/?$', 'index.php?contact_redirect=1', 'top');
        add_rewrite_tag('%contact_redirect%', '1');
        add_rewrite_tag('%link%', '([^&]+)');
    }

    /**
     * Handles the vendor contact redirect.
     *
     * If the contact_redirect query var is set, it will redirect the user to the link
     * specified in the link query var.
     *
     * @since 1.0.0
     * @access public
     */
    public function vendor_contact_redirect_handle()
    {
        if (get_query_var('contact_redirect')) {
            $link = sanitize_text_field(get_query_var('link'));

            do_action('wvl_vendor_contact_redirect_handle', $link);

            wp_redirect($link);
            exit;
        }
    }

    /**
     * Modifies the contact links to include the redirect vendor contact link.
     *
     * @param string $link The original contact link.
     *
     * @return string The modified contact link.
     *
     * @since 1.0.0
     * @access public
     */
    public function modify_contact_links($link)
    {
        return add_query_arg(['link' => $link, 'post_id' => get_the_ID()], home_url('redirect/vendor-contact'));
    }

    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Vendor_Contact_Redirect The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

WVL_Vendor_Contact_Redirect::get_instance();
