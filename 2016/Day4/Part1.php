<?php
/**
 *--- Day 4: Security Through Obscurity ---
 *
 * Finally, you come across an information kiosk with a list of rooms. Of course, the list is encrypted and
 * full of decoy data, but the instructions to decode the list are barely hidden nearby.
 * Better remove the decoy data first.
 *
 * Each room consists of an encrypted name (lowercase letters separated by dashes) followed by a dash,
 * a sector ID, and a checksum in square brackets.
 *
 * A room is real (not a decoy) if the checksum is the five most common letters in the encrypted name,
 * in order, with ties broken by alphabetization. For example:
 *
 * aaaaa-bbb-z-y-x-123[abxyz] is a real room because the most common letters are a (5), b (3), and then a
 * tie between x, y, and z, which are listed alphabetically.
 *
 * a-b-c-d-e-f-g-h-987[abcde] is a real room because although the letters are all tied (1 of each),
 * the first five are listed alphabetically.
 *
 * not-a-real-room-404[oarel] is a real room.
 *
 * totally-real-room-200[decoy] is not.
 *
 * Of the real rooms from the list above, the sum of their sector IDs is 1514.
 *
 * What is the sum of the sector IDs of the real rooms?
 */

$sector_id_sum = 0;
//echo 'totally-real-room-200[decoy] ' . (the_room_is_valid('totally-real-room-200[decoy]') ? 'is real' : 'is not real');
//echo "\n";
echo 'not-a-real-room-404[oarel] ' . (the_room_is_valid('not-a-real-room-404[oarel]') ? 'is real' : 'is not real') . "\n";
echo 'not-a-real-room-404[oarel] Sector ID: ' . get_sector_id_for('not-a-real-room-404[oarel]') . "\n";
echo "\n";

$valid = [];
$regex = '/(?P<roomCode>[a-z-]+)-(?P<sectorID>\d+)\[(?P<checksum>[^\]]+)\]$/';
foreach (lines_in(__DIR__ . '/data.txt') as $room) {
    if (the_room_is_valid($room)) {
        $sector_id = get_sector_id_for($room);

        $sector_id_sum += (int)$sector_id;
    }
}

echo 'The sum of all the Valid Sector IDs is: ' . $sector_id_sum . "\n";

/**
 * @param $room
 *
 * @return int
 */
function get_sector_id_for($room)
{
    $regex  = '/(?P<sectorID>\d+)\[[^\]]+\]$/';
    $result = preg_match($regex, $room, $matches);
    if ($result !== 1) {
        return 0;
    }

    return $matches['sectorID'];
}

/**
 * @param string $room
 *
 * @return bool
 */
function the_room_is_valid($room)
{
    $regex   = '/(?P<roomCode>[a-z-]+)-(?P<sectorID>\d+)\[(?P<checksum>[^\]]+)\]$/';
    $matches = [
        'roomCode' => '',
        'sectorId' => '',
        'checksum' => '',
    ];
    $result  = preg_match($regex, $room, $matches);
    if ($result !== 1) {
        return false;
    }

    $code          = str_replace('-', '', $matches['roomCode']);
    $letters       = str_split($code);
    $letter_counts = array_count_values($letters);
    arsort($letter_counts);

    $count_letters = [];
    foreach ($letter_counts as $letter => $count) {
        if (!array_key_exists($count, $count_letters)) {
            $count_letters[$count] = [];
        }
        $count_letters[$count][] = $letter;
    }

    $checksum = '';
    foreach ($count_letters as $value) {
        sort($value);
        $checksum .= implode('', $value);
    }
    $checksum = substr($checksum, 0, 5);


    return $checksum === $matches['checksum'];
}

function lines_in($data_file)
{
    $f = fopen($data_file, 'rb');
    while ($line = fgets($f)) {
        $line = trim($line);
        yield $line;
    }
    fclose($f);
}