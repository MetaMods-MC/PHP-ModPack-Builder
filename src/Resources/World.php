<?php namespace MetaMods\Resources;

class World
{
    public function __construct(array $data)
    {
        $this->path = sprintf("%s/%s/", $this->getPathPrefix(), $data['filename']);
    }

    private function getPathPrefix(): string
    {
        return 'worlds';
    }
}
