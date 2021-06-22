<?php declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Tests\Unit\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use T3G\Bundle\TemplateBundle\DependencyInjection\TemplateExtension;

class TemplateExtensionTest extends TestCase
{
    /** @var ContainerBuilder */
    protected $configuration;

    protected function tearDown()
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
        $this->assertEquals('https://jira.typo3.com/servicedesk/customer/portal/2', $config['routes']['feedback']);
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
                    'CEO: Mathias Schreiber',
                    'Supervisory Board: Olivier Dobberkau, Ric van Westhreenen, Stefan Busemann'
                ]
            ),
            $config['email']['legal_footer']
        );
    }
}
