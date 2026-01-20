<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Rio_Marquee_Widget extends Widget_Base {

    public function get_name() {
        return 'rio-marquee';
    }

    public function get_title() {
        return __('Rio Marquee', 'rio');
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        return ['rio-marquee'];
    }

    public function get_script_depends() {
        return ['rio-marquee'];
    }

    /* -------------------------------------------
     * CONTROLS
     * ------------------------------------------- */
    protected function register_controls() {

        /* ---------- Content ---------- */
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Items', 'rio'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'rio'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'text',
            [
                'label' => __('Text', 'rio'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Logo', 'rio'),
            ]
        );

        $this->add_control(
            'items',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['text' => 'Logo 1'],
                    ['text' => 'Logo 2'],
                    ['text' => 'Logo 3'],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

        /* ---------- Marquee Settings ---------- */
        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Marquee Settings', 'rio'),
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => __('Speed', 'rio'),
                'type' => Controls_Manager::NUMBER,
                'default' => 40,
                'min' => 5,
                'max' => 200,
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => __('Pause on Hover', 'rio'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        /* ---------- Image Style ---------- */
        $this->start_controls_section(
            'section_image_style',
            [
                'label' => __('Image Style', 'rio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
        'item_gap',
        [
            'label' => __('Space Between Items', 'rio'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'default' => [
                'size' => 40,
            ],
            'selectors' => [
                '{{WRAPPER}} .rio-marquee-track' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

        $this->add_control(
            'image_fit',
            [
                'label' => __('Image Fit', 'rio'),
                'type' => Controls_Manager::SELECT,
                'default' => 'contain',
                'options' => [
                    'contain' => __('Contain', 'rio'),
                    'cover'   => __('Cover', 'rio'),
                    'none'    => __('Original', 'rio'),
                    'fixed'   => __('1024 × 1024', 'rio'),
                    'custom'  => __('Custom', 'rio'),
                ],
            ]
        );

        $this->add_control(
            'image_ratio',
            [
                'label' => __('Aspect Ratio', 'rio'),
                'type' => Controls_Manager::SELECT,
                'default' => '1-1',
                'options' => [
                    '1-1'  => '1:1',
                    '4-3'  => '4:3',
                    '16-9' => '16:9',
                    'auto' => __('Auto', 'rio'),
                ],
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => __('Image Width', 'rio'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 20, 'max' => 1024],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rio-marquee-item img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'image_fit' => 'custom',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => __('Image Height', 'rio'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 20, 'max' => 1024],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rio-marquee-item img' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'image_fit' => 'custom',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_radius',
            [
                'label' => __('Border Radius', 'rio'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rio-marquee-item' =>
                        'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_bg',
            [
                'label' => __('Background Color', 'rio'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rio-marquee-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => __('Padding', 'rio'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rio-marquee-item' =>
                        'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hover_effect',
            [
                'label' => __('Hover Effect', 'rio'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'      => __('None', 'rio'),
                    'scale'     => __('Scale', 'rio'),
                    'grayscale' => __('Grayscale', 'rio'),
                    'both'      => __('Scale + Grayscale', 'rio'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    /* -------------------------------------------
     * RENDER
     * ------------------------------------------- */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['items'] ) ) return;

        $classes = [
            'rio-marquee',
            'rio-fit-' . $settings['image_fit'],
            'rio-ratio-' . $settings['image_ratio'],
            'rio-hover-' . $settings['hover_effect'],
        ];
        ?>
        <div class="<?php echo esc_attr( implode(' ', $classes) ); ?>"
             data-speed="<?php echo esc_attr( $settings['speed'] ); ?>"
             data-pause="<?php echo esc_attr( $settings['pause_on_hover'] ); ?>">

            <div class="rio-marquee-track">
                <?php foreach ( $settings['items'] as $item ) : ?>
                    <div class="rio-marquee-item">
                        <?php if ( ! empty( $item['image']['url'] ) ) : ?>
                            <img
                                src="<?php echo esc_url( $item['image']['url'] ); ?>"
                                alt="<?php echo esc_attr( $item['text'] ); ?>"
                                loading="lazy"
                            >
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <?php
    }
}
