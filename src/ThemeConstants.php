<?php declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle;

class ThemeConstants
{
    public static function getThemeColors(): array
    {
        return [
            'primary',
            'secondary',
            'tertiary',
            'quaternary',
            'success',
            'info',
            'warning',
            'danger',
            'notice',
            'default',
            'lighter',
            'light',
            'dark',
            'darker',
        ];
    }

    public static function getFrameColors(): array
    {
        return [
            'primary',
            'secondary',
            'tertiary',
            'quaternary',
            'white',
            'lighter',
            'light',
            'dark',
            'darker',
        ];
    }

    public static function getReviewColors(): array
    {
        return [
            'default',
            'bugfix',
            'feature',
            'task',
        ];
    }

    public static function getIssueColors(): array
    {
        return [
            'default',
            'bug',
            'feature',
            'task',
            'epic',
            'story',
        ];
    }

    public static function getStatusColors(): array
    {
        return [
            'new',
            'accepted',
            'underreview',
            'onhold',
            'needsfeedback',
            'nextup',
            'inprogress',
            'done',
        ];
    }

    public static function getProgressColors(): array
    {
        return [
            'default',
            'blocked',
            'open',
            'wip',
            'done',
        ];
    }
}
