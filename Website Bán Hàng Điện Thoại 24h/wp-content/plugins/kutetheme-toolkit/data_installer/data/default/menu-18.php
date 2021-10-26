<?php
//Menu
$menu_id = kt_add_menu( 186, 'Top left', 'topbar_menuleft' );

 // Menu Item
kt_add_menu_item( 2118, $menu_id, 0, '<span><i class=\"fa fa-phone\"></i> 00-62-658-658</span>', 'custom', 2118, 'custom', '#', '', '0', '' );

kt_add_menu_item( 2119, $menu_id, 0, '<span><i class=\"fa fa-envelope\"></i> Contact us today !</span>', 'custom', 2119, 'custom', '#', '', '0', '' );
