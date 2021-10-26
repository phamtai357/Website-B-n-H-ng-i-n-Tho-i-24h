<?php
require_once(ABSPATH . 'wp-config.php'); 
require_once(ABSPATH . 'wp-includes/wp-db.php'); 
require_once(ABSPATH . 'wp-admin/includes/taxonomy.php'); 
require_once(ABSPATH . 'wp-includes/pluggable.php');

//all category id added
$categories_id = array();

//all Menu id added
$menus_id = array();
//all post id added
$posts_id  = array();

kt_get_all_categories_added();

kt_get_all_menus_added();

/**
 * Download an image from the specified URL and attach it to a post.
 *
 * @since 1.0
 *
 * @param string $post The serialize of post
 */
function kt_download_media( $id, $post_title, $guid ){
    global $posts_id;
    
    $new_id = kt_get_post_id( $id, 'attachment', 'kt_demo_attachment' );
    
    if( ! $new_id ) {
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-includes/pluggable.php');
        
        // Set variables for storage, fix file filename for query strings.
        preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $guid, $matches );
        $file_array = array();
        $file_array['name'] = basename( $matches[0] );
        
        // Download file to temp location.
        $file_array['tmp_name'] = download_url( $guid );
        
        // If error storing temporarily, return the error.
        if ( is_wp_error( $file_array['tmp_name'] ) ) {
            @unlink($file_array['tmp_name']);
            echo 'is_wp_error $file_array: ' . $guid;
            print_r($file_array['tmp_name']);
            return $file_array['tmp_name'];
        }
        
         // Do the validation and storage stuff.
        $new_id = media_handle_sideload( $file_array, '', $post_title ); //$id of attachement or wp_error
        
        // If error storing permanently, unlink.
        if ( is_wp_error( $new_id ) ) {
            @unlink( $file_array['tmp_name'] );
            echo 'is_wp_error $id: ' . $new_id->get_error_messages() . ' ' . $guid;
            return $new_id;
        }
        
        if( isset( $posts_id[ 'attachment' ][ 'kt_demo_attachment' ] ) ) {
            $posts_id[ 'attachment' ][ 'kt_demo_attachment' ][ $id ] = $new_id;
        }
        update_post_meta($new_id, 'kt_demo_attachment', $id );
        
        return $new_id;
    }
    return $new_id;
}
/**
 * Get attachment url by id
 *  
 * @since 1.0
 * 
 * @param int $id Attachment id 
 */

function kt_get_attachment_url( $id , $size = "full") {
    $image_id = kt_get_post_id( $id, 'attachment', 'kt_demo_attachment' );

    if( $image_id !== false ) {
        $attachement_array = wp_get_attachment_image_src( $image_id, $size, false );
        
        if ( ! empty( $attachement_array[0] ) ) {
            return $attachement_array[0];
        }
    
    }
    return false;
}
 
/**
 * Remove attachment
 *
 * @since 1.0
 */
function kt_remove_attachment() {
    $args = array(
        'post_type'     => array('attachment'),
        'post_status'   => array( 'inherit', 'publish' ),
        'meta_key'      => 'kt_demo_attachment',
        'posts_per_page' => '-1'
    );
    $query = new WP_Query( $args );
    
    if ( ! empty( $query->posts ) ) {
        foreach ($query->posts as $post) {
            $return_value = wp_delete_attachment($post->ID, true);
            if ($return_value === false) {
                echo 'kt_remove_attachment: - failed to delete image id:' . $post->ID ;
            }
        }
    }
}
function kt_add_taxonomies( $taxonomy ){
    $tax = unserialize( base64_decode( $taxonomy ) );
    if( is_array( $tax ) ) {
        foreach( $tax as $k => $v ) {
            if ( ! taxonomy_exists( $k ) ) {
                register_taxonomy( $k, $v->object_type,
        			array(
        				'hierarchical'          => $v->hierarchical,
        				'update_count_callback' => $update_count_callback->update_count_callback,
        				'label'                 => $v->label,
        				'labels'                => (array)$v->labels,
        				'show_ui'               => $v->show_ui,
        				'query_var'             => $v->query_var,
        				'capabilities'          => (array) $v->cap,
        				'rewrite'               => $v->rewrite,
        			)
        		);
            }
        }
    }
}

function kt_add_options( $options ){
    $options = unserialize( base64_decode( $options ) );
    if( is_array( $options ) && ! empty( $options ) ) {
        update_option( 'kt_options', $options );
    }
}
/**
 * Add category
 * 
 * @since 1.0
 * 
 * @param $cat serialize string category
 */
