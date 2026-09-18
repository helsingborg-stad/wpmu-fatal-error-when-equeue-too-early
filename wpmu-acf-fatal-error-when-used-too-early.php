<?php

/**
 * Plugin Name: WPMU Fatal Error When Enqueued Too Early
 * Description: Throws a descriptive exception when scripts or styles are registered or enqueued before the appropriate WordPress hook.
 * Version: 0.2.0
 * Author:      Helsingborgs stad
 */

namespace WPMUFatalErrorWhenEnqueuedTooEarly;

use Exception;

/**
 * Detects scripts and styles registered or enqueued before their appropriate hooks.
 */
class WPMUFatalErrorWhenEnqueuedTooEarly
{
    /**
     * Registers the WordPress doing-it-wrong validation hook.
     *
     * @return void
     */
    public function __construct()
    {
        add_action('doing_it_wrong_run', [$this, 'throwExceptionForEarlyEnqueue'], 10, 3);
    }

    /**
     * Throws an exception for scripts and styles registered or enqueued too early.
     *
     * @param string $functionName The WordPress function that was used incorrectly.
     * @param string $message      The WordPress doing-it-wrong message.
     * @param string $version      The WordPress version in which the notice was introduced.
     *
     * @return void
     *
     * @throws Exception When a script or style is registered or enqueued too early.
     */
    public function throwExceptionForEarlyEnqueue(string $functionName, string $message, string $version): void
    {
        $earlyEnqueueFunctions = [
            'wp_register_script',
            'wp_enqueue_script',
            'wp_register_style',
            'wp_enqueue_style',
        ];

        if (!in_array($functionName, $earlyEnqueueFunctions, true)
            || strpos($message, 'should not be registered or enqueued until') === false) {
            return;
        }

        throw new Exception(
            "{$functionName} was called too early: {$message} (since WordPress {$version})."
        );
    }
}

new WPMUFatalErrorWhenEnqueuedTooEarly();
