<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Pagination;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class EntityListPaginator
{
    public const DEFAULT_PAGE_PARAMETER = 'page';
    public const OPTION_PAGE_PARAMETER = 'pageParameterName';
    public const DEFAULT_PAGE_RANGE = 5;
    public const OPTION_PAGE_RANGE = 'pageRange';
    public const OPTION_QUERY = 'query';
    public const OPTION_ROUTE = 'route';
    public const OPTION_TEMPLATE = 'template';

    private readonly Request $request;

    public function __construct(
        RequestStack $requestStack,
        private readonly string $template
    ) {
        $this->request = $requestStack->getMainRequest();
    }

    public function paginate(
        ?\T3G\DatahubApiLibrary\Entity\AbstractPaginatedList $entityList = null,
        int $limit = 10,
        int $offset = 0,
        array $options = [
            self::OPTION_PAGE_PARAMETER => self::DEFAULT_PAGE_PARAMETER,
            self::OPTION_PAGE_RANGE => self::DEFAULT_PAGE_RANGE,
        ]
    ): EntityListPagination {
        $total = null !== $entityList ? $entityList->getMeta()['totalRecordCount'] : 0;

        return new EntityListPagination(
            $offset + 1,
            null !== $entityList ? $offset + count($entityList->getData()) : null,
            $total,
            $this->request->query->getInt($options[self::OPTION_PAGE_PARAMETER] ?? self::DEFAULT_PAGE_PARAMETER, 1),
            $limit,
            $options[self::OPTION_PAGE_RANGE] ?? self::DEFAULT_PAGE_RANGE,
            $options[self::OPTION_ROUTE] ?? $this->request->attributes->get('_route'),
            $options[self::OPTION_QUERY] ?? \array_replace($this->request->query->all(), $this->request->attributes->get('_route_params', [])),
            $entityList?->getData() ?? [],
            $options,
            $options[self::OPTION_TEMPLATE] ?? $this->template
        );
    }
}
