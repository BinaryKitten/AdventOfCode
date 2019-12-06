<?php declare(strict_types=1);
/*
 * --- Day 6: Universal Orbit Map ---
 * You've landed at the Universal Orbit Map facility on Mercury. Because navigation in space often involves
 *  transferring between orbits, the orbit maps here are useful for finding efficient routes between, for example,
 *  you and Santa.
 * You download a map of the local orbits (your puzzle input).
 *
 * Except for the universal Center of Mass (COM), every object in space is in orbit around exactly one other object.
 * An orbit looks roughly like this:
 *
 *                   \
 *                    \
 *                     |
 *                     |
 * AAA--> o            o <--BBB
 *                     |
 *                     |
 *                    /
 *                   /
 * In this diagram, the object BBB is in orbit around AAA. The path that BBB takes around AAA (drawn with lines) is
 *  only partly shown.
 * In the map data, this orbital relationship is written AAA)BBB, which means "BBB is in orbit around AAA".
 *
 * Before you use your map data to plot a course, you need to make sure it wasn't corrupted during the download.
 * To verify maps, the Universal Orbit Map facility uses orbit count checksums - the total number of direct orbits
 *   (like the one shown above) and indirect orbits.
 *
 * Whenever A orbits B and B orbits C, then A indirectly orbits C. This chain can be any number of objects long:
 *   if A orbits B, B orbits C, and C orbits D, then A indirectly orbits D.
 *
 * For example, suppose you have the following map:
 *
 * COM)B
 * B)C
 * C)D
 * D)E
 * E)F
 * B)G
 * G)H
 * D)I
 * E)J
 * J)K
 * K)L
 * Visually, the above map of orbits looks like this:
 *
 *         G - H       J - K - L
 *        /           /
 * COM - B - C - D - E - F
 *                \
 *                 I
 * In this visual representation, when two objects are connected by a line, the one on the right directly
 *   orbits the one on the left.
 *
 * Here, we can count the total number of orbits as follows:
 *
 * D directly orbits C and indirectly orbits B and COM, a total of 3 orbits.
 * L directly orbits K and indirectly orbits J, E, D, C, B, and COM, a total of 7 orbits.
 * COM orbits nothing.
 * The total number of direct and indirect orbits in this example is 42.
 *
 * What is the total number of direct and indirect orbits in your map data?
 */
$data = file('input.txt');
//$data = file('example.txt');
$input = array_map(
    function ($item)
    {
        return array_combine(
            ['parent', 'child'],
            explode(
                ')',
                trim($item)
            )
        );
    },
    $data
);
ini_set('xdebug.max_nesting_level', (string)count($input));


$tree = [];
$parents = array_column($input, 'parent');
$children = array_column($input, 'child');
$thisLevelParents = array_unique(array_diff($parents, $children));

while (count($thisLevelParents) != 0) {
    foreach ($thisLevelParents as $levelParent) {
        $levelChildren = [];
        foreach ($input as $idx => $item) {
            if ($item['parent'] === $levelParent) {
                unset($input[$idx]);
                $levelChildren[] = $item['child'];
            }
        }
        $tree[$levelParent] = implode(',', $levelChildren);
    }
    $thisLevelParents = array_unique(
        array_diff(
            array_column($input, 'parent'),
            array_column($input, 'child')
        )
    );
}

function get_children($children_value, &$data)
{
    if (!empty($children_value) && !is_array($children_value)) {
        $children = array_fill_keys(
            array_map(
                'trim',
                explode(',', $children_value)
            ),
            []
        );
        foreach ($children as $child => $value) {
            if (!array_key_exists($child, $data)) {
                continue;
            }
            $children[$child] = get_children($data[$child], $data);
            unset($data[$child]);
        }
        $children_value = $children;
    }

    return $children_value;
}

function count_paths(array $tree): int
{
    $arrayIterator = new \RecursiveArrayIterator($tree);
    $iterator = new \RecursiveIteratorIterator($arrayIterator, RecursiveIteratorIterator::CHILD_FIRST);
    $depths = 0;
    foreach ($iterator as $item) {
        if ($iterator->getDepth() <= 1) {
            continue;
        }
        $depths += $iterator->getDepth();
    }

    return $depths + 1;
}

foreach ($tree as $key => $children_value) {
    $tree[$key] = get_children($children_value, $tree);
}

printf('Total Orbits: %d' . "\n", count_paths($tree));

// Your puzzle answer was 158090.
