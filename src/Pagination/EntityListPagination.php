<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Pagination;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use Knp\Component\Pager\Pagination\AbstractPagination;

class EntityListPagination extends AbstractPagination implements SlidingPaginationInterface
{
    private readonly int $pages;

    public function __construct(
        private readonly ?int $first = null,
        private readonly ?int $last = null,
        private readonly int $total = 0,
        private readonly int $current = 1,
        protected ?int $numItemsPerPage = null,
        private int $pageRange = 5,
        private readonly ?string $route = null,
        private readonly array $query = [],
        protected iterable $items = [],
        protected ?array $paginatorOptions = null,
        private readonly string $template = '@Template/pagination/pagination.html.twig'
    ) {
        $this->pages = (int) ceil($total / ($numItemsPerPage ?? 1));
    }

    public function getPagesInRange(): array
    {
        return range(1, $this->pages);
    }

    public function getFirst(): ?int
    {
        return $this->first;
    }

    public function getLast(): ?int
    {
        return $this->last;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function getCurrent(): int
    {
        return $this->current;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    // methods required to use knp_pagination_render() in twig templates

    public function getTemplate(): string
    {
        return $this->template;
    }

    #[\Override]
    public function getParams(): array
    {
        return $this->query;
    }

    #[\Override]
    public function isSorted($key = null, array $params = []): bool
    {
        // @TODO: implement a sorting option
        return false;
    }

    #[\Override]
    public function getPaginationData(): array
    {
        $pageCount = $this->getPages();
        $current = $this->getCurrent();

        if ($pageCount < $current) {
            $current = $pageCount;
        }

        if ($this->pageRange > $pageCount) {
            $this->pageRange = $pageCount;
        }

        $delta = \ceil($this->pageRange / 2);

        if ($current - $delta > $pageCount - $this->pageRange) {
            $pages = \range($pageCount - $this->pageRange + 1, $pageCount);
        } else {
            if ($current - $delta < 0) {
                $delta = $current;
            }

            $offset = $current - $delta;
            $pages = \range($offset + 1, $offset + $this->pageRange);
        }

        $proximity = \floor($this->pageRange / 2);

        $startPage = $current - $proximity;
        $endPage = $current + $proximity;

        if ($startPage < 1) {
            $endPage = \min($endPage + (1 - $startPage), $pageCount);
            $startPage = 1;
        }

        if ($endPage > $pageCount) {
            $startPage = \max($startPage - ($endPage - $pageCount), 1);
            $endPage = $pageCount;
        }

        $viewData = [
            'last' => $pageCount,
            'current' => $current,
            'numItemsPerPage' => $this->numItemsPerPage,
            'first' => 1,
            'pageCount' => $pageCount,
            'totalCount' => $this->getTotal(),
            'pageRange' => $this->pageRange,
            'startPage' => $startPage,
            'endPage' => $endPage,
        ];

        if ($current > 1) {
            $viewData['previous'] = $current - 1;
        }

        if ($current < $pageCount) {
            $viewData['next'] = $current + 1;
        }

        $viewData['pagesInRange'] = $pages;
        $viewData['firstPageInRange'] = \min($pages);
        $viewData['lastPageInRange'] = \max($pages);

        if (null !== $this->getItems()) {
            $viewData['currentItemCount'] = $this->count();
            $viewData['firstItemNumber'] = 0;
            $viewData['lastItemNumber'] = 0;
            if ($viewData['totalCount'] > 0) {
                $viewData['firstItemNumber'] = (($current - 1) * $this->numItemsPerPage) + 1;
                $viewData['lastItemNumber'] = $viewData['firstItemNumber'] + $viewData['currentItemCount'] - 1;
            }
        }

        return $viewData;
    }

    #[\Override]
    public function getPaginatorOptions(): ?array
    {
        return $this->paginatorOptions;
    }

    #[\Override]
    public function getCustomParameters(): ?array
    {
        return $this->customParameters;
    }
}
