<?php
/**
 * @author  AngelsIT
 * @package KUTE TOOLKIT
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// Get products on sale
$product_ids_on_sale = wc_get_product_ids_on_sale();

if( ! $is_phone ):
    if( isset( $banner_left ) && $banner_left ): 
        $banner_left_args = array(
            'post_type' => 'attachment',
            'include'   => $banner_left,
            'orderby'   => 'post__in'
        );
        $list_banner_left = get_posts( $banner_left_args );
        ob_start();
        foreach($list_banner_left as $l):
        ?>
            <li>
                <a href="<?php echo  $term_link ? esc_url( $term_link ) : ''; ?>">
                    <?php echo wp_get_attachment_image($l->ID,'full');?>
                </a>
            </li>
        <?php
        endforeach;
        $banner_carousel = ob_get_clean();
    endif;
    
    
    
    $meta_query = WC()->query->get_meta_query();
    
    $deal_args = array(
    	'posts_per_page'    => 5,
        'post_type'         => 'product',
        'orderby'           => 'date',
        'order'             => 'DESC',
        'no_found_rows' 	=> 1,
    	'post_status' 		=> 'publish',
    	'meta_query' 		=> $meta_query,
    	'post__in'			=> array_merge( array( 0 ), $product_ids_on_sale ),
        'tax_query'         => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'id',
                'terms'    => $term->term_id,
                'operator' => 'IN'
            ),
        )
    );
    if( $term ){
        $deal_args [ 'tax_query' ] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'id',
                'terms'    => $term->term_id,
                'operator' => 'IN'
            )
        );
    }
    $deal_product = new WP_Query( $deal_args );
    if( $deal_product->have_posts() ){
        //add_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size_131x160' ) );
        add_filter("woocommerce_get_price_html_from_to", "kt_get_price_html_from_to", 10 , 4);
        add_filter( 'woocommerce_sale_price_html', 'woocommerce_custom_sales_price', 10, 2 );
        ob_start();
        add_filter( 'kt_product_thumbnail_loop', array( &$this, 'get_size_product_option_3' ) );
        while($deal_product->have_posts()): $deal_product->the_post();
            wc_get_template_part( 'content', 'tab-category-deal' );
        endwhile;
        remove_filter( 'kt_product_thumbnail_loop', array( &$this, 'get_size_product_option_3' ) );
        $deal_product_tmp = ob_get_clean();
        //remove_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size_131x160' ) );
        remove_filter("woocommerce_get_price_html_from_to", "kt_get_price_html_from_to", 10 , 4);
        remove_filter( 'woocommerce_sale_price_html', 'woocommerce_custom_sales_price', 10, 2 );
    }
endif;
?>
<div class="<?php echo esc_attr( $elementClass ); ?>" id="change-color-<?php echo esc_attr( $id ); ?>" data-target="change-color" data-color="<?php echo esc_attr( $main_color ); ?>" data-rgb="<?php echo esc_attr ( implode( ',', $main_color_rgb ) ) ;  ?>">
    <!-- featured category sports -->
    <div class="category-featured sports container-tab">
        <nav class="navbar nav-menu show-brand">
          <div class="container-fuild">
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
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
          <div class="floor-elevator">
            <a href="#" class="btn-elevator up  fa fa-angle-up"></a>
            <a href="#" class="btn-elevator down  fa fa-angle-down"></a>
          </div>
        </nav>
       <div class="product-featured clearfix" <?php echo isset($style) ? $style : '';  ?>>
            <div class="row">
                <?php if ( isset($subcats) && $subcats ) : ?>
                    <div class="col-sm-2 sub-category-wapper">
                        <ul class="sub-category-list">
                            <?php foreach( $subcats as $cate ): ?>
                                <?php $cate_link = get_term_link($cate); ?>
                                <li><a href="<?php echo esc_url( $cate_link ); ?>"><?php echo esc_html( $cate->name ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-sm-10 col-right-tab">
                <?php else: ?>
                    <div class="col-sm-12 col-right-tab">
                <?php endif; ?>
                    <div class="product-featured-tab-content">
                        <div class="tab-container">
                            <?php 
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
                            //add_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size173x211' ) );
                            //$woocommerce_loop['columns'] = $atts['columns'];
                    
                            if ( $products->have_posts() ) :?>
                            <!-- tab product -->
                            <div class="tab-panel <?php echo ( $i == 0) ? 'active' : ''; ?>" id="<?php echo 'tab-' . $id . '-' . $i; ?>">
                                <?php if( ! $is_phone ): ?>
                                <div class="box-left">
                                    <?php if( $i % 2 ==0 ): ?>
                                        <?php if( isset( $deal_product_tmp ) && $deal_product_tmp ): ?>
                                        <div class="deal-product">
                                            <div class="deal-product-head">
                                                <h3><span><?php _e( 'Deals of The Day', 'kutetheme' ) ?></span></h3>
                                            </div>
                                            <ul class="owl-carousel" data-items="1" data-nav="true" data-dots="false">
                                                <?php echo  $deal_product_tmp; ?>
                                            </ul>
                                        </div>
                                        <?php endif; ?>
                                        <?php if( isset( $banner_carousel ) && $banner_carousel ) : ?>
                                        <ul class="owl-intab owl-carousel" data-loop="true" data-items="1" data-dots="false" data-nav="true">
                                            <?php echo  $banner_carousel; ?>
                                        </ul>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if( isset( $banner_carousel ) && $banner_carousel ) : ?>
                                        <ul class="owl-intab owl-carousel" data-loop="true" data-items="1" data-dots="false" data-nav="true">
                                            <?php echo  $banner_carousel; ?>
                                        </ul>
                                        <?php endif; ?>
                                        
                                        <?php if( isset( $deal_product_tmp ) && $deal_product_tmp ): ?>
                                        <div class="deal-product">
                                            <div class="deal-product-head">
                                                <h3><span><?php _e( 'Deals of The Day', 'kutetheme' ) ?></span></h3>
                                            </div>
                                            <ul class="owl-carousel" data-items="1" data-nav="true" data-dots="false">
                                                <?php echo  $deal_product_tmp; ?>
                                            </ul>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <div class="box-right">
                                <?php if( $is_phone ): ?>
                                    <ul class="product-list owl-carousel" data-autoplay="false" data-navigation="false" data-nav="false" data-margin="0" data-slidespeed="250" data-theme="style-navigation-bottom" data-autoheight="false" data-nav="true" data-dots="false" data-items="1">
                                <?php else: ?>
                                    <ul class="product-list row product-columns columns-3">                                    
                                <?php endif; ?>  
                                        <?php 
                                        while ( $products->have_posts() ) : $products->the_post();
                                            ?>
                                            <li class="product-item col-sm-4">
                                            <?php
                                                wc_get_template_part( 'content', 'product-tab2' );
                                            ?>
                                            </li>
                                            <?php
                                        endwhile; // end of the loop.
                                        ?>
                                    </ul>
                                </div>
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
            </div>
       </div>
    </div>
    <!-- end featured category sports-->
</div>