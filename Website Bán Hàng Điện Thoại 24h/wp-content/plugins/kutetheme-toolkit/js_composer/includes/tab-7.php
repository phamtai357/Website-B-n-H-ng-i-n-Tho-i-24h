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
<!-- Tab category -->
<div class="block-tab-category <?php echo esc_attr( $elementClass ); ?>" id="change-color-<?php echo esc_attr( $id ); ?>" data-target="change-color" data-color="<?php echo esc_attr( $main_color ); ?>" data-rgb="<?php echo esc_attr( implode( ',', $main_color_rgb ) );  ?>">
    <div class="container-tab">
        <div class="head">
            <h2 class="title">
                <span class="bar"><i class="fa fa-bars"></i><i class="fa fa-times"></i></span>
                <?php  echo ( isset( $title ) && $title ) ? esc_html( $title ) : __( 'Tabs Name', 'kutetheme' );  ?>
            </h2>
            <ul class="box-tabs nav-tab">
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
                            }elseif( isset($tab['section_type']) && $tab['section_type'] == 'by-ids' ){
                                _e( 'Tab', 'kutetheme' );
                            }elseif( isset($tab['section_type']) && $tab['section_type'] == 'on-sales' ){
                                _e( 'On sales', 'kutetheme' );
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
        </div>
        <div class="inner">
            <?php if( ! $is_phone ): ?>
            <div class="block-banner <?php echo ( ! $is_phone && $banner_left ) ? 'has_thumbnail_left' : '' ?>">
                <ul class="tab-cat">
                    <?php foreach( $subcats as $cate ): ?>
                        <?php 
                            $cate_link = get_term_link( $cate ); 
                            $thumbnail_id = get_woocommerce_term_meta( $cate->term_id, 'thumbnail_id', true );
                            $image = wp_get_attachment_url( $thumbnail_id, array( 18, 18 ) );
                        ?>
                        <?php if( ! is_wp_error( $image ) && $image ) : ?>
                            <li class="has-thumbnail">
                                <a href="<?php echo esc_url( $cate_link ); ?>"><img class="img-1" src="<?php echo esc_url( $image ) ; ?>" alt="<?php echo esc_html( $cate->name ); ?>" /><?php echo esc_html( $cate->name ); ?></a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?php echo esc_url( $cate_link ); ?>"><?php echo esc_html( $cate->name ); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <?php if( ! $is_phone && $banner_left ): 
                    $banner_left_args = array(
                        'post_type' => 'attachment',
                        'include'   => $banner_left,
                        'orderby'   => 'post__in',
                        'posts_per_page' => 1,
                    );
                    $attachments = get_posts( $banner_left_args );
                    if ( $attachments ) {
                        foreach ( $attachments as $attachment ) {
                            ?>
                            <div class="banner-img has_thumbnail">
                                <a href="<?php echo  $term_link ? esc_url( $term_link ) : ''; ?>">
                                    <?php echo wp_get_attachment_image( $attachment->ID, 'full' ); ?>
                                </a>
                            </div>
                            <?php
                        }
                    }
                ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="block-content">
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
                    <?php foreach( $tabs as $tab ): 
                    
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
                    //add_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size173x211' ) );
                    //$woocommerce_loop['columns'] = $atts['columns'];
            
                    if ( $products->have_posts() ) :?>
                    <div id="<?php echo 'tab-' . $id . '-' . $i; ?>" class="tab-panel <?php echo ( $i == 0) ? 'active' : ''; ?>" >
                        <ul class="tab-products">
                            <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                                <li class="product-style3">
                                    <?php wc_get_template_part( 'content', 'product-tab12' ); ?>
                                </li>
                            <?php endwhile; // end of the loop. ?>
                        </ul>
                    </div>
                    <?php $i++; ?>
                    <?php endif; ?>
                    <?php //remove_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size173x211' ) ); ?>
                    <?php wp_reset_query();?>
                    <?php wp_reset_postdata(); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div><!--./container tab-->
</div>
<!-- ./Tab category -->