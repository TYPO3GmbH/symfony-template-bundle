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
            new TwigFunction('timediff', [$this, 'timediff'], ['needs_environment' => true, 'is_safe' => ['html']]),
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

    public function timediff(Environment $environment, \DateTimeInterface $datetime = null): string
    {
        if (null === $datetime) {
            return '';
        }

        $timediff = null;
        $now = new \DateTime('now');
        $interval = $now->diff($datetime);

        $format = [];
        if ($interval->y !== 0) {
            $format[] = '%y ' . $this->pluralize($interval->y, 'year', 'years');
        }
        if ($interval->m !== 0) {
            $format[] = '%m ' . $this->pluralize($interval->m, 'month', 'months');
        }
        if ($interval->d !== 0) {
            $format[] = '%d ' . $this->pluralize($interval->d, 'day', 'days');
        }
        if ($interval->h !== 0) {
            $format[] = '%h ' . $this->pluralize($interval->h, 'hour', 'hours');
        }
        if ($interval->i !== 0) {
            $format[] = '%i ' . $this->pluralize($interval->i, 'minute', 'minutes');
        }

        if ($interval->s !== 0) {
            if (!count($format)) {
                $format[] = 'less than a minute ago';
            } else {
                $format[] = '%s ' . $this->pluralize($interval->s, 'second', 'seconds');
            }
        }

        if (count($format) > 1) {
            $formatString = array_shift($format) . ' and ' . array_shift($format);
        } else {
            $formatString = array_pop($format);
        }

        return $environment->render('@Template/extension/datetime/timediff.html.twig', ['timediff' => $interval->format($formatString)]);
    }

    private function pluralize(int $number, string $singular, string $plural)
    {
        return $number > 1 ? $plural : $singular;
    }
}
