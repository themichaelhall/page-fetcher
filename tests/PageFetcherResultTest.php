<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use MichaelHall\PageFetcher\PageFetcherResult;
use PHPUnit\Framework\TestCase;

/**
 * Test PageFetcherResult class.
 */
class PageFetcherResultTest extends TestCase
{
    /**
     * Tests a standard result.
     */
    public function testStandardResult()
    {
        $result = new PageFetcherResult(200);

        self::assertSame(200, $result->getHttpCode());
    }
}
