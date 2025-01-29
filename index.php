<?php

declare(strict_types=1);

/**
 * @copyright 2019-2025 N'Guessan Kouadio Elisée <eliseekn@gmail.com>
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

use Core\Application;

/**
 * Main application entry.
 */

require 'vendor/autoload.php';
require_once 'bootstrap.php';

(new Application())->run();
