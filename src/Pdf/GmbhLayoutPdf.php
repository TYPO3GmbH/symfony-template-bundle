<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Pdf;

use setasign\Fpdi\Tcpdf\Fpdi;
use T3G\Bundle\TemplateBundle\ConfigurationSet\T3gConfigurationSet;

class GmbhLayoutPdf extends Fpdi
{
    public function setupPage(): void
    {
        $this->SetCellPadding(0);
        $this->SetMargins(25, 40, 20, true);
        $this->SetHeaderMargin(5);
        $this->SetFooterMargin(25);
        $this->SetAutoPageBreak(true, 45);

        $this->SetCreator(T3gConfigurationSet::$author);
        $this->SetAuthor(T3gConfigurationSet::$author);
    }

    public function getSenderAddress(): string
    {
        return sprintf(
            '
            %s
            %s
            %s %s
            %s
        ',
            T3gConfigurationSet::$author,
            T3gConfigurationSet::$street,
            T3gConfigurationSet::$zip,
            T3gConfigurationSet::$city,
            T3gConfigurationSet::$country
        );
    }

    public function Header()
    {
        // Logo
        $logoWidth = 35;
        $logoHeight = $logoWidth / 3.70;
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/logo.svg',
            25,
            17,
            $logoWidth,
            $logoHeight
        );

        // Edge
        $edgeWidth = 72;
        $edgeHeight = 34;
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/edge.svg',
            138,
            0,
            $edgeWidth,
            $edgeHeight
        );

        // Marker
        $markerWidth = 4;
        $markerHeight = 4;
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/icon-caret-right.svg',
            0.7,
            103.2,
            $markerWidth,
            $markerHeight
        );
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/icon-caret-right.svg',
            0.7,
            208.2,
            $markerWidth,
            $markerHeight
        );
    }

    public function Footer()
    {
        // Line
        $this->SetLineStyle([
            'width' => 0.25,
            'cap' => 'butt',
            'join' => 'miter',
            'dash' => 0,
            'color' => [200, 200, 200],
        ]);
        $this->Line(25, 262, 190, 262);

        $iconWidth = 4;
        $iconHeight = 4;

        // Address
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/icon-marker.svg',
            24.3,
            270,
            $iconWidth,
            $iconHeight
        );
        $this->writeHTMLCell(
            0,
            0,
            29.7,
            270.1,
            sprintf(
                '%s<br>%s<br>%s %s<br>%s',
                T3gConfigurationSet::$author,
                T3gConfigurationSet::$street,
                T3gConfigurationSet::$zip,
                T3gConfigurationSet::$city,
                T3gConfigurationSet::$country
            )
        );

        // Contact
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/icon-globe-alt.svg',
            64.7,
            270,
            $iconWidth,
            $iconHeight
        );
        $this->writeHTMLCell(
            0,
            0,
            70.5,
            270.1,
            'typo3.com<br>info@typo3.com'
        );

        // Register
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/icon-university.svg',
            98.6,
            270,
            $iconWidth,
            $iconHeight
        );
        $this->writeHTMLCell(
            0,
            0,
            104.3,
            270.1,
            'Register No: HRB 77950<br>Ust-ID No: DE 815 655 651'
        );

        // Bank
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/icon-credit-card.svg',
            141.5,
            270,
            $iconWidth,
            $iconHeight
        );
        $this->writeHTMLCell(
            0,
            0,
            147.2,
            270.1,
            'Bank: Sparkasse Oberrhein<br>IBAN: DE56 6845 2290 0077 0735 26'
        );
    }
}
