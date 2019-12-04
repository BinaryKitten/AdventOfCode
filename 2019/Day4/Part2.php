<?php declare(strict_types=1);
/*
 * --- Part Two ---
 * An Elf just remembered one more important detail:
 * the two adjacent matching digits are not part of a larger group of matching digits.
 *
 * Given this additional criterion, but still ignoring the range rule, the following are now true:
 *
 * 112233 meets these criteria because the digits never decrease and all repeated digits are exactly two digits long.
 * 123444 no longer meets the criteria (the repeated 44 is part of a larger group of 444).
 * 111122 meets the criteria (even though 1 is repeated more than twice, it still contains a double 22).
 * How many different passwords within the range given in your puzzle input meet all of the criteria?
 */
$input = range(231832, 767346);
//$input   = [122345, 111123, 135679, 111111, 223450, 123789, 112233, 123444, 111122];
$matches = array_filter(
    $input,
    static function ($password) {
        $password  = (string) $password;
        $double    = false;
        $increases = true;
        for ($i = 1; $i < 6; $i++) {
            $thisDigit = (int) $password[$i];
            $lastDigit = (int) $password[$i - 1];
            if ($thisDigit < $lastDigit) {
                $increases = false;
                break;
            }

            if (!$double && $thisDigit === $lastDigit) {
                $pattern = sprintf('/%d{3,}/', $thisDigit);
                if (!preg_match($pattern, $password)) {
                    $double = true;
                }
            }
        }

        return $double && $increases;
    }
);

printf('There are %d matching passwords' . "\n", count($matches));

// Your puzzle answer was 876.
