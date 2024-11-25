<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\Extension;

use Psr\Log\LoggerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LinkIconExtension extends AbstractExtension
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('linkIconIdentifier', [$this, 'getLinkIconIdentifier'], ['is_safe' => ['html']]),
            new TwigFunction('linkIconName', [$this, 'getLinkIconName'], ['is_safe' => ['html']]),
        ];
    }

    public function getLinkIconIdentifier(string $icon): string
    {
        if (class_exists('T3G\DatahubApiLibrary\Enum\LinkTypes')) {
            return \T3G\DatahubApiLibrary\Enum\LinkTypes::getIconIdentifier($icon);
        }

        $this->logger->warning('Tried to get link icon identifier without t3g/datahub-api-library installed.', ['icon' => $icon]);

        return $icon;
    }

    public function getLinkIconName(string $icon): string
    {
        if (class_exists('T3G\DatahubApiLibrary\Enum\LinkTypes')) {
            return \T3G\DatahubApiLibrary\Enum\LinkTypes::getName($icon);
        }

        $this->logger->warning('Tried to get link icon name without t3g/datahub-api-library installed.', ['icon' => $icon]);

        return '';
    }
}
