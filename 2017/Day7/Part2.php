<?php
/**
 * --- Part Two ---
 *
 * The programs explain the situation: they can't get down. Rather, they could get down, if they weren't expending
 * all of their energy trying to keep the tower balanced. Apparently, one program has the wrong weight, and until
 * it's fixed, they're stuck here.
 *
 * For any program holding a disc, each program standing on that disc forms a sub-tower. Each of those sub-towers
 * are supposed to be the same weight, or the disc itself isn't balanced. The weight of a tower is the sum of the
 * weights of the programs in that tower.
 *
 * In the example above, this means that for ugml's disc to be balanced, gyxo, ebii, and jptl must all have the
 * same weight, and they do: 61.
 *
 * However, for tknk to be balanced, each of the programs standing on its disc and all programs above it must each
 * match. This means that the following sums must all be the same:
 *
 * ugml + (gyxo + ebii + jptl) = 68 + (61 + 61 + 61) = 251
 * padx + (pbga + havc + qoyq) = 45 + (66 + 66 + 66) = 243
 * fwft + (ktlj + cntj + xhth) = 72 + (57 + 57 + 57) = 243
 * As you can see, tknk's disc is unbalanced: ugml's stack is heavier than the other two. Even though the nodes
 * above ugml are balanced, ugml itself is too heavy: it needs to be 8 units lighter for its stack to weigh 243 and
 * keep the towers balanced. If this change were made, its weight would be 60.
 *
 * Given that exactly one program is the wrong weight, what would its weight need to be to balance the entire tower?
 **/

function parse_data($listing)
{
    $data    = [];
    $regex   = '/(?P<name>[^ ]+) \((?P<weight>\d+)\)(?: -> (?P<children>.+))?/';
    $listing = trim($listing);
    $listing = explode("\n", $listing);
    foreach ($listing as $row) {
        $row = trim($row);
        preg_match($regex, $row, $matches);

        $children = '';
        if (isset($matches['children'])) {
            $children = $matches['children'];
        }
        $data[$matches['name']] = [
            'weight'   => (int)$matches['weight'],
            'children' => $children
        ];
    }

    return $data;
}

function get_children($children_value, &$data)
{
    $children_data = $children_value['children'];
    if ( ! empty($children_data) && ! is_array($children_data)) {
        $children = array_fill_keys(
            array_map(
                'trim',
                explode(',', $children_data)
            ),
            []
        );
        foreach ($children as $child => $value) {
            if ( ! array_key_exists($child, $data)) {
                continue;
            }
            $children[$child] = get_children($data[$child], $data);
            unset($data[$child]);
        }
        $children_value['children'] = $children;
    }

    return $children_value;
}

function parse_tree(&$data)
{
    foreach ($data as $key => $children_value) {
        if (array_key_exists($key, $data)) {
            $data[$key] = get_children($children_value, $data);
        }
    }
}

function get_weights($data)
{
    foreach ($data as $key => $value) {
        if ( ! empty($value['children'])) {
            $data[$key]['children']    = get_weights($value['children']);
        } else {
            unset($data[$key]['children']);
        }
        if (count($data[$key]) === 1 && isset($data[$key]['weight'])) {
            $data[$key] = $data[$key]['weight'];
        }
    }

    return $data;
}

$input_data = parse_data(file_get_contents('input.txt'));
$demo_data  = parse_data('pbga (66)
xhth (57)
ebii (61)
havc (66)
ktlj (57)
fwft (72) -> ktlj, cntj, xhth
qoyq (66)
padx (45) -> pbga, havc, qoyq
tknk (41) -> ugml, padx, fwft
jptl (61)
ugml (68) -> gyxo, ebii, jptl
gyxo (61)
cntj (57)');

parse_tree($demo_data);
$demo_weights = get_weights($demo_data);
var_dump($demo_weights);


//$demo_root = get_root($demo_data);
//$root      = get_root($input_data);
//
//echo 'Demo Root is ' . $demo_root . "\n";
//echo 'Root is ' . $root . "\n";