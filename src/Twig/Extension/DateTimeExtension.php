<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\Extension;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DateTimeExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('to_datetime', [$this, 'toDateTime']),
            new TwigFunction('localtime', [$this, 'localtime'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new TwigFunction('relativetime', [$this, 'relativetime'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function toDateTime(string $date, string $format = 'Y/m/d H:i:s'): \DateTime
    {
        $datetime = \DateTime::createFromFormat($format, $date);
        return $datetime;
    }

    public function localtime(Environment $environment, \DateTimeInterface $datetime = null): string
    {
        return $environment->render('@Template/extension/datetime/localtime.html.twig', ['datetime' => $datetime]);
    }

    public function relativetime(Environment $environment, \DateTimeInterface $datetime = null): string
    {
        return $environment->render('@Template/extension/datetime/relativetime.html.twig', ['datetime' => $datetime]);
    }
}
