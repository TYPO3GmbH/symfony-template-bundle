<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Tests\Unit\Pagination;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use T3G\Bundle\TemplateBundle\Pagination\EntityListPaginator;
use T3G\DatahubApiLibrary\Entity\AbstractPaginatedList;

class EntityListPaginatorTest extends TestCase
{
    /**
     * @dataProvider paginateDataProvider
     */
    public function testPaginate(AbstractPaginatedList $list, int $limit, int $offset, array $options, int $expectedTotal, int $expectedPage, ?int $expectedItemCount = null): void
    {
        $paginator = self::createPaginator($options[EntityListPaginator::OPTION_QUERY] ?? []);
        $pagination = $paginator->paginate($list, $limit, $offset, $options);

        if (null !== $expectedItemCount) {
            self::assertCount($expectedItemCount, $pagination->getItems());
        } else {
            self::assertCount($limit, $pagination->getItems());
        }

        self::assertSame($expectedTotal, $pagination->getTotal());
        self::assertSame($expectedPage, $pagination->getCurrent());

        if (isset($options[EntityListPaginator::OPTION_QUERY])) {
            self::assertSame($options[EntityListPaginator::OPTION_QUERY], $pagination->getQuery());
        }
        if (isset($options[EntityListPaginator::OPTION_ROUTE])) {
            self::assertSame($options[EntityListPaginator::OPTION_ROUTE], $pagination->getRoute());
        }
        if (isset($options[EntityListPaginator::OPTION_TEMPLATE])) {
            self::assertSame($options[EntityListPaginator::OPTION_TEMPLATE], $pagination->getTemplate());
        }
    }

    private static function createPaginator(array $query = []): EntityListPaginator
    {
        $request = new Request($query);
        $requestStack = new RequestStack();
        $requestStack->push($request);

        return new EntityListPaginator(
            $requestStack,
            'injected-template.html.twig'
        );
    }

    private static function createPaginatedList(int $totalRecordCount, int $itemsOnPage): AbstractPaginatedList
    {
        $data = [];
        for ($i = 0; $i < $itemsOnPage; $i++) {
            $object = new \stdClass();
            $object->id = $i + 1;
            $data[$i] = $object;
        }

        return new class(['totalRecordCount' => $totalRecordCount], [], $data) extends AbstractPaginatedList {
            public function getData(): array
            {
                return $this->data;
            }
        };
    }

    public static function paginateDataProvider(): array
    {
        return [
            'paginated' => [
                'list' => self::createPaginatedList(120, 10),
                'limit' => 10,
                'offset' => 20,
                'options' => [
                    EntityListPaginator::OPTION_QUERY => ['page' => 3],
                ],
                'expectedTotal' => 120,
                'expectedPage' => 3,
                'expectedItemCount' => null,
            ],
            'paginated (last page)' => [
                'list' => self::createPaginatedList(115, 5),
                'limit' => 10,
                'offset' => 110,
                'options' => [
                    EntityListPaginator::OPTION_QUERY => ['page' => 12],
                ],
                'expectedTotal' => 115,
                'expectedPage' => 12,
                'expectedItemCount' => 5,
            ],
            'full options' => [
                'list' => self::createPaginatedList(120, 10),
                'limit' => 10,
                'offset' => 0,
                'options' => [
                    EntityListPaginator::OPTION_PAGE_PARAMETER => 'customPageParameter',
                    EntityListPaginator::OPTION_QUERY => ['customPageParameter' => 0],
                    EntityListPaginator::OPTION_ROUTE => 'custom_route',
                    EntityListPaginator::OPTION_TEMPLATE => 'custom-template.html.twig',
                ],
                'expectedTotal' => 120,
                'expectedPage' => 0,
                'expectedItemCount' => null,
            ],
        ];
    }
}
