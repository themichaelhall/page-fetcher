<?php
/**
 * This file is a part of the page-fetcher package.
 *
 * Read more at https://github.com/themichaelhall/page-fetcher
 */
declare(strict_types=1);

namespace MichaelHall\PageFetcher\Interfaces;

/**
 * Interface for PageFetcherResponse.
 *
 * @since 1.0.0
 */
interface PageFetcherResponseInterface
{
    /**
     * Adds a header.
     *
     * @since 1.0.0
     *
     * @param string $header The header.
     */
    public function addHeader(string $header): void;

    /**
     * Returns the content.
     *
     * @since 1.0.0
     *
     * @return string The content.
     */
    public function getContent(): string;

    /**
     * Returns the headers.
     *
     * @since 1.0.0
     *
     * @return string[] The headers.
     */
    public function getHeaders(): array;

    /**
     * Returns the http code.
     *
     * @since 1.0.0
     *
     * @return int The http code.
     */
    public function getHttpCode(): int;

    /**
     * Returns true if the response is successful, false otherwise.
     *
     * @since 1.0.0
     *
     * @return bool True if the response is successful, false otherwise.
     */
    public function isSuccessful(): bool;
}
