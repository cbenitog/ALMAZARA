<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/usr/home/almazaradevaldeverdeja.com/web/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', '45277wordpress20220511233724' );
/** MySQL database username */
define( 'DB_USER', 'myalm948' );
/** MySQL database password */
define( 'DB_PASSWORD', '95R6FGV5' );
/** MySQL hostname */
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
define( 'AUTH_KEY', 'vl@B;Y=GUr6>fdc[R+8+dkJ8JfmEJD=@G;4E; OeC[aX=>~=-?RU+~l#8-wpqF/S' );
define( 'SECURE_AUTH_KEY',  'v|uvJj1K|k%.!+l-ReNM:0GsVfKp@u!$$:F^A<vA6@-9*n4)G$k4r:xO45cD04BF' );
define( 'LOGGED_IN_KEY', '(k[f8o KT|P4mxCh|PNGVYV!^)k[0-<C|)_kg]+Pr C(;)A/o#VkPN5i5/<tCGCc' );
define( 'NONCE_KEY', ',[aZ)R,-~u?M-Wgdd4n8EV1l@,-SjS?u>{$|f7,/3=uyFF-YI)j^e1D=L +B9Fz-' );
define( 'AUTH_SALT', '2yOZ>*.~B8M7_G^`qgu$s#80J]G&*E8i#auH3:]JT $R(4KhT:.*zLO8!ne^<ND-' );
define( 'SECURE_AUTH_SALT', '~[AI85/kC9}]R$.8)[{^dZ[#bRY#XXqPu+:GH:-c6B-rZT%g|a @k|X<aa2 ~W7K' );
define( 'LOGGED_IN_SALT', '<ohU5rr.PgB_B|7n61VziIEj_S`0.9$lj0sz^pnwQ9g1%E%58~DgTNY|O9f?rNwk' );
define( 'NONCE_SALT', 'G`Fe$tkv$&`#S-YavaSNH^azJDPUHbB8BMx@j5`/&-91,tmjSc#P)^B/?rB7zfV;' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
