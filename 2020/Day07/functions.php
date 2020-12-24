<?php

declare(strict_types=1);

/**
 * @param string $file
 * @return array
 */
function parseRules(string $file): array
{
    $rules = file($file);
    $matches = [];
    $bags = [];

    foreach ($rules as $rule) {
        $rule = trim($rule);
        preg_match('/(.+) bags contain ((?:no other bags)|(?:(?:\d{1,2} .+ bags?)))/', $rule, $matches);
        [, $bag, $return] = $matches;
        if (!array_key_exists($bag, $bags)) {
            $bags[$bag] = [];
        }
        if ($return !== 'no other bags') {
            preg_match_all('/(\d{1,2}) ((?:\w|\s)+) bags?/', $return, $return);
            [, $bagItemCounts, $bagTypesReturned] = $return;
            foreach ($bagTypesReturned as $childBag) {
                if (!array_key_exists($childBag, $bags)) {
                    $bags[$childBag] = [];
                }
            }
            $bags[$bag] = array_combine($bagTypesReturned, array_map('intval', $bagItemCounts));
        }
    }

    return $bags;
}
