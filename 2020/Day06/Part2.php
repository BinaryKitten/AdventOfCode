<?php

declare(strict_types=1);

/**
 * --- Part Two ---
 *
 * As you finish the last group's customs declaration, you notice that you misread one word in the instructions:
 *
 * You don't need to identify the questions to which anyone answered "yes"; you need to identify the questions to
 * which everyone answered "yes"!
 *
 * Using the same example as above:
 *
 * abc
 *
 * a
 * b
 * c
 *
 * ab
 * ac
 *
 * a
 * a
 * a
 * a
 *
 * b
 *
 * This list represents answers from five groups:
 *
 * In the first group, everyone (all 1 person) answered "yes" to 3 questions: a, b, and c.
 * In the second group, there is no question to which everyone answered "yes".
 * In the third group, everyone answered yes to only 1 question, a.
 * Since some people did not answer "yes" to b or c, they don't count.
 * In the fourth group, everyone answered yes to only 1 question, a.
 * In the fifth group, everyone (all 1 person) answered "yes" to 1 question, b.
 *
 * In this example, the sum of these counts is 3 + 0 + 1 + 1 + 1 = 6.
 *
 * For each group, count the number of questions to which everyone answered "yes".
 * What is the sum of those counts?
 */

function getYesSum(string $fileName): float|int
{
    return (int)array_sum(
        array_map(
            static function (string $group) {
                $groupAnswers = explode("\n", $group);
                $groupAnswersSplit = array_map('str_split', $groupAnswers);
                $groupUnique = array_count_values(
                    array_merge(
                        ...$groupAnswersSplit
                    )
                );
                $groupShared = array_filter(
                    $groupUnique,
                    fn($count, $letter) => $count === count($groupAnswers),
                    ARRAY_FILTER_USE_BOTH
                );
                return count($groupShared);
            },
            explode("\n\n", trim(file_get_contents($fileName)))
        )
    );
}

$testResult = getYesSum(__DIR__ . '/test.txt');
$result = getYesSum(__DIR__ . '/input.txt');

echo 'Test Result: ' . $testResult . "\n";
echo 'Result: ' . $result . "\n";

// Your puzzle answer was 3219.
