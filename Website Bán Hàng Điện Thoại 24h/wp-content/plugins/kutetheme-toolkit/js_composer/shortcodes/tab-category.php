<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

vc_map( array(
    "name"                    => __( "Categories Tab", 'kutetheme'),
    "base"                    => "categories_tab",
    "category"                => __('Kute Theme', 'kutetheme' ),
    "description"             => __( "Show tab categories", 'kutetheme'),
    "as_parent"               => array('only' => 'tab_section'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element"         => true,
    "show_settings_on_create" => true,
    "params"                  => array(
        array(
            "type"        => "textfield",
            "heading"     => __( "Title", 'kutetheme' ),
            "param_name"  => "title",
            "admin_label" => true,
        ),
        array(
            "type"        => "dropdown",
            "heading"     => __("Product Size", 'kutetheme'),
            "param_name"  => "size",
            "value"       => $product_thumbnail,
            'std'         => 'kt_shop_catalog_214',
            "description" => __( "Product size", 'kutetheme' ),
            "admin_label" => true,
        ),
        array(
            "type"        => "textfield",
            "heading"     => __( "Number Post", 'kutetheme' ),
            "param_name"  => "per_page",
            'std'         => 10,
            "admin_label" => false,
            'description' => __( 'Number post in a slide', 'kutetheme' )
        ),
        array(
            "type"        => "textfield",
            "heading"     => __( "Column", 'kutetheme' ),
            "param_name"  => "number_column",
            "admin_label" => false,
            'std'         => 4,
            'description' => __( 'Number column display', 'kutetheme' )
        ),
        array(
            "type"        => "dropdown",
            "heading"     => __("Tabs Type", 'kutetheme'),
            "param_name"  => "tabs_type",
            "admin_label" => true,
            'std'         => 'tab-1',
            'value'       => array(
        		__( 'Tab 1', 'kutetheme' ) => 'tab-1',
                __( 'Tab 2', 'kutetheme' ) => 'tab-2',
                __( 'Tab 3', 'kutetheme' ) => 'tab-3',
                __( 'Tab 4', 'kutetheme' ) => 'tab-4',
                __( 'Tab 5', 'kutetheme' ) => 'tab-5',
                __( 'Tab 6', 'kutetheme' ) => 'tab-6',
                __( 'Tab 7', 'kutetheme' ) => 'tab-7',
        	),
        ),
        
        array(
            "type"        => "kt_categories",
            "heading"     => __("Choose Category", 'kutetheme'),
            "param_name"  => "category",
            "admin_label" => true,
        ),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Left', 'js_composer' )  => 'left',
                __( 'Right', 'js_composer' ) => 'right',
                
            ),
            'heading'     => __( 'Align', 'kutetheme' ),
            'param_name'  => 'align',
            'admin_label' => false,
            "dependency"  => array("element" => "tabs_type","value" => array('tab-6')),
		),
        
        array(
            "type"        => "kt_number",
            "heading"     => __("The items subcategory on per slide", 'kutetheme'),
            "param_name"  => "number_slide",
            "value"       => "14",
            "suffix"      => __("subcategory", 'kutetheme'),
            "description" => __('The number of items subcategory on per slide', 'kutetheme'),
            'admin_label' => false,
            "dependency"  => array("element" => "tabs_type","value" => array('tab-6')),
	  	),
        array(
            "type"        => "colorpicker",
            "heading"     => __("Main Color", 'kutetheme'),
            "param_name"  => "main_color",
            "admin_label" => true,
        ),
        
        array(
            'type'        => 'attach_image',
            'heading'     => __( 'Icon', 'kutetheme' ),
            'param_name'  => 'icon',
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1', 'tab-2', 'tab-3', 'tab-4', 'tab-5', 'tab-6')),
            'description' => __( 'Setup icon for the tab', 'kutetheme' )
    	),
        
        array(
            'type'        => 'attach_image',
            'heading'     => __( 'Background Image', 'kutetheme' ),
            'param_name'  => 'bg_cate',
            "dependency"  => array("element" => "tabs_type", "value" => array( 'tab-2', 'tab-3', 'tab-4', 'tab-5', 'tab-6' )),
            'description' => __( 'Setup background for box', 'kutetheme' )
    	),
        array(
            'type'        => 'attach_images',
            'heading'     => __( 'Banner top', 'kutetheme' ),
            'param_name'  => 'banner_top',
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1')),
            'description' => __( 'Setup image on  top of the tab', 'kutetheme' )
    	),
        
        array(
            'type'        => 'attach_images',
            'heading'     => __( 'Banner left', 'kutetheme' ),
            'param_name'  => 'banner_left',
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1', 'tab-2', 'tab-3', 'tab-4', 'tab-5', 'tab-6', 'tab-7')),
            'description' => __( 'Setup image on  left of the tab', 'kutetheme' )
    	),
        
        array(
            'type'        => 'checkbox',
            'heading'     => __( 'Featured', 'kutetheme' ),
            'param_name'  => 'featured',
            "dependency"  => array("element" => "tabs_type", "value" => array('tab-1')),
            'description' => __( 'Setup image on  left of the tab', 'kutetheme' ),
            'value'       => array( __( 'Yes', 'kutetheme' ) => 'yes' )
    	),
        
        array(
            'type'        => 'dropdown',
            'heading'     => __( 'CSS Animation', 'js_composer' ),
            'param_name'  => 'css_animation',
            'admin_label' => false,
            'value'       => array(
                __( 'No', 'js_composer' )                 => '',
                __( 'Top to bottom', 'js_composer' )      => 'top-to-bottom',
                __( 'Bottom to top', 'js_composer' )      => 'bottom-to-top',
                __( 'Left to right', 'js_composer' )      => 'left-to-right',
                __( 'Right to left', 'js_composer' )      => 'right-to-left',
                __( 'Appear from center', 'js_composer' ) => "appear"
        	),
        	'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
        ),
        
        // Carousel
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 'true',
                __( 'No', 'js_composer' )  => 'false'
            ),
            'heading'     => __( 'AutoPlay', 'kutetheme' ),
            'param_name'  => 'autoplay',
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1')),
		),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 'true',
                __( 'No', 'js_composer' )  => 'false'
            ),
            'heading'     => __( 'Navigation', 'kutetheme' ),
            'param_name'  => 'navigation',
            'description' => __( "Don't display 'next' and 'prev' buttons.", 'kutetheme' ),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1')),
		),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 'true',
                __( 'No', 'js_composer' )  => 'false'
            ),
            'std'         => 'false',
            'heading'     => __( 'Loop', 'kutetheme' ),
            'param_name'  => 'loop',
            'description' => __( "Inifnity loop. Duplicate last and first items to get loop illusion.", 'kutetheme' ),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1')),
		),
        array(
            "type"        => "kt_number",
            "heading"     => __("Slide Speed", 'kutetheme'),
            "param_name"  => "slidespeed",
            "value"       => "250",
            "suffix"      => __("milliseconds", 'kutetheme'),
            "description" => __('Slide speed in milliseconds', 'kutetheme'),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1')),
	  	),
        array(
            "type"        => "kt_number",
            "heading"     => __("Margin", 'kutetheme'),
            "param_name"  => "margin",
            "value"       => "0",
            "suffix"      => __("px", 'kutetheme'),
            "description" => __('Distance( or space) between 2 item', 'kutetheme'),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1')),
	  	),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 1,
                __( 'No', 'js_composer' )  => 0
            ),
            'heading'     => __( 'Use Carousel Responsive', 'kutetheme' ),
            'param_name'  => 'use_responsive',
            'description' => __( "Try changing your browser width to see what happens with Items and Navigations", 'kutetheme' ),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
            "dependency"  => array(
                "element" => "tabs_type",
                "value"   => array( 'tab-1')
            ),
		),
        array(
            "type"        => "kt_number",
            "heading"     => __("The items on destop (Screen resolution of device >= 992px )", 'kutetheme'),
            "param_name"  => "items_destop",
            "value"       => "4",
            "suffix"      => __("item", 'kutetheme'),
            "description" => __('The number of items on destop', 'kutetheme'),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1')),
	  	),
        array(
            "type"        => "kt_number",
            "heading"     => __("The items on tablet (Screen resolution of device >=768px and < 992px )", 'kutetheme'),
            "param_name"  => "items_tablet",
            "value"       => "2",
            "suffix"      => __("item", 'kutetheme'),
            "description" => __('The number of items on destop', 'kutetheme'),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1')),
	  	),
        array(
            "type"        => "kt_number",
            "heading"     => __("The items on mobile (Screen resolution of device < 768px)", 'kutetheme'),
            "param_name"  => "items_mobile",
            "value"       => "1",
            "suffix"      => __("item", 'kutetheme'),
            "description" => __('The numbers of item on destop', 'kutetheme'),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
            "dependency"  => array("element" => "tabs_type","value" => array('tab-1')),
	  	),
        array(
            'type'        => 'css_editor',
            'heading'     => __( 'Css', 'js_composer' ),
            'param_name'  => 'css',
            'group'       => __( 'Design options', 'js_composer' ),
            'admin_label' => false,
		),
        
    ),
    "js_view" => 'VcColumnView'
));
vc_map( array(
    "name"            => __("Section Tab", 'kutetheme'),
    "base"            => "tab_section",
    "content_element" => true,
    "as_child"        => array('only' => 'categories_tab'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params"          => array(
        // add params same as with any other content element
        array(
            "type"        => "textfield",
            "heading"     => __( "Header", 'kutetheme' ),
            "param_name"  => "header",
            "admin_label" => true,
        ),
        array(
            "type"        => "dropdown",
            "heading"     => __("Section Type", 'kutetheme'),
            "param_name"  => "section_type",
            "admin_label" => true,
            'std'         => 'best-seller',
            'value'       => array(
        		__( 'Best Sellers', 'kutetheme' ) => 'best-seller',
                __( 'Most Reviews', 'kutetheme' ) => 'most-review',
                __( 'New Arrivals', 'kutetheme' ) => 'new-arrival',
                __( 'On Sales', 'kutetheme' )     => 'on-sales',
                __( 'By Ids', 'kutetheme' )       => 'by-ids',
                __( 'Category', 'kutetheme' )     => 'category',
                __( 'Custom', 'kutetheme' )       => 'custom'
        	),
        ),
        
        array(
            "type"        => "kt_categories",
            "heading"     => __("Choose Category", 'kutetheme'),
            "param_name"  => "section_cate",
            "admin_label" => false,
            "dependency"  => array("element" => "section_type", "value" => array('category')),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => __("Order by", 'kutetheme'),
            "param_name" => "orderby",
            "value"      => array(
                __('None', 'kutetheme')       => 'none',
                __('ID', 'kutetheme')         => 'ID',
                __('Author', 'kutetheme')     => 'author',
                __('Name', 'kutetheme')       => 'name',
                __('Date', 'kutetheme')       => 'date',
                __('Modified', 'kutetheme')   => 'modified',
                __('Rand', 'kutetheme')       => 'rand',
                __('Sale Price', 'kutetheme') => '_sale_price'
        	),
            'std'         => 'date',
            "description" => __("Select how to sort retrieved posts.",'kutetheme'),
            "dependency"  => array("element" => "section_type", "value" => array('custom', 'on-sales', 'category')),
        ),
        array(
            "type"        => "textfield",
            "heading"     => __( "Ids", 'kutetheme' ),
            "param_name"  => "ids",
            "admin_label" => true,
            "description" => __("Get product by list ids.( Input IDs which separated by a comma ',' )",'kutetheme'),
            "dependency"  => array("element" => "section_type", "value" => array( 'by-ids' ) ),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => __("Order", 'kutetheme'),
            "param_name" => "order",
            "value"      => array(
                __('ASC', 'kutetheme')  => 'ASC',
                __('DESC', 'kutetheme') => 'DESC'
        	),
            'std'         => 'DESC',
            "description" => __("Designates the ascending or descending order.",'kutetheme'),
            "dependency"  => array("element" => "section_type", "value" => array('custom', 'on-sales', 'category')),
        ),
        array(
            "type"        => "textfield",
            "heading"     => __( "Extra class name", "js_composer" ),
            "param_name"  => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
            'admin_label' => false,
        ),
    )
) );
class WPBakeryShortCode_Categories_Tab extends WPBakeryShortCodesContainer {
    public $product_size = 'kt_shop_catalog_214';
    
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'categories_tab', $atts ) : $atts;
        extract( shortcode_atts( array(
            'title'          => 'Tabs Name',
            'size'           => 'kt_shop_catalog_214',
            'tabs_type'      => 'tab-1',
            'per_page'       => 10,
            'column'         => 4,
            'category'       => 0,
            'term_link'     => '',
            'main_color'     => '#ff3366',
            'icon'           => '',
            'bg_cate'        => '',
            'banner_top'     => '',
            'banner_left'    => '',
            "featured"       => false,
            
            "align"          => 'left',
            "number_slide"   => 14,
            //Carousel            
            'autoplay'       => 'false', 
            'navigation'     => 'false',
            'margin'         => 0,
            'slidespeed'     => 250,
            'css'            => '',
            'css_animation'  => '',
            'el_class'       => '',
            'nav'            => 'true',
            'loop'           => 'false',
            //Default
            'use_responsive' => 1,
            'items_destop'   => 4,
            'items_tablet'   => 2,
            'items_mobile'   => 1,
        ), $atts ) );
        
         global $woocommerce_loop;
        $is_phone = false;
        $this->product_size = $size;
        if( function_exists( 'kt_is_phone' ) && kt_is_phone() ){
            $is_phone = true;
        }
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' box-tab-category ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        if( function_exists( 'kt_hex2rgb' )){
            $main_color_rgb = kt_hex2rgb($main_color);
        }else{
            $main_color_rgb = array( 'red' => 255, 'green' => 51, 'blue' => 102 );
        }
        
        $elementClass = apply_filters( 'kt_category_tab_class_container', $elementClass );
        
        
        $tabs = kt_get_all_attributes( 'tab_section', $content );
        
        if( isset( $bg_cate ) && $bg_cate ): 
            $att_bg = wp_get_attachment_image_src( $bg_cate , 'full' );  
            $att_bg_url =  is_array($att_bg) ? esc_url($att_bg[0]) : ""; 
            if( $att_bg_url ){
                $style = "style='background: #fff url(".$att_bg_url.") no-repeat left bottom;'";
            }
        endif; 
        if( count( $tabs ) > 0 ):
            $id = uniqid($category);
            $args = array(
               'hierarchical' => 1,
               'show_option_none' => '',
               'hide_empty' => 0,
               'taxonomy' => 'product_cat'
            );
            $term = get_term( $category, 'product_cat' );
            
            if( file_exists( KUTETHEME_PLUGIN_PATH . '/js_composer/includes/'.$tabs_type.'.php' ) ){
                
                if( ! is_wp_error( $term ) && $term ){
                    $args [ 'parent' ] = $term->term_id;
                    $term_link = get_term_link( $term );
                }else{
                    $term = false;
                }
                if( ! $is_phone ){
                    $subcats = get_categories($args);
                }
                if( $tabs_type == 'tab-1' ){
                    $elementClass .= ' option1 tab-1';
                }elseif( $tabs_type == 'tab-2' ){
                    $elementClass .= ' option2 tab-2';
                }elseif( $tabs_type == 'tab-3' ){
                    $elementClass .= ' option2 tab-3';
                }elseif( $tabs_type == 'tab-4' ){
                    $elementClass .= ' option2 tab-4';
                }elseif( $tabs_type == 'tab-5' ){
                    $elementClass .= ' option2 tab-5';
                }elseif( $tabs_type == 'tab-6' ){
                    $elementClass .= ' option7 tab-6';
                }elseif( $tabs_type == 'tab-7' ){
                    $elementClass .= ' option12 tab-7';
                }
                ob_start();
                add_filter( 'kt_product_thumbnail_loop', array( &$this, 'get_size_product' ) );
                @include( KUTETHEME_PLUGIN_PATH . 'js_composer/includes/'.$tabs_type.'.php' );
                remove_filter( 'kt_product_thumbnail_loop', array( &$this, 'get_size_product' ) );
                return ob_get_clean();
            }
        endif;
    }
    /**
     * order_by_rating_post_clauses function.
     *
     * @access public
     * @param array $args
     * @return array
     */
    public function order_by_rating_post_clauses( $args ) {
    	global $wpdb;
    
    	$args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";
    
    	$args['where'] .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";
    
    	$args['join'] .= "
    		LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
    		LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
    	";
    
    	$args['orderby'] = "average_rating DESC, $wpdb->posts.post_date DESC";
    
    	$args['groupby'] = "$wpdb->posts.ID";
    
    	return $args;
    }
    public function get_size_product( $size ){
        return $this->product_size;
    }
    public function get_size_product_option_3( $size ){
        return 'kt_shop_catalog_131';
    }
}