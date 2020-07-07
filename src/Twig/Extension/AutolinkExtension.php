<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AutolinkExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('autolink', [$this, 'autolink'], ['is_safe' => ['html']]),
        ];
    }

    public function autolink(string $value): string
    {
        $links = [];

        $value = preg_replace_callback(
            '~(<a .*?>.*?</a>|<.*?>)~i',
            function ($match) use (&$links) {
                return '<' . array_push($links, $match[1]) . '>';
            },
            $value
        );

        // Links
        $value = preg_replace_callback(
            '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i',
            function ($match) use (&$links) {
                $link = $match[2] ?: $match[3];
                return '<' . array_push($links, "<a href=\"https://$link\" target=\"_blank\" rel=\"noopener\">$link</a>") . '>';
            },
            $value
        );

        // Email
        $value = preg_replace_callback(
            '~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~',
            function ($match) use (&$links) {
                return '<' . array_push($links, "<a href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>';
            },
            $value
        );

        // Phone
        $value = preg_replace_callback(
            '~([\+][1-9]\d{0,3}[\d\-/() ]+)(?<![\.,:])~i',
            function ($match) use (&$links) {
                $formattedNumber = str_replace(['-', ' ', '(0)', '(', ')'], '', $match[1]);
                return '<' . array_push($links, "<a href=\"tel:{$formattedNumber}\">{$match[1]}</a>") . '>';
            },
            $value
        );

        return preg_replace_callback(
            '/<(\d+)>/',
            function ($match) use (&$links) {
                return $links[$match[1] - 1];
            },
            $value
        );
    }
}