function kt_add_category( $term_id, $name, $slug, $taxonomy, $parent, $description ) {
    global $categories_id;
    
    $new_cat_id = kt_get_cate_id( $term_id );
    
    if( ! $new_cat_id ) {
        //all categories
        $ids = $categories_id;
        if ( ! taxonomy_exists( $taxonomy ) ) {
            if( $taxonomy == 'product_type' ){
                register_taxonomy( 'product_type',
        			apply_filters( 'woocommerce_taxonomy_objects_product_type', array( 'product' ) ),
        			apply_filters( 'woocommerce_taxonomy_args_product_type', array(
        				'hierarchical'      => false,
        				'show_ui'           => false,
        				'show_in_nav_menus' => false,
        				'query_var'         => is_admin(),
        				'rewrite'           => false,
        				'public'            => false
        			) )
        		);
            }
            if( $taxonomy == 'product_type' ){
                register_taxonomy( 'product_type',
        			apply_filters( 'woocommerce_taxonomy_objects_product_type', array( 'product' ) ),
        			apply_filters( 'woocommerce_taxonomy_args_product_type', array(
        				'hierarchical'      => false,
        				'show_ui'           => false,
        				'show_in_nav_menus' => false,
        				'query_var'         => is_admin(),
        				'rewrite'           => false,
        				'public'            => false
        			) )
        		);
            } 
            
            if( $taxonomy == 'product_tag' ){
                register_taxonomy( 'product_tag',
        			apply_filters( 'woocommerce_taxonomy_objects_product_tag', array( 'product' ) ),
        			apply_filters( 'woocommerce_taxonomy_args_product_tag', array(
        				'hierarchical'          => false,
        				'update_count_callback' => '_wc_term_recount',
        				'label'                 => __( 'Product Tags', 'woocommerce' ),
        				'labels'                => array(
        						'name'                       => __( 'Product Tags', 'woocommerce' ),
        						'singular_name'              => __( 'Product Tag', 'woocommerce' ),
        						'menu_name'                  => _x( 'Tags', 'Admin menu name', 'woocommerce' ),
        						'search_items'               => __( 'Search Product Tags', 'woocommerce' ),
        						'all_items'                  => __( 'All Product Tags', 'woocommerce' ),
        						'edit_item'                  => __( 'Edit Product Tag', 'woocommerce' ),
        						'update_item'                => __( 'Update Product Tag', 'woocommerce' ),
        						'add_new_item'               => __( 'Add New Product Tag', 'woocommerce' ),
        						'new_item_name'              => __( 'New Product Tag Name', 'woocommerce' ),
        						'popular_items'              => __( 'Popular Product Tags', 'woocommerce' ),
        						'separate_items_with_commas' => __( 'Separate Product Tags with commas', 'woocommerce'  ),
        						'add_or_remove_items'        => __( 'Add or remove Product Tags', 'woocommerce' ),
        						'choose_from_most_used'      => __( 'Choose from the most used Product tags', 'woocommerce' ),
        						'not_found'                  => __( 'No Product Tags found', 'woocommerce' ),
        					),
        				'show_ui'               => true,
        				'query_var'             => true,
        				'capabilities'          => array(
        					'manage_terms' => 'manage_product_terms',
        					'edit_terms'   => 'edit_product_terms',
        					'delete_terms' => 'delete_product_terms',
        					'assign_terms' => 'assign_product_terms',
        				),
        				'rewrite'               => array(
        					'slug'       => empty( $permalinks['tag_base'] ) ? _x( 'product-tag', 'slug', 'woocommerce' ) : $permalinks['tag_base'],
        					'with_front' => false
        				),
        			) )
        		);
            }
            if( $taxonomy == 'product_shipping_class' ){
                register_taxonomy( 'product_shipping_class',
        			apply_filters( 'woocommerce_taxonomy_objects_product_shipping_class', array('product', 'product_variation') ),
        			apply_filters( 'woocommerce_taxonomy_args_product_shipping_class', array(
        				'hierarchical'          => true,
        				'update_count_callback' => '_update_post_term_count',
        				'label'                 => __( 'Shipping Classes', 'woocommerce' ),
        				'labels' => array(
        						'name'              => __( 'Shipping Classes', 'woocommerce' ),
        						'singular_name'     => __( 'Shipping Class', 'woocommerce' ),
        						'menu_name'         => _x( 'Shipping Classes', 'Admin menu name', 'woocommerce' ),
        						'search_items'      => __( 'Search Shipping Classes', 'woocommerce' ),
        						'all_items'         => __( 'All Shipping Classes', 'woocommerce' ),
        						'parent_item'       => __( 'Parent Shipping Class', 'woocommerce' ),
        						'parent_item_colon' => __( 'Parent Shipping Class:', 'woocommerce' ),
        						'edit_item'         => __( 'Edit Shipping Class', 'woocommerce' ),
        						'update_item'       => __( 'Update Shipping Class', 'woocommerce' ),
        						'add_new_item'      => __( 'Add New Shipping Class', 'woocommerce' ),
        						'new_item_name'     => __( 'New Shipping Class Name', 'woocommerce' )
        					),
        				'show_ui'               => false,
        				'show_in_nav_menus'     => false,
        				'query_var'             => is_admin(),
        				'capabilities'          => array(
        					'manage_terms' => 'manage_product_terms',
        					'edit_terms'   => 'edit_product_terms',
        					'delete_terms' => 'delete_product_terms',
        					'assign_terms' => 'assign_product_terms',
        				),
        				'rewrite'               => false,
        			) )
        		);      
            }                                                          
                        
        }
        if( ! $parent ){
            $new_cat_id = wp_insert_term(
                $name, // the term 
                $taxonomy, // the taxonomy
                array(
                    'description'=> $description,
                    'slug' => $slug,                   // what to use in the url for term archive
                    'parent'=> $ids [ $parent ]
                )
            );
        }else{
            if( $ids [$parent] ){
                $new_cat_id = wp_insert_term(
                    $name, // the term 
                    $taxonomy, // the taxonomy
                    array(
                        'description'=> $description,
                        'slug' => $slug,                   // what to use in the url for term archive
                        'parent'=> $ids [parent]
                    )
                );
            }else{
                //The categoy have been waiting 
                $cate_add_after = get_option('kt_demo_categories_add_before');
                if( $cate_add_after && count( $cate_add_after ) ){
                    foreach( $cate_add_after as $after ){
                        kt_add_category( $after );
                    }
                }
                $cate_add_after[] = $cat;
                update_option('kt_demo_categories_add_before', $cate_add_after);
            }
        }
        if( ! is_wp_error( $new_cat_id ) ){
            if( is_array( $new_cat_id ) && isset( $new_cat_id['term_id'] ) ){
                $ids [ $term_id ] = array( 
                    'id'  => $new_cat_id['term_id'],
                    'tax' => $taxonomy
                );
            }else{
                $ids [ $term_id ] = array( 
                    'id'  => $new_cat_id,
                    'tax' => $taxonomy
                );
            }
        
            $categories_id = $ids;
            
            update_option('kt_demo_categories', $categories_id);
        }
        else{
            return;
        }
        
    }
    return $new_cat_id;
}
/**
 * Add Brand
 * 
 * @since 1.0
 * 
 * @param $term_id
 * @param $name
 * @param $slug
 * @param $taxonomy
 * @param $parent
 * @param $description
 * @param $thumbnail
 */
