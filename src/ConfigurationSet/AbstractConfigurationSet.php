<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\ConfigurationSet;

abstract class AbstractConfigurationSet
{
    public static string $author;
    public static string $url;
    public static string $footer;
    public static string $privacyRoute;
    public static string $legalRoute;
    public static string $feedbackRoute;

    public static function apply(array &$config, bool $overwrite = false): void
    {
        if ($overwrite) {
            $config['application']['copyright']['author'] = static::$author;
            $config['application']['copyright']['url'] = static::$url;
            $config['application']['email']['legal_footer'] = static::$footer;
            $config['application']['routes']['privacy'] = static::$privacyRoute;
            $config['application']['routes']['legal'] = static::$legalRoute;
            $config['application']['routes']['feedback'] = static::$feedbackRoute;
        } else {
            $config['application']['copyright']['author'] ??= static::$author;
            $config['application']['copyright']['url'] ??= static::$url;
            $config['application']['email']['legal_footer'] ??= static::$footer;
            $config['application']['routes']['privacy'] ??= static::$privacyRoute;
            $config['application']['routes']['legal'] ??= static::$legalRoute;
            $config['application']['routes']['feedback'] ??= static::$feedbackRoute;
        }
    }
}
