<?php
/**
 * --- Part Two ---
 *
 * With all the decoy data out of the way, it's time to decrypt this list and get moving.
 *
 * The room names are encrypted by a state-of-the-art shift cipher, which is nearly unbreakable without
 * the right software. However, the information kiosk designers at Easter Bunny HQ were not expecting to deal
 * with a master cryptographer like yourself.
 *
 * To decrypt a room name, rotate each letter forward through the alphabet a number of times equal to the room's
 * sector ID. A becomes B, B becomes C, Z becomes A, and so on. Dashes become spaces.
 *
 * For example, the real name for qzmt-zixmtkozy-ivhz-343 is very encrypted name.
 *
 * What is the sector ID of the room where North Pole objects are stored?
 */

$sector_id_sum = 0;
echo get_decrypt_room_name('qzmt-zixmtkozy-ivhz-343') . "\n";

////echo 'totally-real-room-200[decoy] ' . (the_room_is_valid('totally-real-room-200[decoy]') ? 'is real' : 'is not real');
////echo "\n";
//echo 'not-a-real-room-404[oarel] ' . (the_room_is_valid('not-a-real-room-404[oarel]') ? 'is real' : 'is not real') . "\n";
//echo 'not-a-real-room-404[oarel] Sector ID: ' . get_sector_id_for('not-a-real-room-404[oarel]') . "\n";
//echo "\n";

$valid = [];
foreach (lines_in(__DIR__ . '/data.txt') as $room) {
    if (the_room_is_valid($room) && 'northpole object storage' === get_decrypt_room_name($room)) {
        $sector_id = get_sector_id_for($room);
        echo 'The Sector ID that the North Pole Objects are stored in is: ' . $sector_id . "\n";
        break;
    }
}

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

function get_decrypt_room_name($room)
{
    $regex   = '/(?P<roomCode>[a-z-]+)-(?P<sectorID>\d+)(?:\[[^\]]+\])?$/';
    $matches = [
        'roomCode' => '',
        'sectorID' => '',
    ];
    preg_match($regex, $room, $matches);

    $asc_a   = ord('a');
    $asc_z   = ord('z');
    $decoded = '';
    foreach (str_split($matches['roomCode']) as $letter) {
        if ($letter === '-') {
            $decoded .= ' ';
            continue;
        }

        $asc = ord($letter);
        for ($i = 1; $i <= $matches['sectorID']; $i++) {
            $asc++;
            if ($asc > $asc_z) {
                $asc = $asc_a;
            }
        }

        $decoded .= chr($asc);
    }

    return $decoded;
}