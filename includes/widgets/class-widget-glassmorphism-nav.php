<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class Glassmorphism_Nav_Widget extends Widget_Base {
    public function get_name() {
        return 'glassmorphism-nav';
    }

    public function get_title() {
        return __( 'Glassmorphism Nav', 'glassmorphism-nav-elementor' );
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_categories() {
        return array( 'general' );
    }

    public function get_keywords() {
        return array( 'nav', 'navigation', 'glass', 'glassmorphism', 'menu' );
    }

    public function get_style_depends() {
        return array(
            'glassmorphism-nav-elementor-style',
            'glassmorphism-nav-elementor-fontawesome',
        );
    }

    public function get_script_depends() {
        return array(
            'glassmorphism-nav-elementor-script',
        );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => __( 'Content', 'glassmorphism-nav-elementor' ),
            )
        );

        $this->add_control(
            'logo_url',
            array(
                'label' => __( 'Logo Image', 'glassmorphism-nav-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => array(
                    'url' => '',
                ),
            )
        );

        $this->add_control(
            'logo_alt',
            array(
                'label' => __( 'Logo Alt Text', 'glassmorphism-nav-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Logo', 'glassmorphism-nav-elementor' ),
            )
        );

        $this->add_control(
            'logo_link',
            array(
                'label' => __( 'Logo Link', 'glassmorphism-nav-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => array(
                    'url' => '#',
                ),
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'menu_item_title',
            array(
                'label' => __( 'Menu Item', 'glassmorphism-nav-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Home', 'glassmorphism-nav-elementor' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'menu_item_link',
            array(
                'label' => __( 'Link', 'glassmorphism-nav-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => array(
                    'url' => '#',
                ),
            )
        );

        $repeater->add_control(
            'menu_item_active',
            array(
                'label' => __( 'Active', 'glassmorphism-nav-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'glassmorphism-nav-elementor' ),
                'label_off' => __( 'No', 'glassmorphism-nav-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'menu_items',
            array(
                'label' => __( 'Menu Items', 'glassmorphism-nav-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => array(
                    array(
                        'menu_item_title' => 'Home',
                        'menu_item_link' => array( 'url' => '#' ),
                        'menu_item_active' => 'yes',
                    ),
                    array(
                        'menu_item_title' => 'About',
                        'menu_item_link' => array( 'url' => '#about' ),
                    ),
                    array(
                        'menu_item_title' => 'Portfolio',
                        'menu_item_link' => array( 'url' => '#portfolio' ),
                    ),
                    array(
                        'menu_item_title' => 'Services',
                        'menu_item_link' => array( 'url' => '#services' ),
                    ),
                    array(
                        'menu_item_title' => 'Contact',
                        'menu_item_link' => array( 'url' => '#contact' ),
                    ),
                ),
                'title_field' => '{{{ menu_item_title }}}',
            )
        );

        $this->add_control(
            'current_page_text',
            array(
                'label' => __( 'Current Page Text', 'glassmorphism-nav-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Home', 'glassmorphism-nav-elementor' ),
            )
        );

        $this->add_control(
            'cta_text',
            array(
                'label' => __( 'CTA Text', 'glassmorphism-nav-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Get a Quote', 'glassmorphism-nav-elementor' ),
            )
        );

        $this->add_control(
            'cta_link',
            array(
                'label' => __( 'CTA Link', 'glassmorphism-nav-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => array(
                    'url' => '#contact',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $logo_url = isset( $settings['logo_url']['url'] ) ? $settings['logo_url']['url'] : '';
        $logo_alt = ! empty( $settings['logo_alt'] ) ? $settings['logo_alt'] : __( 'Logo', 'glassmorphism-nav-elementor' );
        $logo_link = ! empty( $settings['logo_link']['url'] ) ? $settings['logo_link']['url'] : '#';
        $current_page_text = ! empty( $settings['current_page_text'] ) ? $settings['current_page_text'] : __( 'Home', 'glassmorphism-nav-elementor' );
        $cta_text = ! empty( $settings['cta_text'] ) ? $settings['cta_text'] : __( 'Get a Quote', 'glassmorphism-nav-elementor' );
        $cta_link = ! empty( $settings['cta_link']['url'] ) ? $settings['cta_link']['url'] : '#contact';
        $menu_items = ! empty( $settings['menu_items'] ) ? $settings['menu_items'] : array();

        ?>
        <div class="glassmorphism-nav-widget">
            <header class="navbar bottom-docked" data-state="closed">
                <nav class="nav-container">
                    <div class="nav-logo">
                        <a href="<?php echo esc_url( $logo_link ); ?>" class="logo-link">
                            <?php if ( ! empty( $logo_url ) ) : ?>
                                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>">
                            <?php else : ?>
                                <span class="logo-text"><?php echo esc_html( $logo_alt ); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="current-page-indicator">
                        <span class="current-page-text"><?php echo esc_html( $current_page_text ); ?></span>
                    </div>

                    <ul class="nav-menu">
                        <?php foreach ( $menu_items as $item ) :
                            $title = isset( $item['menu_item_title'] ) ? $item['menu_item_title'] : '';
                            $url = isset( $item['menu_item_link']['url'] ) ? $item['menu_item_link']['url'] : '#';
                            $active = isset( $item['menu_item_active'] ) && 'yes' === $item['menu_item_active'];
                            $classes = 'nav-link' . ( $active ? ' active' : '' );
                        ?>
                            <li class="nav-item">
                                <a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $classes ); ?>">
                                    <span class="nav-text"><?php echo esc_html( $title ); ?></span>
                                    <span class="nav-indicator"></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <li class="nav-item cta-item">
                            <a href="<?php echo esc_url( $cta_link ); ?>" class="nav-link cta-link">
                                <span class="nav-text"><?php echo esc_html( $cta_text ); ?></span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </li>
                    </ul>

                    <div class="toggle-menu-btn" data-state="closed">
                        <span class="toggle-line"></span>
                        <span class="toggle-line"></span>
                        <span class="toggle-line"></span>
                    </div>
                </nav>
            </header>

            <div class="nav-overlay"></div>
        </div>
        <?php
    }
}
