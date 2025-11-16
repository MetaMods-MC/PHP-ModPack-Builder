<?php namespace MetaMods\Loaders;

abstract class Loader
{
    public readonly string $version;

    public function __construct(string $version)
    {
        $this->version = $version;
    }
}