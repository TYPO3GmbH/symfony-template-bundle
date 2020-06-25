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
     * @param string $value
     * @param int $size
     * @return string
     */
    public static function getAvatar(string $value, int $size = 80): string
    {
        $attributes = '';

        $attributesData = [];
        $attributesData['src'] = self::getAvatarUrl($value, $size);
        $attributesData['class'] = 'avatar';
        $attributesData['height'] = $size;
        $attributesData['width'] = $size;

        foreach ($attributesData as $key => $data) {
            $attributes .= ' ' . $key . '="' . $data . '"';
        }

        return '<img' . $attributes . '/>';
    }

    /**
     * @param string $value
     * @param int $size
     * @return string
     */
    public static function getAvatarUrl(string $value, int $size = 80): string
    {
        if (!preg_match('/^[a-f0-9]{32}$/', $value)) {
            $value = md5(strtolower(trim($value)));
        }

        return 'https://www.gravatar.com/avatar/' . $value . '?s= ' . $size . '&d=mp&r=g';
    }
}
