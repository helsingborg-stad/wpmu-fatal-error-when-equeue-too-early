# WPMU Fatal Error When Translation Too Early

A WordPress must-use plugin that converts early script and style registration or enqueue notices into fatal exceptions.

It helps catch code that calls one of the following functions before WordPress reaches an appropriate enqueue hook:

- `wp_register_script()`
- `wp_enqueue_script()`
- `wp_register_style()`
- `wp_enqueue_style()`

## Requirements

- PHP 7.4 or later
- WordPress

## Installation

Install the package with Composer:

```sh
composer require helsingborg-stad/wpmu-fatal-error-when-translation-too-early
```

As a must-use plugin, it must be available in WordPress's `mu-plugins` directory. Configure your Composer installer paths according to your WordPress project.

## Behavior

When WordPress triggers a `doing_it_wrong_run` notice for a supported script or style function, the plugin throws an exception. This stops execution and makes the invalid call visible in development and automated testing.

Register and enqueue frontend assets on `wp_enqueue_scripts`, admin assets on `admin_enqueue_scripts`, and login assets on `login_enqueue_scripts`.

## License

MIT
