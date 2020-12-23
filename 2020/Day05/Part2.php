<?php

declare(strict_types=1);

/**
 * --- Part Two ---
 *
 * Ding! The "fasten seat belt" signs have turned on. Time to find your seat.
 *
 * It's a completely full flight, so your seat should be the only missing boarding pass in your list.
 *  However, there's a catch: some of the seats at the very front and back of the plane don't exist on this aircraft,
 *  so they'll be missing from your list as well.
 *
 * Your seat wasn't at the very front or back, though; the seats with IDs +1 and -1 from yours will be in your list.
 *
 * What is the ID of your seat?
 */

include __DIR__ . '/functions.php';
$boardingPasses = parseFileToBoardingPasses(__DIR__ . '/input.txt');
$seats = array_map('convertBoardingPassToSeatDetails', $boardingPasses);
$inputSeatIds = array_column($seats, 'seatId');

$mySeat = [];
for ($r = 1;$r <= 126; $r++) {
    for($c=0;$c<=7;$c++) {
        $seatId = ($r * 8) + $c;
        if (!in_array($seatId, $inputSeatIds,true)) {
            $mySeat = [
                'row' => $r, 'column' => $c, 'seatId' => $seatId
            ];
            break 2;
        }
    }
}

vprintf('Your Seat is: Row %d, Column %d, SeatId: %d' . "\n", $mySeat);

// Your puzzle answer was 612.
