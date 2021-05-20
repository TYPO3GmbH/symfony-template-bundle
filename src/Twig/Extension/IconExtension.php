<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\Extension;

use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class IconExtension extends AbstractExtension
{
    private $kernel;
    private $cache;
    private $packages;

    public function __construct(KernelInterface $kernel, CacheInterface $cache, Packages $packages)
    {
        $this->kernel = $kernel;
        $this->cache = $cache;
        $this->packages = $packages;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('icon', [$this, 'getIcon'], ['is_safe' => ['html']]),
        ];
    }

    public function getIcon(string $identifier, string $size = 'auto'): string
    {
        $identifier = $this->getAliasForIdentifier($identifier);
        $icon = $this->getIconForIdentifier($identifier) ?? $this->getNotFoundIcon();
        $isSpinner = strpos($identifier, 'spinner-') === 0 ? true : false;

        if ($icon) {
            $url = explode('#', $icon['sprite']);
            $url[0] = $this->packages->getUrl('bundles/template/icons/' . $url[0], 'template');
            $url = implode('#', $url);
            $markup = [];
            $markup[] = '<span class="icon icon-size-' . $size . ' icon-state-default' . ($isSpinner ? ' icon-spin' : '') . '">';
            $markup[] =     '<span class="icon-markup">';
            $markup[] =         '<svg role="img" class="icon-color"><use xlink:href="' . $url . '"></use></svg>';
            $markup[] =     '</span>';
            $markup[] = '</span>';

            return implode($markup);
        }

        throw new \InvalidArgumentException('Could not find an icon for identifier "' . $identifier . '"');
    }

    private function getAliasForIdentifier(string $identifier): string
    {
        return $this->getIconData()['aliases'][$identifier] ?? $identifier;
    }

    private function getIconForIdentifier(string $identifier): ?array
    {
        return $this->getIconData()['icons'][$identifier] ?? null;
    }

    private function getNotFoundIcon(): array
    {
        return $this->getIconData()['icons']['default-not-found'] ?? null;
    }

    private function getIconData(): array
    {
        $iconDataFileBaseName = basename($this->packages->getUrl('bundles/template/icons/icons.json', 'template'));
        $iconDataCache = $this->cache->getItem('icon.data-' . $iconDataFileBaseName);
        if (!$iconDataCache->isHit()) {
            $iconDataJson = file_get_contents($this->kernel->locateResource('@TemplateBundle/Resources/public/icons/' . $iconDataFileBaseName));
            if (false !== $iconDataJson) {
                $iconDataJsonDecoded = json_decode($iconDataJson, true);
                if (JSON_ERROR_NONE !== json_last_error()) {
                    $iconDataJsonDecoded = [
                        'icons' => [],
                        'aliases' => [],
                    ];
                }
            }
            $iconDataCache->set($iconDataJsonDecoded);
        }

        return $iconDataCache->get();
    }
}
