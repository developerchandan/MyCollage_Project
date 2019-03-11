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
define( 'DB_NAME', 'CollageProject' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'KAO*4z1$Pf1<LJyqySFw^&I_U-ZWVhUEKfpjt/-b2]},^^J#6oFAlkYpS+.I<e$l' );
define( 'SECURE_AUTH_KEY',  '=llzkbh+D$HU&i$sJySMz[8}?n|TZboY7ljv;PiMb$k4r!/U]94S9vZ$1+W7*v>r' );
define( 'LOGGED_IN_KEY',    'Oy1qfwqgh|r/-%PG(e2}/K3U[|g#fKYIF$pTT`r~Hw{uPBRGcG0X#c^#Yay;|!Qf' );
define( 'NONCE_KEY',        '}*+[)a^$ GY=wDU0,~9$!B@fyVu1R]MV_Co#9)UM@XvskF871zrRe/v#D^@/srJZ' );
define( 'AUTH_SALT',        'yPr$J-~#}Y:!/&#;6Aega7N!fYLVvn8QqkHlSmIImqf}uYpjhjX0C(a;QTS/`hRI' );
define( 'SECURE_AUTH_SALT', 'W%G%>5L27+$29WL(0Qp8e|0(f4Bc<eYVeM8k+G;Vnt]~G<8+yEdhH4*[a%}s0@mr' );
define( 'LOGGED_IN_SALT',   'ML}+gupQ!!lYI&wVOmlSNzx>l&CfsC-{+v!X+*M}^aT*d8JJAr``)V$z^LMY->Q?' );
define( 'NONCE_SALT',       'Mkok .Rq^X)r&$?QQ`<gWE<Dxt=9b^~BY{a>)|0R>[=jJhX1o&Zg}zQ6q*2ajO~l' );

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
