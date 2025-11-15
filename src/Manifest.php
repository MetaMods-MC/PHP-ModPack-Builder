<?php namespace MetaMods;

use MetaMods\Enums\ResourceEnvironmentTypesEnum;

class Manifest
{
    const GAME = 'minecraft';

    const FORMAT_VERSION = 1;

    const MANIFEST_FILENAME = 'modpack.manifest.json';

    private readonly Modpack $modpack;

    public array $manifest = [];

    public function __construct(Modpack $modpack)
    {
        $this->modpack = $modpack;
    }

    public static function for(Modpack $modpack): self
    {
        return new self($modpack);
    }

    public function generate(): self
    {
        $this->manifest = [
            'game' => self::GAME,
            'format_version' => self::FORMAT_VERSION,
            'modpack' => [
                'name' => $this->modpack->name,
                'version' => $this->modpack->version,
                'summary' => $this->modpack->summary,
                'files' => []
            ]
        ];

        foreach ($this->modpack->getResources() as $resource) {
            $this->manifest['modpack']['files'][$resource->path] = [
                'hashes' => [
                    'md5' => $resource->md5,
                    'sha1' => $resource->sha1,
                    'sha512' => $resource->sha1,
                ],
                'downloads' => [$resource->downloadUrl],
                'env' => [
                    'client_side' => $resource->clientSide === 1 ? ResourceEnvironmentTypesEnum::REQUIRED->value : ($resource->clientSide === -1 ? ResourceEnvironmentTypesEnum::INCOMPATIBLE->value : ResourceEnvironmentTypesEnum::OPTIONAL->value),
                    'server_side' => $resource->serverSide === 1 ? ResourceEnvironmentTypesEnum::REQUIRED->value : ($resource->serverSide === -1 ? ResourceEnvironmentTypesEnum::INCOMPATIBLE->value : ResourceEnvironmentTypesEnum::OPTIONAL->value)
                ],
                'size' => $resource->size,
            ];
        }

        return $this;
    }

    public function toJson(): string
    {
        return json_encode($this->manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function toArray(): array
    {
        return $this->manifest;
    }

    public function getFileName(): string
    {
        return self::MANIFEST_FILENAME;
    }
}
