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

class GmbhLayoutPdf extends Fpdi
{
    public function getSenderAddress(): string
    {
        return '
            TYPO3 GmbH
            Emanuel-Leutze-Str. 11
            40547 Düsseldorf
            Germany
        ';
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
            'TYPO3 GmbH<br>Emanuel-Leutze-Str. 11<br>40547 Düsseldorf<br>Germany'
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
