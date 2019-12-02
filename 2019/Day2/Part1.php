<?php declare(strict_types=1);
/**
 * --- Day 2: 1202 Program Alarm ---
 *
 * On the way to your gravity assist around the Moon, your ship computer beeps angrily about a
 * "1202 program alarm". On the radio, an Elf is already explaining how to handle the situation:
 * "Don't worry, that's perfectly norma--" The ship computer bursts into flames.
 *
 * You notify the Elves that the computer's magic smoke seems to have escaped. "That computer ran Intcode programs
 * like the gravity assist program it was working on; surely there are enough spare parts up there to build a
 * new Intcode computer!"
 *
 * An Intcode program is a list of integers separated by commas (like 1,0,0,3,99).
 * To run one, start by looking at the first integer (called position 0).
 * Here, you will find an opcode - either 1, 2, or 99. The opcode indicates what to do;
 * for example, 99 means that the program is finished and should immediately halt.
 * Encountering an unknown opcode means something went wrong.
 *
 * Opcode 1 adds together numbers read from two positions and stores the result in a third position.
 * The three integers immediately after the opcode tell you these three positions - the first two indicate
 * the positions from which you should read the input values, and the third indicates the position at which
 * the output should be stored.
 *
 * For example, if your Intcode computer encounters 1,10,20,30, it should read the values at positions 10 and 20,
 * add those values, and then overwrite the value at position 30 with their sum.
 *
 * Opcode 2 works exactly like opcode 1, except it multiplies the two inputs instead of adding them.
 * Again, the three integers after the opcode indicate where the inputs and outputs are, not their values.
 *
 * Once you're done processing an opcode, move to the next one by stepping forward 4 positions.
 *
 * For example, suppose you have the following program:
 *
 * 1,9,10,3,2,3,11,0,99,30,40,50
 * For the purposes of illustration, here is the same program split into multiple lines:
 *
 * 1,9,10,3,
 * 2,3,11,0,
 * 99,
 * 30,40,50
 * The first four integers, 1,9,10,3, are at positions 0, 1, 2, and 3. Together, they represent the first
 * opcode (1, addition), the positions of the two inputs (9 and 10), and the position of the output (3).
 * To handle this opcode, you first need to get the values at the input positions: position 9 contains 30,
 * and position 10 contains 40. Add these numbers together to get 70. Then, store this value at the output position;
 * here, the output position (3) is at position 3, so it overwrites itself. Afterward, the program looks like this:
 *
 * 1,9,10,70,
 * 2,3,11,0,
 * 99,
 * 30,40,50
 * Step forward 4 positions to reach the next opcode, 2. This opcode works just like the previous, but it multiplies
 * instead of adding. The inputs are at positions 3 and 11; these positions contain 70 and 50 respectively.
 * Multiplying these produces 3500; this is stored at position 0:
 *
 * 3500,9,10,70,
 * 2,3,11,0,
 * 99,
 * 30,40,50
 * Stepping forward 4 more positions arrives at opcode 99, halting the program.
 *
 * Here are the initial and final states of a few more small programs:
 *
 * 1,0,0,0,99 becomes 2,0,0,0,99 (1 + 1 = 2).
 * 2,3,0,3,99 becomes 2,3,0,6,99 (3 * 2 = 6).
 * 2,4,4,5,99,0 becomes 2,4,4,5,99,9801 (99 * 99 = 9801).
 * 1,1,1,4,99,5,6,0,99 becomes 30,1,1,4,2,5,6,0,99.
 * Once you have a working computer, the first step is to restore the gravity assist program (your puzzle input)
 * to the "1202 program alarm" state it had just before the last computer caught fire.
 * To do this, before running the program, replace position 1 with the value 12 and replace position 2 with the value 2.
 *
 * What value is left at position 0 after the program halts?
 *
 * @param int $number
 *
 * @return string
 */
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
 */
function intCodeCompute(string $fileName): void
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

    $opCount = 0;
//    for ($pos = 0, $end = count($data); $pos <= $end; $pos += 4) {
//        if ($data[$pos] === 99) {
//            break;
//        }
//        $opCount++;
//    }
//    printf('End found %2$s Opcode (Loc: %1$d)' . "\n", $pos, ordinal($opCount +1));

    for ($opCodePos = 0, $end = count($data); $opCodePos <= $end; $opCodePos += 4) {
        if ($data[$opCodePos] === 99) {
            printf('End found %2$s Opcode (Loc: %1$d)' . "\n", $opCodePos, ordinal($opCount +1));
            break;
        }

        $opCode = $data[$opCodePos];
        $inputValLoc1 = $data[$opCodePos + 1];
        $inputValLoc2 = $data[$opCodePos + 2];
        $outputLocation = $data[$opCodePos + 3];

        printf(
            '%s Opcode (Loc: %d): %d',
            ordinal($opCount +1),
            $opCodePos,
            $opCode
        );

        $inputVal1 = $data[$inputValLoc1];
        $inputVal2 = $data[$inputValLoc2];

        $result = $opCode === 1 ? $inputVal1 + $inputVal2 : $inputVal1 * $inputVal2;
        $method = $opCode === 1 ? 'addition': 'multiplication';

        printf(
            ' - %s of %d (Loc: %d) & %d (Loc: %d): %d (set Loc: %d)' . "\n",
            $method,
            $inputVal1,
            $inputValLoc1,
            $inputVal2,
            $inputValLoc2,
            $result,
            $outputLocation
        );

        $data[$outputLocation] = $result;

        $opCount++;
    }

    return;

    $outputFile = fopen('out_' . $fileName, 'w');
    fputcsv($outputFile, $data);

    $pos = 0;
    $opcode = $data[$pos];
    while ($opcode !== 99) {
        $inputValLoc1 = $data[$pos + 1];
        $inputValLoc2 = $data[$pos + 2];
        $inputVal1 = $data[$inputValLoc1];
        $inputVal2 = $data[$inputValLoc2];
        $outputLocation = $data[$pos + 3];
        switch ($opcode) {
            case 1:
                $result = $inputVal1 + $inputVal2;
                $method = 'addition';

                break;
            case 2:
                $result = $inputVal1 * $inputVal2;
                $method = 'multiplication';
                break;
        }

        printf(
            '%d (Loc: %d) - %s of %d (Loc: %d) & %d (Loc: %d)' . "\n",
            $result,
            $outputLocation,
            $method,
            $inputVal1,
            $inputValLoc1,
            $inputVal2,
            $inputValLoc2
        );

        $data[$outputLocation] = $result;

        fputcsv($outputFile, $data);

        $pos += 4;
        $opcode = $data[$pos];
    }

    fclose($outputFile);
    printf('Result from dataset %s is: %d' . "\n", $fileName, $data[0]);
}

//intCodeCompute('data/example.txt');
//echo str_repeat('-', 30) . "\n";
//intCodeCompute('data/example2.txt');
//echo str_repeat('-', 30) . "\n";
//intCodeCompute('data/example3.txt');
//echo str_repeat('-', 30) . "\n";
//intCodeCompute('data/example4.txt');
//echo str_repeat('-', 30) . "\n";
//intCodeCompute('data/example5.txt');
//echo str_repeat('-', 30) . "\n";
intCodeCompute('data/input.txt');
echo str_repeat('-', 30) . "\n";
