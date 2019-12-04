<?php declare(strict_types=1);
/*
 * --- Day 4: Secure Container ---
 * You arrive at the Venus fuel depot only to discover it's protected by a password.
 * The Elves had written the password on a sticky note, but someone threw it out.
 *
 * However, they do remember a few key facts about the password:
 *
 * It is a six-digit number.
 * The value is within the range given in your puzzle input.
 * Two adjacent digits are the same (like 22 in 122345).
 * Going from left to right, the digits never decrease;
 *      they only ever increase or stay the same (like 111123 or 135679).
 * Other than the range rule, the following are true:
 *
 * 111111 meets these criteria (double 11, never decreases).
 * 223450 does not meet these criteria (decreasing pair of digits 50).
 * 123789 does not meet these criteria (no double).
 * How many different passwords within the range given in your puzzle input meet these criteria?
 */
$input = range(231832, 767346);
//$input   = [122345, 111123, 135679, 111111, 223450, 123789,];
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
            if ($thisDigit === $lastDigit) {
                $double = true;
            }
        }

        return $double && $increases;
    }
);

printf('There are %d matching passwords' . "\n", count($matches));

// Your puzzle answer was 1330.
