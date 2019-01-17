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

function is_assoc(array $arr)
{
    if (array() === $arr) {
        return false;
    }
    return array_keys($arr) !== range(0, count($arr) - 1);
}

/**
 * Computes the difference of arrays with additional index check
 * @param array $array1 The array to compare from
 * @param array $array2 An array to compare against
 * @param array $_ [optional]
 * @return array An array containing all the values from
 * array1 that are not present in any of the other arrays.
 */
function array_diff_assoc_improved(array $array1, array $array2, array $_ = [])
{
    foreach ($array1 as $key => $value) {
        $value2 = $array2[$key] ?? null;
        if ($value == $value2) {
            unset($array1[$key]);
        }
    }
    return $array1;
}

/**
 * Computes the difference of arrays
 * @param array $array1 The array to compare from
 * @param array $array2 An array to compare against
 * @param array $_ [optional]
 * @return array An array containing all the entries from
 * array1 that are not present in any of the other arrays.
 */
function array_diff_improved(array $array1, array $array2, array $_ = [])
{
    $map = array();
    $arraysList1 = [];
    $arraysList2 = [];
    foreach ($array1 as $value) {
        if (is_array($value)) {
            $arraysList1[] = $value;
            continue;
        }
        $map[$value] = 1;
    }

    $_[] = $array2;
    foreach ($_ as $array) {
        foreach ($array as $value) {
            if (is_array($value)) {
                $arraysList2[] = $value;
                continue;
            }
            unset($map[$value]);
        }
    }

    foreach ($arraysList1 as $key => $value) {
        if (in_array($value, $arraysList2)) {
            unset($arraysList1[$key]);
        }
    }

    return array_keys($map) + array_values($arraysList1);
}

/**
 *
 * @param array $array1 The array to compare from
 * @param array $array2 An array to compare against
 * @param int $depth User specified recursion depth.
 * @return array An array containing all the entries from array1 that are not present in array2.
 */
function array_recursive_diff(array $array1, array $array2, $depth = 512)
{
    $results = [];

    if ($depth <= 1) {
        return is_assoc($array1) ? array_diff_assoc_improved($array1, $array2) : array_diff_improved($array1, $array2);
    }

    foreach ($array1 as $key => $value) {
        if (!array_key_exists($key, $array2)) {
            $results[$key] = $value;
            continue;
        }

        if (is_array($value)) {
            if (is_array($array2[$key])) {
                if ($diff = array_recursive_diff($value, $array2[$key], $depth - 1)) {
                    $results[$key] = $diff;
                }
                continue;
            }
            $results[$key] = $value;
            continue;
        }

        if ($value !== $array2[$key]) {
            $results[$key] = $value;
        }
    }

    return $results;
}