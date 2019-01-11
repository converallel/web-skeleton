<?php

function startsWith($haystack, $needle)
{
    return substr($haystack, 0, strlen($needle)) === $needle;
}

/**
 * Return current unix timestamp, e.g. "1970-01-01 00:00:00"
 * @return false|string
 */
function timestamp()
{
    return date("Y-m-d H:i:s");
}