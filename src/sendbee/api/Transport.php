<?php


namespace Sendbee\Api;


use GuzzleHttp\Client as HttpClient;

class Transport
{
    protected $api_key;
    protected $api_secret;

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    /**
     * Client constructor.
     * @param $api_key
     * @param $api_secret
     */
    public function __construct($api_key, $api_secret, $options = null)
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
    }


    public static function generateToken($apiSecret, $ts = 0)
    {
        $ts = $ts ?: time();

        $encrypted = hash_hmac('sha256', $ts, $apiSecret, false);

        return base64_encode($ts . '.' . $encrypted);
    }

    protected function getHttpClient()
    {
        $authToken = self::generateToken($this->api_secret);

        $client = new HttpClient([
            'base_uri' => 'https://dashboard-api-dev.sendbee.io:4010',
            'timeout' => 2.0,
            'headers' => [
                'User-Agent' => 'testing/1.0',
                "X-Auth-Token" => $authToken,
                'X-Api-Key' => $this->api_key,
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]
        ]);

        return $client;
    }

    /**
     * Does the request to Sendbee API endpoint
     *
     * @param $path
     * @param string $method
     * @param array $query
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    protected function doRequest($path, $method = self::GET, $query = [], $data = [])
    {
        $client = $this->getHttpClient();

        $response = $client->request($method, $path, ['query' => $query, 'json' => $data]);

        return $response->getBody()->getContents();
    }

    protected function extractParams($allowedKeys, $received)
    {
        return array_filter(
            $received,
            function ($key) use ($allowedKeys) {
                return in_array($key, $allowedKeys);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    protected function requireKeys($requiredKeys, $data)
    {
        // check if all required keys are present
        $missing = array_diff($requiredKeys, array_keys($data));
        if(!empty($missing))
        {
            throw new \Exception('Data is missing required keys: ' . join(', ', $missing));
        }
        return true;
    }
}