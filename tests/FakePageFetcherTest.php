<?php

declare(strict_types=1);

namespace MichaelHall\PageFetcher\Tests;

use DataTypes\FilePath;
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
        self::assertSame([], $response->getHeaders());
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
        self::assertSame(['X-Request-Url: https://example.org/'], $response->getHeaders());
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
        self::assertSame(['X-Request-Url: https://example.org/notfound'], $response->getHeaders());
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
        self::assertSame(['X-Request-Url: https://example.org/'], $response->getHeaders());
    }

    /**
     * Test a POST request with post fields.
     */
    public function testPostRequestWithPostFields()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.org/'), 'POST');
        $request->setPostField('Foo', 'Bar');
        $request->setPostField('Baz', '');
        $pageFetcher = new FakePageFetcher();
        $pageFetcher->setResponseHandler($this->responseHandler);
        $response = $pageFetcher->fetch($request);

        self::assertSame(200, $response->getHttpCode());
        self::assertSame("Method=[POST]\nUrl=[https://example.org/]\nHeaders=[]\nPost[Foo]=[Bar]\nPost[Baz]=[]", $response->getContent());
        self::assertSame(['X-Request-Url: https://example.org/'], $response->getHeaders());
    }

    /**
     * Test a POST request with files.
     */
    public function testPostRequestWithFiles()
    {
        $request = new PageFetcherRequest(Url::parse('https://example.org/'), 'POST');
        $filePath1 = FilePath::parse('/tmp/file1.txt');
        $filePath2 = FilePath::parse('/tmp/file2.txt');
        $request->setFile('Foo', $filePath1);
        $request->setFile('Baz', $filePath2);
        $pageFetcher = new FakePageFetcher();
        $pageFetcher->setResponseHandler($this->responseHandler);
        $response = $pageFetcher->fetch($request);

        self::assertSame(200, $response->getHttpCode());
        self::assertSame("Method=[POST]\nUrl=[https://example.org/]\nHeaders=[]\nFile[Foo]=[$filePath1]\nFile[Baz]=[$filePath2]", $response->getContent());
        self::assertSame(['X-Request-Url: https://example.org/'], $response->getHeaders());
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

        foreach ($request->getPostFields() as $name => $value) {
            $content[] = 'Post[' . $name . ']=[' . $value . ']';
        }

        foreach ($request->getFiles() as $name => $path) {
            $content[] = 'File[' . $name . ']=[' . $path . ']';
        }

        $response = new PageFetcherResponse($httpCode, implode("\n", $content));
        $response->addHeader('X-Request-Url: ' . $request->getUrl());

        return $response;
    }

    /**
     * @var callable My response handler.
     */
    private $responseHandler;
}
