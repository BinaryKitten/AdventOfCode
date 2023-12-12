<?php

declare(strict_types=1);

require_once __DIR__.'/../helpers.php';

/**
 * --- Day 3: Gear Ratios ---
 *
 * You and the Elf eventually reach a gondola lift station; he says the gondola lift will take you up to the
 * water source, but this is as far as he can bring you.
 * You go inside.
 *
 * It doesn't take long to find the gondolas, but there seems to be a problem: they're not moving.
 *
 * "Aaah!"
 *
 * You turn around to see a slightly-greasy Elf with a wrench and a look of surprise.
 * "Sorry, I wasn't expecting anyone! The gondola lift isn't working right now;
 *      it'll still be a while before I can fix it."
 * You offer to help.
 *
 * The engineer explains that an engine part seems to be missing from the engine, but nobody can figure out which one.
 * If you can add up all the part numbers in the engine schematic, it should be easy to work out which part is missing.
 *
 * The engine schematic (your puzzle input) consists of a visual representation of the engine.
 * There are lots of numbers and symbols you don't really understand, but apparently any number adjacent to a symbol,
 * even diagonally, is a "part number" and should be included in your sum. (Periods (.) do not count as a symbol.)
 *
 * Here is an example engine schematic:
 *
 * ```
 * 467..114..
 * ...*......
 * ..35..633.
 * ......#...
 * 617*......
 * .....+.58.
 * ..592.....
 * ......755.
 * ...$.*....
 * .664.598..
 * ```
 *
 * In this schematic, two numbers are not part numbers because they are not adjacent to a symbol:
 * 114 (top right) and 58 (middle right).
 * Every other number is adjacent to a symbol and so is a part number; their sum is 4361.
 *
 * Of course, the actual engine schematic is much larger.
 * What is the sum of all of the part numbers in the engine schematic?
 */

function createGridFrom(string $filename): array
{
    return array_map(
        static fn(string $line): array => str_split(trim($line)),
        array_filter(file(__DIR__.'/'.$filename))
    );
}

function hasSurroundingSymbols(array $grid, int $currentX, int $currentY): bool
{
    $surroundingChars = [];
    $haveRowAbove = $currentY > 0;
    $haveRowBelow = $currentY < count($grid) - 1;
    $havePreviousColumn = $currentX > 0;
    $haveNextColumn = $currentX < count($grid[$currentY]) - 1;

    if ($haveRowAbove) {
        $rowAbove = $grid[$currentY - 1];
        if ($havePreviousColumn) {
            $surroundingChars['NW'] = $rowAbove[$currentX - 1];
        }
        $surroundingChars['N'] = $rowAbove[$currentX];

        if ($haveNextColumn) {
            $surroundingChars['NE'] = $rowAbove[$currentX + 1];
        }
    }

    if ($havePreviousColumn) {
        $surroundingChars['W'] = $grid[$currentY][$currentX - 1];
    }

    if ($haveNextColumn) {
        $surroundingChars['E'] = $grid[$currentY][$currentX + 1];
    }

    if ($haveRowBelow) {
        $rowBelow = $grid[$currentY + 1];
        if ($havePreviousColumn) {
            $surroundingChars['SW'] = $rowBelow[$currentX - 1];
        }
        $surroundingChars['S'] = $rowBelow[$currentX];

        if ($haveNextColumn) {
            $surroundingChars['SE'] = $rowBelow[$currentX + 1];
        }
    }

    $surroundingChars = array_filter(
        $surroundingChars,
        fn(string $char): bool => ! is_numeric($char) && $char !== '.'
    );

    return ! empty($surroundingChars);
}

function findPartNumbers(array $grid): array
{
    $numbers = [];
    for ($rowIdx = 0, $rowCount = count($grid); $rowIdx < $rowCount; $rowIdx++) {
        $row = $grid[$rowIdx];
        for ($colIdx = 0, $colCount = count($row); $colIdx < $colCount; $colIdx++) {
            $character = $row[$colIdx];
            $number = '';
            $positions = [];
            if (is_numeric($character)) {
                $number .= $character;
                $positions[] = $colIdx;
                $nextCharIdx = $colIdx + 1;
                if ($nextCharIdx < count($row) -1 ) {
                    $nextChar = $row[$nextCharIdx];
                    while (is_numeric($nextChar)) {
                        $number .= $nextChar;
                        $positions[] = $nextCharIdx;
                        $nextCharIdx++;
                        if ($nextCharIdx >= count($row)) {
                            break;
                        }
                        $nextChar = $row[$nextCharIdx];
                    }
                }

                $surround = [];
                foreach ($positions as $position) {
                    $surround[] = hasSurroundingSymbols($grid, $position, $rowIdx);
                }
                $surround = array_filter($surround);

                if (! empty($surround)) {
                    if (strlen($number) > 1) {
                        $colIdx = $nextCharIdx;
                    }
                    $numbers[] = $number;
                }
            }
        }
    }

    return $numbers;
}

function partNumberSum(string $fileName): int
{
    $grid = createGridFrom($fileName);
    $partNumbers = findPartNumbers($grid);
    return array_sum($partNumbers);
}


echo 'Example Result: '.partNumberSum('example.txt')."\n";
echo 'Result: '.partNumberSum('input.txt')."\n\n";

// Your puzzle answer was 521601.
