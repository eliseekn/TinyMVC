<?php

/**
* TinyMVC
*
* MIT License
*
* Copyright (c) 2019, N'Guessan Kouadio Elisée
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*
* @author: N'Guessan Kouadio Elisée (eliseekn => eliseekn@gmail.com)
*/

class Session {

	private $started;

	public function __construct() {
		if (!$this->started) {
			session_start();
			$this->started = true;
		}
	}

	public function set($data) {
		if (is_array($data)) {
            foreach ($data as $key => $value) {
    			$_SESSION[$key] = $value;
    		}
        }
	}

	public function unset($item) {
		unset($_SESSION[$item]);
	}

	public function get($item) {
		return $_SESSION[$item];
	}

	public function exists($item) {
		return isset($_SESSION[$item]);
	}

	public function destroy() {
		session_unset();
		session_destroy();
	}
}
