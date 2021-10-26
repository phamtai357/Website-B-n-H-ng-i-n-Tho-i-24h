<?php

require_once( dirname(__FILE__) . '../../../../wp-admin/admin.php' );
require_once( dirname(__FILE__) . '../../../../wp-includes/pluggable.php');

if ( !current_user_can('export') )
	wp_die(__('You do not have sufficient permissions to export the content of this site.'));


global $wpdb, $post;
$args = array();
// If the 'download' URL parameter is set, a WXR export file is baked and returned.
if ( isset( $_GET['download_export'] ) ) {
	if ( ! isset( $_GET['content'] ) || 'all' == $_GET['content'] ) {
		$args['content'] = 'all';
	} elseif ( 'posts' == $_GET['content'] ) {
		$args['content'] = 'post';

		if ( $_GET['cat'] )
			$args['category'] = (int) $_GET['cat'];

		if ( $_GET['post_author'] )
			$args['author'] = (int) $_GET['post_author'];

		if ( $_GET['post_start_date'] || $_GET['post_end_date'] ) {
			$args['start_date'] = $_GET['post_start_date'];
			$args['end_date'] = $_GET['post_end_date'];
		}

		if ( $_GET['post_status'] )
			$args['status'] = $_GET['post_status'];
	} elseif ( 'pages' == $_GET['content'] ) {
		$args['content'] = 'page';

		if ( $_GET['page_author'] )
			$args['author'] = (int) $_GET['page_author'];

		if ( $_GET['page_start_date'] || $_GET['page_end_date'] ) {
			$args['start_date'] = $_GET['page_start_date'];
			$args['end_date'] = $_GET['page_end_date'];
		}

		if ( $_GET['page_status'] )
			$args['status'] = $_GET['page_status'];
	} elseif ( 'nav_menu_item' == $_GET['content'] ) {
	   $args['content'] = 'nav_menu_item';
    } elseif ( 'widget' == $_GET['content'] ) {
	   $args['content'] = 'widget';
    }else {
		$args['content'] = $_GET['content'];
	}

	/**
	 * Filter the export args.
	 *
	 * @since 3.5.0
	 *
	 * @param array $args The arguments to send to the exporter.
	 */
	$args = apply_filters( 'kt_export_args', $args );
}


$defaults = array( 
    'content'   => 'all', 
    'author'    => false, 
    'category'  => false,
	'start_date'=> false, 
    'end_date'  => false, 
    'status'    => false,
    'nav_menu_item' => false,
    'widget' => false
);
$args = wp_parse_args( $args, $defaults );

do_action( 'kt_data_export', $args );

$sitename = sanitize_key( get_bloginfo( 'name' ) );
if ( ! empty($sitename) ) $sitename .= '.';
$filename = $sitename . 'wordpress.' . date( 'Y-m-d' ) . '.php';
$uri = plugin_dir_url(__FILE__);     

header( 'Content-Description: File Transfer' );
header( 'Content-Disposition: attachment; filename=' . $filename );
header( 'Content-Type: text/plain; charset=' . get_option( 'blog_charset' ), true );

echo "<?php\r";

/*
 * Get the requested terms ready, empty unless posts filtered by category
 * or all content.
 */
$cats = $tags = $terms = array();
if ( isset( $term ) && $term ) {
	$cat = get_term( $term['term_id'], 'category' );
	$cats = array( $cat->term_id => $cat );
    
	unset( $term, $cat );
} elseif ( 'all' == $args['content'] ) {
	$categories = (array) get_categories( array( 'get' => 'all' ) );
	$tags = (array) get_tags( array( 'get' => 'all' ) );
    
	$custom_taxonomies = get_taxonomies( array( '_builtin' => false ) );
    
	$custom_terms = (array) get_terms( $custom_taxonomies, array( 'get' => 'all' ) );
    
	// Put categories in order with no child going before its parent.
	while ( $cat = array_shift( $categories ) ) {
		if ( $cat->parent == 0 || isset( $cats[$cat->parent] ) )
			$cats[$cat->term_id] = $cat;
		else
			$categories[] = $cat;
	}

	// Put terms in order with no child going before its parent.
	while ( $t = array_shift( $custom_terms ) ) {
		if ( $t->parent == 0 || isset( $terms[$t->parent] ) )
			$terms[$t->term_id] = $t;
		else
			$custom_terms[] = $t;
	}

	unset( $categories, $custom_taxonomies, $custom_terms );
}
echo '// Option theme';
echo "\r";
$kt_options = get_option('kt_options');
echo "kt_add_options( '". base64_encode( serialize( $kt_options ) ) ."' );\r\r";

