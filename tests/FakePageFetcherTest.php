<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use DataTypes\Url;
use MichaelHall\PageFetcher\FakePageFetcher;
use MichaelHall\PageFetcher\Interfaces\PageFetcherRequestInterface;
use MichaelHall\PageFetcher\Interfaces\PageFetcherResultInterface;
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
        $pageFetcher = new FakePageFetcher();
        $result = $pageFetcher->fetch($request);

        self::assertSame(200, $result->getHttpCode());
        self::assertSame('', $result->getContent());
    }

    /**
     * Test a basic request.
     */
    public function testBasicRequest()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.org/'));
        $pageFetcher = new FakePageFetcher();
        $pageFetcher->setResultHandler($this->resultHandler);
        $result = $pageFetcher->fetch($request);

        self::assertSame(200, $result->getHttpCode());
        self::assertSame("Method=[GET]\nUrl=[https://example.org/]\nHeaders=[]", $result->getContent());
    }

    /**
     * Test a not found request.
     */
    public function testNotFoundRequest()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.org/notfound'));
        $pageFetcher = new FakePageFetcher();
        $pageFetcher->setResultHandler($this->resultHandler);
        $result = $pageFetcher->fetch($request);

        self::assertSame(404, $result->getHttpCode());
        self::assertSame("Method=[GET]\nUrl=[https://example.org/notfound]\nHeaders=[]", $result->getContent());
    }

    /**
     * Set up.
     */
    protected function setUp()
    {
        $this->resultHandler = function (PageFetcherRequestInterface $request): PageFetcherResultInterface {
            return self::resultHandler($request);
        };
    }

    /**
     * My result handler.
     *
     * @param PageFetcherRequestInterface $request The request.
     *
     * @return PageFetcherResultInterface The response.
     */
    private static function resultHandler(PageFetcherRequestInterface $request): PageFetcherResultInterface
    {
        $resultCode = 200;

        if ($request->getUrl()->getPath()->__toString() === '/notfound') {
            $resultCode = 404;
        }

        $content = [
            'Method=[GET]',
            'Url=[' . $request->getUrl() . ']',
            'Headers=[' . implode('|', $request->getHeaders()) . ']',
        ];

        return new PageFetcherResult($resultCode, implode("\n", $content));
    }

    /**
     * @var callable My result handler.
     */
    private $resultHandler;
}
