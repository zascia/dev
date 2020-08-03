<?php
/**
 * Plugin Name: Elementor Awesomeforms
 * Description: A Elementor Awesomeforms plugin add custom widgets.
 * Plugin URI:  https://www.primofinans.se/
 * Version:     1.0.0
 * Author:      Maksym Burkhan
 * Text Domain: elementor-awesomeforms
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Main Elementor Awesomeforms Class
 *
 * The init class that runs the Elementor Awesomeforms plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.0.0
 */
final class Elementor_Awesomeforms {

    /**
     * Plugin Version
     *
     * @since 1.0.0
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct() {

        // Load translation
        add_action('init', array($this, 'i18n'));

        // Init Plugin
        add_action('plugins_loaded', array($this, 'init'));
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     * Fired by `init` action hook.
     *
     * @since 1.2.0
     * @access public
     */
    public function i18n() {
        load_plugin_textdomain('elementor-awesomeforms');
    }

    /**
     * Initialize the plugin
     *
     * Validates that Elementor is already loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed include the plugin class.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.2.0
     * @access public
     */
    public function init() {

        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', array($this, 'admin_notice_missing_main_plugin'));
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_elementor_version'));
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_php_version'));
            return;
        }

        // Once we get here, We have passed all validation checks so we can safely include our plugin
        require_once( 'plugin.php' );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_missing_main_plugin() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor */
                esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-awesomeforms'),
                '<strong>' . esc_html__('Elementor Awesomeforms', 'elementor-awesomeforms') . '</strong>',
                '<strong>' . esc_html__('Elementor', 'elementor-awesomeforms') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
                esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-awesomeforms'),
                '<strong>' . esc_html__('Elementor Awesomeforms', 'elementor-awesomeforms') . '</strong>',
                '<strong>' . esc_html__('Elementor', 'elementor-awesomeforms') . '</strong>',
                self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
                /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
                esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-awesomeforms'),
                '<strong>' . esc_html__('Elementor Awesomeforms', 'elementor-awesomeforms') . '</strong>',
                '<strong>' . esc_html__('PHP', 'elementor-awesomeforms') . '</strong>',
                self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

}

// Instantiate Elementor_Awesomeforms.
new Elementor_Awesomeforms();

// регистрируем стили
add_action('wp_enqueue_scripts', 'register_plugin_styles', 99);

// регистрируем файл стилей и добавляем его в очередь
function register_plugin_styles() {
    wp_enqueue_script('elementor-awesomeforms-owl', plugin_dir_url(__FILE__) . 'assets/js/owl.js', ['jquery'], false, true);
    wp_enqueue_script('elementor-awesomeforms-sl-min', plugin_dir_url(__FILE__) . 'assets/js/sl-min.js', ['jquery'], false, true);
    wp_enqueue_script('elementor-awesomeforms-steps', plugin_dir_url(__FILE__) . 'assets/js/app.js', ['jquery'], false, true);

    wp_enqueue_style('elementor-awesomeforms-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
}

// add claasname for step1 form
add_filter('body_class', 'extra_body_class');

// Add specific CSS class by filter
function extra_body_class($classes) {
    if (is_page(971))
        $classes[] = 'first-step-form';
    return $classes;
}

function custom_content_after_body_open_tag() {
    ?>
    <input type="hidden" name="domain_val" id="domain_val" value="<?php echo get_bloginfo('url'); ?>">
    <?php
}

add_action('after_body_open_tag', 'custom_content_after_body_open_tag');

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Awesome forms settings',
        'menu_title' => 'Awesome forms',
        'menu_slug' => 'awesomeforms-general-settings',
        'icon_url' => 'dashicons-feedback',
        'position' => 3.6,
        'redirect' => false
    ));

}