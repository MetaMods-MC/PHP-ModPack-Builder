# PHP ModPack Builder

Minecraft modpack MetaMods like format builder.

## Requirements



## Installation

Use composer to install this package:

```SHELL
composer require metamods/php-modpack-builder
```

## Usage

Create instance of Modpack:

```PHP
use MetaMods\Modpack;

$modpack = Modpack::create($name, $version, $summary);
```
Pass `name` of your modpack, optional `version` and optional `summary` as description.

To add some resource use next:

```PHP
use MetaMods\Resources\Mod;

$modpack->add(new Mod('ae2'));
```

If you want to add multiple resources:

```PHP
$modpack->add([
    new Mod('ae2'),
    new Mod('industrial-craft')
]);
```

And then build your modpack:

```PHP
$modpack->build();
```

## Supported resource types

### Mods

```PHP
use MetaMods\Resources\Mod;

$mod = new Mod('ae2');
```

You can find the entire [mod catalog](https://metamods.net/mods) on MetaMods.
