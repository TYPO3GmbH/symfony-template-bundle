<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\Extension;

use T3G\Bundle\TemplateBundle\Utility\AvatarUtility;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * AvatarExtension.
 **/
class AvatarExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('avatar', [$this, 'render'], ['is_safe' => ['html']]),
            new TwigFunction('avatarUrl', [$this, 'renderUrl'], ['is_safe' => ['html']]),
        ];
    }

    public function render(string $value, int $size = 36): string
    {
        return AvatarUtility::getAvatar($value, $size);
    }

    public function renderUrl(string $value, int $size = 36): string
    {
        return AvatarUtility::getAvatarUrl($value, $size);
    }

    public function getName(): string
    {
        return 'avatar';
    }
}
