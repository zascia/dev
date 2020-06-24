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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'h141281_primofin' );

/** MySQL database username */
define( 'DB_USER', 'h141281_primofin' );

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
define( 'AUTH_KEY',         'n0|A1Id9I,;!L5;VN/aQny*Zb4 Nm5NQ|RO7E0&|d^:1;gD1oVSV]I$YltqF#x!`' );
define( 'SECURE_AUTH_KEY',  'Y #S>cA4XM?i[d,-PLKuAIj{s sRpmU>-!G8%:y8^=^tk.uIG%Faz.gFxt>K;U8L' );
define( 'LOGGED_IN_KEY',    'QF#aSg0X[_:-hZT>PiX{TxX/6Ge:Q(]4~1dMnW?:_;Z$ym8(Ne[ fxkR=Ot6f#o1' );
define( 'NONCE_KEY',        'ylv/9^)%s.OqEO06FVxF[^{PrVNF?/Tv,WUZ+z N>NqqYiKUN=v~QzLiO#J3>oeg' );
define( 'AUTH_SALT',        ':I91%(xKqEf/pMlQcZ]&sS%rEAn*W3pb}.YXRWp]<=ZRq&]~?A,<cd$>K$|C>;oT' );
define( 'SECURE_AUTH_SALT', 'z)wsM:W^!BNe)0Fj)J$|X)OX[Uh2`*4q=c<&+-~mS.^WQ ;@HazfkFeu;e5^b0l~' );
define( 'LOGGED_IN_SALT',   '`&(Dm;Qzqq]f/SKls=>EA]/|?/?.6G:dY6KA1Y.KlW5U-y&+Z~.=#iJ1%7&P9/!u' );
define( 'NONCE_SALT',       'N<d7GR,r35:Pfrdohny4ejMhr,lisvh68K?^8*:<.$u[ W5~RV7:(XeJJJ<W1v3}' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'www_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define( 'WPLANG', 'en_GB' );

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
//define( 'WP_DEBUG', false );
define( 'WP_DEBUG', true );  
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false);
define( 'SCRIPT_DEBUG', true );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
