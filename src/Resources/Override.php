<?php namespace MetaMods\Resources;

class Override extends Resource
{
    public function __construct(array $data)
    {
        $this->path = sprintf("%s/%s/", $this->getPathPrefix(), $data['filename']);
    }

    private function getPathPrefix(): string
    {
        return 'overrides';
    }
}
