<?php declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Tests\Unit\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use T3G\Bundle\TemplateBundle\ConfigurationSet\T3gConfigurationSet;
use T3G\Bundle\TemplateBundle\DependencyInjection\TemplateExtension;

class TemplateExtensionTest extends TestCase
{
    /** @var ContainerBuilder */
    protected $configuration;

    protected function tearDown(): void
    {
        $this->configuration = null;
    }

    public function testDefault()
    {
        $container = new ContainerBuilder();
        $loader = new TemplateExtension();
        $loader->load([[]], $container);

        $config = $container->getParameter('t3g.template.config')['application'];

        $this->assertEquals('Template Bundle', $config['name']);
        $this->assertEquals(false, $config['platformkey']);
        $this->assertEquals('TYPO3 GmbH', $config['copyright']['author']);
        $this->assertEquals('https://typo3.com', $config['copyright']['url']);
        $this->assertEquals('app_index', $config['routes']['home']);
        $this->assertEquals('https://typo3.com/privacy-policy', $config['routes']['privacy']);
        $this->assertEquals('https://typo3.com/legal-notice', $config['routes']['legal']);
        $this->assertEquals('https://support.typo3.com', $config['routes']['feedback']);
        $this->assertEquals('T3G\Bundle\TemplateBundle\Menu\MenuBuilder', $config['menu']['class']);
        $this->assertEquals([], $config['security']['headers']);
        $this->assertEquals(['report_only' => true, 'rules' => []], $config['security']['content_security_policy']);
        $this->assertEquals(false, $config['assets']['encore_entrypoint']);
        $this->assertEquals(false, $config['theme']['use_logo']);
        $this->assertEquals('lg', $config['theme']['navbar_breakpoint']);
        $this->assertEquals('lighter', $config['theme']['background']);
        $this->assertEquals(
            implode(
                "\n",
                [
                    'TYPO3 GmbH, Emanuel-Leutze-Straße 11, DE-40547 Düsseldorf, Germany',
                    'Phone: +49 (0)211 20 54 36 0, Web: www.typo3.com, Email: info@typo3.com',
                    '',
                    'Court of registration: Amtsgericht Düsseldorf HRB 77950',
                    'CEO: Daniel Fau,  (CTO & Procuration) Frank Nägler',
                    'Supervisory Board: Olivier Dobberkau, Ric van Westhreenen, Stefan Busemann'
                ]
            ),
            $config['email']['legal_footer']
        );
        $this->assertEquals('Emanuel-Leutze-Straße 11', $config['address']['street']);
        $this->assertEquals('40547', $config['address']['zip']);
        $this->assertEquals('Düsseldorf', $config['address']['city']);
        $this->assertEquals('Germany', $config['address']['country']);
        $this->assertEquals('DE', $config['address']['countryIso2Code']);
    }

    /**
     * @dataProvider overruleDataProvider
     */
    public function testOverrule(array $configs)
    {
        $container = new ContainerBuilder();
        $loader = new TemplateExtension();
        $loader->load([$configs], $container);

        $config = $container->getParameter('t3g.template.config')['application'];

        $this->assertEquals('Author', $config['copyright']['author']);
        $this->assertEquals('https://example.org', $config['copyright']['url']);
        $this->assertEquals('Footer', $config['email']['legal_footer']);
        $this->assertEquals('app_privacy', $config['routes']['privacy']);
        $this->assertEquals('app_legal', $config['routes']['legal']);
        $this->assertEquals('app_feedback', $config['routes']['feedback']);
        $this->assertEquals('12345', $config['address']['zip']);
    }

    public function testExceptionOnInvalidConfigurationSet()
    {
        $this->expectException(InvalidConfigurationException::class);

        $container = new ContainerBuilder();
        $loader = new TemplateExtension();
        $loader->load([
            'config' => [
                'application' => [
                    'configurationSet' => 'MyInvalidConfigurationSet'
                ]
            ]
        ], $container);
    }

    public function overruleDataProvider(): array
    {
        return [
            [
                'config' => [
                    'application' => [
                        'configurationSet' => T3gConfigurationSet::class,
                        'copyright' => [
                            'author' => 'Author',
                            'url' => 'https://example.org',
                        ],
                        'email' => [
                            'legal_footer' => 'Footer'
                        ],
                        'routes' => [
                            'privacy' => 'app_privacy',
                            'legal' => 'app_legal',
                            'feedback' => 'app_feedback',
                        ],
                        'address' => [
                            'zip' => '12345',
                        ],
                    ],
                ],
            ],
        ];
    }
}
