<?php

if (!function_exists('mb_split')) {
    function mb_split(string $pattern, string $string, int $limit = -1): array|false
    {
        return preg_split('/' . str_replace('/', '\\/', $pattern) . '/u', $string, $limit);
    }
}

if (!function_exists('mb_strimwidth')) {
    function mb_strimwidth(string $string, int $start, int $width, string $trim_marker = '', ?string $encoding = null): string
    {
        $len = mb_strlen($string);

        if ($start < 0) {
            $start = max(0, $len + $start);
        }

        if ($start >= $len || $width <= 0) {
            return '';
        }

        $markerLen = mb_strlen($trim_marker);

        if ($len - $start > $width) {
            $resultLength = $width - $markerLen;

            if ($resultLength < 0) {
                $resultLength = 0;
            }

            return mb_substr($string, $start, $resultLength) . $trim_marker;
        }

        return mb_substr($string, $start, $width);
    }
}
