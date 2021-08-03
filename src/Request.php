<?php


namespace makehui\iflytek;


trait Request
{

    protected $client;

    private $headers = ['Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'];

    /**
     * @param $uri
     * @param array $body
     * @param array $headers
     * @return array
     */
    public function post($uri, array $body = [], array $headers = [])
    {
        $headers = array_merge($this->headers, $headers);

        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        ob_get_clean();

        return ['http_code' => $httpCode, 'response' => $response];
    }

}