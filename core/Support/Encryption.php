<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

namespace Core\Support;

/**
 * String encryption/decryption cipher.
 */
class Encryption
{
    public static string $cipher_method = 'aes-128-ctr';

    public static function encrypt(string $str): string
    {
        $enc_key = openssl_digest(config('security.encryption.key'), 'SHA256', true);
        $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$cipher_method));

        return openssl_encrypt($str, self::$cipher_method, $enc_key, 0, $enc_iv) . '::' . bin2hex($enc_iv);
    }

    public static function decrypt(string $enc_str): string
    {
        list($str, $enc_iv) = explode('::', $enc_str);
        $enc_key = openssl_digest(config('security.encryption.key'), 'SHA256', true);

        return openssl_decrypt($str, self::$cipher_method, $enc_key, 0, hex2bin($enc_iv));
    }

    public static function hash(string $str): string
    {
        return password_hash($str, PASSWORD_DEFAULT);
    }

    /**
     * Compare hashed string.
     */
    public static function check(string $str, string $hash): bool
    {
        return password_verify($str, $hash);
    }
}
