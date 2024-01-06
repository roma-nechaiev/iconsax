## Introduction

The package provides icons as a set of blade components that can be easily customized to suit your application's needs.

## Installation

```bash
composer require sax-ui/iconsax
```

## Usage

After Composer has installed the Laravel Iconsax package, you may run the icon:add Artisan command. This command publishes icon component to your application. 

```bash
php artisan icon:add smileys --type=linear
```

Available types: 

```
linear | bold | outline | twotone | bulk | broken
```

If the icon name is missing, you will be prompted to enter a search term to filter the results.

 ![screenshot](https://github.com/roma-nechaiev/iconsax/assets/98153123/e2652a1a-ba79-4a1b-b456-6480165cc3da)


Then select the icon type

![screenshot-2](https://github.com/roma-nechaiev/iconsax/assets/98153123/b3fbcfa6-c078-4596-b53b-e81f6ccbe5ac)


That's all, the icon will be installed in the components folder.

## License

Iconsax is open-sourced software licensed under the [MIT license](LICENSE.md).
