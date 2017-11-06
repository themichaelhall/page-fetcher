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
        $this->myHeaders = [];
    }

    /**
     * Adds a header.
     *
     * @since 1.0.0
     *
     * @param string $header The header.
     */
    public function addHeader(string $header): void
    {
        $this->myHeaders[] = $header;
    }

    /**
     * Returns the headers.
     *
     * @since 1.0.0
     *
     * @return string[] The headers.
     */
    public function getHeaders(): array
    {
        return $this->myHeaders;
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

    /**
     * @var string[] My headers.
     */
    private $myHeaders;
}
