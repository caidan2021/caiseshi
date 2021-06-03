<?php

if (!function_exists('isOnlineEnv')) {
    function isOnlineEnv() {
        return app()->environment() == 'online';
    }
}

if (!function_exists('isWebtestEnv')) {
    function isWebtestEnv() {
        return app()->environment() == 'webtest';
    }
}

if (!function_exists('isLocalEnv')) {
    function isLocalEnv() {
        return app()->environment() == 'local';
    }
}