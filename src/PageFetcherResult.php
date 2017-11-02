<?php
/**
 * This file is a part of the page-fetcher package.
 *
 * Read more at https://github.com/themichaelhall/page-fetcher
 */
declare(strict_types=1);

namespace MichaelHall\PageFetcher;

use MichaelHall\PageFetcher\Interfaces\PageFetcherResultInterface;

/**
 * Page fetcher result class.
 *
 * @since 1.0.0
 */
class PageFetcherResult implements PageFetcherResultInterface
{
    /**
     * PageFetcherResult constructor.
     *
     * @since 1.0.0
     *
     * @param int $httpCode The http code.
     */
    public function __construct(int $httpCode)
    {
        $this->myHttpCode = $httpCode;
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
}
