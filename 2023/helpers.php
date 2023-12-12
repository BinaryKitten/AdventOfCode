<?php

declare(strict_types=1);

function dump(...$data): void
{
    array_walk($data, fn(mixed $item) => var_dump($item));
}

function dd(...$data): void
{
    dump(...$data);
    die();
}