$taxonomies = get_taxonomies(array(), 'objects');
echo '// Taxonomies';
echo "\r";
echo "kt_add_taxonomies( '". base64_encode( serialize( $taxonomies ) ) ."' );\r\r";

if( ! empty( $cats ) ) {
    echo '// Categories';
    echo "\r";
    foreach ( $cats as $c ) :
        echo "kt_add_category( " .$c->term_id. ", '". addslashes( $c->name )."', '". $c->slug ."', '". $c->taxonomy ."', '". $c->parent ."', '". addslashes( $c->description ) ."' );\r\r";
    endforeach;
    
    echo '// Custom term';
    echo "\r";
    foreach ( $terms as $c ) :
        if( $c->taxonomy ==  'product_brand' ){
            $thumbnail_id = get_metadata( 'woocommerce_term', $c->term_id, 'thumbnail_id', true );
            
            echo "kt_add_brand( " .$c->term_id. ", '". addslashes( $c->name )."', '". $c->slug ."', '". $c->taxonomy ."', '". $c->parent ."', '". addslashes( $c->description ) ."', '" . $thumbnail_id . "' );\r\r";
        }elseif( $c->taxonomy ==  'product_cat' ){
            $thumbnail_id = get_metadata( 'woocommerce_term', $c->term_id, 'thumbnail_id', true );
            
            echo "kt_add_product_cat( " .$c->term_id. ", '". addslashes( $c->name )."', '". $c->slug ."', '". $c->taxonomy ."', '". $c->parent ."', '". addslashes( $c->description ) ."', '" . $thumbnail_id . "' );\r\r";
        }else{
            echo "kt_add_category( " .$c->term_id. ", '". addslashes( $c->name )."', '". $c->slug ."', '". $c->taxonomy ."', '". $c->parent ."', '". addslashes( $c->description ) ."' );\r\r";
        }
    endforeach;
    
    echo '// Tag';
    echo "\r";
    foreach ( $tags as $c ) :
        echo "kt_add_category( " .$c->term_id. ", '". addslashes( $c->name )."', '". $c->slug ."', '". $c->taxonomy ."', '". $c->parent ."', '". addslashes( $c->description ) ."' );\r\r";
    endforeach;
}

