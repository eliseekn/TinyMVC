<?php

/**
 * TinyMVC
 * 
 * PHP framework based on MVC architecture
 * 
 * @copyright 2019-2020 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/TinyMVC
 */

/**
 * Application main configuration
 */

//define application root folder. Set to '/' for server root
define('APP_ROOT', '/tinymvc/');

//domain url
define('WEB_DOMAIN', 'http://localhost' . APP_ROOT);

//absolute application path
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);

//errors display configuration
define('DISPLAY_ERRORS', true);