function kt_add_brand( $term_id, $name, $slug, $taxonomy, $parent, $description, $thumbnail = 0 ) {
    global $categories_id;
    
    $new_cat_id = kt_get_cate_id( $term_id );
    if( ! $new_cat_id ) {
        //all categories
        $ids = $categories_id;
        if ( ! taxonomy_exists( $taxonomy ) ) {
            $labels = array(
    			'name'              => __( 'Product Brands', 'kutetheme' ),
    			'singular_name'     => __( 'Product Brand', 'kutetheme' ),
    			'search_items'      => __( 'Search Genres', 'kutetheme' ),
    			'all_items'         => __( 'All Brands', 'kutetheme' ),
    			'parent_item'       => __( 'Parent Brands', 'kutetheme' ),
    			'parent_item_colon' => __( 'Parent Brands:', 'kutetheme' ),
    			'edit_item'         => __( 'Edit Product Brand', 'kutetheme' ),
    			'update_item'       => __( 'Update Product Brand', 'kutetheme' ),
    			'add_new_item'      => __( 'Add New Product Brand', 'kutetheme' ),
    			'new_item_name'     => __( 'New Brand Name', 'kutetheme'),
    			'menu_name'         => 'Brands',
    		);
            
            $args = array(
    			'hierarchical'      => true,
    			'labels'            => $labels,
    			'show_ui' 				=> true,
    			'show_in_nav_menus' 	=> true,
    			'capabilities'          => array(
					'manage_terms' => 'manage_product_terms',
					'edit_terms'   => 'edit_product_terms',
					'delete_terms' => 'delete_product_terms',
					'assign_terms' => 'assign_product_terms',
				),
    			'rewrite' 				=> array( 'slug' => 'product_brand' , 'with_front' => false, 'hierarchical' => true )
    		);
            register_taxonomy( 'product_brand', array('product'), apply_filters( 'kt_register_taxonomy_product_brand', $args ));
        }
        if( ! $parent ){
            $new_cat_id = wp_insert_term(
                $name, // the term 
                $taxonomy, // the taxonomy
                array(
                    'description'=> $description,
                    'slug' => $slug,                   // what to use in the url for term archive
                    'parent'=> $ids [ $parent ]
                )
            );
        }else{
            if( $ids [$parent] ){
                $new_cat_id = wp_insert_term(
                    $name, // the term 
                    $taxonomy, // the taxonomy
                    array(
                        'description'=> $description,
                        'slug' => $slug,                   // what to use in the url for term archive
                        'parent'=> $ids [ $parent ]
                    )
                );
            }else{
                //The categoy have been waiting 
                $cate_add_after = get_option('kt_demo_categories_add_before');
                if( $cate_add_after && count( $cate_add_after ) ){
                    foreach( $cate_add_after as $after ){
                        kt_add_category( $after );
                    }
                }
                $cate_add_after[] = $cat;
                update_option('kt_demo_categories_add_before', $cate_add_after);
            }
        }
        if( ! is_wp_error( $new_cat_id ) ){
            if( is_array( $new_cat_id ) && isset( $new_cat_id['term_id'] ) ){
                $ids [ $term_id ] = array( 
                    'id'  => $new_cat_id['term_id'],
                    'tax' => $taxonomy
                );
            }else{
                $ids [ $term_id ] = array( 
                    'id'  => $new_cat_id,
                    'tax' => $taxonomy
                );
            }
        
            $categories_id = $ids;
            
            update_option( 'kt_demo_categories', $categories_id );
            
            //Update thumbnail
            if( $thumbnail ){
                $thumnail_id = kt_get_post_id( $thumbnail, 'attachment', 'kt_demo_attachment' );
                
                if( function_exists( 'add_woocommerce_term_meta' ) ){
                    return add_woocommerce_term_meta( $new_cat_id['term_id'], 'thumbnail_id', $thumnail_id, false );
                }else{
                    return add_metadata( 'woocommerce_term', $new_cat_id['term_id'], 'thumbnail_id', $thumnail_id, false );
                }
            }
        }else{
            return;
        }
        
    }
    return $new_cat_id;
}

