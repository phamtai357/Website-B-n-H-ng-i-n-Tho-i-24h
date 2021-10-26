<?php
//Menu
$menu_id = kt_add_menu( 18, 'Top bar menu right', 'topbar_menuright' );

 // Menu Item
kt_add_menu_item( 23, $menu_id, 0, 'Services', 'page', 21, 'post_type', 'http://kutethemes.net/wordpress/kuteshop/option11/services/', '', '', '' );

kt_add_menu_item( 24, $menu_id, 0, 'Support', 'page', 19, 'post_type', 'http://kutethemes.net/wordpress/kuteshop/option11/support/', '', '', '' );
