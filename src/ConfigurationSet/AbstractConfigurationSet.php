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
    public static string $street;
    public static string $zip;
    public static string $city;
    public static string $country;
    public static string $countryIso2Code;
    public static string $footerAddition;
    public static string $privacyRoute;
    public static string $legalRoute;
    public static string $feedbackRoute;

    public static function apply(array &$config, bool $overwrite = false): void
    {
        if ($overwrite) {
            $config['application']['copyright']['author'] = static::$author;
            $config['application']['copyright']['url'] = static::$url;
            $config['application']['email']['legal_footer'] = static::getFooter();
            $config['application']['routes']['privacy'] = static::$privacyRoute;
            $config['application']['routes']['legal'] = static::$legalRoute;
            $config['application']['routes']['feedback'] = static::$feedbackRoute;
            $config['application']['address']['street'] = static::$street;
            $config['application']['address']['zip'] = static::$zip;
            $config['application']['address']['city'] = static::$city;
            $config['application']['address']['country'] = static::$country;
            $config['application']['address']['countryIso2Code'] = static::$countryIso2Code;
        } else {
            $config['application']['copyright']['author'] ??= static::$author;
            $config['application']['copyright']['url'] ??= static::$url;
            $config['application']['email']['legal_footer'] ??= static::getFooter();
            $config['application']['routes']['privacy'] ??= static::$privacyRoute;
            $config['application']['routes']['legal'] ??= static::$legalRoute;
            $config['application']['routes']['feedback'] ??= static::$feedbackRoute;
            $config['application']['address']['street'] ??= static::$street;
            $config['application']['address']['zip'] ??= static::$zip;
            $config['application']['address']['city'] ??= static::$city;
            $config['application']['address']['country'] ??= static::$country;
            $config['application']['address']['countryIso2Code'] ??= static::$countryIso2Code;
        }
    }

    public static function getFooter(): string
    {
        return sprintf(
            '%s, %s, %s-%s %s, %s%s',
            static::$author,
            static::$street,
            static::$countryIso2Code,
            static::$zip,
            static::$city,
            static::$country,
            static::$footerAddition
        );
    }
}
