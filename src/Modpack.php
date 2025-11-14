<?php namespace MetaMods;

use MetaMods\Resources\Override;
use MetaMods\Resources\Resource;
use ZipArchive;
use MetaMods\Modpack\Exceptions\ZipArchiveCreateException;

class Modpack
{
    private array $resources = [];

    private array $overrides = [];

    public readonly string $name;

    public readonly string $version;

    public readonly string $summary;

    public function __construct(string $name, string $version = '1.0.0', string $summary = null)
    {
        $this->name = $name;
        $this->version = $version;
        $this->summary = $summary;
    }

    public static function create(string $name, string $version, string $summary): self
    {
        return new self($name, $version, $summary);
    }

    public function add(Resource|array $resources): self
    {
        if (!is_array($resources)) {
            $resources = [$resources];
        }

        foreach ($resources as $resource) {
            if ($resource instanceof Override) {
                $this->overrides[] = $resource;
            } else {
                $this->resources[] = $resource;
            }
        }

        return $this;
    }

    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * @throws ZipArchiveCreateException
     */
    public function build(): string
    {
        $zip = new ZipArchive;

        $fileName = $this->getFileName();

        if ($zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new ZipArchiveCreateException('Failed to create zip archive');
        }

        $manifest = $this->generateManifest();

        $zip->addFromString($manifest->getFileName(), $manifest->toJson());

        return $fileName;
    }

    private function generateManifest(): Manifest
    {
        return Manifest::for($this)->generate();
    }

    private function getFileName(): string
    {
        return sprintf('%s-%s.modpack', $this->name, $this->version);
    }

    public function getInfo(): array
    {
        return [

        ];
    }

    public function getSize(): int
    {
        return 0;
    }
}
