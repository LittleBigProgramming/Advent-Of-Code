<?php

$answers = explode("\n\n", file_get_contents('input.txt'));

/**
 * @param $answers
 * @return int
 */
function countUniqueAnswers($answers)
{
    $count = 0;

    foreach ($answers as $group) {
        $groupAnswers = preg_replace('/\s+/', '', $group);
        $uniqueAnswers = findUnique($groupAnswers);

        $count += $uniqueAnswers;
    }

    return $count;
}

/**
 * @param $groupAnswers
 * @return int
 */
function findUnique($groupAnswers)
{
    return strlen(count_chars($groupAnswers, 3));
}

$time_start = microtime(true);

echo countUniqueAnswers($answers);

$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo 'Total Execution Time: ' . $execution_time .' Seconds';
