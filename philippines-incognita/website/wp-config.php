<?php
define( 'WP_CACHE', true );
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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'philippi_main' );

/** MySQL database username */
define( 'DB_USER', 'philippi_main' );

/** MySQL database password */
define( 'DB_PASSWORD', 'pS104[7[1g' );

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
define( 'AUTH_KEY',         '9gzo49u5dbrq9egxiowm4augubc3skhjgvptk56nzeyij61g7ca6ktrhlnvxof7v' );
define( 'SECURE_AUTH_KEY',  'njcpikuewhxxv6tyabfnuo9wtcsr3avwahroz49n5dyvbrciqj3dl7oe8bynw45h' );
define( 'LOGGED_IN_KEY',    'xi6nip5scqftz0iofl8kytvau5wwnlwiobbdbs7d7ngaggoharzjqd5f6jdc4f0b' );
define( 'NONCE_KEY',        'ex0o8z1h3hwcxp6wzyx9p3o2wnkb7sl1btwabyp93zkrj2zjjsfn7e5qawquiv1u' );
define( 'AUTH_SALT',        '28tnojvs9jur3xkpjxkewjlyqgyjonsssbvsym6ngsqubwn6c3fis3t5lyfskaak' );
define( 'SECURE_AUTH_SALT', 'ncu2lfk7ymwxn1qt0lcyltvooclp4c8gk5abxysxe7xvk8ietzr8zf02u8bz3hs4' );
define( 'LOGGED_IN_SALT',   'brdily0nk7jporttjdn5grx9fyhh1qu2lrnloxqbuqp9kdatgng8fupyht4ifggy' );
define( 'NONCE_SALT',       'xc7eyppbfas3i4drx4pyfm6eviwj43knmdiyqebme0gok3i7gr3gmndgttiwzfxk' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp1m_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );  
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false);
define( 'SCRIPT_DEBUG', true );
#define('WP_ALLOW_MULTISITE', true);
/** New system status */
define( 'WP_MEMORY_LIMIT', '512M' );
define( 'WP_MAX_MEMORY_LIMIT', '1024M' );
/* That's all, stop editing! Happy publishing. */

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
