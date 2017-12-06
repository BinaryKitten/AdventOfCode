<?php
/**
 * --- Day 7: Internet Protocol Version 7 ---
 *
 * While snooping around the local network of EBHQ, you compile a list of IP addresses
 * (they're IPv7, of course; IPv6 is much too limited). You'd like to figure out which IPs
 * support TLS (transport-layer snooping).
 *
 * An IP supports TLS if it has an Autonomous Bridge Bypass Annotation, or ABBA. An ABBA is any
 * four-character sequence which consists of a pair of two different characters followed by the reverse
 * of that pair, such as xyyx or abba. However, the IP also must not have an ABBA within any hypernet sequences,
 * which are contained by square brackets.
 *
 * For example:
 *
 * abba[mnop]qrst supports TLS (abba outside square brackets).
 * abcd[bddb]xyyx does not support TLS (bddb is within square brackets, even though xyyx is outside square brackets).
 * aaaa[qwer]tyui does not support TLS (aaaa is invalid; the interior characters must be different).
 * ioxxoj[asdfgh]zxcvbn supports TLS (oxxo is outside square brackets, even though it's within a larger string).
 * How many IPs in your puzzle input support TLS?
 *
 */

$tls_ips = 0;
foreach (line_in(__DIR__ . '/data.txt') as $idx => $ipAddress) {
    echo $idx . ' - ';
    $increment = true;
    foreach (sequence_in($ipAddress) as $sequence) {
        echo $sequence;
        if (is_sequence_in_hypernet($ipAddress, $sequence)) {
            $increment = false;
            echo "\n";
            break;
        } else {
            echo '++';
            echo "\n";
        }
    }
    if ($increment) {
        $tls_ips++;
    }
}
echo $tls_ips . ' IPs found supporting TLS' . "\n";


function line_in($data_file)
{
    $f = fopen($data_file, 'rb');
    while ($line = fgets($f)) {
        yield trim($line);
    }
    fclose($f);
}

function sequence_in($line)
{
    $p = preg_match_all('/([a-z])([a-z])\2\1/', $line, $matches);
    if ($p) {
        foreach ($matches[0] as $match) {
            yield $match;
        }

    }
}

function is_sequence_in_hypernet($line, $sequence)
{
    $data_in_blocks = preg_match_all('/(?P<hypernet>\[[^\]]+\])/', $line, $matches);
    if (!$data_in_blocks) {
        return false;
    }

    $matchString = implode('', $matches['hypernet']);
//    foreach ($matches['hypernet'] as $hypernet) {
        if (false !== strpos($matchString, $sequence)) {
            echo ' - ' . $matchString;
            return true;
        }
//    }

    return false;
}