/**
 * Add Product Cat
 * 
 * @since 1.0
 * 
 * @param $term_id
 * @param $name
 * @param $slug
 * @param $taxonomy
 * @param $parent
 * @param $description
 * @param $thumbnail
 */
function kt_add_product_cat( $term_id, $name, $slug, $taxonomy, $parent, $description, $thumbnail = 0 ) {
    global $categories_id;
    
    $new_cat_id = kt_get_cate_id( $term_id );
    if( ! $new_cat_id ) {
        //all categories
        $ids = $categories_id;
        if ( ! taxonomy_exists( $taxonomy ) ) {
            register_taxonomy( 'product_cat',
    			apply_filters( 'woocommerce_taxonomy_objects_product_cat', array( 'product' ) ),
    			apply_filters( 'woocommerce_taxonomy_args_product_cat', array(
    				'hierarchical'          => true,
    				'update_count_callback' => '_wc_term_recount',
    				'label'                 => __( 'Product Categories', 'woocommerce' ),
    				'labels' => array(
    						'name'              => __( 'Product Categories', 'woocommerce' ),
    						'singular_name'     => __( 'Product Category', 'woocommerce' ),
    						'menu_name'         => _x( 'Categories', 'Admin menu name', 'woocommerce' ),
    						'search_items'      => __( 'Search Product Categories', 'woocommerce' ),
    						'all_items'         => __( 'All Product Categories', 'woocommerce' ),
    						'parent_item'       => __( 'Parent Product Category', 'woocommerce' ),
    						'parent_item_colon' => __( 'Parent Product Category:', 'woocommerce' ),
    						'edit_item'         => __( 'Edit Product Category', 'woocommerce' ),
    						'update_item'       => __( 'Update Product Category', 'woocommerce' ),
    						'add_new_item'      => __( 'Add New Product Category', 'woocommerce' ),
    						'new_item_name'     => __( 'New Product Category Name', 'woocommerce' )
    					),
    				'show_ui'               => true,
    				'query_var'             => true,
    				'capabilities'          => array(
    					'manage_terms' => 'manage_product_terms',
    					'edit_terms'   => 'edit_product_terms',
    					'delete_terms' => 'delete_product_terms',
    					'assign_terms' => 'assign_product_terms',
    				),
    				'rewrite'               => array(
    					'slug'         => empty( $permalinks['category_base'] ) ? _x( 'product-category', 'slug', 'woocommerce' ) : $permalinks['category_base'],
    					'with_front'   => false,
    					'hierarchical' => true,
    				),
    			) )
    		);
        }
        if( ! $parent ){
            $new_cat_id = wp_insert_term(
                $name, // the term 
                $taxonomy, // the taxonomy
                array(
                    'description'=> $description,
                    'slug' => $slug,                   // what to use in the url for term archive
                    'parent'=> $ids [ $parent ]
                )
            );
        }else{
            if( $ids [$parent] ){
                $new_cat_id = wp_insert_term(
                    $name, // the term 
                    $taxonomy, // the taxonomy
                    array(
                        'description'=> $description,
                        'slug' => $slug,                   // what to use in the url for term archive
                        'parent'=> $ids [ $parent ]
                    )
                );
            }else{
                //The categoy have been waiting 
                $cate_add_after = get_option('kt_demo_categories_add_before');
                if( $cate_add_after && count( $cate_add_after ) ){
                    foreach( $cate_add_after as $after ){
                        kt_add_category( $after );
                    }
                }
                $cate_add_after[] = $cat;
                update_option('kt_demo_categories_add_before', $cate_add_after);
            }
        }
        if( ! is_wp_error( $new_cat_id ) ){
            if( is_array( $new_cat_id ) && isset( $new_cat_id['term_id'] ) ){
                $ids [ $term_id ] = array( 
                    'id'  => $new_cat_id['term_id'],
                    'tax' => $taxonomy
                );
            }else{
                $ids [ $term_id ] = array( 
                    'id'  => $new_cat_id,
                    'tax' => $taxonomy
                );
            }
        
            $categories_id = $ids;
            
            update_option( 'kt_demo_categories', $categories_id );
            
            //Update thumbnail
            if( $thumbnail ){
                $thumnail_id = kt_get_post_id( $thumbnail, 'attachment', 'kt_demo_attachment' );
                
                if( function_exists( 'add_woocommerce_term_meta' ) ){
                    return add_woocommerce_term_meta( $new_cat_id['term_id'], 'thumbnail_id', $thumnail_id, false );
                }else{
                    return add_metadata( 'woocommerce_term', $new_cat_id['term_id'], 'thumbnail_id', $thumnail_id, false );
                }
            }
        }else{
            return;
        }
        
    }
    return $new_cat_id;
}

