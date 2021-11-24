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
use TCPDF_FONTS;

class SimplePdf
{
    private Fpdi $pdf;
    private array $colors = [
        'text' => [50, 50, 50],
        'light' => [242, 242, 242],
    ];
    private $fonts;
    private ?string $overlay = null;

    public function __construct(?Fpdi $layout = null)
    {
        $this->pdf = $layout ?? new GmbhLayoutPdf();
        $this->setUp();
    }

    public function setUp(): void
    {
        // Fonts
        $this->fonts = [
            'SourceSansPro-Light' => TCPDF_FONTS::addTTFfont(__DIR__ . '/../../assets/pdf/fonts/SourceSansPro-Light.ttf'),
            'SourceSansPro-Bold' => TCPDF_FONTS::addTTFfont(__DIR__ . '/../../assets/pdf/fonts/SourceSansPro-Bold.ttf'),
            'SourceSansPro-Regular' => TCPDF_FONTS::addTTFfont(__DIR__ . '/../../assets/pdf/fonts/SourceSansPro-Regular.ttf'),
        ];

        $this->pdf->setHeaderFont([$this->fonts['SourceSansPro-Regular'], '', 10]);
        $this->pdf->setFooterFont([$this->fonts['SourceSansPro-Light'], '', 8]);
        $this->pdf->SetFont($this->fonts['SourceSansPro-Regular'], 10);
        $this->pdf->setCellHeightRatio(1.25);

        // Spacings
        $this->pdf->SetCellPadding(0);
        $this->pdf->SetMargins(25, 40, 20, true);
        $this->pdf->SetHeaderMargin(5);
        $this->pdf->SetFooterMargin(25);

        $this->pdf->SetAutoPageBreak(true, 45);
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $this->pdf->SetLineStyle(['color' => $this->colors['light']]);
        $this->pdf->SetTextColor(...$this->colors['text']);
        $this->pdf->SetCreator('TYPO3 GmbH');
        $this->pdf->SetAuthor('TYPO3 GmbH');
    }

    public function setBadge(string $path)
    {
        $this->pdf->ImageSVG(
            $path,
            158,
            10,
            40,
            40
        );
    }

    public function addDate(\DateTimeInterface $date)
    {
        $this->pdf->writeHTML('<div style="text-align: right">' . $date->format('Y-m-d') . '</div>');
    }

    public function import(string $path)
    {
        $pageCount = $this->pdf->setSourceFile($path);
        for ($i = 1; $i <= $pageCount; ++$i) {
            $template = $this->pdf->importPage($i, '/MediaBox');
            $this->pdf->AddPage();
            $this->pdf->useTemplate($template);
        }
    }

    public function setPrintHeader(bool $value)
    {
        $this->pdf->setPrintHeader($value);
    }

    public function setPrintFooter(bool $value)
    {
        $this->pdf->setPrintFooter($value);
    }

    public function addPage()
    {
        $this->pdf->AddPage('A4');
        $this->pdf->SetFontSize(10);
    }

    public function addAddressBlock(string $address)
    {
        if (method_exists($this->pdf, 'getSenderAddress')) {
            $this->pdf->SetFontSize(8);
            $senderData = explode("\n", trim($this->pdf->getSenderAddress()));
            foreach ($senderData as $senderLine => $senderValue) {
                $senderData[$senderLine] = trim($senderValue);
            }
            $senderData[0] = '<span style="color: #ff8700;">' . $senderData[0] . '</span>';
            $this->pdf->writeHTML(implode(' <span style="color: #ff8700;">|</span> ', $senderData));
            $this->pdf->SetY($this->pdf->GetY() + 5);
        }
        $this->pdf->SetFontSize(10);

        $data = explode("\n", $address);
        foreach ($data as $line => $value) {
            $data[$line] = trim($value);
        }
        $html = implode('<br>', $data);
        $this->pdf->writeHTML($html);
        $this->pdf->SetY(110);
    }

    public function addHTML(string $html)
    {
        $this->pdf->SetFontSize(10);
        $data = explode("\n", $html);
        foreach ($data as $line => $value) {
            $data[$line] = trim($value);
        }
        $html = implode("\n", $data);
        $this->pdf->writeHTML($html, false, false, true, false, '');
    }

    public function output(string $filename, string $destination = 'I')
    {
        return $this->pdf->Output($filename, $destination);
    }

    public function __toString(): string
    {
        return (string) $this->pdf->Output('doc.pdf', 'S');
    }
}
