<?php
/**
 * Basic String Extensions
 * 
 * From StackOverflow: https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
 */
function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}