/**
 * Get all category added
 * @since 1.0
 */
function kt_get_all_categories_added(){
    global $categories_id;
    $categories_id = get_option('kt_demo_categories');
}
/**
 * Remove all categories
 * 
 * @since 1.0
 * 
 */
function kt_remove_cate() {
    global $categories_id;
    if ( is_array( $categories_id ) ) :
        foreach( $categories_id as $id ) :
            if( isset( $id['id'] ) && isset( $id['tax'] ) && intval( $id['id'] ) && $id['tax'] ){
                wp_delete_term( $id['id'], $id['tax'] );
            }
        endforeach;
    endif;
}
/**
 * Get new id category
 * 
 * @since 1.0
 * 
 * @param $cate_id_old int old id of category
 */
function kt_get_cate_id( $cate_id_old ){
    global $categories_id;
    if( is_array( $categories_id ) && isset( $categories_id [ $cate_id_old ] ) && $categories_id [ $cate_id_old ] ){
        if( isset( $categories_id [ $cate_id_old ][ 'id' ] ) && intval( $categories_id [ $cate_id_old ][ 'id' ] ) ) {
            return $categories_id [ $cate_id_old ][ 'id' ];
        }
    }
    return false;
}
/**
 * Add Post
 * 
 * @since 1.0
 * @param $id int old id
 * @param $post_title string 
 * @param $post_content base64
 * @param $guid 
 * @param $post_category int old category
 * @param $post_format string default standard
 * @param $post_thumnail int old id thumbnail
 */
function kt_add_post( $id, $post_title, $post_content, $guid, $post_category, $post_format="standard", $post_thumnail = false, $meta = '' ) {
    global $posts_id;
    $new_id = kt_get_post_id( $id );
    
    if( ! $new_id ) {
        $list_category = array();
        $categories = explode( ',', $post_category );
        
        if( is_array( $categories ) && count( $categories ) ){
            foreach( $categories as  $cate_id_old ) {
                $new_cate_id = kt_get_cate_id( $cate_id_old );
                
                if( $new_cate_id ) {
                    $list_category[] = $new_cate_id;
                }
            }
        }
        
        $new_post = array(
            'post_title'     => $post_title,
            'post_status'    => 'publish',
            'post_type'      => 'post',
            'post_content'   => base64_decode($post_content),
            'comment_status' => 'open',
            'post_category'  => $list_category, //adding category to this post
            'guid'           => $guid
        );
    
        //new post / page
        $post_id = wp_insert_post($new_post);
        
        if( isset( $posts_id['post'][ 'kt_demo_post' ] ) ){
            $posts_id[ 'post' ][ 'kt_demo_post' ][ $id ] = $post_id;
        }
         // add our demo custom meta field, using this field we will delete all the pages
        update_post_meta( $post_id, 'kt_demo_post', $id);
        
        if( $post_thumnail ) {
            $post_thumnail_id = kt_get_post_id( $post_thumnail, 'attachment', 'kt_demo_attachment' );
            
            if( $post_thumnail_id ) {
                update_post_meta( $post_id, '_thumbnail_id', $post_thumnail_id );
            }
        }
        if( $meta ){
            kt_add_postmeta( $post_id, $meta );
        }
        if( $post_format != 'standard') {
            wp_set_post_terms($post_id, $post_format, 'post_format' );
        }
        return $post_id;
    }
    return $new_id;
}
/**
 * Add Page
 * 
 * @since 1.0
 * @param $id int - old id
 * @param $post_title string - post title
 * @param $post_content string - post content
 * @param $guid string 
 * @param $template string
 * @return $new id
 */
function kt_add_page( $id, $post_title, $post_content, $guid, $template = 'page.php', $comment_status = "open", $meta = '' ) {
    global $posts_id;
    $new_id = kt_get_post_id( $id, 'page', 'kt_demo_page' );
    
    if( ! $new_id ) {
        $new_post = array(
            'post_title' => $post_title,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => base64_decode($post_content),
            'comment_status' => $comment_status,
            'guid' => $guid
        );
    
        //new post / page
        $page_id = wp_insert_post ($new_post);
        
        if( isset( $posts_id['page'][ 'kt_demo_page' ] ) ){
            $posts_id[ 'page' ][ 'kt_demo_page' ][ $id ] = $page_id;
        }
        // add our demo custom meta field, using this field we will delete all the pages
        update_post_meta($page_id, 'kt_demo_page', $id);
        
        // set the page template if we have one
        if ( ! empty( $template ) && $template != 'page.php' ) {
            update_post_meta($page_id, '_wp_page_template', $template);
        }
        if( $meta ){
            kt_add_postmeta( $page_id, $meta );
        }
        return $page_id;
    }
    return $new_id;
}
function remove_page(){
    remove_post( 'page', 'kt_demo_page' );
}
/**
 * 
 * 
 */
 
