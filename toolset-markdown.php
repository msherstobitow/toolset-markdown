<?php
/**
 * @package Toolset
 * @version 0.1
 */
/*
Plugin Name: Toolset Markdown
Plugin URI: http://makss.ca/plugins/toolset
Description: Markdown ability for Wordpress
Author: Maks Sherstobitow
Version: 0.1
Author URI: http://makss.ca
*/

/*
	TODO:
	get_the_excerpt
	the_content
	the_content_rss
	the_content_feed
	the_title
 */

class Toolset_Markdown_Plugin {
	private static $instance = null;
	private $parsedown = null;
	public static $textdomain = 'toolset_markdown';

	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	*	Singleton pattern
	*/
	static function instance() {
		if (self::$instance == null)
			self::$instance = new Toolset_Markdown_Plugin();
		return self::$instance;
	}

	public function init() {
		remove_filter('the_content', 'wpautop');
		add_filter( 'the_content', array( $this, 'proceed_markdown' ), 10 );
		remove_filter('the_excerpt', 'wpautop');
		add_filter( 'get_the_excerpt', array( $this, 'proceed_markdown' ), 10 );
		require 'vendor/Parsedown.php';
		$this->parsedown = new Parsedown();
	}

	/**
	 * Get HTML from Markdown
	 */
	public function proceed_markdown( $content ) {
		var_dump($this->parsedown->text( $content ));
		return $this->parsedown->text( $content );
	}

}

/**
 * Inits plugin on all plugins loaded
 */
add_action('plugins_loaded', 'toolset_markdown_plugins_loaded');

function toolset_markdown_plugins_loaded() {
	Toolset_Markdown_Plugin::instance();
}