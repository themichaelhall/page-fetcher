<?php
/**
 * This file is a part of the page-fetcher package.
 *
 * Read more at https://github.com/themichaelhall/page-fetcher
 */
declare(strict_types=1);

namespace MichaelHall\PageFetcher;

use DataTypes\Interfaces\UrlInterface;
use MichaelHall\PageFetcher\Interfaces\PageFetcherRequestInterface;

/**
 * Page fetcher request class.
 *
 * @since 1.0.0
 */
class PageFetcherRequest implements PageFetcherRequestInterface
{
    /**
     * Constructs a page fetcher request.
     *
     * @since 1.0.0
     *
     * @param UrlInterface $url The url.
     */
    public function __construct(UrlInterface $url)
    {
        $this->myUrl = $url;
    }

    /**
     * Returns the url.
     *
     * @since 1.0.0
     *
     * @return UrlInterface The url.
     */
    public function getUrl(): UrlInterface
    {
        return $this->myUrl;
    }

    /**
     * @var UrlInterface My url.
     */
    private $myUrl;
}