if( $args['content'] != 'nav_menu_item' && $args['content'] != 'widget' ){
    if ( 'all' != $args['content'] && post_type_exists( $args['content'] ) ) {
    	$ptype = get_post_type_object( $args['content'] );
    	if ( ! $ptype->can_export )
    		$args['content'] = 'post';
    
    	$where = $wpdb->prepare( "{$wpdb->posts}.post_type = %s", $args['content'] );
    } else {
    	$post_types = get_post_types( array( 'can_export' => true ) );
    	$esses = array_fill( 0, count($post_types), '%s' );
    	$where = $wpdb->prepare( "{$wpdb->posts}.post_type IN (" . implode( ',', $esses ) . ')', $post_types );
    }
    
    if ( $args['status'] && ( 'post' == $args['content'] || 'page' == $args['content'] ) )
    	$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_status = %s", $args['status'] );
    else
    	$where .= " AND {$wpdb->posts}.post_status != 'auto-draft'";
    
    $join = '';
    if ( $args['category'] && 'post' == $args['content'] ) {
    	if ( $term = term_exists( $args['category'], 'category' ) ) {
    		$join = "INNER JOIN {$wpdb->term_relationships} ON ({$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id)";
    		$where .= $wpdb->prepare( " AND {$wpdb->term_relationships}.term_taxonomy_id = %d", $term['term_taxonomy_id'] );
    	}
    }
    
    if ( 'post' == $args['content'] || 'page' == $args['content'] ) {
    	if ( $args['author'] )
    		$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_author = %d", $args['author'] );
    
    	if ( $args['start_date'] )
    		$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_date >= %s", date( 'Y-m-d', strtotime($args['start_date']) ) );
    
    	if ( $args['end_date'] )
    		$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_date < %s", date( 'Y-m-d', strtotime('+1 month', strtotime($args['end_date'])) ) );
    }
    
    // Grab a snapshot of post IDs, just in case it changes during the export.
    $post_ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} $join WHERE $where" );
    // posts
    $list_post = array();
    // pages
    $list_page = array();
    //Menu item
    $list_nav_menu_item = array();
    //Other
    //product
    $list_product = array();
    //product_variation
    $list_product_variation = array();
    $list_other = array();
    
    if ( $post_ids ) {
    	/**
    	 * @global WP_Query $wp_query
    	 */
    	global $wp_query;
    
    	// Fake being in the loop.
    	$wp_query->in_the_loop = true;
        echo '// Attachment';
        echo "\r";
    	// Fetch 20 posts at a time rather than loading the entire table into memory.
    	while ( $next_posts = array_splice( $post_ids, 0, 20 ) ) {
        	$where = 'WHERE ID IN (' . join( ',', $next_posts ) . ')';
        	$posts = $wpdb->get_results( "SELECT * FROM {$wpdb->posts} $where" );
            
        	// Begin Loop.
        	foreach ( $posts as $post ) {
        		setup_postdata( $post );
        		$is_sticky = is_sticky( $post->ID ) ? 1 : 0;
                $post->is_sticky = $is_sticky;
                
                if( $post->post_type == 'attachment' ) {
                    preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $post->guid, $matches );
                    
                    if( isset( $matches[0] ) && ! empty( $matches[0] ) ) {
                        echo "kt_download_media(" .$post->ID. ", '" . addslashes( $post->post_title ) . "', '" . $post->guid . "');\r\r";
                    }
                }else if( $post->post_type == 'page' ){
                    $post->template = get_post_meta( $post->ID, '_wp_page_template', 'page.php' );
                    $list_page[] = $post;
                }else if( $post->post_type == 'post' ){
                    $post->post_thumnail = get_post_thumbnail_id( $post->ID );
                    $list_post[] = $post;
                }else if( $post->post_type == 'nav_menu_item' ){
                    $list_nav_menu_item[] = $post;
                }else if( $post->post_type == 'product' ){
                    $list_product[] = $post;
                }else if( $post->post_type == 'product_variation' ){
                    $list_product_variation[] = $post;
                }else{
                    //Other post type
                    $list_other[] = $post;
                }
                
            }//end foreach ( $posts as $post )
        }//end while ( $next_posts = array_splice( $post_ids, 0, 20 ) )
        if( count( $list_post > 0 ) ) {
            echo '// Post';
            echo "\r";
        
            foreach( $list_post as $post ):
                $post_categories = wp_get_post_categories( $post->ID );
                $post_categories = implode( ',', $post_categories );
                $meta = get_post_meta( $post->ID );
                $format = get_post_format( $post->ID );
                
                if ( false === $format ) {
                	$format = 'standard';
                }
                echo "kt_add_post(" .$post->ID. ", '" . addslashes( $post->post_title ). "', '" .base64_encode( $post->post_content ). "', '".$post->guid."', '". $post_categories ."', '" .$format. "', '" . $post->post_thumnail . "', '" .serialize( $meta ). "' );\r\r";
            endforeach;
        }
        if( count( $list_page > 0 ) ) {
            echo '// Page';
            echo "\r";
            
            foreach( $list_page as $post ):
                $meta = get_post_meta( $post->ID );
                echo "kt_add_page(" .$post->ID. ", '" .addslashes( $post->post_title ). "', '" .base64_encode( $post->post_content ). "', '" .$post->guid. "', '" .$post->template. "', '" .$post->comment_status. "', '" .serialize( $meta ). "' );\r\r";
            endforeach;
        }
        
        if( count( $list_product > 0 ) ) {
            echo '// Product';
            echo "\r";
            foreach( $list_product as $post ):
                $meta = get_post_meta( $post->ID );
                $post_categories = wp_get_object_terms($post->ID, 'product_cat', array('fields' => 'ids') );
                $post_categories = implode( ',', $post_categories );
                //Thumbnail id
                $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
                echo "kt_other_post_type(" .$post->ID. ", '". $post->post_type ."', ".$post->post_parent." ,'" . addslashes( $post->post_title ). "', '" .base64_encode( $post->post_content ). "', '".$post->guid."', '". $post_categories ."', '". $post->comment_status ."', '" . serialize( $meta ) . "', '" . $post_thumbnail_id . "' );\r\r";
            endforeach;
        }
        if( count( $list_product_variation > 0 ) ) {
            echo '// Product Variation';
            echo "\r";
            foreach( $list_product_variation as $post ):
                $meta = get_post_meta( $post->ID );
                $post_categories = wp_get_object_terms($post->ID, 'product_cat', array('fields' => 'ids') );
                $post_categories = implode( ',', $post_categories );
                echo "kt_other_post_type(" .$post->ID. ", '". $post->post_type ."', ".$post->post_parent." ,'" .addslashes( $post->post_title ). "', '" .base64_encode( $post->post_content ). "', '".$post->guid."', '". $post_categories ."', '". $post->comment_status ."', '" .serialize( $meta ). "' );\r\r";
            endforeach;
        }
        
        if( count( $list_other > 0 ) ) {
            echo '// Other';
            echo "\r";
            foreach( $list_other as $post ):
                $meta = get_post_meta( $post->ID );
                $taxonomies = get_object_taxonomies( $post->post_type, 'objects' );
                $post_categories = array();
                
                if( ! empty( $taxonomies ) ){
                    foreach( $taxonomies as $tax ){
                        $cat_ids = wp_get_object_terms($post->ID, addslashes( $tax->name ), array('fields' => 'ids') );
                        if( ! empty( $cat_ids ) ){
                            foreach( $cat_ids as $c ){
                                $post_categories[] = $c;
                            }
                        }
                    }
                }
                $post_categories = implode( ',', $post_categories );
                echo "kt_other_post_type(" .$post->ID. ", '". $post->post_type ."', ".$post->post_parent." ,'" . addslashes( $post->post_title ). "', '" .base64_encode( $post->post_content ). "', '".$post->guid."', '". $post_categories ."', '". $post->comment_status ."', '" .serialize( $meta ). "' );\r\r";
            endforeach;
        }
        
    }//endif if ( $post_ids ) 
}

