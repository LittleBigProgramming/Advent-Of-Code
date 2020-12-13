<?php

$seatCodes = explode(PHP_EOL, file_get_contents('input.txt'));

/**
 * @param $seat
 * @return float|int
 */
function convertToBinary($seat)
{
    return bindec(preg_replace(['/[FL]/', '/[BR]/'], [0,1], $seat));
}

/**
 * @param $seatCodes
 * @return mixed
 */
function getfindMaxSeatId($seatCodes)
{
    $binarySeatCodes = [];
    foreach($seatCodes as $i => $seat) {
        array_push($binarySeatCodes, convertToBinary($seat));
    }

    return max($binarySeatCodes);
}

$time_start = microtime(true);

echo getfindMaxSeatId($seatCodes) . PHP_EOL;

$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo 'Total Execution Time: ' . $execution_time .' Seconds';
