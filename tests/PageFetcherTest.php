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
        $request = new PageFetcherRequest(Url::parse('https://httpbin.org/anything'));
        $request->addHeader('X-Test-Header: Foo Bar');
        $result = $pageFetcher->fetch($request);
        $jsonContent = json_decode($result->getContent(), true);

        self::assertSame(200, $result->getHttpCode());
        self::assertSame('GET', $jsonContent['method']);
        self::assertSame('Foo Bar', $jsonContent['headers']['X-Test-Header']);

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
        self::assertSame('Failed to connect to localhost port 123: Connection refused', $result->getContent());
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
        self::assertSame('', $result->getContent());
        self::assertFalse($result->isSuccessful());
    }
}
