<?php // phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

echo "<pre>";

$haystack = array(  "01qweabc234567defgqwe8910qwexyz",
                    "01abc234567defgqwe8910qwexyz",
                    "01abc234567defg8910qwexyz",
                    "01abc234567defg8910xyz");
$needle = "qwe";

/**
 * Convert string
 *
 * @param mixed $a Source string
 * @param mixed $b Substring needle
 *
 * @return Source string with converted second occurrence substring
 */
function convertString($a, $b)
{
    if (substr_count($a, $b) > 1) {
        $i = strpos($a, $b, strpos($a, $b) + strlen($b)); // second occur index
        return substr_replace($a, strrev($b), $i, strlen($b));
    } else {
        return "Less than two occurrences (" . substr_count($a, $b) . ")";
    }
}

echo "Substring: " . $needle  . str_repeat(PHP_EOL, 2);
foreach ($haystack as $str) {
    echo $str . PHP_EOL . convertString($str, $needle) . str_repeat(PHP_EOL, 2);
}

// phpcs:ignore PSR2.Files.ClosingTag.NotAllowed
?>
