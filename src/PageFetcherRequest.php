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
     * @param UrlInterface $url    The url.
     * @param string       $method The method.
     */
    public function __construct(UrlInterface $url, string $method = 'GET')
    {
        $this->url = $url;
        $this->method = $method;
        $this->headers = [];
        $this->postFields = [];
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
        $this->headers[] = $header;
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
        return $this->headers;
    }

    /**
     * Returns the method.
     *
     * @since 1.0.0
     *
     * @return string The method.
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns the post fields.
     *
     * @since 1.0.0
     *
     * @return array The post fields.
     */
    public function getPostFields(): array
    {
        return $this->postFields;
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
        return $this->url;
    }

    /**
     * Sets a post field.
     *
     * @since 1.0.0
     *
     * @param string $name  The name.
     * @param string $value The value.
     */
    public function setPostField(string $name, string $value): void
    {
        $this->postFields[$name] = $value;
    }

    /**
     * @var UrlInterface My url.
     */
    private $url;

    /**
     * @var string My method.
     */
    private $method;

    /**
     * @var string[] My headers.
     */
    private $headers;

    /**
     * @var array My post fields.
     */
    private $postFields;
}
