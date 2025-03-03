<?php

declare(strict_types=1);

namespace T3G\Bundle\TemplateBundle\Tests\Unit\Pagination;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use T3G\Bundle\TemplateBundle\Pagination\EntityListPagination;
use T3G\Bundle\TemplateBundle\Pagination\EntityListPaginator;
use T3G\DatahubApiLibrary\Entity\AbstractPaginatedList;

class EntityListPaginationTest extends TestCase
{
    /**
     * @dataProvider getPaginationDataDataProvider
     */
    public function testGetPaginationData(array $parameters, array $expectation): void
    {
        $pagination = new EntityListPagination(...$parameters);

        self::assertSame($expectation, $pagination->getPaginationData());
    }

    public static function getPaginationDataDataProvider(): array
    {
        return [
            'first page' => [
                'parameters' => [
                    1,
                    10,
                    120,
                    1,
                    10,
                    5,
                    'route',
                    ['page' => 1],
                    [new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass()],
                    []
                ],
                'expectation' => [
                    'last' => 12,
                    'current' => 1,
                    'numItemsPerPage' => 10,
                    'first' => 1,
                    'pageCount' => 12,
                    'totalCount' => 120,
                    'pageRange' => 5,
                    'startPage' => 1,
                    'endPage' => 5,
                    'next' => 2,
                    'pagesInRange' => [1, 2, 3, 4, 5],
                    'firstPageInRange' => 1,
                    'lastPageInRange' => 5,
                    'currentItemCount' => 10,
                    'firstItemNumber' => 1,
                    'lastItemNumber' => 10,
                ],
            ],
            'middle page' => [
                'parameters' => [
                    30,
                    40,
                    120,
                    3,
                    10,
                    5,
                    'route',
                    ['page' => 3],
                    [new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass()],
                    []
                ],
                'expectation' => [
                    'last' => 12,
                    'current' => 3,
                    'numItemsPerPage' => 10,
                    'first' => 1,
                    'pageCount' => 12,
                    'totalCount' => 120,
                    'pageRange' => 5,
                    'startPage' => 1,
                    'endPage' => 5,
                    'previous' => 2,
                    'next' => 4,
                    'pagesInRange' => [1, 2, 3, 4, 5],
                    'firstPageInRange' => 1,
                    'lastPageInRange' => 5,
                    'currentItemCount' => 10,
                    'firstItemNumber' => 21,
                    'lastItemNumber' => 30,
                ],
            ],
            'last page' => [
                'parameters' => [
                    30,
                    34,
                    34,
                    4,
                    10,
                    5,
                    'route',
                    ['page' => 3],
                    [new \stdClass(), new \stdClass(), new \stdClass(), new \stdClass()],
                    []
                ],
                'expectation' => [
                    'last' => 4,
                    'current' => 4,
                    'numItemsPerPage' => 10,
                    'first' => 1,
                    'pageCount' => 4,
                    'totalCount' => 34,
                    'pageRange' => 4,
                    'startPage' => 1,
                    'endPage' => 4,
                    'previous' => 3,
                    'pagesInRange' => [1, 2, 3, 4],
                    'firstPageInRange' => 1,
                    'lastPageInRange' => 4,
                    'currentItemCount' => 4,
                    'firstItemNumber' => 31,
                    'lastItemNumber' => 34,
                ],
            ],
        ];
    }
}
