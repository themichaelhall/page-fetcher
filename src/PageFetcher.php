<?php
/**
 * This file is a part of the page-fetcher package.
 *
 * Read more at https://github.com/themichaelhall/page-fetcher
 */

declare(strict_types=1);

namespace MichaelHall\PageFetcher;

use DataTypes\Interfaces\UrlInterface;

/**
 * Page fetcher class.
 *
 * @since 1.0.0
 */
class PageFetcher
{
    /**
     * Fetches the content from an url.
     *
     * @since 1.0.0
     *
     * @param UrlInterface $url The url.
     *
     * @return int The http status code.
     */
    public function fetch(UrlInterface $url): int
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url->__toString());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);

        curl_exec($curl);
        $httpCode = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $httpCode;
    }
}
