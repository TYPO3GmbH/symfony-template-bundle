<?php declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('template');
        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('application')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('name')
                            ->defaultValue('Template Bundle')
                            ->example('Intercept')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('platformkey')
                            ->example('intercept')
                            ->defaultValue(false)
                        ->end()
                        ->arrayNode('copyright')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('author')
                                    ->defaultValue('TYPO3 GmbH')
                                    ->example('TYPO3 GmbH')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('url')
                                    ->defaultValue('https://typo3.com')
                                    ->example('https://typo3.com')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('email')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('legal_footer')
                                    ->defaultValue(implode("\n", [
                                        'TYPO3 GmbH, Emanuel-Leutze-Straße 11, DE-40547 Düsseldorf, Germany',
                                        'Phone: +49 (0)211 20 54 36 0, Web: www.typo3.com, Email: info@typo3.com',
                                        '',
                                        'Court of registration: Amtsgericht Düsseldorf HRB 77950',
                                        'CEO: Mathias Schreiber',
                                        'Supervisory Board: Olivier Dobberkau, Ric van Westhreenen, Stefan Busemann'
                                    ]))
                                    ->example(implode("\n", [
                                        'TYPO3 GmbH, Emanuel-Leutze-Straße 11, DE-40547 Düsseldorf, Germany',
                                        'Phone: +49 (0)211 20 54 36 0, Web: www.typo3.com, Email: info@typo3.com',
                                        '',
                                        'Court of registration: Amtsgericht Düsseldorf HRB 77950',
                                        'CEO: Mathias Schreiber',
                                        'Supervisory Board: Olivier Dobberkau, Ric van Westhreenen, Stefan Busemann'
                                    ]))
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('routes')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('home')
                                    ->defaultValue('app_index')
                                    ->example('app_index')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('privacy')
                                    ->defaultValue('https://typo3.com/privacy-policy')
                                    ->example('https://typo3.com/privacy-policy')
                                ->end()
                                ->scalarNode('legal')
                                    ->defaultValue('https://typo3.com/legal-notice')
                                    ->example('https://typo3.com/legal-notice')
                                ->end()
                                ->scalarNode('feedback')
                                    ->defaultValue('https://jira.typo3.com/servicedesk/customer/portal/2')
                                    ->example('https://jira.typo3.com/servicedesk/customer/portal/2')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('menu')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('T3G\Bundle\TemplateBundle\Menu\MenuBuilder')
                                    ->example('App\Menu\MenuBuilder')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('assets')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('encore_entrypoint')
                                    ->defaultValue(false)
                                    ->example('app')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('theme')->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('use_logo')
                                    ->defaultValue(false)
                                ->end()
                                ->scalarNode('navbar_breakpoint')
                                    ->defaultValue('lg')
                                    ->example('md')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('background')
                                    ->defaultValue('light')
                                    ->example('none')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
