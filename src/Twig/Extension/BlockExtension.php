<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\Extension;

use T3G\Bundle\TemplateBundle\Twig\TokenParser\ExampleTokenParser;
use T3G\Bundle\TemplateBundle\Twig\TokenParser\FrameTokenParser;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BlockExtension extends AbstractExtension
{
    public function getTokenParsers()
    {
        return [
            new ExampleTokenParser(),
            new FrameTokenParser(),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('example', [$this, 'exampleFunction'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new TwigFunction('frame', [$this, 'frameFunction'], ['needs_environment' => true, 'is_safe' => ['html']])
        ];
    }

    public function exampleFunction(Environment $environment, string $content, array $attributes): string
    {
        return $environment->render('@Template/extension/block/example.html.twig', [
            'content' => $content,
            'language' => $attributes['language'] ?? 'none',
        ]);
    }

    public function frameFunction(Environment $environment, string $content, array $attributes): string
    {
        $attributes['id'] = $attributes['id'] ?? null;
        $attributes['layout'] = $attributes['layout'] ?? 'default';

        $attributes['backgroundImage'] = $attributes['backgroundImage'] ?? null;
        $attributes['backgroundImageFade'] = (bool) ($attributes['backgroundImageFade'] ?? true);
        $attributes['backgroundImageBlur'] = (bool) ($attributes['backgroundImageBlur'] ?? false);
        $attributes['backgroundImageParallax'] = (bool) ($attributes['backgroundImageParallax'] ?? false);
        $attributes['backgroundImageGrayscale'] = (bool) ($attributes['backgroundImageGrayscale'] ?? false);
        $attributes['backgroundImageSepia'] = (bool) ($attributes['backgroundImageSepia'] ?? false);

        $attributes['size'] = $attributes['size'] ?? 'default';
        $attributes['color'] = $attributes['color'] ?? 'default';
        $attributes['indent'] = $attributes['indent'] ?? false;
        $attributes['rulerBefore'] = $attributes['rulerBefore'] ?? false;
        $attributes['rulerAfter'] = $attributes['rulerAfter'] ?? false;
        $attributes['center'] = $attributes['center'] ?? false;
        $attributes['height'] = $attributes['height'] ?? 'auto';
        $attributes['innerWidth'] = $attributes['innerWidth'] ?? 'default';
        $attributes['title'] = $attributes['title'] ?? null;
        $attributes['titleSize'] = (int)($attributes['titleSize'] ?? 2);
        $attributes['titleAnchor'] = $attributes['titleAnchor'] ?? true;

        $groupContainerClasses = [];
        $groupContainerClasses[] = 'frame-group-container';
        $groupContainerClasses[] = 'frame-group-container-' . $attributes['innerWidth'];

        $classesOuter = [];
        $classesOuter[] = 'frame';
        $classesOuter[] = 'frame-layout-' . $attributes['layout'];
        $classesOuter[] = 'frame-size-' . $attributes['size'];
        $classesOuter[] = 'frame-height-' . $attributes['height'];

        if ($attributes['indent']) {
            if ($attributes['indent'] === 'left') {
                $classesOuter[] = 'frame-indent-left';
            } elseif ($attributes['indent'] === 'right') {
                $classesOuter[] = 'frame-indent-right';
            } else {
                $classesOuter[] = 'frame-indent';
            }
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

        $backgroundImageClasses = [];
        $backgroundImageClasses[] = 'frame-backgroundimage';
        if ($attributes['backgroundImageFade']) {
            $backgroundImageClasses[] = 'frame-backgroundimage-fade';
        }
        if ($attributes['backgroundImageBlur']) {
            $backgroundImageClasses[] = 'frame-backgroundimage-blur';
        }
        if ($attributes['backgroundImageParallax']) {
            $backgroundImageClasses[] = 'frame-backgroundimage-parallax';
        }
        if ($attributes['backgroundImageGrayscale']) {
            $backgroundImageClasses[] = 'frame-backgroundimage-grayscale';
        }
        if ($attributes['backgroundImageSepia']) {
            $backgroundImageClasses[] = 'frame-backgroundimage-sepia';
        }

        $classesInner = [];
        $classesInner[] = 'frame-inner';
        if ($attributes['center']) {
            $classesInner[] = 'text-center';
        }

        if (!$attributes['id']) {
            $attributes['titleAnchor'] = false;
        }

        if ($attributes['titleSize'] < 1 || $attributes['titleSize'] > 6) {
            $attributes['titleSize'] = 2;
        }

        return $environment->render('@Template/extension/block/frame.html.twig', [
            'content' => $content,
            'id' => $attributes['id'],
            'groupContainerClasses' => implode(' ', $groupContainerClasses),
            'backgroundImage' => $attributes['backgroundImage'],
            'backgroundImageClasses' => implode(' ', $backgroundImageClasses),
            'classesOuter' => implode(' ', $classesOuter),
            'classesContainer' => implode(' ', $classesContainer),
            'classesInner' => implode(' ', $classesInner),
            'title' => $attributes['title'],
            'titleSize' => $attributes['titleSize'],
            'titleAnchor' => $attributes['titleAnchor'],
        ]);
    }
}
