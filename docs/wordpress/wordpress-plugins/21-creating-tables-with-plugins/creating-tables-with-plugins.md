# Creating Tables with Plugins

Reference: <https://developer.wordpress.org/plugins/creating-tables-with-plugins/>

## Overview

If you are writing a plugin for WordPress, you will almost certainly find that you need to store some information in the WordPress database. There are two types of information you could store:

- **Setup information** — user choices that are entered when the user first sets up your plugin, and don't tend to grow much beyond that (for example, in a tag-related plugin, the user's choices regarding the format of the tag cloud in the sidebar). Setup information will generally be stored using the WordPress options mechanism.
- **Data** — information that is added as the user continues to use your plugin, generally expanded information related to posts, categories, uploads, and other WordPress components (for example, in a statistics-related plugin, the various page views, referrers, and other statistics associated with each post on your site).

Data can be stored in a separate MySQL/MariaDB table, which will have to be created. Before jumping in with a whole new table, however, consider whether storing your plugin's data in WordPress' Post Meta (a.k.a. Custom Fields) would work — Post Meta is the preferred method, and should be used when possible/practical.

This article describes how to have your plugin automatically create a MySQL/MariaDB table to store its data. As an alternative, you could have the plugin user run an install script, or execute an SQL query themselves via something like phpMyAdmin — but neither option is very satisfactory, since a user could easily forget to run the install script, mess up the query, or not have phpMyAdmin available.

It's recommended you have your plugin automatically create its database tables by:

1. Writing a PHP function that creates the table.
2. Ensuring WordPress calls the function when the plugin is activated.
3. Creating an upgrade function, if a new version of your plugin needs a different table structure.

## Create Database Tables

Create a PHP function within your plugin that adds a table or tables to the WordPress MySQL/MariaDB database. For this article, the function is called `jal_install`.

### Database Table Prefix

In `wp-config.php`, a WordPress site owner can define a database table prefix. By default the prefix is `wp_`, but you need to check the actual value and use it to define your table name — it's available as `$wpdb->prefix`.

So, to create a table called `(prefix)liveshoutbox`, the first few lines of your table-creation function look like:

```php
function jal_install () {
   global $wpdb;

   $table_name = $wpdb->prefix . "liveshoutbox";
}
```

### Creating or Updating the Table

Rather than executing an SQL query directly, use the `dbDelta()` function in `wp-admin/includes/upgrade.php` (you'll need to load this file, as it isn't loaded by default). `dbDelta()` examines the current table structure, compares it to the desired structure, and adds or modifies the table as necessary, making it handy for updates. It is, however, rather picky:

- Put each field on its own line in your SQL statement.
- Have two spaces between the words `PRIMARY KEY` and the definition of your primary key.
- Use the keyword `KEY` rather than its synonym `INDEX`, and include at least one `KEY`.
- `KEY` must be followed by a single space, then the key name, then a space, then an open parenthesis with the field name, then a closed parenthesis.
- Don't use any apostrophes or backticks around field names.
- Field types must be all lowercase.
- SQL keywords, like `CREATE TABLE` and `UPDATE`, must be uppercase.
- Specify the length of all fields that accept a length parameter — `int(11)`, for example.

With those caveats, here are the next lines in the function, which create or update the table (substitute your own table structure in the `$sql` variable):

```php
global $wpdb;

$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  name tinytext NOT NULL,
  text text NOT NULL,
  url varchar(55) DEFAULT '' NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
```

Setting the default character set and collation avoids some characters being converted to `?` when saved in the table. `$wpdb->get_charset_collate()` was introduced in WordPress 3.5; to support earlier versions you'd need to build the charset/collate string yourself.

### Adding Initial Data

You may want to add some data to the table you just created:

```php
$welcome_name = 'Mr. WordPress';
$welcome_text = 'Congratulations, you just completed the installation!';

$table_name = $wpdb->prefix . 'liveshoutbox';

$wpdb->insert(
    $table_name,
    array(
        'time' => current_time( 'mysql' ),
        'name' => $welcome_name,
        'text' => $welcome_text,
    )
);
```

Using `$wpdb->insert()` means your data is automatically escaped. If you use another method like `$wpdb->query()` instead, run the variables through `$wpdb->prepare()` before passing the query to the database, to prevent security problems.

### A Version Option

Add an option to record a version number for your database table structure, so you can use that information later if you need to update the table:

```php
add_option( "jal_db_version", "1.0" );
```

### The Whole Function

```php
<?php

global $jal_db_version;
$jal_db_version = '1.0';

function jal_install() {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'liveshoutbox';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name tinytext NOT NULL,
        text text NOT NULL,
        url varchar(55) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );

    add_option( 'jal_db_version', $jal_db_version );
}

function jal_install_data() {
    global $wpdb;

    $welcome_name = 'Mr. WordPress';
    $welcome_text = 'Congratulations, you just completed the installation!';

    $table_name = $wpdb->prefix . 'liveshoutbox';

    $wpdb->insert(
        $table_name,
        array(
            'time' => current_time( 'mysql' ),
            'name' => $welcome_name,
            'text' => $welcome_text,
        )
    );
}
```

### Calling the Functions

Use the `register_activation_hook` action so WordPress calls your installation function when the plugin is activated. If your plugin file is `wp-content/plugins/plugindir/pluginfile.php`, add this to the main body of your plugin:

```php
register_activation_hook( __FILE__, 'jal_install' );
register_activation_hook( __FILE__, 'jal_install_data' );
```

## Adding an Upgrade Function

Over the lifetime of your plugin, you may need to change its database structure in an upgraded version. The easiest approach is to add version-check code to the `jal_install` function itself.

For example, say the function above created database version 1.0, and you're now upgrading to 1.1 so the URL field can be wider (100 characters instead of 55). Add the following to the end of `jal_install` to check the version and upgrade if necessary:

```php
<?php

global $wpdb;
$installed_ver = get_option( "jal_db_version" );

if ( $installed_ver != $jal_db_version ) {

    $table_name = $wpdb->prefix . 'liveshoutbox';

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name tinytext NOT NULL,
        text text NOT NULL,
        url varchar(100) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    update_option( "jal_db_version", $jal_db_version );
}
```

You'll also need to update the global `$jal_db_version` variable at the top of the file, and change the initialization section to use the new table structure.

Since WordPress 3.1, the activation function registered with `register_activation_hook()` is not called when a plugin is updated. To run the upgrade code after the plugin is upgraded, check the plugin's database version on another hook and call the function manually if it's old:

```php
function myplugin_update_db_check() {
    global $jal_db_version;
    if ( get_site_option( 'jal_db_version' ) != $jal_db_version ) {
        jal_install();
    }
}
add_action( 'plugins_loaded', 'myplugin_update_db_check' );
```

## Resources

For further reading, see the Plugin Handbook for a comprehensive list of plugin resources, the wp-hackers mailing list answer to "Plugin Requires Additional Tables," and Post meta vs separate database tables.
