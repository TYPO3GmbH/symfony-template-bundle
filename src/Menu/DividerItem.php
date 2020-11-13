<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;

final class DividerItem extends MenuItem
{
    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        parent::__construct('divider' . uniqid(), $factory);
        $this->setExtra('divider', true);
    }
}
