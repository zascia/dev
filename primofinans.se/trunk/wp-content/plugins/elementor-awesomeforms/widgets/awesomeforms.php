<?php

namespace ElementorAwesomeforms\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class AwesomeformsStep1 extends Widget_Base {

    /**
     * Retrieve the widget name.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'awesomeformsstep1';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Awesomeforms step 1', 'elementor-awesomeforms');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fa fa-wpforms';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['general'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
                'section_content',
                [
                    'label' => __('Content', 'elementor-awesomeforms'),
                ]
        );

        $this->add_control(
                'title',
                [
                    'label' => __('Title', 'elementor-awesomeforms'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Välj lånebelopp och återbetalningstid', 'elementor-awesomeforms'),
                ]
        );


        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('title', 'none');
        ?>
        <h2 <?php echo $this->get_render_attribute_string('title'); ?>><?php echo $settings['title']; ?></h2>
        <?php
        require_once( __DIR__ . '/template/breadcrumbs.php' );
        require_once( __DIR__ . '/template/form_step1.php' );
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function _content_template() {
        ?>
        <#
        view.addInlineEditingAttributes( 'title', 'none' );
        #>
        <h2 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>
        <?php
        require_once( __DIR__ . '/template/breadcrumbs.php' );
        require_once( __DIR__ . '/template/form_step1.php' );
    }

}

class AwesomeformsStep2 extends Widget_Base {

    /**
     * Retrieve the widget name.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'awesomeformsstep2';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Awesomeforms step 2', 'elementor-awesomeforms');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fa fa-wpforms';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['general'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
                'section_content',
                [
                    'label' => __('Content', 'elementor-awesomeforms'),
                ]
        );

        $this->add_control(
                'title',
                [
                    'label' => __('Title', 'elementor-awesomeforms'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Få erbjudanden om lån', 'elementor-awesomeforms'),
                ]
        );


        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('title', 'none');
        ?>
        <h2 <?php echo $this->get_render_attribute_string('title'); ?>><?php echo $settings['title']; ?></h2>
        <?php
        require_once( __DIR__ . '/template/breadcrumbs.php' );
        require_once( __DIR__ . '/template/form_step2.php' );
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function _content_template() {
        ?>
        <#
        view.addInlineEditingAttributes( 'title', 'none' );
        #>
        <h2 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>
        <?php
        require_once( __DIR__ . '/template/breadcrumbs.php' );
        require_once( __DIR__ . '/template/form_step2.php' );
    }

}