if( $args['content'] == 'nav_menu_item' || $args['content'] == 'all' ){
    //get all menu term
    $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
    
    if( ! empty( $menus ) ) :
        $nav_menu_locations = get_theme_mod('nav_menu_locations');
        foreach ( $menus as $menu ) {
            $location = false;
            foreach( $nav_menu_locations as $k => $v ){
                if( $v == $menu->term_id ){
                    $location = $k;
                }
            }
            echo "//Menu\r";
            echo '$menu_id ';
            echo "= kt_add_menu( $menu->term_id, '" .addslashes( $menu->name ) . "', '$location' );\r";
            echo "\r // Menu Item\r";
            $items = wp_get_nav_menu_items( $menu->term_id );
            if( count($items) > 0 ){
                foreach( $items as $item ) {
                    $megamenu_enable    = get_post_meta( $item->ID, '_menu_item_megamenu_enable', true );
                    $megamenu_menu_page = get_post_meta( $item->ID, '_menu_item_megamenu_menu_page', true );
                    $megamenu_img_icon  = get_post_meta( $item->ID, '_menu_item_megamenu_img_icon', true );
                    
                    if( $megamenu_enable ){
                        $item->enable_megamenu = $megamenu_enable;
                    }
                    if( $megamenu_menu_page ){
                        $item->megamenu_page = $megamenu_menu_page;
                    }
                    if( $megamenu_img_icon ){
                        $item->megamenu_icon = $megamenu_img_icon;
                    }
                    echo "kt_add_menu_item( $item->ID, " .'$menu_id'.", $item->menu_item_parent, '".addslashes( $item->title )."', '$item->object', $item->object_id, '$item->type', '$item->url', '$megamenu_enable', '$megamenu_menu_page', '$megamenu_img_icon' );\r\r";
                }
            }
            
        }
    endif;
}
if( $args['content'] == 'widget' || $args['content'] == 'all' ){
    $widgets = wp_get_sidebars_widgets();
    
    echo "\r // Widgets\r";
    if( ! empty( $widgets ) ){
        foreach( $widgets as $k => $widget ){
            if( ! empty( $widget ) ){
                foreach( $widget as $w ){
                    $tmp = explode( '-', $w );
                    $count = count ( $tmp );
                    if( ! empty( $tmp ) && $count > 0 ){
                        $pos = $tmp[ $count -1 ];
                        if( $pos && intval( $pos ) > 0 ){
                            unset( $tmp[ $count -1 ] );
                            $name = join( '-', $tmp );
                            
                            if( ! empty( $name ) ) {
                                $data = get_option( 'widget_' . $name, array());
                                
                                if( isset( $data[ $pos ] ) && !empty( $data[ $pos ] ) ){
                                    echo "kt_add_widget( '$name', '$k', '$pos', '". base64_encode( serialize( $data[ $pos ] ) ) ."', '$pos' );\r\r";
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
echo "\r?>";