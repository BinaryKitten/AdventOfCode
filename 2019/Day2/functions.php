<?php

function ordinal(int $number): string
{
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
        return $number . 'th';
    } else {
        return $number . $ends[$number % 10];
    }
}

/**
 * @param string $fileName
 * @param array $setup
 *
 * @param bool $debug
 *
 * @return int
 */
function intCodeCompute(string $fileName, array $setup = [], $debug = false): int
{
    $data = array_map(
        'intval',
        explode(
            ',',
            rtrim(
                file_get_contents(
                    $fileName
                )
            )
        )
    );

    if (!empty($setup)) {
        foreach ($setup as $location => $value) {
            $data[$location] = (int)$value;
        }
    }

    $instructions = array_chunk($data, 4);
    foreach ($instructions as $instructionCount => $instruction) {
        $opCode = $instruction[0];
        if ($opCode === 99) {
            $debug && printf('End found %1$s Opcode' . "\n", ordinal($instructionCount + 1));
            break;
        }
        [$opCode, $nounLocation, $verbLocation, $outputLocation] = $instruction;

        $debug && printf(
            '%s Opcode: %d',
            ordinal($instructionCount + 1),
            $opCode
        );

        $noun = $data[$nounLocation];
        $verb = $data[$verbLocation];

        $result = $opCode === 1 ? $noun + $verb : $noun * $verb;
        $method = $opCode === 1 ? 'addition' : 'multiplication';

        $debug && printf(
            ' - %s of %d (Loc: %d) & %d (Loc: %d): %d (set Loc: %d)' . "\n",
            $method,
            $noun,
            $nounLocation,
            $verb,
            $verbLocation,
            $result,
            $outputLocation
        );

        $data[$outputLocation] = $result;
    }

    $debug && printf('Result from dataset %s is: %d' . "\n", $fileName, $data[0]);

    return $data[0];
}

function line()
{
    echo str_repeat('-', 30) . "\n";
}
