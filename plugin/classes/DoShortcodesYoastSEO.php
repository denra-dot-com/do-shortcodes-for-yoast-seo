<?php

/**
 * DoShortcodesYoast Class
 *
 * The main class for the plugin Do Shortcodes for Yoast SEO
 *
 * @author     Denra.com aka SoftShop Ltd <support@denra.com>
 * @copyright  2019-2020 Denra.com aka SoftShop Ltd
 * @license    GPLv2 or later
 * @version    2.5
 * @link       https://www.denra.com/
 */

namespace Denra\Plugins;

class DoShortcodesYoastSEO extends Plugin {
    
    public function __construct($id, $data = []) {
        
        // Set text_domain for the framework
        $this->text_domain = 'denra-do-sc-yoast-seo';
        
        // Set admin menus texts
        $this->admin_title_menu = __('Do Shortcodes for YoastSEO', 'denra-do-sc-yoast-seo');
        
        $this->settings_default['do_shortcodes'] =[
            'wpseo_title' => 1,
            'wpseo_metadesc' => 1,
            'wpseo_opengraph_title' => 1,
            'wpseo_opengraph_desc' => 1,
            'wpseo_opengraph_site_name' => 1,
            'wpseo_twitter_title' => 1,
            'wpseo_twitter_description' => 1,
            'wpseo_schema_graph' => 1,
            'wp_title' => 0,
            'the_content' => 0,
            'nav_menu' => 0,
            'widget' => 0
        ];
        $this->settings_default['filters_priority'] = 10;
        
        parent::__construct($id, $data);
        
        $this->addFilters();

    }
    
    public function addFilters() {
        
        $settings =& $this->settings['do_shortcodes'];
        
        if (isset($settings['wpseo_title']) && $settings['wpseo_title']) {
            add_filter('wpseo_title', [&$this, 'doShortcodes'], $this->settings['filters_priority']);
        }
        
        if (isset($settings['wpseo_metadesc']) && $settings['wpseo_metadesc']) {
            add_filter('wpseo_metadesc', [&$this, 'doShortcodes'], $this->settings['filters_priority']);
        }
        
        if (isset($settings['wpseo_opengraph_title']) && $settings['wpseo_opengraph_title']) {
            add_filter('wpseo_opengraph_title', [&$this, 'doShortcodes'], $this->settings['filters_priority']);
        }
        
        if (isset($settings['wpseo_opengraph_desc']) && $settings['wpseo_opengraph_desc']) {
            add_filter('wpseo_opengraph_desc', [&$this, 'doShortcodes'], $this->settings['filters_priority']);
        }
        
        if (isset($settings['wpseo_opengraph_site_name']) && $settings['wpseo_opengraph_site_name']) {
            add_filter('wpseo_opengraph_site_name', [&$this, 'doShortcodes'], $this->settings['filters_priority']);
        }
        
        if (isset($settings['wpseo_twitter_title']) && $settings['wpseo_twitter_title']) {
            add_filter('wpseo_twitter_title', [&$this, 'doShortcodes'], $this->settings['filters_priority']);
        }
        
        if (isset($settings['wpseo_twitter_description']) && $settings['wpseo_twitter_description']) {
            add_filter('wpseo_twitter_description', [&$this, 'doShortcodes'], $this->settings['filters_priority']);
        }
        
        if (isset($settings['wpseo_schema_graph']) && $settings['wpseo_schema_graph']) {
            add_filter('wpseo_schema_graph', [&$this, 'doWPSEOSchemaGraphShortcodes'], $this->settings['filters_priority'], 2);
        }
        
        if (isset($settings['wp_title']) && $settings['wp_title']) {
            add_filter('wp_title', 'do_shortcode', $this->settings['filters_priority']);
            add_filter('the_title', 'do_shortcode', $this->settings['filters_priority']);
        }
        
        if (isset($settings['the_content']) && $settings['the_content']) {
            add_filter('the_content', 'do_shortcode', $this->settings['filters_priority']);
        }
        
        if (isset($settings['nav_menu']) && $settings['nav_menu']) {
            add_filter('walker_nav_menu_start_el', 'do_shortcode', $this->settings['filters_priority']);
        }
        
        if (isset($settings['widget']) && $settings['widget']) {
            add_filter('widget_title', [&$this, 'doShortcodes'], $this->settings['filters_priority'], 3);
            add_filter('widget_text', 'do_shortcode', $this->settings['filters_priority'], 3);
            add_filter('widget_custom_html_content', 'do_shortcode', $this->settings['filters_priority'], 3);
        }
    }
    
