<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'maxwellh_9cpw');

/** MySQL database username */
define('DB_USER', 'maxwellh_9cpw');

/** MySQL database password */
define('DB_PASSWORD', '8ayfef4wim9umhel');

/** MySQL hostname */
define('DB_HOST', '10.169.0.89');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'DGIcytnYdzcvatNEwV6LbEj2CxzdYbuKaOuuJej93zxEx6C6T7kj9KeaHz31lPmw');
define('SECURE_AUTH_KEY',  '5n0gHkSOoqzmjC0VCX8u0m9Ga7VHcfIH5nzQh9BUF7uTF6bpNYJi0eK6C41s8fli');
define('LOGGED_IN_KEY',    'klxygloW2ToYJOdQAxf2IY3yBRRiHky2JMAzQIPlA5JpasuwNfyTocAi1fYAwISM');
define('NONCE_KEY',        'Akz6sIi68nCAYSQojzhwEMbR6Qx8p5CABqZs6VHtk6pw0bbvDBryyxmNLSEPutTb');
define('AUTH_SALT',        'z0yJiKdyrpPet9ePdFCQeC3l4o44lfEnx7j57OgFfc21aWdE1WEwVrLMU7NkP8PE');
define('SECURE_AUTH_SALT', 'ABUK3Uu4oXoGWUfgpJbuaiwlxbjy7BZ5Nas4RNURw5VgcyligMDLQ3fNGEJeUOAS');
define('LOGGED_IN_SALT',   'xdj8LA6CxfQJTZs3WjnPY9lvs6Cln6Y0HHAlrE1Z7rlkLCsbxEBrrnpZgimtbrHY');
define('NONCE_SALT',       'yj13IHQf7YHk7Lcbz9GEKR4D6ipTYQWnN9LY0TxEaDIO6fo72XVvO5mgQnc8Xctq');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'jgnb_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
