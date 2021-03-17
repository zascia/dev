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
define( 'DB_NAME', 'philippi_teachme' );

/** MySQL database username */
define( 'DB_USER', 'philippi_teachme' );

/** MySQL database password */
define( 'DB_PASSWORD', 'a1b2c3d4e5=11' );

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
define( 'AUTH_KEY',         'c^4~iC%(;ma_zVYXIfo4,T5=F~5wY$^hZg,-SaKRco>6aAQ|>Td&Ky9C}AoJx/;#' );
define( 'SECURE_AUTH_KEY',  'y~GC_mIv[)2i.7n0F(_=7~o0`FD,A[-Zk`3PQf7&[tMq5}-{vC`(L8#_vZ-gZiDE' );
define( 'LOGGED_IN_KEY',    'Ngd,*P6Zz=*qjbCK(PL>5T`x3gcz!&0f+/EHaNdGBJ6F0.-q,?e+davc/ YD?^l@' );
define( 'NONCE_KEY',        'bbfy.H;{]0Fdm41_/f8<^MjKBS]p8GeNN|s_Y@h=iM{ApPzIrfXwmPaCa5*2O3ha' );
define( 'AUTH_SALT',        '/FLj5*vD(N&Wc~tjl,B8;Jh`;&Bfz4Ys}7a.4Fz^oH=3$FXZn9sDZ*tJezbqk jU' );
define( 'SECURE_AUTH_SALT', 'm<ykT8^(Q@_E9>U(7T#tO8kVZQRWQFBcIz0FUL}Mp(W Tqyql<!TlIuK)UTFhzH^' );
define( 'LOGGED_IN_SALT',   '{StKw$DLxaf];`M/[}$uM|^aNCam=;h^Hs4]n^oE..z=50`g-{)5`dw q.>iPs=x' );
define( 'NONCE_SALT',       '+%U[8UQ%IYKBhU}~,J9t-NBkgEuPO<<TMp>.N:Vp]nO;aMR2q>RE&AaME((UX-s2' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
