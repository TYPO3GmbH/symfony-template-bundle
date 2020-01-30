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
use Twig\Extension\GlobalsInterface;

class GlobalVariablesExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var array
     */
    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getGlobals(): array
    {
        return [
            'template' => $this->config,
        ];
    }

    public function getName(): string
    {
        return 'template_global_variable';
    }
}
