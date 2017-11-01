<?php
/**
 * This file is a part of the page-fetcher package.
 *
 * Read more at https://github.com/themichaelhall/page-fetcher
 */
declare(strict_types=1);

namespace MichaelHall\PageFetcher\Interfaces;

/**
 * Interface for PageFetcher class.
 *
 * @since 1.0.0
 */
interface PageFetcherInterface
{
    /**
     * Fetches the content from a request.
     *
     * @since 1.0.0
     *
     * @param PageFetcherRequestInterface $request The page fetcher request.
     *
     * @return PageFetcherResultInterface The page fetcher result.
     */
    public function fetch(PageFetcherRequestInterface $request): PageFetcherResultInterface;
}
