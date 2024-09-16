<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'nikhiljo_mywebsite' );

/** Database username */
define( 'DB_USER', 'nikhil' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'F8t2,2^MxhQw`fY@!@tT-/T[rE>GVz+u%Q?jk<4h8|B_s{n*ArY;My>70)pT-JZW' );
define( 'SECURE_AUTH_KEY',  '=A(s}?8!SVD2.+^Xn;ra.F{5l|)x$RJeQ!~ 1!%7q2rp<d?)Ns3Q0kJ]]qr}.rw?' );
define( 'LOGGED_IN_KEY',    'L=z0&kGr@V7{m!#}<-%bx=2@Upr+{={Kv5FgEZv@p]#A|Q$gQ8}e,Ij@o)e}Q42;' );
define( 'NONCE_KEY',        '$Fce+Uk@z #w3+SU{{bbeYNcK,LY50x6AWewyQHvy/|<R6kX* 6[3[LI3Q&!E3Hx' );
define( 'AUTH_SALT',        'kDuv-v!4?%_)`(s-msQW{UQLdN!&>=c|VZoB4KO}9Ks.#x6%kJ?.c;C ;#RE=K]`' );
define( 'SECURE_AUTH_SALT', ':@v:$TDM6r[DZ0u%R5L`hU:!kL.O><gC?i|c^wQmr3[>Jd1@gAvqupy3weU6~ba*' );
define( 'LOGGED_IN_SALT',   '(*jcqE5#fBP|CH)xYK}yeU?F}V7:[)[U1w&<)v>KEv!y:0paEhMS+1+@wrbc!`nM' );
define( 'NONCE_SALT',       '=ep<T_Q.bR*2n#ns?BgqLsIs*s O eY!tdJ_sZ}E?lqMFeGoe^q%(P#IP>RH2@*2' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
