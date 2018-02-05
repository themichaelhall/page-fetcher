<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use MichaelHall\PageFetcher\PageFetcherResponse;
use PHPUnit\Framework\TestCase;

/**
 * Test PageFetcherResponse class.
 */
class PageFetcherResponseTest extends TestCase
{
    /**
     * Test default response.
     */
    public function testDefaultResponse()
    {
        $response = new PageFetcherResponse();

        self::assertSame(200, $response->getHttpCode());
        self::assertSame('', $response->getContent());
        self::assertTrue($response->isSuccessful());
    }

    /**
     * Test custom response.
     */
    public function testCustomResponse()
    {
        $response = new PageFetcherResponse(404, 'Page was not found.');

        self::assertSame(404, $response->getHttpCode());
        self::assertSame('Page was not found.', $response->getContent());
        self::assertFalse($response->isSuccessful());
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
        $response = new PageFetcherResponse($httpCode);

        self::assertSame($expectedIsSuccessful, $response->isSuccessful());
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
