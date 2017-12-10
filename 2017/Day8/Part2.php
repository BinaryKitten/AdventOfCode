<?php
/* @REQUIRES PHP 7.1 */

/**
 * --- Part Two ---
 * 
 * To be safe, the CPU also needs to know the highest value held in any register during this process so that it
 * can decide how much memory to allocate to these operations.
 *
 * For example, in the above instructions, the highest value ever held was 10
 * (in register c after the third instruction was evaluated).
 */
function inc(&$value, $amount)
{
    $value += $amount;
}

function dec(&$value, $amount)
{
    $value -= $amount;
}

//$operators = [
//    '==' => function($value1, $value2) {
//        return $value1 == $value2;
//    },
//    '<=' => function($value1, $value2) {
//        return $value1 <= $value2;
//    },
//];

$data  = [];
$input = file_get_contents('input.txt');
$input = trim($input);
$input = array_map('trim', explode("\n", $input));
$max = 0;

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

    $new_max = max($data);
    if ($new_max > $max) {
        $max = $new_max;
    }
}

echo 'The Highest value is: ' . max($data) . "\n";
echo 'The Highest value set was: ' . $max . "\n";

// Your puzzle answer was 4254.