function kt_other_post_type( $id, $post_type, $post_parent = 0 ,$post_title, $post_content, $guid, $post_category, $comment_status = "open", $meta = '', $post_thumnail = 0
 ) {
    global $posts_id;
    $new_id = kt_get_post_id( $id, $post_type, "kt_demo_{$post_type}" );
    
    if( ! $new_id ) {
        $list_category = array();
        $categories = explode( ',', $post_category );
        
        if( is_array( $categories ) && count( $categories ) ){
            foreach( $categories as  $cate_id_old ) {
                $new_cate_id = kt_get_cate_id( $cate_id_old );
                
                if( $new_cate_id ) {
                    $list_category[] = $new_cate_id;
                }
            }
        }
        $parent_id = 0;
        if( $post_parent ){
            if( $post_type == 'product_variation' ){
                $parent_id = kt_get_post_id( $post_parent, 'product', "kt_demo_product" );
            }else{
                $parent_id = kt_get_post_id( $post_parent );
            }
        }
        $new_post = array(
            'post_title'     => $post_title,
            'post_status'    => 'publish',
            'post_type'      => $post_type,
            'post_content'   => base64_decode($post_content),
            'comment_status' => $comment_status,
            'post_category'  => $list_category, //adding category to this post
            'guid'           => $guid,
            'post_parent'    => $parent_id,
            'tax_input' => array(
                'product_cat' => $list_category
            ),
        );
        
        //new post / page
        $post_id = wp_insert_post($new_post);
        
        if( isset( $posts_id[ $post_type ][ "kt_demo_{$post_type}" ] ) ){
            $posts_id[ $post_type ][ "kt_demo_{$post_type}" ][ $id ] = $post_id;
        }
        $_thumbnail_id = array();
        if( $post_thumnail ) {
            $post_thumnail_id = kt_get_post_id( $post_thumnail, 'attachment', 'kt_demo_attachment' );
            
            if( $post_thumnail_id ) {
                set_post_thumbnail($post_id, $post_thumnail_id );
            }
            $_thumbnail_id [] = $post_thumnail_id;
        }
         // add our demo custom meta field, using this field we will delete all the pages
        update_post_meta( $post_id, "kt_demo_{$post_type}", true);
       
        if( $meta ){
            $meta = unserialize($meta);
            if( isset( $meta['_thumbnail_id'] ) ){
                $meta['_thumbnail_id'] = $_thumbnail_id;
            }
            if( isset( $meta [ '_product_image_gallery' ] ) && $meta [ '_product_image_gallery' ] ){
                if( isset( $meta [ '_product_image_gallery' ][0] ) && $meta [ '_product_image_gallery' ][0] ){
                    $_gallery = explode( ',', $meta [ '_product_image_gallery' ][0] );
                    
                    $_product_gallery = array();
                    
                    if( is_array( $_gallery ) && count( $_gallery ) ){
                        foreach( $_gallery as  $thumbnail ) {
                            $thumnail_id = kt_get_post_id( $thumbnail, 'attachment', 'kt_demo_attachment' );
                            
                            if( $thumnail_id ) {
                                $_product_gallery[] = $thumnail_id;
                            }
                        }
                    }
                    $meta [ '_product_image_gallery' ] = array( implode( ',', $_product_gallery ) );
                }
                
            }
            $meta = serialize($meta);
            kt_add_postmeta( $post_id, $meta );
        }
        return $post_id;
    }
    return $new_id;
}

function kt_add_postmeta( $new_id, $meta ){
    $post_meta = unserialize( $meta );
    
    if( is_array( $post_meta ) && count( $post_meta ) > 0 ){
        foreach( $post_meta as $k => $v ){
            if( isset( $v[0] ) ){
                update_post_meta( $new_id, $k, $v[0] );
            }
        }
    }
}
/**
 * Add Menu
 * 
 * @since 1.0
 * @param $id int - old id
 * @param $name string - name
 * @param $location string - old location
 * @return new id menu
 */
function kt_add_menu( $id, $name, $location = 0 ) {
    global $menus_id;
    $menu_id = kt_get_menu_id( $id );
    
    if( ! $menu_id){
        $menu_id = wp_create_nav_menu($name);
    
        if (is_wp_error($menu_id)) {
            return false;
        }
        
        $menu_spots_array = get_theme_mod('nav_menu_locations');
        // activate the menu only if it's not already active
        if ( ! isset($menu_spots_array[$location]) or $menu_spots_array[$location] != $menu_id) {
            $menu_spots_array[$location] = $menu_id;
            set_theme_mod('nav_menu_locations', $menu_spots_array);
        }
        $menus_id [ $id ] = $menu_id;
        
        update_option('kt_demo_menus', $menus_id);
    }
    return $menu_id;
}
/**
 * Add Menu Item
 * 
 * @since 1.0
 */
