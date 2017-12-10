<?php
/* @REQUIRES PHP 7.1 */

/**
 * --- Day 8: I Heard You Like Registers ---
 *
 * You receive a signal directly from the CPU. Because of your recent assistance with jump instructions, it would
 * like you to compute the result of a series of unusual register instructions.
 *
 * Each instruction consists of several parts: the register to modify, whether to increase or decrease that
 * register's value, the amount by which to increase or decrease it, and a condition. If the condition fails,
 * skip the instruction without modifying the register. The registers all start at 0.
 *
 * The instructions look like this:
 *
 * b inc 5 if a > 1
 * a inc 1 if b < 5
 * c dec -10 if a >= 1
 * c inc -20 if c == 10
 *
 * These instructions would be processed as follows:
 *
 * Because a starts at 0, it is not greater than 1, and so b is not modified.
 * a is increased by 1 (to 1) because b is less than 5 (it is 0).
 * c is decreased by -10 (to 10) because a is now greater than or equal to 1 (it is 1).
 * c is increased by -20 (to -10) because c is equal to 10.
 * After this process, the largest value in any register is 1.
 *
 * You might also encounter <= (less than or equal to) or != (not equal to). However, the CPU doesn't have the
 * bandwidth to tell you what all the registers are named, and leaves that to you to determine.
 *
 * What is the largest value in any register after completing the instructions in your puzzle input?
 */
function inc(&$value, $amount)
{
    $value += $amount;
}

function dec(&$value, $amount)
{
    $value -= $amount;
}


$data  = [];
$input = file_get_contents('input.txt');
$input = trim($input);
$input = array_map('trim', explode("\n", $input));

$regex = '/(?P<register>[^\s]+)\s+(?P<op>inc|dec)\s+(?P<amount>-?\d+)\s+if\s+(?P<check_register>[^\s]+)\s+(?P<check_compare>[^\s]+)\s+(?P<check_amount>-?\d+)/i';
foreach ($input as $line) {
    preg_match($regex, $line, $matches);

    list(
        'register' => $register,
        'op' => $op,
        'amount' => $amount,
        'check_register' => $check_register,
        'check_compare' => $check_compare,
        'check_amount' => $check_amount
        ) = $matches;


    if ( ! array_key_exists($register, $data)) {
        $data[$register] = 0;
    }
    if ( ! array_key_exists($check_register, $data)) {
        $data[$check_register] = 0;
    }

    $valid_compares = [
        '=='
    ];

    $check = sprintf(
        '$check_pass = (bool)(%d %s %d); ',
        $data[$check_register],
        $check_compare,
        $check_amount
    );
    eval($check);
//    echo $check . ': ' . var_export($check_pass, true) . "\n";

    if ($check_pass) {
        $op($data[$register], $amount);
    }

}

echo 'The Highest value is: ' . max($data) . "\n";

// Your puzzle answer was 2971.
