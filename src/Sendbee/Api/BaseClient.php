<?php


namespace Sendbee\Api;


use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Sendbee\Api\Support\DataException;
use Sendbee\Api\Transport\Response;

class BaseClient
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    protected static $baseURL = 'https://api-v2.sendbee.io';
    protected static $returnRawGuzzleResponse = false;

    protected $api_key;
    protected $api_secret;


    /**
     * Client constructor.
     * @param $api_key
     * @param $api_secret
     */
    public function __construct($api_key, $api_secret)
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
    }

    /**
     * @return string
     */
    public static function getBaseURL()
    {
        return self::$baseURL;
    }

    /**
     * @param string $baseURL
     */
    public static function setBaseURL($baseURL)
    {
        self::$baseURL = $baseURL;
    }


    public static function generateToken($apiSecret, $ts = 0)
    {
        $ts = $ts ?: time();

        $encrypted = hash_hmac('sha256', $ts, $apiSecret, false);

        return base64_encode($ts . '.' . $encrypted);
    }

    public static function verifyToken($apiSecret, $token, $expiration_seconds = 0)
    {
        // sanity checks
        if(!is_string($token) || !$token)
        {
            return false;
        }

        $decoded = base64_decode($token);
        $parts = explode('.', $decoded);

        if(count($parts) != 2)
        {
            return false;
        }

        if($expiration_seconds < 1)
        {
            $expiration_seconds = 60 * 15;
        }
        // check if still valid
        if($parts[0] < (time() - $expiration_seconds))
        {
            return false;
        }

        return self::generateToken($apiSecret, $parts[0]) === $token;
    }

    /**
     * Does the request to Sendbee API endpoint
     * Throws GuzzleException in case of a connection error that got no reply from endpoint
     * (meaning backend URL is wrong or unreachable)
     *
     * @param $path
     * @param string $method - HTTP method to use
     * @param array $query - query parameters
     * @param array $data - data to be sent
     * @param string $modelClass - specify class for data
     * @return \Psr\Http\Message\ResponseInterface|Response|null
     * @throws DataException
     */
    protected function makeRequest($path, $method = self::GET, $query = [], $data = [], $modelClass = '')
    {
        $authToken = self::generateToken($this->api_secret);

        $client = new GuzzleHttpClient([
            'base_uri' => self::$baseURL,
            'timeout' => 2.0,
            'headers' => [
                'User-Agent' => 'Sendbee PHP API Client',
                "X-Auth-Token" => $authToken,
                'X-Api-Key' => $this->api_key,
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]
        ]);

        try {
            $response = $client->request($method, $path, ['query' => $query, 'json' => $data]);
            $responseContent = $response->getBody()->getContents();
            $responseStatusCode = $response->getStatusCode();
        } catch (\GuzzleHttp\Exception\RequestException $ex) {
            if ($ex->hasResponse()) {
                $response = $ex->getResponse();
                $responseContent = $response->getBody()->getContents();
                $responseStatusCode = $response->getStatusCode();
            } else {
                throw $ex;
            }
        }

        if (self::$returnRawGuzzleResponse) {
            return $response;
        }

        return new Transport\Response($responseStatusCode, $responseContent, $modelClass);
    }

    protected function filterKeys($allowedKeys, $received)
    {
        return array_filter(
            $received,
            function ($key) use ($allowedKeys) {
                return in_array($key, $allowedKeys);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * @param $requiredKeys
     * @param $data
     * @return bool
     * @throws DataException
     */
    protected function requireKeys($requiredKeys, $data)
    {
        // check if all required keys are present
        $missing = array_diff($requiredKeys, array_keys($data));
        if (!empty($missing)) {
            throw new DataException('Data is missing required keys: ' . join(', ', $missing));
        }
        return true;
    }
}