function kt_add_menu_item( $id, $menu_id, $parent ,$post_title, $object, $object_id, $type, $url, $megamenu_enable = false, $megamenu_menu_page= 0, $megamenu_img_icon = 0 ) {
    global $posts_id;
    
    $menu = kt_get_menu_id( $menu_id );
    
    if( ! $menu) {
        $new_id = kt_get_post_id( $id, 'nav_menu_item', 'kt_demo_nav_menu_item' );
        
        if( ! $new_id ) {
            //$menu_id, $title='', $page_id, $parent_id = ''
            $parent_id = kt_get_post_id( $parent, 'nav_menu_item', 'kt_demo_nav_menu_item' );
            
            if( ! $parent_id ) {
                $parent_id = 0;
            }
            $menu_item_data =  array(
                'menu-item-title'     => $post_title,
                'menu-item-parent-id' => $parent_id,
                'menu-item-object'    => $object,
                'menu-item-object-id' => $object_id,
                'menu-item-type'      => $type,
                'menu-item-status'    => 'publish',
                'menu-item-url'       => $url
            );
            /*
            if( $type == 'post_type' && $object == 'page' ) {
                $page_id = kt_get_post_id( $object_id, 'page', 'kt_demo_page' );
                $url = get_page_link( $page_id );
                
                if( is_link( $url ) ){
                    $menu_item_data[ 'menu-item-url' ] = $url;
                }
            }
            */
            $menu_item_id = wp_update_nav_menu_item( $menu_id, 0, $menu_item_data);
            
            if( isset( $posts_id['nav_menu_item'][ 'kt_demo_nav_menu_item' ] ) ){
                $posts_id[ 'nav_menu_item' ][ 'kt_demo_nav_menu_item' ][ $id ] = $menu_item_id;
            }
            
            // add our demo custom meta field, using this field we will delete all the pages
            update_post_meta( $menu_item_id, 'kt_demo_nav_menu_item', $id );
            
            if( $megamenu_enable ) {
                update_post_meta( $menu_item_id, '_menu_item_megamenu_enable', $megamenu_enable );
            }
            
            if( $megamenu_menu_page ) {
                $new_id_megamenu_menu_page = kt_get_post_id( $megamenu_menu_page, 'megamenu', 'kt_demo_megamenu' );
                
                if( ! $new_id_megamenu_menu_page )
                    $new_id_megamenu_menu_page = kt_get_post_id( $megamenu_menu_page, 'page', 'kt_demo_page' );
                
                if( $new_id_megamenu_menu_page ){
                    update_post_meta( $menu_item_id, '_menu_item_megamenu_menu_page', $new_id_megamenu_menu_page );
                }
            }
            
            if( $megamenu_img_icon ) {
                $new_id_megamenu_img_icon = kt_get_post_id( $megamenu_img_icon, 'attachment', 'kt_demo_attachment' );
                if( $new_id_megamenu_img_icon )
                    update_post_meta( $menu_item_id, '_menu_item_megamenu_img_icon', $new_id_megamenu_img_icon );
            }
            
            return $menu_item_id;
        }
        return $new_id;
    }
    return false;
}

/**
 * Get all menu added
 * @since 1.0
 */

function kt_get_all_menus_added(){
    global $menus_id;
    $menus_id = get_option('kt_demo_menus');
}

/**
 * Get menu ID
 * 
 * @param $menu_id_old int old id menu
 * @return new id menu
 * @since 1.0
 */
function kt_get_menu_id( $menu_id_old ) {
    global $menus_id;
    if( is_array($menus_id) && isset( $menus_id [$menu_id_old] ) && $menus_id [$menu_id_old] ){
        return $menus_id [$menu_id_old];
    }
    return false;
    
}
function kt_remove_menu( ) {
    global $menus_id;
    if( is_array($menus_id) && count( $menus_id ) > 0 ) {
        foreach( $menus_id as $menu ){
            wp_delete_nav_menu($menu);
        }
        delete_option( 'kt_demo_menus' );
        $menus_id = array();
    }
}
function kt_remove_menu_items(){
    remove_post( 'nav_menu_item', 'kt_demo_nav_menu_item');
}
/**
 * Add widget 
 * $name string name widget
 * $location string location
 * $pos int maching position
 * $data base64 + serialize array data
 * $default_pos int old positon check exist insert new database
 * */
function kt_add_widget( $name, $location, $pos = 0, $data = '', $default_pos = 0 ) {
    $mark = $name .'-'. $pos;
    $kt_demo_widget =  get_option( 'kt_demo_widget', array() );
    
    if( ! in_array( $name .'-'. $default_pos . '-' . $location,  $kt_demo_widget) ){
        $widgets = wp_get_sidebars_widgets();
        
        if( isset( $widgets[ $location ] ) && ! is_array( $widgets[ $location ] ) ){
            $widgets[ $location ] = array();
        }
        if( empty( $widgets[ $location ] ) or ! in_array( $mark, $widgets[ $location ] ) ){
            $widgets[ $location ][] = $mark;
            $default_data = get_option( 'widget_' . $name, array());
            if( ! isset( $default_data[ $pos ] ) ){
                //Add widget to sidebar
                update_option('sidebars_widgets', $widgets);
                //Update setting
                $default_data[ $pos ] = unserialize( base64_decode( $data ) ) ;
                update_option( 'widget_' . $name, $default_data );
                
                //sticky
                $kt_demo_widget[] = $name .'-'. $default_pos . '-' . $location;
                    
                update_option( 'kt_demo_widget', $kt_demo_widget );
                
                //support delete
                $kt_demo_new_widget = get_option( 'kt_demo_new_widget', array() );
                
                $kt_demo_new_widget[] = array( 
                    'mark'     => $mark,
                    'name'     => $name,
                    'pos'      => $pos,
                    'location' => $location,
                    'old_pos'  => $default_pos
                );
                update_option( 'kt_demo_new_widget', $kt_demo_new_widget );
            }else{
                kt_add_widget( $name, $location, $pos + 1, $data, $default_pos);
            }
        }else{
            kt_add_widget( $name, $location, $pos + 1, $data, $default_post);
        }
    }
    
}
function remove_widget(){
    $kt_demo_new_widget = get_option( 'kt_demo_new_widget', array() );
    
    if( ! empty( $kt_demo_new_widget ) ){
        $widgets = wp_get_sidebars_widgets();
        
        foreach( $kt_demo_new_widget as $w ){
            if( isset( $widgets[ $w['location'] ] ) && is_array( $widgets[ $w['location'] ] ) && ! empty( $widgets[ $w['location'] ] ) ){
                foreach( $widgets[ $w['location'] ] as $k => $wl ){
                    if( $wl == $w['mark'] ) {
                        //Delete widget
                        unset( $widgets[ $w['location'] ][$k] );
                        update_option('sidebars_widgets', $widgets);
                        //Update value
                        $data = get_option( 'widget_' . $w['name'] );
                        unset( $data[ $w[ 'pos' ] ] );
                        update_option( 'widget_' . $w['name'], $data );
                    }
                }
            }
        }
    } 
    delete_option( 'kt_demo_widget' );
    delete_option( 'kt_demo_new_widget' );
}
/**
 * Get attachment id by old_id
 *  
 * @since 1.0
 * 
 * @param int $old_id Old id 
 */

