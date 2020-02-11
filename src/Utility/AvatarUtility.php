<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Utility;

/**
 * AvatarUtility.
 */
class AvatarUtility
{
    /**
     * @param string $email
     * @param int $size
     * @return string
     */
    public static function getAvatar($email, $size = 80): string
    {
        $attributes = '';

        $attributesData = [];
        $attributesData['src'] = self::getAvatarUrl($email, $size);
        $attributesData['class'] = 'avatar';
        $attributesData['height'] = (int) $size;
        $attributesData['width'] = (int) $size;

        foreach ($attributesData as $key => $value) {
            $attributes .= ' ' . $key . '="' . $value . '"';
        }

        return '<img' . $attributes . '/>';
    }

    /**
     * @param string $email
     * @param int $size
     * @return string
     */
    public static function getAvatarUrl($email, $size = 80): string
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?s= ' . (int) $size . '&d=mp&r=g';
    }
}
