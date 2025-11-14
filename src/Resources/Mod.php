<?php namespace MetaMods\Resources;

class Mod
{
    public function __construct(array $data, $local = false)
    {
        $this->path = sprintf("%s/%s", $this->getPathPrefix(), $data['filename']);
    }

    private function getPathPrefix(): string
    {
        return 'mods';
    }
}
