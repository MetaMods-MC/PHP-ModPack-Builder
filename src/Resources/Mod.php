<?php namespace MetaMods\Resources;

class Mod extends Resource
{
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    protected function getPathPrefix(): string
    {
        return 'mods';
    }
}
