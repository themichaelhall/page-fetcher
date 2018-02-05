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
     * Test fetching a page with 200 OK response.
     */
    public function testOkResponse()
    {
        $pageFetcher = new PageFetcher();
        $request = new PageFetcherRequest(Url::parse('https://httpbin.org/anything'));
        $request->addHeader('X-Test-Header: Foo Bar');
        $response = $pageFetcher->fetch($request);
        $jsonContent = json_decode($response->getContent(), true);

        self::assertSame(200, $response->getHttpCode());
        self::assertSame('GET', $jsonContent['method']);
        self::assertSame('Foo Bar', $jsonContent['headers']['X-Test-Header']);
        self::assertTrue($response->isSuccessful());
    }

    /**
     * Test fetching a page with failed connection.
     */
    public function testFailedConnectionResponse()
    {
        $pageFetcher = new PageFetcher();
        $request = new PageFetcherRequest(Url::parse('https://localhost:123/'));
        $response = $pageFetcher->fetch($request);

        self::assertSame(0, $response->getHttpCode());
        self::assertSame('Failed to connect to localhost port 123: Connection refused', $response->getContent());
        self::assertFalse($response->isSuccessful());
    }

    /**
     * Test fetching a page with 404 Not Found response.
     */
    public function testNotFoundResponse()
    {
        $pageFetcher = new PageFetcher();
        $request = new PageFetcherRequest(Url::parse('https://httpbin.org/status/404'));
        $response = $pageFetcher->fetch($request);

        self::assertSame(404, $response->getHttpCode());
        self::assertSame('', $response->getContent());
        self::assertFalse($response->isSuccessful());
    }

    /**
     * Test a POST request.
     */
    public function testPostRequest()
    {
        $pageFetcher = new PageFetcher();
        $request = new PageFetcherRequest(Url::parse('https://httpbin.org/anything'), 'POST');
        $response = $pageFetcher->fetch($request);
        $jsonContent = json_decode($response->getContent(), true);

        self::assertSame(200, $response->getHttpCode());
        self::assertSame('POST', $jsonContent['method']);
        self::assertTrue($response->isSuccessful());
    }
}
