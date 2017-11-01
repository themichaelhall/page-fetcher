<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use DataTypes\Url;
use MichaelHall\PageFetcher\FakePageFetcher;
use MichaelHall\PageFetcher\PageFetcherRequest;
use MichaelHall\PageFetcher\PageFetcherResult;
use PHPUnit\Framework\TestCase;

/**
 * Test FakePageFetcher class.
 */
class FakePageFetcherTest extends TestCase
{
    /**
     * Test fetch a page returning the default result.
     */
    public function testDefaultResult()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.org/'));
        $result = new PageFetcherResult(200);
        $pageFetcher = new FakePageFetcher($result);

        self::assertSame($result, $pageFetcher->fetch($request));
    }
}
