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
define( 'DB_NAME', 'philippi_bookme' );

/** MySQL database username */
define( 'DB_USER', 'philippi_bookme' );

/** MySQL database password */
define( 'DB_PASSWORD', 'pcn+#VOGJ!]h' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ',uN %$dA)Ao-_dqT{ky+IBk+YS~Iw1o{=[.;Q2ds~RT2BY=1itY{!g-Sw4,I@)xe' );
define( 'SECURE_AUTH_KEY',  'G]>h#r<n)ZFeLra1Q/?^-C[aJ1]y2v];xjAJ#V.Tm+1IA:jS_|ej]t)%z2J$r6#&' );
define( 'LOGGED_IN_KEY',    'hh:;b!LX, W T?K}:t$gmsCA{?w[3I<FK~BTDfg}jlGY~/uN[p:53gzp5@^)eEx4' );
define( 'NONCE_KEY',        'sG|WPOYN=]<Oa_SHQO:rFaj#mst`zNJr?6G%`s:7G0,8Yd2r*IIN/5${V,=?)WK#' );
define( 'AUTH_SALT',        'gAGW(Z&),d-];zs7na ]TTe,@^D[hX-],Rp1t2h[]i2D78,*2d)>D]n]VGx4M}X]' );
define( 'SECURE_AUTH_SALT', '6QUCl#r5d%Q.1$Z-md_tQQqVCtWeXP%!Om9tdgmA~f]idYV4[E}z TP^Fu.|-A|g' );
define( 'LOGGED_IN_SALT',   '4>QF/M3T.v,tQ(<|<d^xS@nG=0Li_Awj<cKYo8d(Pikbdz2HUsRwU|=RNx>V+]-v' );
define( 'NONCE_SALT',       'R`=fP(bE=rDwHor<D=~stp<GO6?2gc*Kvcqe6:4g>f7YG=G.9V052UBxk!yBkh/u' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'bm_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
