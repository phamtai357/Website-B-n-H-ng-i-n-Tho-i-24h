<?php
/*
Plugin Name: Data Installer
Plugin URI: http://kutethemes.net/
Description: Install Sample Data Category, content, history, media, menus, mics, stage, widget,...
Version: 1.4.1
Author: Angels.IT
*/
// Load API
require_once dirname( __FILE__ ) . '/utility.php';


class KT_Data_Installer{
    /**
	 * the paths.
	 *
	 * @since 1.0
	 * @var string
	 */
	private $paths;
    
    private $url;
    
    /**
	 * Core singleton class
	 * @var Singleton self - pattern realization
	 */
	private static $_instance;
    
    /**
     * the demo data
     * 
     * @since 1.0
     * @var array()
     */
    private $data = array(
        'default' => array(
            'title'      => 'Default demo',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',
                'menu-2'            => 'menu-2',
                'menu-3'            => 'menu-3',
                'menu-4'            => 'menu-4',
                'menu-5'            => 'menu-5',
                'menu-6'            => 'menu-6',
                'menu-7'            => 'menu-7',
                'menu-8'            => 'menu-8',
                'menu-9'            => 'menu-9',
                'menu-10'           => 'menu-10',
                'menu-11'           => 'menu-11',
                'menu-12'           => 'menu-12',
                'menu-13'           => 'menu-13',
                'menu-14'           => 'menu-14',
                'menu-15'           => 'menu-15',
                'menu-16'           => 'menu-16',
                'menu-17'           => 'menu-17',
                'menu-18'           => 'menu-18',
                'menu-19'           => 'menu-19',
                'menu-20'           => 'menu-20',
                'widget'            => 'widget' 
            )
        ),//
        'option2' => array(
            'title'      => 'Option 2',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',
                'widget'            => 'widget' 
            )
        ),//
        'option3' => array(
            'title'      => 'Option 3',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',
                'widget'            => 'widget' 
            )
        ),//
        'option4' => array(
            'title'      => 'Option 4',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',
                'widget'            => 'widget' 
            )
        ),//
        'option5' => array(
            'title'      => 'Option 5',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',

            )
        ),//
        'option6' => array(
            'title'      => 'Option 6',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',
                'widget'            => 'widget' 
            )
        ),//
        'option7' => array(
            'title'      => 'Option 7',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',
                'widget'            => 'widget' 
            )
        ),//
        'option8' => array(
            'title'      => 'Option 8',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',

            )
        ),//
        'option9' => array(
            'title'      => 'Option 9',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'categories'        => 'category',
                'terms'             => 'term',
                'tags'              => 'tag',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',
                'menu-2'            => 'menu-2',
                'menu-3'            => 'menu-3',
                'menu-4'            => 'menu-4',
                'menu-5'            => 'menu-5',
                'menu-6'            => 'menu-6',
                'menu-7'            => 'menu-7',
                'menu-8'            => 'menu-8',
                'widget'            => 'widget' 
            )
        ),//
        'option11' => array(
            'title'      => 'Option 11',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'tags'              => 'tag',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',
                'menu-2'            => 'menu-2',
                'menu-3'            => 'menu-3',
                'menu-4'            => 'menu-4',
                'menu-5'            => 'menu-5',
                'menu-6'            => 'menu-6',
                'menu-7'            => 'menu-7',
                'menu-8'            => 'menu-8',
                'menu-9'            => 'menu-9',
                'menu-10'           => 'menu-10',
                'menu-11'           => 'menu-11',
                'menu-12'           => 'menu-12',
                'menu-13'           => 'menu-13',
                'menu-14'           => 'menu-14',
                'widget'            => 'widget' 
            )
        ),
        'option12' => array(
            'title'      => 'Option 12',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'categories'        => 'category',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'menu'              => 'menu',
                'widget'            => 'widget' 
            )
        ),//
        'option13' => array(
            'title'      => 'Option 13',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',
                'menu-2'            => 'menu-2',
                'menu-3'            => 'menu-3',
                'menu-4'            => 'menu-4',
                'menu-5'            => 'menu-5',
                'menu-6'            => 'menu-6',
                'menu-7'            => 'menu-7',
                'menu-8'            => 'menu-8',
                'menu-9'            => 'menu-9',
                'menu-10'           => 'menu-10',
                'menu-11'           => 'menu-11',
                'menu-12'           => 'menu-12',
                'menu-13'           => 'menu-13',
                'menu-14'           => 'menu-14',
                'menu-15'           => 'menu-15',
                'menu-16'           => 'menu-16',
                'menu-17'           => 'menu-17',
                'menu-18'           => 'menu-18',
                'menu-19'           => 'menu-19',
                'menu-20'           => 'menu-20',
                'widget'            => 'widget' 
            )
        ),//
        'option14' => array(
            'title'      => 'Option 14',
            'screenshot' => 'screenshot.jpg',
            'files'       => array(
                'options'           => 'option',
                'taxonomies'        => 'taxonomy',
                'attachment-1'      => 'attachment-1',
                'attachment-2'      => 'attachment-2',
                'attachment-3'      => 'attachment-3',
                'attachment-4'      => 'attachment-4',
                'attachment-5'      => 'attachment-5',
                'attachment-6'      => 'attachment-6',
                'attachment-7'      => 'attachment-7',
                'attachment-8'      => 'attachment-8',
                'attachment-9'      => 'attachment-9',
                'attachment-10'     => 'attachment-10',
                'attachment-11'     => 'attachment-11',
                'attachment-12'     => 'attachment-12',
                'attachment-13'     => 'attachment-13',
                'attachment-14'     => 'attachment-14',
                'attachment-15'     => 'attachment-15',
                'attachment-16'     => 'attachment-16',
                'attachment-17'     => 'attachment-17',
                'attachment-18'     => 'attachment-18',
                'attachment-19'     => 'attachment-19',
                'attachment-20'     => 'attachment-20',
                'categories'        => 'category',
                'terms'             => 'term',
                'tags'              => 'tag',
                'posts'             => 'post',
                'pages'             => 'page',
                'product'           => 'product',
                'other-post-type'   => 'other-post-type',
                'menu-1'            => 'menu-1',

            )
        ),//
    );
    /**
	 * Get the instane of KT_Data_Installer
	 *
	 * @return self
	 */
	public static function getInstance() {
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
    
    /**
	 * Constructor loads API functions, defines paths and adds required wp actions
	 *
	 * @since  1.0
	 */
	public function __construct() {
        $this->paths = dirname( __FILE__ );
        $this->url = plugin_dir_url( __FILE__ );
        
        add_action('admin_menu', array( &$this, 'data_installer_menu' ));
        
        // Add hooks
        do_action( 'kt_data_installer_plugins_loaded' );
        
        load_plugin_textdomain( 'kutetheme', false, $this->paths . 'languages' );
        
        add_action( 'init', array( &$this, 'init' ), 9 );
        
        register_activation_hook( __FILE__, array( $this, 'activationHook' ) );
        
        add_action( 'admin_enqueue_scripts', array( $this, 'kt_enqueue_script' ) );
        
        add_action( 'wp_ajax_nopriv_kt_ajax_demo_install', array($this, 'kt_ajax_demo_install'));
        add_action( 'wp_ajax_kt_ajax_demo_install', array($this, 'kt_ajax_demo_install'));
        
        
	}
    public function data_installer_menu(){
        add_menu_page( 'Data Exporter', 'Data Exporter', 'edit_posts', 'kt_data_exporter', array( &$this, 'kt_data_exporter_page' ), 'dashicons-admin-tools' );
        add_menu_page( 'Data Installer', 'Data Installer', 'edit_posts', 'kt_data_installer', array( &$this, 'kt_data_installer_page' ), 'dashicons-admin-network' );
    }
    /**
	 * Enables to add hooks in activation process.
	 * @since 1.0
	 */
	public function activationHook() {
		do_action( 'kt_data_installer_activation_hook' );
	}
    public function kt_enqueue_script(){
        wp_localize_script( 'kt-ajax-script', 'kt_object_ajax', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
    	) );  
        
        wp_register_style( 'kt_data_css', $this->url . 'assets/css/style.css' );
        wp_enqueue_style( 'kt_data_css' );
        
        wp_register_script( 'kt_data_js', $this->url . 'assets/js/scripts.js' );
        wp_enqueue_script( 'kt_data_js', array( 'jquery' ) );
    }
    
    public function kt_ajax_demo_install(){
        @set_time_limit(600);
        $packet = 'default';
        $action = 'install';
        
        if (isset($_POST[ 'kt_demo_action' ])) {
            $action = $_POST[ 'kt_demo_action' ];
        }
        
        if (isset($_POST[ 'kt_packet' ])) {
            $packet = $_POST[ 'kt_packet' ];
        }
        if( $action == 'install'){
            $current = get_option( 'kt_demo_packet', false );
            echo $current;
            if( $current && $current != $action ){
                $this->remove_all();
            }
            $install = $this->install( $packet );
            if( ! $install ){
                echo "error";
            }
        }else{
            $this->remove_all();
            delete_option( 'kt_demo_packet' );
        }
    }
    public function install( $packet ) {
        if( isset( $this->data[ $packet ]['files'] ) and ! empty( $this->data[ $packet ]['files'] ) ){
            $file = $this->data[ $packet ]['files'];
            
            if( is_array( $file ) ){
                foreach( $file as $k => $v ) {
                    $is_mark = get_option( "kt_mark_step", array() );
                    echo "<pre>";
                    print_r($is_mark);
                    echo "</pre>";
                    if( empty( $is_mark ) || ! in_array( $k, $is_mark ) ){
                        require_once( $this->paths . "/data/{$packet}/{$v}.php");
                        $is_mark[] = $k;
                        update_option( "kt_mark_step", $is_mark );
                    }
                    
                }
                update_option( 'kt_demo_packet', $packet );
                return true;
            }
        }
        return false;
    }
    
    /**
	 * Callback function for WP init action hook. Sets kt data installer mode and loads required objects.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function init() {
		do_action( 'kt_data_installer_before_init' );
        do_action( 'kt_data_installer_after_init' );
    }
    
    /**
	 * Gets absolute path for file/directory in filesystem.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @param string $file - file name or directory inside path
	 *
	 * @return string
	 */
	public function path( $file = '' ) {
		$path = $this->paths . ( strlen( $file ) > 0 ? '/' . preg_replace( '/^\//', '', $file ) : '' );

		return apply_filters( 'kt_data_installer_path_filter', $path );
	}
    public function remove_all(){
        kt_remove_attachment();
        kt_remove_cate();
        
        kt_remove_menu();
        remove_post();
        remove_page();
        remove_other_post();
        
        kt_remove_menu_items();
        remove_widget();
        $this->remove_mark();

    }
    public function remove_mark(){
        delete_option( 'kt_mark_step' );
    }
    /**
     * Create admin page kt_data_installer_page
     * @since 1.0
     */
    public function kt_data_installer_page(){
        ?>
        <div class="kt-page-importer">
            <div class="kt-plugin-title">
                <h2><?php _e( 'Importer', 'kutetheme' ) ?></h2>
            </div>
            <?php if( ! empty( $this->data )  ): $current = get_option( 'kt_demo_packet' ); ?>
            <div class="kt-plugin-content">
                <ul class="container-box">
                    <?php foreach( $this->data as $k => $d ): ?>
                    <li class="box-item">
                        <img class="loading-gif" src="<?php echo $this->url . "assets/imgs/loading.GIF" ?>" alt="loading..." />
                        <?php if( isset( $d['screenshot'] ) ): ?>
                        <div class="item-thumbnail">
                            <img src="<?php echo $this->url . "/data/$k/" . $d['screenshot']; ?>" alt="screenshot" />
                        </div>
                        <?php endif; ?>
                        <?php if( isset( $d['title'] ) ): ?>
                        <div class="item-info">
                            <h3 class="info-title"><?php echo $d['title']; ?></h3>
                        </div>
                        <?php endif; ?>
                        <?php if( $current && $current == $k ): ?>
                            <div class="item-button">
                                <button class="button button-primary button-large" data-method="uninstall" data-packet="<?php echo $k; ?>"><?php _e( 'Uninstall', 'thumbnail' ) ?></button>
                            </div>
                        <?php else: ?>
                            <div class="item-button">
                                <button class="button button-primary button-large" data-method="install" data-packet="<?php echo $k; ?>"><?php _e( 'Install', 'thumbnail' ) ?></button>
                            </div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }
    public function kt_data_exporter_page(){
        global $wpdb;
        ?>
        <div class="wrap">
            <h1><?php _e( 'Export', 'kutetheme' ); ?></h1>
            
            <p><?php _e('When you click the button below, We will create an PHP file for you to save to your computer.'); ?></p>
            <p><?php _e('Once you&#8217;ve saved the download file, you can use the Import function in another, We installation to import the content from this site.'); ?></p>
            
            <h3><?php _e( 'Choose what to export' ); ?></h3>
            <form name="kt_data_installer_page" id="kt_data_installer_page" method="GET" action="<?php echo plugin_dir_url(__FILE__) . 'export.php' ?>">
                <input type="hidden" name="download_export" value="true" />
                <p><label><input type="radio" name="content" value="all" checked="checked" /> <?php _e( 'All content' ); ?></label></p>
                <p class="description"><?php _e( 'This will contain all of your posts, pages, comments, custom fields, terms, navigation menus and custom posts.' ); ?></p>
                
                <p><label><input type="radio" name="content" value="posts" /> <?php _e( 'Posts' ); ?></label></p>
                <ul id="post-filters" class="export-filters">
                	<li>
                		<label><?php _e( 'Categories:' ); ?></label>
                		<?php wp_dropdown_categories( array( 'show_option_all' => __('All') ) ); ?>
                	</li>
                	<li>
                		<label><?php _e( 'Authors:' ); ?></label>
                        <?php
                    		$authors = $wpdb->get_col( "SELECT DISTINCT post_author FROM {$wpdb->posts} WHERE post_type = 'post'" );
                    		wp_dropdown_users( array( 'include' => $authors, 'name' => 'post_author', 'multi' => true, 'show_option_all' => __('All') ) );
                        ?>
                	</li>
                	<li>
                		<label><?php _e( 'Date range:' ); ?></label>
                		<select name="post_start_date">
                			<option value="0"><?php _e( 'Start Date' ); ?></option>
                			<?php kt_export_date_options(); ?>
                		</select>
                		<select name="post_end_date">
                			<option value="0"><?php _e( 'End Date' ); ?></option>
                			<?php kt_export_date_options(); ?>
                		</select>
                	</li>
                	<li>
                		<label><?php _e( 'Status:' ); ?></label>
                		<select name="post_status">
                			<option value="0"><?php _e( 'All' ); ?></option>
                			<?php $post_stati = get_post_stati( array( 'internal' => false ), 'objects' );
                			 foreach ( $post_stati as $status ) : ?>
                			 <option value="<?php echo esc_attr( $status->name ); ?>"><?php echo esc_html( $status->label ); ?></option>
                			<?php endforeach; ?>
                		</select>
                	</li>
                </ul>
                
                <p><label><input type="radio" name="content" value="pages" /> <?php _e( 'Pages' ); ?></label></p>
                <ul id="page-filters" class="export-filters">
                	<li>
                		<label><?php _e( 'Authors:' ); ?></label>
                        <?php
                        	$authors = $wpdb->get_col( "SELECT DISTINCT post_author FROM {$wpdb->posts} WHERE post_type = 'page'" );
                        	wp_dropdown_users( array( 'include' => $authors, 'name' => 'page_author', 'multi' => true, 'show_option_all' => __('All') ) );
                        ?>
                	</li>
                	<li>
                		<label><?php _e( 'Date range:' ); ?></label>
                		<select name="page_start_date">
                			<option value="0"><?php _e( 'Start Date' ); ?></option>
                			<?php kt_export_date_options( 'page' ); ?>
                		</select>
                		<select name="page_end_date">
                			<option value="0"><?php _e( 'End Date' ); ?></option>
                			<?php kt_export_date_options( 'page' ); ?>
                		</select>
                	</li>
                	<li>
                		<label><?php _e( 'Status:' ); ?></label>
                		<select name="page_status">
                			<option value="0"><?php _e( 'All' ); ?></option>
                			<?php foreach ( $post_stati as $status ) : ?>
                			<option value="<?php echo esc_attr( $status->name ); ?>"><?php echo esc_html( $status->label ); ?></option>
                			<?php endforeach; ?>
                		</select>
                	</li>
                </ul>
                
                <?php foreach ( get_post_types( array( '_builtin' => false, 'can_export' => true ), 'objects' ) as $post_type ) : ?>
                <p><label><input type="radio" name="content" value="<?php echo esc_attr( $post_type->name ); ?>" /> <?php echo esc_html( $post_type->label ); ?></label></p>
                <?php endforeach; ?>
                
                <p><label><input type="radio" name="content" value="nav_menu_item" /> <?php _e( 'Menu', 'kutetheme' ) ?></label></p>
                <p><label><input type="radio" name="content" value="widget" /> <?php _e( 'Widget', 'kutetheme' ) ?></label></p>
                <?php
                /**
                 * Fires after the export filters form.
                 *
                 * @since 3.5.0
                 */
                do_action( 'kt_export_filters' );
                ?>
                
                <?php submit_button( __('Download Export File') ); ?>
                </form>
            </div>
        <?php
    }
}
$data_installer = new KT_Data_Installer();

//require_once dirname( __FILE__ ) . '/data/welcometowordpressthemes.wordpress.2015-11-12.php';

