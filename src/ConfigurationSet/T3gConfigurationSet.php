<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\ConfigurationSet;

class T3gConfigurationSet extends AbstractConfigurationSet
{
    public static string $author = 'TYPO3 GmbH';
    public static string $url = 'https://typo3.com';
    public static string $footer = "TYPO3 GmbH, Emanuel-Leutze-Straße 11, DE-40547 Düsseldorf, Germany\nPhone: +49 (0)211 20 54 36 0, Web: www.typo3.com, Email: info@typo3.com\n\nCourt of registration: Amtsgericht Düsseldorf HRB 77950\nCEO: Daniel Fau,  (CTO & Procuration) Frank Nägler\nSupervisory Board: Olivier Dobberkau, Ric van Westhreenen, Stefan Busemann";
    public static string $privacyRoute = 'https://typo3.com/privacy-policy';
    public static string $legalRoute = 'https://typo3.com/legal-notice';
    public static string $feedbackRoute = 'https://support.typo3.com';
}
