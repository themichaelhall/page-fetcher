<?php
/**
 * This file is a part of the page-fetcher package.
 *
 * Read more at https://github.com/themichaelhall/page-fetcher
 */
declare(strict_types=1);

namespace MichaelHall\PageFetcher;

use MichaelHall\PageFetcher\Interfaces\PageFetcherInterface;
use MichaelHall\PageFetcher\Interfaces\PageFetcherRequestInterface;
use MichaelHall\PageFetcher\Interfaces\PageFetcherResponseInterface;

/**
 * Fake page fetcher class.
 *
 * @since 1.0.0
 */
class FakePageFetcher implements PageFetcherInterface
{
    /**
     * Constructs a fake page fetcher.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->responseHandler = null;
    }

    /**
     * Fetches the content from a request.
     *
     * @since 1.0.0
     *
     * @param PageFetcherRequestInterface $request The page fetcher request.
     *
     * @return PageFetcherResponseInterface The page fetcher response.
     */
    public function fetch(PageFetcherRequestInterface $request): PageFetcherResponseInterface
    {
        if ($this->responseHandler === null) {
            return new PageFetcherResponse();
        }

        return call_user_func($this->responseHandler, $request);
    }

    /**
     * Sets the response handler to use for returning a response.
     *
     * The handler must be a callable in form: function(PageFetcherRequestInterface $request): PageFetcherResponseInterface
     *
     * @since 1.0.0
     *
     * @param callable $responseHandler The response handler.
     */
    public function setResponseHandler(callable $responseHandler): void
    {
        $this->responseHandler = $responseHandler;
    }

    /**
     * @var callable|null My response handler.
     */
    private $responseHandler;
}
