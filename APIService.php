<?php

namespace App;

use Http; // Laravel HTTP client
use Illuminate\Http\Client\RequestException; // Exception for HTTP request errors
use Illuminate\Http\Response; // HTTP response object
use SimplePie; // RSS feed parser (not used in this snippet but included)

/**
 * Class APIService
 * 
 * Handles interactions with the Ransomware.live API and RSS feed.
 * Provides methods to fetch ransomware attack data by country.
 */
class APIService
{
    /**
     * Base URL for the Ransomware.live API
     * 
     * @var string
     */
    public string $base_url = "https://api.ransomware.live/v2/";

    /**
     * URL for the RSS feed of ransomware reports
     * 
     * @var string
     */
    public string $rssfeed_url = "https://ransomware.live/rss.xml";

    /**
     * APIService constructor.
     * Currently does not initialize any properties, but kept for future expansion.
     */
    public function __construct()
    {
        //
    }

    /**
     * Fetch ransomware attacks filtered by country code.
     * 
     * Makes an HTTP GET request to the endpoint `countrycyberattacks/{countryCode}`.
     * Handles client-side errors and returns the parsed JSON response as an associative array.
     * 
     * @param string $countryCode ISO country code to filter attacks, e.g. "US", "FR"
     * @return array|string Returns array of attacks on success, or error message string on failure.
     */
    public function getAttacks(string $countryCode)
    {
        // Build the full API endpoint URL
        $endpoint = $this->base_url . "countrycyberattacks/" . $countryCode;

        // Make the HTTP GET request
        $response = Http::get($endpoint);

        // Handle client-side errors (HTTP status code 4xx)
        if ($response->clientError()) {
            $error = $response->json(); // Decode the error response
            dump($error); // Debug output
            return 'Client-side error occurred';
        }

        // Decode JSON response body to associative array
        $data = json_decode($response->getBody(), true);

        // Return the decoded data
        return $data;
    }
}
