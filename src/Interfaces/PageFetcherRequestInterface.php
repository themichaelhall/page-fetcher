<?php
/**
 * This file is a part of the page-fetcher package.
 *
 * Read more at https://github.com/themichaelhall/page-fetcher
 */
declare(strict_types=1);

namespace MichaelHall\PageFetcher\Interfaces;

use DataTypes\Interfaces\UrlInterface;

/**
 * Interface for PageFetcherRequest class.
 *
 * @since 1.0.0
 */
interface PageFetcherRequestInterface
{
    /**
     * Returns the url.
     *
     * @since 1.0.0
     *
     * @return UrlInterface The url.
     */
    public function getUrl(): UrlInterface;
}
