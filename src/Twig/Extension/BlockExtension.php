<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\Extension;

use T3G\Bundle\TemplateBundle\Twig\TokenParser\FrameTokenParser;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BlockExtension extends AbstractExtension
{
    public function getTokenParsers()
    {
        return [
            new FrameTokenParser()
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('frame', [$this, 'frameFunction'], ['needs_environment' => true, 'is_safe' => ['html']])
        ];
    }

    public function frameFunction(Environment $environment, string $content, array $attributes): string
    {
        $attributes['id'] = $attributes['id'] ?? null;
        $attributes['backgroundImage'] = $attributes['backgroundImage'] ?? null;
        $attributes['size'] = $attributes['size'] ?? 'default';
        $attributes['color'] = $attributes['color'] ?? 'default';
        $attributes['indent'] = $attributes['indent'] ?? false;
        $attributes['rulerBefore'] = $attributes['rulerBefore'] ?? false;
        $attributes['rulerAfter'] = $attributes['rulerAfter'] ?? false;
        $attributes['center'] = $attributes['center'] ?? false;
        $attributes['height'] = $attributes['height'] ?? 'auto';
        $attributes['innerWidth'] = $attributes['innerWidth'] ?? 'default';

        $classesOuter = [];
        $classesOuter[] = 'frame';
        $classesOuter[] = 'frame-size-' . $attributes['size'];
        $classesOuter[] = 'frame-height-' . $attributes['height'];
        if ($attributes['indent']) {
            $classesOuter[] = 'frame-indent';
        }
        $classesOuter[] = 'frame-background-' . $attributes['color'];
        $classesOuter[] = $attributes['backgroundImage'] ? 'frame-has-backgroundimage' : 'frame-no-backgroundimage';
        if ($attributes['rulerBefore']) {
            $classesOuter[] = 'frame-ruler-before';
        }
        if ($attributes['rulerAfter']) {
            $classesOuter[] = 'frame-ruler-after';
        }
        $classesOuter[] = 'frame-space-before-none';
        $classesOuter[] = 'frame-space-after-none';

        $classesContainer = [];
        $classesContainer[] = 'frame-container';
        $classesContainer[] = 'frame-container-' . $attributes['innerWidth'];

        $classesInner = [];
        $classesInner[] = 'frame-inner';
        if ($attributes['center']) {
            $classesInner[] = 'text-center';
        }

        return $environment->render('@Template/extension/block/frame.html.twig', [
            'content' => $content,
            'id' => $attributes['id'],
            'backgroundImage' => $attributes['backgroundImage'],
            'classesOuter' => implode(' ', $classesOuter),
            'classesContainer' => implode(' ', $classesContainer),
            'classesInner' => implode(' ', $classesInner),
        ]);
    }
}
