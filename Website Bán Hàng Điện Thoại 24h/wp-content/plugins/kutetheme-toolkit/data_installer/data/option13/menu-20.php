<?php
//Menu
$menu_id = kt_add_menu( 232, 'Top bar menu left', 'topbar_menuleft' );

 // Menu Item
kt_add_menu_item( 2218, $menu_id, 0, '<span><i class=\"fa fa-phone\"></i> 00-62-658-658</span>', 'custom', 2218, 'custom', '#', '', '0', '' );

kt_add_menu_item( 2219, $menu_id, 0, '<span><i class=\"fa fa-envelope\"></i> Contact us today !</span>', 'custom', 2219, 'custom', '#', '', '0', '' );

//Menu
$menu_id = kt_add_menu( 196, 'Top bar menu right', 'topbar_menuright' );

 // Menu Item
kt_add_menu_item( 2057, $menu_id, 0, 'Services', 'page', 369, 'post_type', 'http://kutethemes.net/wordpress/kuteshop/option13/services/', '', '0', '' );

kt_add_menu_item( 2056, $menu_id, 0, 'Support', 'page', 371, 'post_type', 'http://kutethemes.net/wordpress/kuteshop/option13/support/', '', '0', '' );

//Menu
$menu_id = kt_add_menu( 185, 'Trending', '' );

 // Menu Item
kt_add_menu_item( 1871, $menu_id, 0, 'Men\'s Clothing', 'custom', 1871, 'custom', '#', '', '', '' );

kt_add_menu_item( 1872, $menu_id, 0, 'Kid\'s Clothing', 'custom', 1872, 'custom', '#', '', '', '' );

kt_add_menu_item( 1873, $menu_id, 0, 'Women\'s Clothing', 'custom', 1873, 'custom', '#', '', '', '' );

kt_add_menu_item( 1874, $menu_id, 0, 'Accessories', 'custom', 1874, 'custom', '#', '', '', '' );

