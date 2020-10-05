<?php
/**
 * Proca: Progressive Campaigning
 *
 * @package           Proca
 * @author            Xavier Dutoit
 * @copyright         2020 Proca.foundation
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Proca: progressive campaigning
 * Plugin URI:        https://github.com/TechToThePeople/proca-wordpress
 * Description:       Add a petition signature form to your website
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Proca foundation
 * Author URI:        https://proca.foundation
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

add_shortcode('proca', 'proca_widget');
add_action( 'init', 'proca_register_block' );

function proca_register_block() {
 
    // automatically load dependencies and version
    $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');
    wp_register_script(
        'proca_block',
        plugins_url( 'build/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );
 
    register_block_type( 'proca/action', array(
        'editor_script' => 'proca_block',
    ) );
 
}

function proca_widget( $atts = [], $content = null) {
  $params ="";
  $errors ="";
  $url = "https://widget.proca.foundation/d/";
  $attributes = shortcode_atts(array('action' => 'demo','debug' => false),$atts,'proca');
  $url .= urlencode($attributes['action']);
  if ($attributes['debug']) {
    $url = "http://localhost:3000/static/js/bundle.js";
  }
  unset($atts['action']);
  unset($atts['debug']);
  foreach ($atts as $key => $value) 
    $params .= "data-".$key.'="'.$value.'"';
  return '<div class="proca-widget" '.$params.'>Loading...</div><script id="proca" src="'.$url.'" '. $params . '></script>';
}
