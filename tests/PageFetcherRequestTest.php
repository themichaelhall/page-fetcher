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
}
