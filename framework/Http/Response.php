<?php

/**
 * @copyright 2021 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Framework\Http;

/**
 * Send HTTP responses
 */
class Response
{
    /**
     * send HTTP headers only
     *
     * @param  array $headers
     * @param  int $status_code
     * @return void
     */
    public function headers(array $headers, int $status_code = 200): void
    {
        //send response status code
        http_response_code($status_code);

        //send response headers
        foreach ($headers as $name => $value) {
            header($name . ': ' . $value);
        }
    }
    
    /**
     * send HTTP response
     *
     * @param  mixed $body
     * @param  array $headers
     * @param  int $status_code
     * @return void
     */
    public function send($body, array $headers = [], int $status_code = 200): void
    {
        if (!isset($body) or empty($body)) {
            return;
        }
        
        //send response status code
        http_response_code($status_code);

        //send response headers
        if (!empty($headers)) {
            foreach ($headers as $name => $value) {
                header($name . ': ' . $value);
            }
        }

        //set content length header
        header('Content-Length: ' . strlen($body));

        //send response body
        exit($body);
    }
    
    /**
     * send HTTP response with json body
     *
     * @param  mixed $body
     * @param  array $headers
     * @param  int $status_code
     * @return void
     */
    public function json($body, array $headers = [], int $status_code = 200): void
    {
        if (!isset($body) or empty($body)) {
            return;
        }
        
        //send response status code
        http_response_code($status_code);

        //send response headers
        if (!empty($headers)) {
            foreach ($headers as $name => $value) {
                header($name . ': ' . $value);
            }
        }

        //encode body to json format
        $body = json_encode($body);

        //send json header
        header('Content-Type: application/json');

        //set content length header
        header('Content-Length: ' . strlen($body));

        //send response body
        exit($body);
    }
}
