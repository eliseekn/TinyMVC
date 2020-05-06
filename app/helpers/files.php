<?php

/**
 * TinyMVC
 * 
 * PHP framework based on MVC architecture
 * 
 * @copyright 2019-2020 - N'Guessan Kouadio Elisée (eliseekn@gmail.com)
 * @license MIT (https://opensource.org/licenses/MIT)
 * @link https://github.com/eliseekn/tinymvc
 */

/**
 * Miscellaneous files functions
 */

/**
 * manage single or multiple file upload
 *
 * @param  string $field name of the input file tag
 * @param  string $destination absolute path file destination directory without trailing slash
 * @param  bool $multiple is multiple file uploaded?
 * @param  mixed $filename returns actual uploaded filename
 * @return bool returns true if success or false if failed
 */
function upload_file(string $field, string $destination, bool $multiple, &$filename): bool
{
    if (empty($_FILES[$field]['name'])) {
        return false;
    }

    try {
        if (!$multiple) {
            $origin = $_FILES[$field]['tmp_name'];
            $filename = basename($_FILES[$field]['name']);
            move_uploaded_file($origin, $destination . '/' . $filename);
        } else {
            for ($i = 0; $i < count($_FILES[$field]['name']); $i++) {
                $origin = $_FILES[$field]['tmp_name'][$i];
                $filename[] = basename($_FILES[$field]['name'][$i]);
                move_uploaded_file($origin, $destination . '/' . $filename[$i]);
            }
        }

        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * remove entire directory and all it's content
 *
 * @param  string $dir directory absolute path
 * @return void
 * 
 * @link https://stackoverflow.com/questions/3338123/how-do-i-recursively-delete-a-directory-and-its-entire-contents-files-sub-dir
 */
function remove_dir(string $dir): void
{
    if (is_dir($dir)) {
        $objects = scandir($dir);

        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (
                    is_dir($dir . DIRECTORY_SEPARATOR . $object) &&
                    !is_link($dir . DIRECTORY_SEPARATOR . $object)
                ) {
                    remove_dir($dir . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
                }
            }
        }

        rmdir($dir);
    }
}