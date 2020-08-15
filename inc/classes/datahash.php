<?php
class dataHash {
    /* PHP sha256() */
    static function sha256($data, $rawOutput = false) {
        if (!is_scalar($data)) {
            return false;
        }
        $data = (string)$data;
        $rawOutput = !!$rawOutput;
        return hash('sha256', $data, $rawOutput);
    }

    /* PHP sha256_file() */
    static function sha256_file($file, $rawOutput = false) {
        if (!is_scalar($file)) {
            return false;
        }
        $file = (string)$file;
        if (!is_file($file) || !is_readable($file)) {
            return false;
        }
        $rawOutput = !!$rawOutput;
        return hash_file('sha256', $file, $rawOutput);
    }

    /* PHP sha512() */
    static function sha512($data, $rawOutput = false) {
        if (!is_scalar($data)) {
            return false;
        }
        $data = (string)$data;
        $rawOutput = !!$rawOutput;
        return hash('sha512', $data, $rawOutput);
    }

    /* PHP sha512_file()*/
    static function sha512_file($file, $rawOutput = false) {
        if (!is_scalar($file)) {
            return false;
        }
        $file = (string)$file;
        if (!is_file($file) || !is_readable($file)) {
            return false;
        }
        $rawOutput = !!$rawOutput;
        return hash_file('sha512', $file, $rawOutput);
    }
}