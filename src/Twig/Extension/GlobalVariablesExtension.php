<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use T3G\Bundle\TemplateBundle\ConfigurationSet\AbstractConfigurationSet;
use Traversable;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalVariablesExtension extends AbstractExtension implements GlobalsInterface
{
    /** @param Traversable<string, AbstractConfigurationSet> $configurationSets */
    public function __construct(
        private readonly array $config,
        #[TaggedIterator('t3g.configuration_set', defaultIndexMethod: 'getKey')] private readonly Traversable $configurationSets,
    ) {
    }

    public function getGlobals(): array
    {
        return [
            'template' => $this->config,
            'configuration_sets' => array_map(
                static fn (AbstractConfigurationSet $set) => $set->getProperties(),
                iterator_to_array($this->configurationSets)
            ),
        ];
    }

    public function getName(): string
    {
        return 'template_global_variable';
    }
}
