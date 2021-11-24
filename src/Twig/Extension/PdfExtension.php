<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Twig\Extension;

use T3G\Bundle\TemplateBundle\Pdf\SimplePdf;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PdfExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('inlinePdf', [$this, 'inlinePdf'], ['is_safe' => ['html']]),
        ];
    }

    public function inlinePdf(SimplePdf $pdf): string
    {
        return '<div class="inline-pdf inline-pdf-a4"><iframe src="data:application/pdf;base64,' . base64_encode((string) $pdf) . '"></iframe></div>';
    }
}
