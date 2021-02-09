<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

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
define( 'DB_NAME', 'setup_wp_db' );

/** MySQL database username */
define( 'DB_USER', '\'root\'' );
/**define( 'DB_USER', 'SWU_db_user' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );
/** define( 'DB_PASSWORD', 'SWU_db_user@123' );

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
define( 'AUTH_KEY',         'TR-wn^i*#~,vAJ zA,tMCS?o;#u/Q*v9oi8[[66]Rt%vjl?Ox +s:-ET%#Zv4^tH' );
define( 'SECURE_AUTH_KEY',  '=mvyhkl C=$K.pUR/U,0ti02e$0|NdjY<H]dH1HS>-/tH$y!<GF[kY1u;D|RkI4!' );
define( 'LOGGED_IN_KEY',    'dOo~%7z. O9.ImT,TK+mrv77b)9T@6_db:,]7Al./;O#YbKLdL@!Cbi.=z2pqs,<' );
define( 'NONCE_KEY',        'ibK1zYD;{|3n>Nr$g@#3WkWq{Uo;Cl.iS61]xy.Nzt9O!>2#:mq{+ZY/&cIo)v{d' );
define( 'AUTH_SALT',        '*rX>xEg63a9Gn^ek[BES*GhY[Pk<7yblrKoTpt0#[]F.sDg`zuRg9JX.h&oo`,rg' );
define( 'SECURE_AUTH_SALT', 'Uy 1Zcj:h-{VKgr}l*C*qzlQ^Smu~A8^pt)^R-xeV$mVcOXK#_lhMERm|I:3OJDo' );
define( 'LOGGED_IN_SALT',   'SjxYqH?S#wZI6]64_c}?R!L&79Bl_y-plB..?WIaTbDE.dyxKC.KI*vUC{4u.N9:' );
define( 'NONCE_SALT',       ']-gOF8QOoTvs<fhbtFo<3t|K6b3VW9uoeH|*lAil,0H)cQW{T,)>qvFD Opn$hCT' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
