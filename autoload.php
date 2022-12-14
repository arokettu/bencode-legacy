<?php

declare(strict_types=1);

namespace SandFox\Bencode\Legacy;

const NS = 'Arokettu\\Bencode\\';
const PREFIX = 'SandFox\\Bencode\\';
const PREFIX_LEN = 16;

spl_autoload_register(function (string $class_name) {
    if (str_starts_with($class_name, PREFIX)) {
        $realName = NS . substr($class_name, PREFIX_LEN);
        class_alias($realName, $class_name);
        return true;
    }

    return null;
});
