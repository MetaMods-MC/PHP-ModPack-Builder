<?php namespace MetaMods;

use GuzzleHttp\Client;
use ZipStream\ZipStream;
use MetaMods\Resources\Override;
use MetaMods\Resources\Resource;
use ZipStream\Stream\CallbackStreamWrapper;
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

    public static function create(string $name, string $version = '1.0.0', string $summary = null): self
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

    private function fetchResources()
    {
        $ids = array_map(fn (Resource $resource) => $resource->id, $this->resources);

        if (empty($ids)) {
            return false;
        }

        $client = new Client([
            'verify' => false,
        ]);

        $request = $client->get('https://api.metamods.net/v1/resources/findMany', [
            'json' => $ids
        ]);

        $response = json_decode($request->getBody());

        foreach ($response as $fetchedResource) {
            foreach ($this->getResources() as $resource) {
                if ($fetchedResource->id === $resource->id) {
                    $resource->saturate($fetchedResource);
                    continue 2;
                }
            }
        }
    }

    /**
     * @throws ZipArchiveCreateException
     */
    public function build(callable $callback): void
    {
        $this->fetchResources();

        $zip = new ZipStream(
            outputStream: $callback,
            sendHttpHeaders: false,
        );

        $manifest = $this->generateManifest();

        $zip->addFile(fileName: $manifest->getFileName(), data: $manifest->toJson());

        foreach ($this->overrides as $override) {
            $zip->addFile(fileName: $override->path, data: $override->content);
        }

        $zip->finish();
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
