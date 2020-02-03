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

class TemplateExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('template_function_exist', [$this, 'functionExist'], ['needs_environment' => true]),
            new TwigFunction('template_function_call', [$this, 'functionCall'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function functionExist(Environment $environment, string $name = null): bool
    {
        return $environment->getFunction($name) ? true : false;
    }

    public function functionCall(Environment $environment, string $name = null, ...$arguments): string
    {
        $function = $environment->getFunction($name);
        if ($function === false) {
            return null;
        }
        return $function->getCallable()(...$arguments);
    }
}
