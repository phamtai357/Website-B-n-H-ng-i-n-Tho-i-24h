<?php 
    remove_action('kt_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);

    remove_action('kt_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);
    
    add_action('kt_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    
    add_action('kt_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
    $current = 0;
    $list_banner_left = array();
    if( isset( $banner_left ) && $banner_left ): 
        $banner_left_args = array(
            'post_type' => 'attachment',
            'include'   => $banner_left,
            'orderby'   => 'post__in'
        );
        $list_banner_left = get_posts( $banner_left_args );
    endif;
?>
<div class="<?php echo esc_attr( $elementClass ); ?>">
<!-- box product fashion -->
<div class="box-products option7 fashion container-tab <?php if( $align == 'right' ) : ?> right <?php endif; ?>" id="change-color-<?php echo esc_attr( $id ); ?>" data-target="change-color" data-color="<?php echo esc_attr( $main_color ); ?>" data-rgb="<?php echo esc_attr( implode( ',', $main_color_rgb ) );  ?>">
    <div class="box-product-head">
        <div class="box-product-head-left">
            <div class="box-title">
                <span class="icon"><?php echo wp_get_attachment_image( $icon, 'full' ); ?></span>
                <span class="text"><?php  echo ( isset( $title ) && $title ) ? esc_html( $title ) : __( 'Tabs Name', 'kutetheme' );  ?></span>
            </div>
        </div>
        <div class="box-product-head-right">
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
            <div class="floor-elevator">
                <a href="#" class="btn-elevator up fa fa-angle-up"></a>
                <a href="#" class="btn-elevator down fa fa-angle-down"></a>
            </div>
        </div>
    </div>
    <div class="box-produts-content">
            <div class="block-product-left">
                <?php if ( isset($subcats) && $subcats ) : ?>
                    <div class="block-sub-cat owl-carousel" data-items="1" data-nav="true" data-loop="false" data-dots="false">
                        <?php $i = 1; ?>
                        <?php foreach( $subcats as $cate ): ?>
                            <?php if( $i == 1 ): ?>
                            <ul class="list-cat">
                            <?php endif; ?>
                            
                            <?php $cate_link = get_term_link( $cate ); ?>
                                <li><a href="<?php echo esc_url( $cate_link ); ?>"><?php echo esc_html( $cate->name ); ?></a></li>
                            <?php if( $i == $number_slide ):  ?>
                            </ul><!--<?php echo $i; ?>-->
                            <?php $i = 0; endif; ?>
                            <?php $i ++ ; ?>
                        <?php endforeach; ?>
                        <?php if( $i > 1 && $i != $number_slide ): ?>
                            </ul><!--end<?php echo $i; ?>-->
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if( isset( $banner_left ) && $banner_left ): 
                    $banner_left_args = array(
                        'post_type' => 'attachment',
                        'include'   => $banner_left,
                        'orderby'   => 'post__in'
                    );
                    $list_banner_left = get_posts( $banner_left_args );
                    foreach( $list_banner_left as $l ) :
                    ?>
                    <div class="block-box-products-banner banner-img">
                        <a href="<?php echo  $term_link ? esc_url( $term_link ) : ''; ?>">
                            <?php echo wp_get_attachment_image( $l->ID, 'full' );?>
                        </a>
                    </div>
                    <?php
                    endforeach;
                endif;
                ?>
            </div>
        
        <div class="block-product-right">
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
                            $newargs['order']    = 'DESC';
                        }elseif( $key == 'on-sales' ){
                            $product_ids_on_sale = wc_get_product_ids_on_sale();
                            $newargs['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
                            
                            if( $orderby == '_sale_price' ){
                                $orderby = 'date';
                                $order   = 'DESC';
                            }
                            $newargs['orderby'] = $orderby;
                            $newargs['order']   = $order;
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
                                $newargs['order']   = $order;
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
                                $newargs['order']   = $order;
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
                                <ul class="products autoHeight">
                                    <?php while ( $products->have_posts() ) : $products->the_post();?>
                                        <li class="product autoHeight-item">
                                            <?php wc_get_template_part( 'content', 'product-tab6' ); ?>
                                        </li>
                                    <?php endwhile; // end of the loop. ?>
                                </ul>
                            </div>
                            <?php $i++; ?>
                        <?php endif; ?>
                    <?php wp_reset_query();?>
                    <?php wp_reset_postdata(); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- ./box product fashion -->
</div>
<?php 
remove_action('kt_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
        
remove_action('kt_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

add_action('kt_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);

add_action('kt_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);
?>