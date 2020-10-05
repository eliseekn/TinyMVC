<?php

/**
 * @copyright 2019-2020 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/TinyMVC
 */

namespace Framework\Support;

/**
 * String encryption/decryption cipher
 */
class Encryption
{    
    /**
     * cipher method
     *
     * @var string
     */
    public static $cipher_method = 'aes-128-ctr';
    
    /**
     * encrypt
     *
     * @param  string $str
     * @return mixed returns false or encrypted string
     */
    public static function encrypt(string $str)
    {
        $enc_key = openssl_digest(config('security.enc_key'), 'SHA256', TRUE);
        $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$cipher_method));
        return openssl_encrypt($str, self::$cipher_method, $enc_key, 0, $enc_iv) . '::' . bin2hex($enc_iv);
    }
    
    /**
     * decrypt
     *
     * @param  string $enc_str
     * @return mixed returns false or decrypted string
     */
    public static function decrypt(string $enc_str)
    {
        list($str, $enc_iv) = explode('::', $enc_str);
        $enc_key = openssl_digest(config('security.enc_key'), 'SHA256', TRUE);
        return openssl_decrypt($str, self::$cipher_method, $enc_key, 0, hex2bin($enc_iv));
    }
    
    /**
     * hash string
     *
     * @param  string $str
     * @return string
     */
    public static function hash(string $str): string
    {
        return hash_string($str);
    }

    /**
     * compare hashed string
     *
     * @param  string $str
     * @param  string $hash
     * @return bool
     */
    public static function verify(string $str, string $hash): bool
    {
        return compare_hash($str, $hash);
    }
}
