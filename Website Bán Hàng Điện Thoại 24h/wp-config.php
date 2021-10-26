<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', false); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/erionsefhosting/dienthoai24h.com.vn/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'erionsefhosting_dienthoai24h');

/** MySQL database username */
define('DB_USER', 'erionsefhosting_dt24h');

/** MySQL database password */
define('DB_PASSWORD', 'Nguyenk57v@');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'g^s[9Ny]:[&Yum$hA+)yN#.g::hn,Zz>qJA;]-eg`qbS-RH!Mrb>H`(xy(/|dA6Z');
define('SECURE_AUTH_KEY',  '|*%c_Q7|MckO! -]eXJ7{k<ZDUukZu-jBk%I:jaz:r3lJ(# Vxdu>]*Ojpci}1&M');
define('LOGGED_IN_KEY',    'p{>{}gm9E4(2bmesn=?*M4tDaMDw+::Kcea.1QuX ;Ga#i|/E}UmK2y1a+q!.O[D');
define('NONCE_KEY',        'q3Uy 8PEwKfq=`Q4^mGq.sDp@&^n7;~Fs$Teb2 [>5Co/0`v!;7Yc9bxu|kEacP-');
define('AUTH_SALT',        'w*Je_Ny**si`c9783=(VOXh=(&&qabC`5~x%VN~MK{`d2ceDxh2a,!ah]70`%A#*');
define('SECURE_AUTH_SALT', 'W/2bd5LNg6,X1oYpWoQIy7,ko8<7SLacqi_L8Yeh.;@zls!v^cpK5Sh:Kh@h1`_0');
define('LOGGED_IN_SALT',   'HyDi gJ)k5:yC:SgeJXR`5tZs]YYAY/d%Zd&+@NO.:fpI!^[Aq`}}Mk<gH>r_cR{');
define('NONCE_SALT',       'hEO38}Rm]MSk233eYrTTloTOk9Vudy#7W$.Sje3&$/kt7LLvxs}Vt|dQ<sdJS(DA');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
