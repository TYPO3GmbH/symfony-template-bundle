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
            new TwigFunction('localdatetime', [$this, 'localdatetime'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new TwigFunction('localdate', [$this, 'localdate'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new TwigFunction('relativetime', [$this, 'relativetime'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function toDateTime(string $date, string $format = 'Y/m/d H:i:s'): \DateTime
    {
        $datetime = \DateTime::createFromFormat($format, $date);
        return $datetime;
    }

    /**
     * @deprecated use localdatetime instead
     */
    public function localtime(Environment $environment, \DateTimeInterface $datetime = null): string
    {
        trigger_deprecation('t3g/symfony-template-bundle', '2.11.2', 'localtime is deprecated, use localdatetime instead');
        return $this->localdatetime($environment, $datetime);
    }

    public function localdatetime(Environment $environment, \DateTimeInterface $datetime = null): string
    {
        return $environment->render('@Template/extension/datetime/localdatetime.html.twig', ['datetime' => $datetime]);
    }

    public function localdate(Environment $environment, \DateTimeInterface $datetime = null): string
    {
        return $environment->render('@Template/extension/datetime/localdate.html.twig', ['datetime' => $datetime]);
    }

    public function relativetime(Environment $environment, \DateTimeInterface $datetime = null): string
    {
        return $environment->render('@Template/extension/datetime/relativetime.html.twig', ['datetime' => $datetime]);
    }
}
