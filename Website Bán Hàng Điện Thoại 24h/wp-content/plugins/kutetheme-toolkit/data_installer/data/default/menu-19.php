<?php
//Menu
$menu_id = kt_add_menu( 187, 'Top right', 'topbar_menuright' );

 // Menu Item
kt_add_menu_item( 2120, $menu_id, 0, 'Support', 'page', 371, 'post_type', 'http://kutethemes.net/sample-data/kuteshop/default/support/', '', '0', '' );

kt_add_menu_item( 2121, $menu_id, 0, 'Services', 'page', 369, 'post_type', 'http://kutethemes.net/sample-data/kuteshop/default/services/', '', '0', '' );
