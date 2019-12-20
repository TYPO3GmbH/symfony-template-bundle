<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TextExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('text_expand', [$this, 'expand'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function expand(Environment $environment, string $content = null): string
    {
        return $environment->render('@Template/extension/text/expand.html.twig', [
            'id' => uniqid(),
            'content' => $content
        ]);
    }
}
