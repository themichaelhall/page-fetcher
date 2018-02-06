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

    /**
     * Test getMethod method.
     */
    public function testGetMethod()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.com/foo/bar'), 'PUT');

        self::assertSame('PUT', $request->getMethod());
    }

    /**
     * Test getPostFields method.
     */
    public function testGetPostFields()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.com/foo/bar'));

        self::assertSame([], $request->getPostFields());
    }

    /**
     * Test setPostField method.
     */
    public function testSetPostField()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.com/foo/bar'));
        $request->setPostField('Foo', 'Bar');
        $request->setPostField('Baz', '');

        self::assertSame(['Foo' => 'Bar', 'Baz' => ''], $request->getPostFields());
    }
}
