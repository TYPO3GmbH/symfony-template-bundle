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
    public function getSenderAddress(): string
    {
        return '
            TYPO3 Association
            Sihlbruggstrasse 105
            6340 Baar
            Switzerland
        ';
    }

    public function Header()
    {
        // Logo
        $width = 45;
        $height = $width / 3.70;
        $this->ImageSVG(
            __DIR__ . '/../../assets/pdf/images/logo.svg',
            25,
            10,
            $width,
            $height
        );

        $this->SetY(12.75);
        $this->SetX(80);
        $this->setCellPaddings(2.5, 2.5, 2.5, 2.5);
        $this->SetFillColor(255, 130, 0);
        $this->SetTextColor(255, 255, 255);
        $this->MultiCell(
            0,
            0,
            'TYPO3 Association, Sihlbruggstrasse 105, 6340 Baar, Switzerland',
            0,
            'C',
            true
        );
        $this->SetLineStyle([
            'width' => 0.25,
            'cap' => 'butt',
            'join' => 'miter',
            'dash' => 0,
            'color' => [200, 200, 200],
        ]);
        $this->Line(25, 28, 190, 28);
    }

    public function Footer()
    {
        $this->SetTextColor(100, 100, 100);
        $this->writeHTML('
            <table>
                <tr>
                    <td>
                        <strong>Contact</strong><br>
                        Telephone : +41 41 511 00 35<br>
                        E-Mail : info@typo3.org<br>
                        Backoffice: backoffice@typo3.org<br>
                        Web: association.typo3.org
                    </td>
                    <td>
                        <strong>TAX and Legal</strong><br>
                        CH-VAT: CHE-112.256.297 MWST<br>
                        DE-VAT: DE267 19843<br>
                        CH-Tax-ID: CHE-112.256.297<br>
                        DE-Tax-ID: 09431/35027
                    </td>
                    <td>
                        <strong>Payment in EUR</strong><br>
                        Sparkasse Hochrhein<br>
                        79761 Waldshut-Tiengen<br>
                        IBAN: DE18 6845 2290 0077 0154 28<br>
                        BIC (SWIFT): SKHRDE6W
                    </td>
                    <td>
                        <strong>Payment in CHF</strong><br>
                        Credit Suisse<br>
                        CH-8070 Zürich<br>
                        IBAN: CH55 0484 2039 5125 5100 0<br>
                        BIC (SWIFT): CRESCHZZ80C
                    </td>
                </tr>
            </table>
        ');
    }
}
