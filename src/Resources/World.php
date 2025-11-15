<?php namespace MetaMods\Resources;

class World extends Resource
{
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    protected function getPathPrefix(): string
    {
        return 'saves';
    }
}
