<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use DataTypes\Url;
use MichaelHall\PageFetcher\PageFetcherRequest;
use PHPUnit\Framework\TestCase;

/**
 * Test PageFetcherRequest class.
 */
class PageFetcherRequestTest extends TestCase
{
    /**
     * Tests a standard request.
     */
    public function testStandardRequest()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.com/foo/bar'));

        self::assertSame('https://example.com/foo/bar', $request->getUrl()->__toString());
    }

    /**
     * Test getHeaders method.
     */
    public function testGetHeaders()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.com/foo/bar'));

        self::assertSame([], $request->getHeaders());
    }

    /**
     * Test addHeaders method.
     */
    public function testAddHeader()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.com/foo/bar'));
        $request->addHeader('X-Test-Foo: Foo Header');
        $request->addHeader('X-Test-Bar: Bar Header');

        self::assertSame(['X-Test-Foo: Foo Header', 'X-Test-Bar: Bar Header'], $request->getHeaders());
    }
}
