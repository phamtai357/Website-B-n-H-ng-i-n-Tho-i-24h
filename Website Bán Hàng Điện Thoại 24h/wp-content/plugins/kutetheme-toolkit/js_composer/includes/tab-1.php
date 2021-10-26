<?php 
/**
 * @author  AngelsIT
 * @package KUTE TOOLKIT
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="<?php echo esc_attr( $elementClass ); ?>" id="change-color-<?php echo esc_attr( $id ); ?>" data-target="change-color" data-color="<?php echo esc_attr( $main_color ); ?>" data-rgb="<?php echo esc_attr( implode( ',', $main_color_rgb ) );  ?>">
    <!-- featured category fashion -->
    <div class="category-featured container-tab">
        <nav class="navbar nav-menu nav-menu-red show-brand">
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-brand">
                <a href="<?php echo  $term_link ? esc_url( $term_link ) : ''; ?>">
                    <?php echo wp_get_attachment_image( $icon,'full'); ?>
                    <?php  echo ( isset( $title ) && $title ) ? esc_html( $title ) : __( 'Tabs Name', 'kutetheme' );  ?>
                </a>
            </div>
            <span class="toggle-menu"></span>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">           
                <ul class="nav navbar-nav">
                    <?php $i = 0; ?>
                    <?php foreach( $tabs as $tab ): ?>
                        <li <?php echo  $i == 0 ? 'class="active"': '' ?> >
                            <a data-toggle="tab" href="<?php echo '#tab-' . $id . '-' . $i; ?>">
                                <?php
                                if(isset( $tab['header'] ) && $tab['header']){
                                    echo esc_html( $tab['header'] );
                                }elseif( isset($tab['section_type']) && $tab['section_type'] == 'new-arrival' ){
                                    _e( 'New Arrivals', 'kutetheme' );
                                }elseif( isset($tab['section_type']) && $tab['section_type'] == 'most-review' ){
                                    _e( 'Most Reviews', 'kutetheme' );
                                }elseif( isset($tab['section_type']) && $tab['section_type'] == 'on-sales' ){
                                    _e( 'On sales', 'kutetheme' );
                                }elseif( isset($tab['section_type']) && $tab['section_type'] == 'by-ids' ){
                                    _e( 'Tab', 'kutetheme' );
                                }elseif( isset($tab['section_type']) && $tab['section_type'] == 'category' && isset( $tab['section_cate'] ) && intval( $tab['section_cate'] ) >0 ){
                                    $child_term = get_term( $tab['section_cate'], 'product_cat' );
                                    if($child_term){
                                        echo esc_html( $child_term->name );
                                    }else{
                                        _e( "Best Sellers", 'kutetheme' );
                                    }
                                }else{
                                   _e( "Best Sellers", 'kutetheme' );
                                }
                                 ?>
                            </a>
                        </li>
                        <?php $i++; ?>
                    <?php endforeach;?>
                </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
          <div class="floor-elevator">
                <a href="#" class="btn-elevator up  fa fa-angle-up"></a>
                <a href="#" class="btn-elevator down fa fa-angle-down"></a>
          </div>
        </nav>
        <?php
        if( isset( $banner_top ) &&  $banner_top ):
            $banner_top_args = array(
                'post_type' => 'attachment',
                'include'   => $banner_top,
                'orderby'   => 'post__in'
            );
            $list_banner_top = get_posts( $banner_top_args );
            if( $list_banner_top ):
            $class = 12/ ( count( $list_banner_top ) );
            ?>
            <div class="category-banner">
                <?php foreach($list_banner_top as $b): ?>
                <div class="col-sm-<?php echo esc_attr( $class ) ?> banner">
                    <a href="<?php echo  $term_link ? esc_url( $term_link ) : ''; ?>">
                        <?php echo wp_get_attachment_image($b->ID,'full');?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
           <?php endif; ?>
       <?php endif; ?>
        <div class="product-featured clearfix">
            <?php if( isset( $banner_left ) && $banner_left ): ?>
                <div class="banner-featured">
                    <?php if( isset($featured) && $featured ): ?>
                        <div class="featured-text">
                            <span>
                                <?php  _e( 'featured', 'kutetheme' ) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php  
                        $banner_left_args = array(
                            'post_type' => 'attachment',
                            'include'   => $banner_left,
                            'orderby'   => 'post__in'
                        );
                        $list_banner_left = get_posts( $banner_left_args );
                        if( $list_banner_left ):?>
                            <?php foreach($list_banner_left as $l): ?>
                                <div class="banner-img">
                                    <a href="<?php echo  $term_link ? esc_url( $term_link ) : ''; ?>">
                                        <?php echo wp_get_attachment_image( $l->ID, 'full' );?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                </div>  
            <?php endif; ?>
            <div class="product-featured-content">
                <div class="product-featured-list <?php if( isset( $banner_left ) && $banner_left ): ?> has_attachment <?php endif; ?>">
                    <div class="tab-container">
                        <?php 
                        $meta_query = WC()->query->get_meta_query();
                        $args = array(
                			'post_type'				=> 'product',
                			'post_status'			=> 'publish',
                			'ignore_sticky_posts'	=> 1,
                			'posts_per_page' 		=> $per_page,
                			'meta_query' 			=> $meta_query,
                            'suppress_filter'       => true
                		);
                        if( $term ){
                            $args [ 'tax_query' ] = array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'id',
                                    'terms'    => $term->term_id,
                                    'operator' => 'IN'
                                )
                            );
                        }
                        $i = 0; ?>
                        <?php foreach( $tabs as $tab ): ?>
                        
                        <?php 
                        $tab = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'tab_section', $tab ) : $atts;
                        
                        extract( shortcode_atts( array(
                            'header'       => 'Section Name',
                            'section_type' => 'best-seller',
                            'section_cate' => 0,
                            'orderby'      => 'date',
                            'order'        => 'DESC',
                            'ids'          => ''
                        ), $tab ) );
                        
                        $ids = explode( ',', $ids );
                        
                        $key = isset( $tab['section_type'] ) ? $tab['section_type'] : 'best-seller';
                        
                        $newargs = $args;
                        if( $key == 'new-arrival' ){
                            $newargs['orderby'] = 'date';
                            $newargs['order'] 	 = 'DESC';
                        }elseif( $key == 'on-sales' ){
                            $product_ids_on_sale = wc_get_product_ids_on_sale();
                            $newargs['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
                            
                            if( $orderby == '_sale_price' ){
                                $orderby = 'date';
                                $order   = 'DESC';
                            }
                            $newargs['orderby'] = $orderby;
                            $newargs['order'] 	= $order;
                        }elseif( $key == 'custom' ){
                            if( $orderby == '_sale_price' ){
                                $newargs['meta_query'] = array(
                                    'relation' => 'OR',
                                    array( // Simple products type
                                        'key'           => '_sale_price',
                                        'value'         => 0,
                                        'compare'       => '>',
                                        'type'          => 'numeric'
                                    ),
                                    array( // Variable products type
                                        'key'           => '_min_variation_sale_price',
                                        'value'         => 0,
                                        'compare'       => '>',
                                        'type'          => 'numeric'
                                    )
                                );
                            }else{
                                $newargs['orderby'] = $orderby;
                                $newargs['order'] 	= $order;
                            }
                        }elseif( $key == 'most-review'){
                            add_filter( 'posts_clauses', array( $this, 'order_by_rating_post_clauses' ) );
                        }elseif($key == 'category' && intval( $tab['section_cate'] ) > 0 ){
                            $chil_term = get_term( $section_cate, 'product_cat' );
                            if( $chil_term ){
                                $newargs['tax_query'] = array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field'    => 'id',
                                        'terms'    => $chil_term->term_id,
                                        'operator' => 'IN'
                                    ),
                                );
                            }
                            if( $orderby == '_sale_price' ){
                                $newargs['meta_query'] = array(
                                    'relation' => 'OR',
                                    array( // Simple products type
                                        'key'           => '_sale_price',
                                        'value'         => 0,
                                        'compare'       => '>',
                                        'type'          => 'numeric'
                                    ),
                                    array( // Variable products type
                                        'key'           => '_min_variation_sale_price',
                                        'value'         => 0,
                                        'compare'       => '>',
                                        'type'          => 'numeric'
                                    )
                                );
                            }else{
                                $newargs['orderby'] = $orderby;
                                $newargs['order'] 	= $order;
                            }
                        }elseif( $key == 'by-ids' && count( $ids ) > 0 ){
                            $newargs['post__in'] = $ids;
                            $newargs['orderby'] = 'post__in';
                        }else{
                            $newargs['meta_key'] = 'total_sales';
                            $newargs['orderby']  = 'meta_value_num';
                        }
                        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $newargs, $atts ) );
                        
                        if( $key == 'most-review'){
                            remove_filter( 'posts_clauses', array( $this, 'order_by_rating_post_clauses' ) );
                        }
                        //$woocommerce_loop['columns'] = $atts['columns'];
                
                        if ( $products->have_posts() ) :
                            $data_carousel = array(
                                "autoplay"      => $autoplay,
                                "navigation"    => $navigation,
                                "margin"        => $margin,
                                "smartSpeed"    => $slidespeed,
                                "theme"         => 'style-navigation-bottom',
                                "autoheight"    => 'false',
                                'nav'           => $navigation,
                                'dots'          => 'false',
                                'loop'          => $loop,
                                'autoplayTimeout'    => 1000,
                                'autoplayHoverPause' => 'true'
                            );
                            
                            if( $use_responsive){
                                $arr = array(
                                    '0' => array(
                                        "items" => $items_mobile
                                    ), 
                                    '768' => array(
                                        "items" => $items_tablet
                                    ), 
                                    '992' => array(
                                        "items" => $items_destop
                                    )
                                );
                                $data_responsive = json_encode($arr);
                                $data_carousel["responsive"] = $data_responsive;
                            }else{
                                if( $product_column > 0 )
                                    $data_carousel['items'] =  $product_column;
                            }
                        
                        ?>
                        <!-- tab product -->
                        <div class="tab-panel <?php echo ( $i == 0) ? 'active' : ''; ?>" id="<?php echo 'tab-' . $id . '-' . $i; ?>">
                            <ul class="product-list tab-owl owl-carousel" <?php echo _data_carousel($data_carousel); ?>>
                                <?php 
                                while ( $products->have_posts() ) : $products->the_post();
                                    wc_get_template_part( 'content', 'product-tab' );
                                endwhile; // end of the loop.
                                ?>
                            </ul>
                        </div>
                        <?php
                        endif;
                        wp_reset_query();
                        wp_reset_postdata();
                        $i++; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
       </div>
    </div>
    <!-- end featured category fashion -->
</div>