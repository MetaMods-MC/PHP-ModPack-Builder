<?php namespace MetaMods\Resources;

class Override extends Resource
{
    public function __construct(array $data)
    {
        $this->path = sprintf("%s/%s", $this->getPathPrefix(), $data['path']);
        $this->content = $data['content'];
    }

    protected function getPathPrefix(): string
    {
        return 'overrides';
    }
}
