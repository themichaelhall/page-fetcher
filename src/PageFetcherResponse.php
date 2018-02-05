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
        $this->myHttpCode = $httpCode;
        $this->myContent = $content;
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
        return $this->myContent;
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
        return $this->myHttpCode;
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
        return $this->myHttpCode >= 200 && $this->myHttpCode < 300;
    }

    /**
     * @var int My http code.
     */
    private $myHttpCode;

    /**
     * @var string My content.
     */
    private $myContent;
}
