<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\ConfigurationSet;

class T3aConfigurationSet extends AbstractConfigurationSet
{
    public static string $author = 'TYPO3 Association';
    public static string $url = 'https://typo3.org';
    public static string $street = 'Rathausstrasse 14';
    public static string $zip = '6340';
    public static string $city = 'Baar';
    public static string $country = 'Switzerland';
    public static string $countryIso2Code = 'CH';
    public static string $footerAddition = "\nPhone: +41 41 511 00 35, Fax: +41 41 511 00 39, Email: backoffice@typo3.org";
    public static string $privacyRoute = 'https://typo3.org/privacy-policy';
    public static string $legalRoute = 'https://typo3.org/legal-notice';
    public static string $feedbackRoute = 'https://typo3.org/help';
}
