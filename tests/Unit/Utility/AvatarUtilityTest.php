<?php declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Tests\Unit\Utility;

use PHPUnit\Framework\TestCase;
use T3G\Bundle\TemplateBundle\Utility\AvatarUtility;

class AvatarUtilityTest extends TestCase
{
    /**
     * @dataProvider avatarDataProvider
     * @param string $value
     * @param string $expected
     */
    public function testGetAvatarUrl(string $value, string $expected): void
    {
        $this->assertEquals($expected, AvatarUtility::getAvatarUrl($value));
    }

    public function avatarDataProvider(): array
    {
        return [
            [
                'value' => 'hello@world.com',
                'expected' => 'https://www.gravatar.com/avatar/4b3cdf9adfc6258a102ab90eb64565ea?s=80&d=mp&r=g',
            ],
            [
                'value' => '4b3cdf9adfc6258a102ab90eb64565ea',
                'expected' => 'https://www.gravatar.com/avatar/4b3cdf9adfc6258a102ab90eb64565ea?s=80&d=mp&r=g',
            ]
        ];
    }
}
