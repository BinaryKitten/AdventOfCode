<?php

declare(strict_types=1);

function loadBootFile(string $filename): array
{
    return array_map(
        static function (string $line) {
            [$operation, $argument] = explode(' ', trim($line));
            $argument = (int)$argument;
            return compact('operation', 'argument');
        },
        file($filename)
    );
}

function calculatorAccumulator(array $bootCode, bool $doubleInstructionRunIsOk = true): int
{
    $accumulator = 0;
    $index = 0;
    $instructionsRun = [];
    $instructionCount = count($bootCode);
    $doubleInstructionRun = false;

    do {
        ['operation' => $operation, 'argument' => $argument] = $bootCode[$index];
        $instructionsRun[] = $index;

        switch ($operation) {
            case 'nop':
                $index++;
                break;

            case 'acc':
                $accumulator += $argument;
                $index++;
                break;

            case 'jmp':
                $index += $argument;
                break;
        }

        if (in_array($index, $instructionsRun, true)) {
            $doubleInstructionRun = true;
            break;
        }
    } while ($index <= $instructionCount);


    return $accumulator;
}
