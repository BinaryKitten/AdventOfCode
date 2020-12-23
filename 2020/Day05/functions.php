<?php

declare(strict_types=1);

function convertBoardingPassToSeatDetails(string $boardingPass): array
{
    $boardingPassArray = str_split($boardingPass);
    [$boardingPassRow, $boardingPassColumn] = array_chunk($boardingPassArray, 7);
    $row = binarySearch(range(0, 127), 'F', $boardingPassRow);
    $column = binarySearch(range(0, 7), 'L', $boardingPassColumn);
    $seatId = ($row * 8) + $column;

    return compact('row', 'column', 'seatId');
}

function binarySearch(array $base, string $lowerChar, array $instructions)
{
    return array_reduce(
        $instructions,
        static function (array $carry, string $value) use ($lowerChar) {
            $chunks = array_chunk($carry, (int)floor(count($carry) / 2));
            return $value === $lowerChar ? $chunks[0] : $chunks[1];
        },
        $base
    )[0];
}

function parseFileToBoardingPasses(string $mapFile): array
{
    return array_map(
        fn(string $line) => trim($line),
        file($mapFile)
    );
}
