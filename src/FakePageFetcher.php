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
     *
     * @param PageFetcherResultInterface $defaultResult The default result.
     */
    public function __construct(PageFetcherResultInterface $defaultResult)
    {
        $this->myDefaultResult = $defaultResult;
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
        return $this->myDefaultResult;
    }

    /**
     * @var PageFetcherResultInterface My default result.
     */
    private $myDefaultResult;
}
