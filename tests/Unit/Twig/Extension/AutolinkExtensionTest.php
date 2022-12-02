<?php declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Tests\Unit\Twig\Extension;

use PHPUnit\Framework\TestCase;
use T3G\Bundle\TemplateBundle\Twig\Extension\AutolinkExtension;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class AutolinkExtensionTest extends TestCase
{
    /**
     * @dataProvider getAutolinkTests
     */
    public function testAutolink(string $template, string $expected): void
    {
        $loader = new ArrayLoader(['index' => '{% apply autolink %}' . $template . '{% endapply %}']);
        $twig = new Environment($loader);
        $twig->addExtension(new AutolinkExtension());
        $this->assertEquals($expected, trim($twig->render('index')));
    }

    public function getAutolinkTests()
    {
        return [
            // Url
            ['https://test.de', '<a href="https://test.de" target="_blank" rel="noopener">test.de</a>'],
            ['<a href="https://test.de">https://test.de</a>', '<a href="https://test.de">https://test.de</a>'],
            ['<a href="https://test.de">https://test.de</a> https://test.de', '<a href="https://test.de">https://test.de</a> <a href="https://test.de" target="_blank" rel="noopener">test.de</a>'],
            // Emails
            ['max@mustermann.de', '<a href="mailto:max@mustermann.de">max@mustermann.de</a>'],
            ['benjamin.kott@typo3.com', '<a href="mailto:benjamin.kott@typo3.com">benjamin.kott@typo3.com</a>'],
            ['max@mustermann.de benjamin.kott@typo3.com', '<a href="mailto:max@mustermann.de">max@mustermann.de</a> <a href="mailto:benjamin.kott@typo3.com">benjamin.kott@typo3.com</a>'],
            ['<a href="mailto:benjamin.kott@typo3.com">benjamin.kott@typo3.com</a>', '<a href="mailto:benjamin.kott@typo3.com">benjamin.kott@typo3.com</a>'],
            // Phone Numbers
            ['+1-541-754-3010', '<a href="tel:+15417543010">+1-541-754-3010</a>'],
            ['+49 211 205436-0', '<a href="tel:+492112054360">+49 211 205436-0</a>'],
            // Full
            [
                implode(
                    "\n",
                    [
                        'TYPO3 GmbH, Emanuel-Leutze-Straße 11, DE-40547 Düsseldorf, Germany',
                        'Phone: +49 (0)211 205436-0, Web: www.typo3.com, Email: info@typo3.com',
                        '',
                        'Court of registration: Amtsgericht Düsseldorf HRB 77950',
                        'CEO: Daniel Fau,  (CTO & Procuration) Frank Nägler',
                        'Supervisory Board: Olivier Dobberkau, Ric van Westhreenen, Stefan Busemann',
                    ]
                ),
                implode(
                    "\n",
                    [
                        'TYPO3 GmbH, Emanuel-Leutze-Straße 11, DE-40547 Düsseldorf, Germany',
                        'Phone: <a href="tel:+492112054360">+49 (0)211 205436-0</a>, Web: <a href="https://www.typo3.com" target="_blank" rel="noopener">www.typo3.com</a>, Email: <a href="mailto:info@typo3.com">info@typo3.com</a>',
                        '',
                        'Court of registration: Amtsgericht Düsseldorf HRB 77950',
                        'CEO: Daniel Fau,  (CTO & Procuration) Frank Nägler',
                        'Supervisory Board: Olivier Dobberkau, Ric van Westhreenen, Stefan Busemann',
                    ]
                )
            ],
            [
                implode(
                    "\n",
                    [
                        '<p>',
                        'TYPO3 GmbH, Emanuel-Leutze-Straße 11, DE-40547 Düsseldorf, Germany<br>',
                        'Phone: +49 (0)211 205436-0, Web: www.typo3.com, Email: info@typo3.com<br>',
                        '<br>',
                        'Court of registration: Amtsgericht Düsseldorf HRB 77950<br>',
                        'CEO: Daniel Fau,  (CTO & Procuration) Frank Nägler<br>',
                        'Supervisory Board: Olivier Dobberkau, Ric van Westhreenen, Stefan Busemann',
                        '</p>'
                    ]
                ),
                implode(
                    "\n",
                    [
                        '<p>',
                        'TYPO3 GmbH, Emanuel-Leutze-Straße 11, DE-40547 Düsseldorf, Germany<br>',
                        'Phone: <a href="tel:+492112054360">+49 (0)211 205436-0</a>, Web: <a href="https://www.typo3.com" target="_blank" rel="noopener">www.typo3.com</a>, Email: <a href="mailto:info@typo3.com">info@typo3.com</a><br>',
                        '<br>',
                        'Court of registration: Amtsgericht Düsseldorf HRB 77950<br>',
                        'CEO: Daniel Fau,  (CTO & Procuration) Frank Nägler<br>',
                        'Supervisory Board: Olivier Dobberkau, Ric van Westhreenen, Stefan Busemann',
                        '</p>',
                    ]
                )
            ]
        ];
    }
}
