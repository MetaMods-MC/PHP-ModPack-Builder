<?php namespace MetaMods\Resources;

class Shader extends Resource
{
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    protected function getPathPrefix(): string
    {
        return 'shaderpacks';
    }
}