function kt_get_post_id( $old_id, $post_type = 'post',  $meta_key = 'kt_demo_post') {
    global $posts_id;
    
    $post_id = false;
    
    if( isset( $posts_id[ $post_type ][ $meta_key ] ) && ! empty( $posts_id[ $post_type ][ $meta_key ] ) && is_array( $posts_id[ $post_type ][ $meta_key ] ) && count( $posts_id[ $post_type ][ $meta_key ] ) > 0 ){
        foreach( $posts_id[ $post_type ][ $meta_key ] as $k => $v ){
            if ( $k == $old_id ) {
                $post_id =  $v;
                break;
            }
        }
    }else{
        $args = array(
            'post_type'     => array( $post_type ),
            'post_status'   => array( 'inherit', 'publish' ),
            'meta_key'      => $meta_key,
            'posts_per_page' => '-1'
        );
        
        //@todo big problem here - we rely on the wp_cache from get_post_meta too much
        $query = new WP_Query( $args );
        
        if ( ! empty( $query->posts ) ) {
            foreach ($query->posts as $post) {
                //search for our td_id in the post meta
                $new_id = get_post_meta($post->ID, $meta_key, true);
                if ( $new_id == $old_id ) {
                    $post_id =  $post->ID;
                }
                $posts_id[ $post_type ][ $meta_key ][ $new_id ] = $post->ID;
            }
        }
        
    }
    return $post_id;

}
/**
 * Remove Post
 * @param $post_type string default post
 * @param $meta_key string default kt_demo_post
 * @since 1.0
 */
function remove_post( $post_type = 'post', $meta_key = 'kt_demo_post') {
    $args = array(
        'post_type' => array( $post_type ),
        'meta_key'  => $meta_key,
        'posts_per_page' => '-1'
    );
    
    $query = new WP_Query( $args );
    
    if ( ! empty( $query->posts ) ) {
        foreach ($query->posts as $post) {
            wp_delete_post($post->ID, true);
            delete_post_meta($post->ID, $meta_key, true);
        }
   }
}
function remove_other_post(){
    $post_types = get_post_types( array( '_builtin' => false ));
    if( count($post_types) > 0 ){
        foreach( $post_types as $post_type ){
            $meta_key = "kt_demo_{$post_type}";
            $args = array(
                'post_type' => array( $post_type ),
                'meta_key'  => $meta_key,
                'posts_per_page' => '-1'
            );
            
            $query = new WP_Query( $args );
            
            if ( ! empty( $query->posts ) ) {
                foreach ($query->posts as $post) {
                    wp_delete_post($post->ID, true);
                    delete_post_meta($post->ID, $meta_key, true);
                }
           }
        }
    }
}
if( ! function_exists( 'is_user_logged_in' ) ){
    function is_user_logged_in() {
    	$user = wp_get_current_user();
    
    	return $user->exists();
    }

}
if( ! function_exists( 'kt_export_date_options' ) ){
    function kt_export_date_options( $post_type = 'post' ) {
    	global $wpdb, $wp_locale;
    
    	$months = $wpdb->get_results( $wpdb->prepare( "
    		SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month
    		FROM $wpdb->posts
    		WHERE post_type = %s AND post_status != 'auto-draft'
    		ORDER BY post_date DESC
    	", $post_type ) );
    
    	$month_count = count( $months );
    	if ( !$month_count || ( 1 == $month_count && 0 == $months[0]->month ) )
    		return;
    
    	foreach ( $months as $date ) {
    		if ( 0 == $date->year )
    			continue;
    
    		$month = zeroise( $date->month, 2 );
    		echo '<option value="' . $date->year . '-' . $month . '">' . $wp_locale->get_month( $month ) . ' ' . $date->year . '</option>';
    	}
    }
}