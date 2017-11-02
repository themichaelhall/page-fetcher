<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use DataTypes\Url;
use MichaelHall\PageFetcher\PageFetcher;
use MichaelHall\PageFetcher\PageFetcherRequest;
use PHPUnit\Framework\TestCase;

/**
 * Test page fetcher class.
 */
class PageFetcherTest extends TestCase
{
    /**
     * Test fetching a page with 200 OK result.
     */
    public function testOkResult()
    {
        $pageFetcher = new PageFetcher();
        $request = new PageFetcherRequest(Url::parse('https://httpbin.org/'));
        $result = $pageFetcher->fetch($request);

        self::assertSame(200, $result->getHttpCode());
        self::assertTrue($result->isSuccessful());
    }

    /**
     * Test fetching a page with failed connection.
     */
    public function testFailedConnectionResult()
    {
        $pageFetcher = new PageFetcher();
        $request = new PageFetcherRequest(Url::parse('https://localhost:123/'));
        $result = $pageFetcher->fetch($request);

        self::assertSame(0, $result->getHttpCode());
        self::assertFalse($result->isSuccessful());
    }

    /**
     * Test fetching a page with 404 Not Found result.
     */
    public function testNotFoundResult()
    {
        $pageFetcher = new PageFetcher();
        $request = new PageFetcherRequest(Url::parse('https://httpbin.org/status/404'));
        $result = $pageFetcher->fetch($request);

        self::assertSame(404, $result->getHttpCode());
        self::assertFalse($result->isSuccessful());
    }
}
