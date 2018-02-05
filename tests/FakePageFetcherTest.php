<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use DataTypes\Url;
use MichaelHall\PageFetcher\FakePageFetcher;
use MichaelHall\PageFetcher\Interfaces\PageFetcherRequestInterface;
use MichaelHall\PageFetcher\Interfaces\PageFetcherResponseInterface;
use MichaelHall\PageFetcher\PageFetcherRequest;
use MichaelHall\PageFetcher\PageFetcherResponse;
use PHPUnit\Framework\TestCase;

/**
 * Test FakePageFetcher class.
 */
class FakePageFetcherTest extends TestCase
{
    /**
     * Test fetch a page returning the default response.
     */
    public function testDefaultResponse()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.org/'));
        $pageFetcher = new FakePageFetcher();
        $response = $pageFetcher->fetch($request);

        self::assertSame(200, $response->getHttpCode());
        self::assertSame('', $response->getContent());
    }

    /**
     * Test a basic request.
     */
    public function testBasicRequest()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.org/'));
        $pageFetcher = new FakePageFetcher();
        $pageFetcher->setResponseHandler($this->responseHandler);
        $response = $pageFetcher->fetch($request);

        self::assertSame(200, $response->getHttpCode());
        self::assertSame("Method=[GET]\nUrl=[https://example.org/]\nHeaders=[]", $response->getContent());
    }

    /**
     * Test a not found request.
     */
    public function testNotFoundRequest()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.org/notfound'));
        $pageFetcher = new FakePageFetcher();
        $pageFetcher->setResponseHandler($this->responseHandler);
        $response = $pageFetcher->fetch($request);

        self::assertSame(404, $response->getHttpCode());
        self::assertSame("Method=[GET]\nUrl=[https://example.org/notfound]\nHeaders=[]", $response->getContent());
    }

    /**
     * Test a POST request.
     */
    public function testPostRequest()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.org/'), 'POST');
        $pageFetcher = new FakePageFetcher();
        $pageFetcher->setResponseHandler($this->responseHandler);
        $response = $pageFetcher->fetch($request);

        self::assertSame(200, $response->getHttpCode());
        self::assertSame("Method=[POST]\nUrl=[https://example.org/]\nHeaders=[]", $response->getContent());
    }

    /**
     * Set up.
     */
    protected function setUp()
    {
        $this->responseHandler = function (PageFetcherRequestInterface $request): PageFetcherResponseInterface {
            return self::responseHandler($request);
        };
    }

    /**
     * My response handler.
     *
     * @param PageFetcherRequestInterface $request The request.
     *
     * @return PageFetcherResponseInterface The response.
     */
    private static function responseHandler(PageFetcherRequestInterface $request): PageFetcherResponseInterface
    {
        $httpCode = 200;

        if ($request->getUrl()->getPath()->__toString() === '/notfound') {
            $httpCode = 404;
        }

        $content = [
            'Method=[' . $request->getMethod() . ']',
            'Url=[' . $request->getUrl() . ']',
            'Headers=[' . implode('|', $request->getHeaders()) . ']',
        ];

        return new PageFetcherResponse($httpCode, implode("\n", $content));
    }

    /**
     * @var callable My response handler.
     */
    private $responseHandler;
}
