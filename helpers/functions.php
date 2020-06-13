<?php 

if (!function_exists('generateToken')) {
    function generateToken() {
        return md5(uniqid(mt_rand(), true));
    }
}