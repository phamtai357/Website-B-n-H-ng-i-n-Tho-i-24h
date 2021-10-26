<?php
//Menu
$menu_id = kt_add_menu( 66, 'Sandwich', '' );

 // Menu Item
kt_add_menu_item( 901, $menu_id, 0, 'Pizza', 'custom', 901, 'custom', '#', '', '0', '' );

kt_add_menu_item( 902, $menu_id, 0, 'Bread', 'custom', 902, 'custom', '#', '', '0', '' );

kt_add_menu_item( 903, $menu_id, 0, 'Snacks', 'custom', 903, 'custom', '#', '', '0', '' );

kt_add_menu_item( 904, $menu_id, 0, 'Tops', 'custom', 904, 'custom', '#', '', '0', '' );
