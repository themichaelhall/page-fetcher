<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use MichaelHall\PageFetcher\PageFetcherResult;
use PHPUnit\Framework\TestCase;

/**
 * Test PageFetcherResult class.
 */
class PageFetcherResultTest extends TestCase
{
    /**
     * Test default result.
     */
    public function testDefaultResult()
    {
        $result = new PageFetcherResult();

        self::assertSame(200, $result->getHttpCode());
        self::assertSame('', $result->getContent());
        self::assertTrue($result->isSuccessful());
    }

    /**
     * Test custom result.
     */
    public function testCustomResult()
    {
        $result = new PageFetcherResult(404, 'Page was not found.');

        self::assertSame(404, $result->getHttpCode());
        self::assertSame('Page was not found.', $result->getContent());
        self::assertFalse($result->isSuccessful());
    }

    /**
     * Test isSuccessful method.
     *
     * @dataProvider isSuccessfulDataProvider
     *
     * @param int  $httpCode             The http code.
     * @param bool $expectedIsSuccessful The expected result from isSuccessful method.
     */
    public function testIsSuccessful(int $httpCode, bool $expectedIsSuccessful)
    {
        $result = new PageFetcherResult($httpCode);

        self::assertSame($expectedIsSuccessful, $result->isSuccessful());
    }

    /**
     * Data provider for isSuccessful tests.
     *
     * @return array The data.
     */
    public function isSuccessfulDataProvider(): array
    {
        return [
            [0, false],
            [100, false],
            [199, false],
            [200, true],
            [299, true],
            [300, false],
            [400, false],
            [500, false],
        ];
    }
}
