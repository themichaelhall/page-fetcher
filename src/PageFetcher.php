<?php
/**
 * This file is a part of the page-fetcher package.
 *
 * Read more at https://github.com/themichaelhall/page-fetcher
 */
declare(strict_types=1);

namespace MichaelHall\PageFetcher;

use MichaelHall\PageFetcher\Interfaces\PageFetcherInterface;
use MichaelHall\PageFetcher\Interfaces\PageFetcherRequestInterface;
use MichaelHall\PageFetcher\Interfaces\PageFetcherResponseInterface;

/**
 * Page fetcher class.
 *
 * @since 1.0.0
 */
class PageFetcher implements PageFetcherInterface
{
    /**
     * Fetches the content from a request.
     *
     * @since 1.0.0
     *
     * @param PageFetcherRequestInterface $request The page fetcher request.
     *
     * @return PageFetcherResponseInterface The page fetcher response.
     */
    public function fetch(PageFetcherRequestInterface $request): PageFetcherResponseInterface
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $request->getUrl()->__toString());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request->getHeaders());

        $postFields = $request->getPostFields();
        if (count($postFields) > 0) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postFields));
        }

        $result = curl_exec($curl);
        if ($result === false) {
            $error = curl_error($curl);
            curl_close($curl);

            return new PageFetcherResponse(0, $error);
        }
        curl_close($curl);

        return $this->parseResult($result);
    }

    /**
     * Parses the CURL result into a PageFetcherResponse.
     *
     * @param string $result The CURL result.
     *
     * @return PageFetcherResponseInterface The PageFetcherResponse.
     */
    private function parseResult(string $result): PageFetcherResponseInterface
    {
        $resultParts = explode("\r\n\r\n", $result, 2);

        $headers = explode("\r\n", $resultParts[0]);
        $statusLine = array_shift($headers);
        $statusLineParts = explode(' ', $statusLine);
        $httpCode = intval($statusLineParts[1]);
        $content = count($resultParts) > 1 ? $resultParts[1] : '';

        $response = new PageFetcherResponse($httpCode, $content);
        foreach ($headers as $header) {
            $response->addHeader(trim($header));
        }

        return $response;
    }
}
