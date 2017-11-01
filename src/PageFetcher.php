<?php
/**
 * This file is a part of the page-fetcher package.
 *
 * Read more at https://github.com/themichaelhall/page-fetcher
 */
declare(strict_types=1);

namespace MichaelHall\PageFetcher;

use MichaelHall\PageFetcher\Interfaces\PageFetcherRequestInterface;
use MichaelHall\PageFetcher\Interfaces\PageFetcherResultInterface;

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
     * @param PageFetcherRequestInterface $request The page fetcher request.
     *
     * @return PageFetcherResultInterface The page fetcher result.
     */
    public function fetch(PageFetcherRequestInterface $request): PageFetcherResultInterface
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $request->getUrl()->__toString());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);

        $result = curl_exec($curl);
        if ($result === false) {
            return new PageFetcherResult(0);
        }

        $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return new PageFetcherResult($httpCode);
    }
}
