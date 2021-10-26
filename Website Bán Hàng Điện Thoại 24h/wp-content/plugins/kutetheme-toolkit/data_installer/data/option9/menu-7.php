<?php
//Menu
$menu_id = kt_add_menu( 59, 'Top bar menu right', 'topbar_menuright' );

 // Menu Item
kt_add_menu_item( 938, $menu_id, 0, 'Services', 'page', 21, 'post_type', 'http://kutethemes.net/wordpress/kuteshop/option9/services/', '', '', '' );

kt_add_menu_item( 939, $menu_id, 0, 'Support', 'page', 19, 'post_type', 'http://kutethemes.net/wordpress/kuteshop/option9/support/', '', '', '' );

//Menu
$menu_id = kt_add_menu( 61, 'Topbar menu left', 'topbar_menuleft' );

 // Menu Item
kt_add_menu_item( 950, $menu_id, 0, '<span><i class=\"fa fa-phone\"></i> 00-62-658-658</span>', 'custom', 950, 'custom', '#', '', '0', '' );

kt_add_menu_item( 951, $menu_id, 0, '<span><i class=\"fa fa-envelope\"></i> Contact us today !</span>', 'custom', 951, 'custom', '#', '', '0', '' );
