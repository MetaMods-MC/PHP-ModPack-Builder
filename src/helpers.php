<?php

use MetaMods\Modpack;

if (!function_exists('modpack')) {
    function modpack(string $name, string $version, string $summary): Modpack {
        return new Modpack($name, $version, $summary);
    }
}
