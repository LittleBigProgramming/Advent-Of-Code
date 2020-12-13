<?php

$seatCodes = explode(PHP_EOL, file_get_contents('input.txt'));

/**
 * @param $seat
 * @return float|int
 */
function convertToBinaryThenDecimal($seat)
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
        array_push($binarySeatCodes, convertToBinaryThenDecimal($seat));
    }

    return max($binarySeatCodes);
}

/**
 * @param $seatCodes
 * @return mixed
 */
function getMySeatId($seats)
{
    return current(array_diff(range(min($seats), max($seats)), $seats));
}

/**
 * @param $seatCodes
 * @return array|float[]|int[]
 */
function mapSeatsFromCodes($seatCodes)
{
    return array_map(fn ($seat) => convertToBinaryThenDecimal($seat), $seatCodes);
}

$time_start = microtime(true);

echo 'Part 1 Max Seat ID: ' . getfindMaxSeatId($seatCodes) . PHP_EOL;
$seats = mapSeatsFromCodes($seatCodes);
echo 'Part 2 My Seat ID: ' . getMySeatId($seats) . PHP_EOL;;

$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
echo 'Total Execution Time: ' . $execution_time .' Seconds';
