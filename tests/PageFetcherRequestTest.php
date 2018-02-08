<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use DataTypes\FilePath;
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

    /**
     * Test getFiles method.
     */
    public function testGetFiles()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.com/foo/bar'));

        self::assertSame([], $request->getFiles());
    }

    /**
     * Test setFile method.
     */
    public function testSetFile()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.com/foo/bar'));
        $filePath1 = FilePath::parse('/tmp/file1');
        $filePath2 = FilePath::parse('/tmp/file1');
        $request->setFile('Foo', $filePath1);
        $request->setFile('Bar', $filePath2);

        self::assertSame(['Foo' => $filePath1, 'Bar' => $filePath2], $request->getFiles());
    }
}
