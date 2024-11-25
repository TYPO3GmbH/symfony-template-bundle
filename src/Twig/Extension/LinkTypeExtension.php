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

class LinkTypeExtension extends AbstractExtension
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('linkTypeIdentifier', [$this, 'getLinkTypeIdentifier'], ['is_safe' => ['html']]),
            new TwigFunction('linkTypeName', [$this, 'getLinkTypeName'], ['is_safe' => ['html']]),
            new TwigFunction('linkTypePrefix', [$this, 'getLinkTypePrefix'], ['is_safe' => ['html']]),
        ];
    }

    public function getLinkTypeIdentifier(string $type): string
    {
        if (class_exists('T3G\DatahubApiLibrary\Enum\LinkTypes')) {
            return \T3G\DatahubApiLibrary\Enum\LinkTypes::getIconIdentifier($type);
        }

        $this->logger->warning('Tried to get link type identifier without t3g/datahub-api-library installed.', ['type' => $type]);

        return $type;
    }

    public function getLinkTypeName(string $type): string
    {
        if (class_exists('T3G\DatahubApiLibrary\Enum\LinkTypes')) {
            return \T3G\DatahubApiLibrary\Enum\LinkTypes::getName($type);
        }

        $this->logger->warning('Tried to get link type name without t3g/datahub-api-library installed.', ['type' => $type]);

        return '';
    }

    public function getLinkTypePrefix(string $type): string
    {
        if (class_exists('T3G\DatahubApiLibrary\Enum\LinkTypes')) {
            return \T3G\DatahubApiLibrary\Enum\LinkTypes::getUrlPrefix($type);
        }

        $this->logger->warning('Tried to get link type prefix without t3g/datahub-api-library installed.', ['type' => $type]);

        return '';
    }
}
