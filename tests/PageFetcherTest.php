<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use DataTypes\Url;
use MichaelHall\PageFetcher\PageFetcher;
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
        $result = $pageFetcher->fetch(Url::parse('https://httpbin.org/'));

        self::assertSame(200, $result->getHttpCode());
    }
}
