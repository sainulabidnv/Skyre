<?php

/**
 * Twitter widget for Elementor builder
 *
 * @link       https://skyresoft.com
 * @since      1.0.0
 *
 */

namespace ewidget\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} //Exit if accessed directly

class SkyreTwitter extends \Elementor\Widget_Base {

	
    public function get_name()
    {
        return 'skyre-twitter';
    }

    public function get_title()
    {
        return esc_html__('Twitter Feed', 'skyre');
    }

    public function get_icon()
    {
        return 'fa fa-twitter';
    }

    
    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_twitter_settings',
            [
                'label' => esc_html__('Account Settings', 'skyre'),
            ]
        );

        $this->add_control(
            'twitter_ac_name',
            [
                'label' => esc_html__('Account Name', 'skyre'),
                'type' => Controls_Manager::TEXT,
                'default' => '@premierleague',
                'label_block' => false,
                'description' => esc_html__('Use @ sign with your account name.', 'skyre'),

            ]
        );

        $this->add_control(
            'twitter_hashtag_name',
            [
                'label' => esc_html__('Hashtag Name', 'skyre'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'description' => esc_html__('Remove # sign from your hashtag name.', 'skyre'),

            ]
        );

        $this->add_control(
            'twitter_consumer_key',
            [
                'label' => esc_html__('Consumer Key', 'skyre'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => 'kczS6sRW6aAJ3BFNJSpEYXB8T',
                'description' => '<a href="https://apps.twitter.com/app/" target="_blank">Get Consumer Key.</a> Create a new app or select existing app and grab the <b>consumer key.</b>',
            ]
        );

        $this->add_control(
            'twitter_consumer_secret',
            [
                'label' => esc_html__('Consumer Secret', 'skyre'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => 'JiTyjqCauweK33SpzWOC9u0a8fQU4bzpTxvE5igkO2vqIOUQeq',
                'description' => '<a href="https://apps.twitter.com/app/" target="_blank">Get Consumer Secret.</a> Create a new app or select existing app and grab the <b>consumer secret.</b>',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_twitter_layout_settings',
            [
                'label' => esc_html__('Layout Settings', 'skyre'),
            ]
        );

        /*
        $this->add_control(
            'twitter_type',
            [
                'label' => esc_html__('Content Layout', 'skyre'),
                'type' => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'list' => esc_html__('List', 'skyre'),
                    'grid' => esc_html__('Grid', 'skyre'),
                ],
            ]
        );

        $this->add_control(
            'twitter_type_col_type',
            [
                'label' => __('Column Grid', 'skyre'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'col-lg-6' => '2 Columns',
                    'col-lg-4' => '3 Columns',
                    'col-lg-3' => '4 Columns',
                ],
                'default' => 'col-lg-3',
                'condition' => [
                    'twitter_type' => 'grid',
                ],
            ]
        );
        */
        $this->add_control(
            'twitter_content_length',
            [
                'label' => esc_html__('Content Length', 'skyre'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => '400',
            ]
        );

        $this->add_control(
            'twitter_post_limit',
            [
                'label' => esc_html__('Post Limit', 'skyre'),
                'type' => Controls_Manager::NUMBER,
                'label_block' => false,
                'default' => 10,
            ]
        );

        $this->add_control(
            'twitter_media',
            [
                'label' => esc_html__('Show Media Elements', 'skyre'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'skyre'),
                'label_off' => __('no', 'skyre'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_twitter_card_settings',
            [
                'label' => esc_html__('Card Settings', 'skyre'),
            ]
        );

        $this->add_control(
            'twitter_show_avatar',
            [
                'label' => esc_html__('Show Thumb', 'skyre'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'skyre'),
                'label_off' => __('no', 'skyre'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->add_control(
            'twitter_avatar_style',
            [
                'label' => __('Avatar Style', 'skyre'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'circle' => 'Circle',
                    'square' => 'Square',
                ],
                'default' => 'circle',
                'prefix_class' => 'sk-social-feed-avatar-',
                'condition' => [
                    'twitter_show_avatar' => 'true',
                ],
            ]
        );

        $this->add_control(
            'twitter_show_name',
            [
                'label' => esc_html__('Show Name', 'skyre'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'skyre'),
                'label_off' => __('no', 'skyre'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );


        $this->add_control(
            'twitter_show_date',
            [
                'label' => esc_html__('Show Date', 'skyre'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'skyre'),
                'label_off' => __('no', 'skyre'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->add_control(
            'twitter_show_read_more',
            [
                'label' => esc_html__('Show Read More', 'skyre'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'skyre'),
                'label_off' => __('no', 'skyre'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        
        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style (Twitter Feed Card Style)
         * -------------------------------------------
         */
        $this->start_controls_section(
            'section_twitter_card_style_settings',
            [
                'label' => esc_html__('Card Style', 'skyre'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'twitter_card_bg_color',
            [
                'label' => esc_html__('Background Color', 'skyre'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sk-twitter-item-inner' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'twitter_card_container_padding',
            [
                'label' => esc_html__('Padding', 'skyre'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sk-twitter-item-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .sk-twitter-item-content' => 'padding: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'twitter_card_border',
                'label' => esc_html__('Border', 'skyre'),
                'selector' => '{{WRAPPER}} .sk-twitter-item-inner',
            ]
        );

        $this->add_control(
            'twitter_card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'skyre'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sk-twitter-item-inner' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'twitter_card_shadow',
                'selector' => '{{WRAPPER}} .sk-twitter-item-inner',
            ]
        );

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style (Twitter Feed Typography Style)
         * -------------------------------------------
         */
        $this->start_controls_section(
            'section_twitter_card_typo_settings',
            [
                'label' => esc_html__('Color &amp; Typography', 'skyre'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'twitter_title_heading',
            [
                'label' => esc_html__('Title Style', 'skyre'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'twitter_title_color',
            [
                'label' => esc_html__('Color', 'skyre'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sk-twitter-item .sk-twitter-item-author' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'twitter_title_typography',
                'selector' => '{{WRAPPER}} .sk-twitter-item .sk-twitter-item-author',
            ]
        );
        // Content Style
        $this->add_control(
            'twitter_content_heading',
            [
                'label' => esc_html__('Content Style', 'skyre'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'twitter_content_color',
            [
                'label' => esc_html__('Color', 'skyre'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sk-twitter-item .sk-twitter-item-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'twitter_content_typography',
                'selector' => '{{WRAPPER}} .sk-twitter-item .sk-twitter-item-content p',
            ]
        );

        // Content Link Style
        $this->add_control(
            'twitter_content_link_heading',
            [
                'label' => esc_html__('Link Style', 'skyre'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'twitter_content_link_color',
            [
                'label' => esc_html__('Color', 'skyre'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sk-twitter-item .sk-twitter-item-content a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'twitter_content_link_hover_color',
            [
                'label' => esc_html__('Hover Color', 'skyre'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .sk-twitter-item .sk-twitter-item-content a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'twitter_content_link_typography',
                'selector' => '{{WRAPPER}} .sk-twitter-item .sk-twitter-item-content a',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Twitter Feed
     *
     * @since 1.0
     */
    public function twitter_render_items($id, $settings, $class = '')
    {
        $token = get_option($id . '_' . $settings['twitter_ac_name'] . '_tf_token');
        //$items = get_transient($id . '_' . $settings['twitter_ac_name'] . '_tf_cache');
        $html = '';
        $items = false;

        $token = '';
        
        if(empty($settings['twitter_consumer_key']) || empty($settings['twitter_consumer_secret'])) {
            return;
        }

        if ($items === false) {
            if (empty($token)) {
                $credentials = base64_encode($settings['twitter_consumer_key'] . ':' . $settings['twitter_consumer_secret']);

                add_filter('https_ssl_verify', '__return_false');

                $response = wp_remote_post('https://api.twitter.com/oauth2/token', [
                    'method' => 'POST',
                    'httpversion' => '1.1',
                    'blocking' => true,
                    'headers' => [
                        'Authorization' => 'Basic ' . $credentials,
                        'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
                    ],
                    'body' => ['grant_type' => 'client_credentials'],
                ]);

                $body = json_decode(wp_remote_retrieve_body($response));

                if ($body) {
                    update_option($id . '_' . $settings['twitter_ac_name'] . '_tf_token', $body->access_token);
                    $token = $body->access_token;
                }
            }

            $args = array(
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => array(
                    'Authorization' => "Bearer $token",
                ),
            );

            add_filter('https_ssl_verify', '__return_false');

            $response = wp_remote_get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $settings['twitter_ac_name'] . '&count=999&tweet_mode=extended', [
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => [
                    'Authorization' => "Bearer $token",
                ],
            ]);

            if (!is_wp_error($response)) {
                $items = json_decode(wp_remote_retrieve_body($response), true);
                //set_transient($id . '_' . $settings['twitter_ac_name'] . '_tf_cache', $items, 1800);
            }
        }

        if(empty($items)) {
            return;
        }
        //echo '<pre>';
        //print_r($items);
        //exit;
        //jim_jcgg
        
        if ($settings['twitter_hashtag_name']) {
            foreach ($items as $key => $item) {
                $match = false;
                
                if ($item['entities']['hashtags']) {
                    foreach ($item['entities']['hashtags'] as $tag) {
                        if (strcasecmp($tag['text'], $settings['twitter_hashtag_name']) == 0) {
                            $match = true;
                        }
                    }
                }

                if($match == false) {
                    unset($items[$key]);
                }
            }
        }

        $items = array_splice($items, 0, $settings['twitter_post_limit']);


        foreach ($items as $item) {
            $html .= '<div class=" sk-border-15 sk-twitter-item ' . $class . '">
                <div class="sk-twitter-item-inner row">';
                if ($settings['twitter_show_avatar'] == 'true') {
                    $html .= '<div class="col-3">
                        <div class="sk-twit-thumb"> ';
                        
                            if(isset($item['extended_entities']['media'][0]) and $item['extended_entities']['media'][0]['type'] == 'photo')
                            {
                                if(isset($item['extended_entities']['media'][0]['sizes']['thumb'])) {$tsize = ':thumb';} else {$tsize ='';} 
                                
                                $html .= '
                                    <a class="sk-twitter-item-avatar avatar-' . $settings['twitter_avatar_style'] . '" href="//twitter.com/' . $settings['twitter_ac_name'] . '" target="_blank">    
                                    <img src="' . $item['extended_entities']['media'][0]['media_url_https'] . $tsize . '">
                                    </a>';

                            }else {
                            $html .= '<a class="sk-twitter-item-avatar avatar-' . $settings['twitter_avatar_style'] . '" href="//twitter.com/' . $settings['twitter_ac_name'] . '" target="_blank">
                                <img src="' . $item['user']['profile_image_url_https'] . '">
                            </a>';
                            }
                        
                        
                        $html .='</div>
                    </div>';
                }
                    $html .='<div class="'.($settings['twitter_show_avatar'] == 'true' ? 'col-9':'').'">
                        <div class="sk-twitter-meta">';
                            
                            
                            if ($settings['twitter_show_name'] == 'true') {
                                $html .= '<a class="sk-twitter-item-meta" href="//twitter.com/' . $settings['twitter_ac_name'] . '" target="_blank"> <span class="sk-twitter-item-author">' . $item['user']['name'] . '</span> </a>';
                            }
                                
                            
                        $html .= '</div>

                        <div class="sk-twitter-item-content">
                            ' . substr(str_replace(@$item['entities']['urls'][0]['url'], '', $item['full_text']), 0, $settings['twitter_content_length']) . '...
                            ' . (isset($item['extended_entities']['media'][0]) && $settings['twitter_media'] == 'true' ? ($item['extended_entities']['media'][0]['type'] == 'photo' ? '<div class="media"> <img src="' . $item['extended_entities']['media'][0]['media_url_https'] . '"></div>' : '') : '') ;
                             
                        $html .= '</div>';
                        if ($settings['twitter_show_date'] == 'true') {
                            $html .= '<span class="sk-twitter-item-date">' . sprintf(__('%s ago', 'skyre'), human_time_diff(strtotime($item['created_at']))) . '</span>';
                        }
                        if ($settings['twitter_show_read_more'] == 'true') {
                            $html .= '<a href="//twitter.com/' . @$item['user']['screen_name'] . '\/status/' . $item['id'] . '" target="_blank" class="read-more-link sksc">Read More <i class="fas fa-angle-double-right"></i></a>';
                        }
                    
                        $html .= '</div>
                    <div class="clearfilter"></div>
                </div>
			</div>';
        }

        return $html;
    }

    protected function render()
    {
        $settings = $this->get_settings();

        echo '<div class="sk-twitter sk-twitter-' . $this->get_id() . '" >
			' . $this->twitter_render_items($this->get_id(), $settings) . '
        </div>';
        
       
    }
}

//Plugin::instance()->widgets_manager->register_widget_type( new EAE_Twitter() );