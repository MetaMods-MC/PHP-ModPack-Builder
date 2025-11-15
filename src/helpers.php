<?php

use MetaMods\Modpack;

if (!function_exists('modpack')) {
    function modpack(string $name, string $version = '1.0.0', string $summary = null): Modpack {
        return new Modpack($name, $version, $summary);
    }
}
