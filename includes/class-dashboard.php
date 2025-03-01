<?php
defined('ABSPATH') || exit;
/**
 * WVL_Dashboard class
 */
class WVL_Dashboard
{
    /**
     * The single instance of the class.
     * 
     * @var WVL_Dashboard
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
        add_action('template_redirect', array($this, 'protect_pages'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 1000);
        add_filter('page_template', array($this, 'dashboard_page_template'));
        add_action('init', array($this, 'dashboard_rewrite_rules'));
        add_filter('query_vars', array($this, 'dashboard_query_vars'));
        add_action('wvl_dashboard', array($this,  'render_wvl_dashboard_menu'));
    }

    public function protect_pages()
    {
        if (is_page('dashboard') && !is_user_logged_in()) {
            wp_redirect(home_url('login'));
            exit;
        }
    }

    public function enqueue_scripts() {}

    /**
     * Modifies the page template for the 'dashboard' page.
     *
     * If the current page is the 'dashboard' page, this function modifies the
     * $page_template variable to point to the custom dashboard template
     * located in the 'templates' directory of the plugin.
     *
     * @param string $page_template The current page template.
     * @return string The modified page template.
     */
    public function dashboard_page_template($page_template)
    {
        if (is_page('dashboard')) {
            $page_template = WVL_PLUGIN_DIR . '/templates/dashboard.php';
        }
        return $page_template;
    }



    /**
     * Adds custom rewrite rules for the dashboard subpages.
     *
     * This function registers a rewrite rule to handle URLs of the form
     * 'dashboard/{subpage}', mapping them to the 'dashboard' page with the
     * 'subpage' query variable set to the specified subpage value.
     *
     * The rewrite rule is added to the top of the rules list, ensuring that
     * it takes precedence over other rules.
     */
    public function dashboard_rewrite_rules()
    {
        add_rewrite_rule('^dashboard/([^/]*)/?', 'index.php?pagename=dashboard&subpage=$matches[1]', 'top');
    }


    /**
     * Add 'subpage' as a query variable.
     *
     * The 'subpage' query variable is used to identify the sub-page of the
     * Dashboard page. For example, 'dashboard/profile' will use 'profile' as
     * the value of 'subpage'.
     *
     * @param array $vars The list of query variables.
     *
     * @return array The updated list of query variables.
     */
    public function dashboard_query_vars($vars)
    {
        $vars[] = 'subpage';
        return $vars;
    }

    public function render_wvl_dashboard_menu()
    {
        global $wvl_menus;

        if (!isset($wvl_menus) || empty($wvl_menus)) {
            return;
        }
?>
        <div class="wvl-dashboard py-6 md:flex gap-4">
            <div class="sidebar bg-white w-full md:w-3/12 p-2 lg:p-8 md:rounded-xl h-fit mb-4 md:mb-0">
                <ul>
                    <?php foreach ($wvl_menus as $menu) :
                        if (!current_user_can($menu['capability'])) continue;

                        $url = site_url('dashboard/' . $menu['slug']);
                        $is_active = $menu['slug'] === get_query_var('subpage') ? true : false;
                        $class = $is_active ? 'bg-slate-200 text-gray-800 font-semibold' : 'text-slate-700';
                        $active_class = $is_active ? 'active' : '';
                    ?>
                        <li class="mb-3 <?php echo $active_class; ?>">
                            <a class="hover:bg-slate-100 p-3 rounded-md flex items-center <?php echo $class; ?>" href="<?php echo $url; ?>">
                                <span class="icon inline-block w-6 h-6 mr-2 overflow-hidden"><?php echo $menu['icon']; ?></span>
                                <span class="text-sm capitalize inline-block"><?php echo $menu['name']; ?></span>
                                <?php do_action('wvl_menu_badge', $menu['slug']); ?>
                            </a>
                        </li>
                    <?php
                    endforeach; ?>
                    <li class="logout">
                        <form method="post">
                            <?php wp_nonce_field('wvl_logout_nonce', '_wvl_logout_nonce'); ?>
                            <button type="submit" class="wvl-btn-primary w-full">
                                <?php _e('Logout', 'wedding-venue-listings'); ?>

                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            <div class="content w-full md:w-9/12 py-8 p-2 lg:p-8 bg-white md:rounded-xl">
                <?php
                $subpage = get_query_var('subpage');
                $matched = false;
                if ($subpage) {
                    foreach ($wvl_menus as $menu) {
                        if (!current_user_can($menu['capability'])) continue;

                        if ($menu['slug'] === $subpage) {
                            call_user_func($menu['callback']);
                            $matched = true;
                            break;
                        }
                    }
                }

                if (!$matched) {
                    require_once WVL_PLUGIN_DIR . '/template-parts/dashboard/home.php';
                }
                ?>
            </div>
        </div>
<?php
    }


    /**
     * Gets the singleton instance of the class.
     *
     * @return WVL_Dashboard The singleton instance.
     */
    public static function get_instance()
    {
        if (! self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
WVL_Dashboard::get_instance();
