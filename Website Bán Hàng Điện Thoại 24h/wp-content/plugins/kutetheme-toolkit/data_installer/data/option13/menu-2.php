<?php
//Menu
$menu_id = kt_add_menu( 158, 'Categories', 'vertical' );

 // Menu Item
kt_add_menu_item( 1963, $menu_id, 0, 'Electronic', 'product_cat', 89, 'taxonomy', 'http://kutethemes.net/wordpress/kuteshop/option13/product-category/electronic/', '', '0', '2086' );

kt_add_menu_item( 1964, $menu_id, 0, 'Sport & Outdoors', 'product_cat', 114, 'taxonomy', 'http://kutethemes.net/wordpress/kuteshop/option13/product-category/sport-outdoor/', 'enabled', '766', '2087' );

kt_add_menu_item( 1970, $menu_id, 0, 'Toys & Hobbies', 'product_cat', 122, 'taxonomy', 'http://kutethemes.net/wordpress/kuteshop/option13/product-category/toys-hobbies/', '', '0', '2091' );

kt_add_menu_item( 1969, $menu_id, 0, 'Jewelry & Watches', 'product_cat', 98, 'taxonomy', 'http://kutethemes.net/wordpress/kuteshop/option13/product-category/jewelry/jewelry-watches/', '', '0', '2094' );

kt_add_menu_item( 1966, $menu_id, 0, 'Shoes & Accessories', 'product_cat', 111, 'taxonomy', 'http://kutethemes.net/wordpress/kuteshop/option13/product-category/fashion/shoes-accessories/', 'enabled', '764', '2090' );

kt_add_menu_item( 2097, $menu_id, 0, 'Smartphone & Tablets', 'custom', 2097, 'custom', '#', '', '0', '2088' );

kt_add_menu_item( 2098, $menu_id, 0, 'Health & Beauty Bags', 'custom', 2098, 'custom', '#', '', '0', '2089' );

kt_add_menu_item( 2099, $menu_id, 0, 'Computers & Networking', 'custom', 2099, 'custom', '#', '', '0', '2092' );

kt_add_menu_item( 2100, $menu_id, 0, 'Laptops & Accessories', 'custom', 2100, 'custom', '#', '', '0', '2093' );

kt_add_menu_item( 2101, $menu_id, 0, 'Flashlights & Lamps', 'custom', 2101, 'custom', '#', '', '0', '2095' );

kt_add_menu_item( 2102, $menu_id, 0, 'Cameras & Photo', 'custom', 2102, 'custom', '#', '', '0', '2096' );
