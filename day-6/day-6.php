<?php

$answers = explode("\n\n", file_get_contents('input.txt'));

/**
 * @param $answers
 * @return int
 */
function countUniqueAnswers($answers): int
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
 * @param $answers
 * @return int
 */
function countCommonAnswers($answers): int
{
    $count = 0;

    foreach ($answers as $group) {

        $groupAnswers = array_map('str_split', explode(PHP_EOL, $group));

        if (count($groupAnswers) < 2) {
            $count += count($groupAnswers[0]);
        } else {
            $commonAnswers = count(call_user_func_array('array_intersect', $groupAnswers));
            $count += $commonAnswers;
        }
    }

    return $count;
}

/**
 * @param $groupAnswers
 * @return int
 */
function findUnique($groupAnswers): int
{
    return strlen(count_chars($groupAnswers, 3));
}

$time_start = microtime(true);

echo countUniqueAnswers($answers) . PHP_EOL;
echo countCommonAnswers($answers) . PHP_EOL;

$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo 'Total Execution Time: ' . $execution_time . ' Seconds';
