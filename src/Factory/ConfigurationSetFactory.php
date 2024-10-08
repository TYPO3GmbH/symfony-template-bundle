<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Factory;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use T3G\Bundle\TemplateBundle\ConfigurationSet\AbstractConfigurationSet;
use T3G\Bundle\TemplateBundle\ConfigurationSet\T3AConfigurationSet;
use T3G\Bundle\TemplateBundle\ConfigurationSet\T3GConfigurationSet;

class ConfigurationSetFactory extends AbstractConfigurationSet
{
    public static function fromOrganizationIdentifier(mixed $organizationIdentifier): ?AbstractConfigurationSet
    {
        if (!is_string($organizationIdentifier)) {
            return null;
        }

        return match ($organizationIdentifier) {
            T3AConfigurationSet::IDENTIFIER => new T3AConfigurationSet(),
            T3GConfigurationSet::IDENTIFIER => new T3GConfigurationSet(),
            default => throw new InvalidConfigurationException(
                'Unknown organization key "' . $organizationIdentifier . '"'
            ),
        };
    }
}
