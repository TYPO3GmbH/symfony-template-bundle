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

class AssociationLayoutPdf extends Fpdi
{
    public function setupPage(): void
    {
        $this->SetCellPadding(0);
        $this->SetMargins(25, 40, 20, true);
        $this->SetHeaderMargin(5);
        $this->SetFooterMargin(25);
        $this->SetAutoPageBreak(true, 45);

        $this->SetCreator('TYPO3 Association');
        $this->SetAuthor('TYPO3 Association');
    }

    public function getSenderAddress(): string
    {
        return '
            TYPO3 Association
            Rathausstrasse 14
            6340 Baar
            Switzerland
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
            implode(
                '<br>',
                [
                    'TYPO3 Association',
                    'Rathausstrasse 14',
                    '6340 Baar',
                    'Switzerland',
                ]
            )
        );

        // Contact
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/icon-globe-alt.svg',
            58.7,
            270,
            $iconWidth,
            $iconHeight
        );
        $this->writeHTMLCell(
            0,
            0,
            64.5,
            270.1,
            implode(
                '<br>',
                [
                    'association.typo3.org',
                    'info@typo3.org',
                    'backoffice@typo3.org',
                    '+41 41 511 00 35',
                ]
            )
        );

        // Register
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/icon-university.svg',
            95.6,
            270,
            $iconWidth,
            $iconHeight
        );
        $this->writeHTMLCell(
            0,
            0,
            101.3,
            270.1,
            implode(
                '<br>',
                [
                    'CH-VAT: CHE-112.256.297 MWST',
                    'DE-VAT: DE267 19843',
                    'CH-Tax-ID: CHE-112.256.297',
                    'DE-Tax-ID: 09431/35027',
                ]
            )
        );

        // Bank
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/icon-credit-card.svg',
            144.5,
            270,
            $iconWidth,
            $iconHeight
        );
        $this->writeHTMLCell(
            0,
            0,
            150.2,
            270.1,
            implode(
                '<br>',
                [
                    'Bank EUR: Sparkasse Hochrhein',
                    'IBAN: DE18 6845 2290 0077 0154 28',
                    'Bank CHF: Credit Suisse',
                    'IBAN: CH55 0484 2039 5125 5100 0',
                ]
            )
        );
    }
}
