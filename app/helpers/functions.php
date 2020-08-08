<?php

if (!function_exists('generateTokan')) {
    function generateToken() {
        return md5(uniqid(rand(), true));
    }
}
