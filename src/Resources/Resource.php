<?php namespace MetaMods\Resources;

use GuzzleHttp\Client;

abstract class Resource
{
    public int $id;

    public string $fileName;

    public string $path;

    public int $size;

    public string $md5;

    public string $sha1;

    public string $sha512;

    public string $downloadUrl;

    public int $clientSide;

    public int $serverSide;

    public ?string $content;

    protected abstract function getPathPrefix(): string;

    public function saturate($data): self
    {
        if (empty($this->size)) {
            $this->size = $data->files[0]->size;
        }

        if (empty($this->fileName)) {
            $this->fileName = $data->files[0]->file_name;
        }

        if (empty($this->path)) {
            $this->path = sprintf('%s/%s', $this->getPathPrefix(), $this->fileName);
        }

        if (empty($this->md5)) {
            $this->md5 = $data->files[0]->md5;
        }

        if (empty($this->sha512)) {
            $this->sha512 = $data->files[0]->sha512;
        }

        if (empty($this->sha1)) {
            $this->sha1 = $data->files[0]->sha1;
        }

        if (empty($this->downloadUrl)) {
            $this->downloadUrl = $data->files[0]->download_url;
        }

        if (empty($this->clientSide)) {
            $this->clientSide = $data->client_side;
        }

        if (empty($this->serverSide)) {
            $this->serverSide = $data->server_side;
        }

        return $this;
    }
}
