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
use MichaelHall\PageFetcher\Interfaces\PageFetcherResultInterface;

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
        $this->resultHandler = null;
    }

    /**
     * Fetches the content from a request.
     *
     * @since 1.0.0
     *
     * @param PageFetcherRequestInterface $request The page fetcher request.
     *
     * @return PageFetcherResultInterface The page fetcher result.
     */
    public function fetch(PageFetcherRequestInterface $request): PageFetcherResultInterface
    {
        if ($this->resultHandler === null) {
            return new PageFetcherResult();
        }

        return call_user_func($this->resultHandler, $request);
    }

    /**
     * Sets the result handler to use for returning a result.
     *
     * The handler must be a callable in form: function(PageFetcherRequestInterface $request): PageFetcherResultInterface
     *
     * @since 1.0.0
     *
     * @param callable $resultHandler The result handler.
     */
    public function setResultHandler(callable $resultHandler): void
    {
        $this->resultHandler = $resultHandler;
    }

    /**
     * @var callable|null My result handler.
     */
    private $resultHandler;
}