    public function doShortcodes($content) {
        
        return htmlentities(do_shortcode(html_entity_decode($content)));
        
    }
    
    public function adminSettingsContent() {
        
        echo '<fieldset>';
        echo '<legend>' . __('Do shortcodes for SEO title and description', 'denra-do-sc-yoast-seo') . '</legend>';
        echo '<label for="wpseo_title"><input id="wpseo_title" name="wpseo_title" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['wpseo_title']) && $this->settings['do_shortcodes']['wpseo_title'] ? ' checked' : '') . ' /> ' . __('SEO Title', 'denra-do-sc-yoast-seo') . '</label>';
        echo '<label for="wpseo_metadesc"><input id="wpseo_metadesc" name="wpseo_metadesc" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['wpseo_metadesc']) && $this->settings['do_shortcodes']['wpseo_metadesc'] ? ' checked' : '') . ' /> ' . __('SEO Description', 'denra-do-sc-yoast-seo') . '</label>';
        echo '</fieldset>';
        
        echo '<fieldset>';
        echo '<legend>' . __('Do shortcodes for Facebook (Open Graph)', 'denra-do-sc-yoast-seo') . '</legend>';
        echo '<label for="wpseo_opengraph_title"><input id="wpseo_opengraph_title" name="wpseo_opengraph_title" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['wpseo_opengraph_title']) && $this->settings['do_shortcodes']['wpseo_opengraph_title'] ? ' checked' : '') . ' /> ' . __('Facebook Title', 'denra-do-sc-yoast-seo') . '</label>';
        echo '<label for="wpseo_opengraph_desc"><input id="wpseo_opengraph_desc" name="wpseo_opengraph_desc" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['wpseo_opengraph_desc']) && $this->settings['do_shortcodes']['wpseo_opengraph_desc'] ? ' checked' : '') . ' /> ' . __('Facebook Description', 'denra-do-sc-yoast-seo') . '</label>';
        echo '<label for="wpseo_opengraph_site_name"><input id="wpseo_opengraph_site_name" name="wpseo_opengraph_site_name" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['wpseo_opengraph_site_name']) && $this->settings['do_shortcodes']['wpseo_opengraph_site_name'] ? ' checked' : '') . ' /> ' . __('Facebook Site Name', 'denra-do-sc-yoast-seo') . '</label>';
        echo '</fieldset>';
        
        echo '<fieldset>';
        echo '<legend>'  . __('Do shortcodes for Twitter', 'denra-do-sc-yoast-seo') . '</legend>';
        echo '<label for="wpseo_twitter_title"><input id="wpseo_twitter_title" name="wpseo_twitter_title" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['wpseo_twitter_title']) && $this->settings['do_shortcodes']['wpseo_twitter_title'] ? ' checked' : '') . ' /> ' . __('Twitter Title', 'denra-do-sc-yoast-seo') . '</label>';
        echo '<label for="wpseo_twitter_description"><input id="wpseo_twitter_description" name="wpseo_twitter_description" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['wpseo_twitter_description']) && $this->settings['do_shortcodes']['wpseo_twitter_description'] ? ' checked' : '') . ' /> ' . __('Twitter Description', 'denra-do-sc-yoast-seo') . '</label>';
        echo '</fieldset>';
        
        echo '<fieldset>';
        echo '<legend>'  . __('Do shortcodes for Schema Graph', 'denra-do-sc-yoast-seo') . '</legend>';
        echo '<label for="wpseo_schema_graph"><input id="wpseo_schema_graph" name="wpseo_schema_graph" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['wpseo_schema_graph']) && $this->settings['do_shortcodes']['wpseo_schema_graph'] ? ' checked' : '') . ' /> ' . __('Schema Graph Texts', 'denra-do-sc-yoast-seo') . '</label>';
        echo '</fieldset>';
        
        echo '<fieldset>';
        echo '<legend>'  . __('Do shortcodes in other locations', 'denra-do-sc-yoast-seo') . '<sup>1</sup></legend>';
        echo '<label for="wp_title"><input id="wp_title" name="wp_title" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['wp_title']) && $this->settings['do_shortcodes']['wp_title'] ? ' checked' : '') . ' /> ' . __('Post/Page Title', 'denra-do-sc-yoast-seo') . '</label>';
        echo '<label for="the_content"><input id="the_content" name="the_content" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['the_content']) && $this->settings['do_shortcodes']['the_content'] ? ' checked' : '') . ' /> ' . __('Post/Page Content', 'denra-do-sc-yoast-seo') . '</label>';
        echo '<label for="nav_menu"><input id="nav_menu" name="nav_menu" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['nav_menu']) && $this->settings['do_shortcodes']['nav_menu'] ? ' checked' : '') . ' /> ' . __('Navigation Menu', 'denra-do-sc-yoast-seo') . '</label>';
        echo '<label for="widget"><input id="widget" name="widget" type="checkbox" value="1"' . (isset($this->settings['do_shortcodes']['widget']) && $this->settings['do_shortcodes']['widget'] ? ' checked' : '') . ' /> ' . __('Widget Title and Content', 'denra-do-sc-yoast-seo') . '</label>';
        echo '</fieldset>';
        
        echo '<label for="filters_priority">' . __('Change filters\' priority:', 'denra-do-sc-yoast-seo') . '<sup>2</sup> <input id="filters_priority" name="filters_priority" type="number" min="1" max="999999999" size="12" maxlength="9" value="' . $this->settings['filters_priority']. '" /> (1 - 999999999)</label>';
        
        echo '<p><sup>1</sup> '. __('In case they do not work already.', 'denra-do-sc-yoast-seo');
        echo '<br><sup>2</sup> '. __('In case the filters do not work. Higher is better.', 'denra-do-sc-yoast-seo') . '</p>';
        
        parent::adminSettingsContent();

    }
    
    public function adminSettingsProcessing() {
        
        parent::adminSettingsProcessing();
        
        foreach (array_keys($this->settings_default['do_shortcodes']) as $key) {
            $this->settings['do_shortcodes'][$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT);
        }
        $this->settings['filters_priority'] = abs(filter_input(INPUT_POST, 'filters_priority', FILTER_SANITIZE_NUMBER_INT));
        if ($this->settings['filters_priority'] < 10) {
            $this->settings['filters_priority'] = 10;
        }
        if ($this->settings['filters_priority'] > 999999999) {
            $this->settings['filters_priority'] = 999999999;
        }

    }
    
    public function doWPSEOSchemaGraphShortcodes($graph, $context) {
        foreach($graph as $k1 => $gr) {
            $graph[$k1] = $this->processWPSEOSchemaGraphArray($gr);
        }
        return $graph;
    }
    
    public function processWPSEOSchemaGraphArray($gr) {
        foreach($gr as $k2 => $val) {
            if (is_array($val)) {
                $gr[$k2] = $this->processWPSEOSchemaGraphArray($val);
            }
            elseif (is_string($val)) {
                $text = stripslashes($val);
                $gr[$k2] = addslashes(apply_shortcodes($text));
            }
        }
        return $gr;
    }
}
