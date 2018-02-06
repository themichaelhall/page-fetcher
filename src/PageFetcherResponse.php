<?php
/**
 * This file is a part of the page-fetcher package.
 *
 * Read more at https://github.com/themichaelhall/page-fetcher
 */
declare(strict_types=1);

namespace MichaelHall\PageFetcher;

use MichaelHall\PageFetcher\Interfaces\PageFetcherResponseInterface;

/**
 * Page fetcher response class.
 *
 * @since 1.0.0
 */
class PageFetcherResponse implements PageFetcherResponseInterface
{
    /**
     * PageFetcherResponse constructor.
     *
     * @since 1.0.0
     *
     * @param int    $httpCode The http code.
     * @param string $content  The content.
     */
    public function __construct(int $httpCode = 200, string $content = '')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->headers = [];
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
     * Returns the content.
     *
     * @since 1.0.0
     *
     * @return string The content.
     */
    public function getContent(): string
    {
        return $this->content;
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
     * Returns the http code.
     *
     * @since 1.0.0
     *
     * @return int The http code.
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * Returns true if the response is successful, false otherwise.
     *
     * @since 1.0.0
     *
     * @return bool True if the response is successful, false otherwise.
     */
    public function isSuccessful(): bool
    {
        return $this->httpCode >= 200 && $this->httpCode < 300;
    }

    /**
     * @var int My http code.
     */
    private $httpCode;

    /**
     * @var string My content.
     */
    private $content;

    /**
     * @var string[] My headers.
     */
    private $headers;
}
