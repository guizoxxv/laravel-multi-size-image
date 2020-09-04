# Laravel Multi Size Image

A Laravel package to optimize and store images in different sizes in order to load the appropriate one according to the screen size.

## Pre-requisites
* To resize the images this package uses the [Intervention library](http://image.intervention.io/) which requires a image library like [GD](https://www.php.net/manual/en/book.image.php) or [ImageMagick](https://www.php.net/manual/en/book.imagick.php).
* To optimize the images this package uses [image-optimizer](https://github.com/spatie/image-optimizer) package which requires [optimizers](https://github.com/spatie/image-optimizer#optimization-tools) to be present in your system. This package uses [JpegOptim](http://freshmeat.sourceforge.net/projects/jpegoptim), [Optipng](http://optipng.sourceforge.net/) and [Pngquant 2](https://pngquant.org/) optimizers.

## Installation
Require the package via Composer:

```
$ composer require guizoxxv/laravel-multi-size-image
```

## Configuration
Publish the package configuration file to your Laravel project to change the default behavior.

```
$ php artisan vendor:publish --provider="Guizoxxv\LaravelMultiSizeImage\MultiSizeImageServiceProvider"
```

A `config/multiSizeImage.php` file will be added in your project.

## Usage

**1. Instantiate**

To apply Multi Size Image first you must create a instance of it.

```php
use Guizoxxv\LaravelMultiSizeImage\MultiSizeImage;

...

$multiSizeImage = new MultiSizeImage();
```

**2. Process image**

Call the `processImage` method passing the file path as the first argument.

```php
$filePath = Storage::path('folder/file.png');

$multiSizeImage->processImage($filePath);
```

> The file path must be absolute.

The method returns an array of strings with the full path of the generated files.

**2.1. Mime types**

Only mime types defined in the `mime_types` array in the `config/multiSizeImage.php` file are considered. If a file with mime type not present is used, it is ignored and the method retuns `null`.

> This package is configured to optimize `jpeg` and `png` images. Check the [Optimizing](#optimizing) section to learn how to optimize images with other mime types.

**2.2. Output path**

The default behavior is to create the resized image versions in the same path as the original's. To send the images to a different location you can provide the output path as a second optional parameter.

```php
$multiSizeImage->processImage($filePath, $outputPath, $basePath);
```

The `basePath` optional parameter can be used to keep the original file path as of this path.

**2.3. Resizing**

The resizable values are defined by the `sizes` array in the `config/multiSizeImage.php` file. This array has the keys as the size identification and the value as the size for the image be resized to.

```php
'sizes' => [
    'tb' => 150,
    'sm' => 300,
    'lg' => 1024,
]
```

Above are the default values. The biggest dimmension is considered when resizing and the aspect ratio is kept. An auto-generated name will be used as the new file name. The size identification is used as a suffix in the file name to distinct which will be loaded.


> **Example:**
>
> If a 2000x1000px (width x height) image is used, the following files will be generated:
> * 5f4bc74348ccb@lg.png (1024x512px)
> * 5f4bc7431e3ac@sm.png (300x150px)
> * 5f4bc742eb1e3@tb.png (150x75px)
>

If the image width and height are lower than the specified resize value, the image is not resized and the new file is generated without a suffix.

> **Example:**
>
> If a 100x200px (width x height) image is used, the following files will be generated:
> * 5f4bd0444e9dd.png (100x200px)
> * 5f4bd0444e9dd@tb.png (75x150px)

**2.4. File name**

If you want to keep the original's file name instead of using a auto-generated one, set `keep_original_name` to `true` in the `config/multiSizeImage.php` file.

You can also provide a optional custom name as a forth parameter to the `processImage` method.

```php
$multiSizeImage->processImage($filePath, $outputPath, $basePath, $fileName);
```

**2.5. Optimizing**

By default the newly generate image is also optimized using [image-optimizer](https://github.com/spatie/image-optimizer) package with [JpegOptim](http://freshmeat.sourceforge.net/projects/jpegoptim), [Optipng](http://optipng.sourceforge.net/) and [Pngquant 2](https://pngquant.org/) optimizers with the following `OptimizerChain`.

```php
$optimizerChain = (new OptimizerChain)
    ->addOptimizer(new Jpegoptim([
        '-m85',
        '--strip-all',
        '--all-progressive',
    ]))
    ->addOptimizer(new Pngquant([
        '--force',
    ]))
    ->addOptimizer(new Optipng([
        '-i0',
        '-o2',
        '-quiet',
    ]));
```

To override the default optimization behavior you can provide a custom `OptimizerChain` as an argument when instantiating `MultiSizeImage`.

```php
use Guizoxxv\LaravelMultiSizeImage\MultiSizeImage;
use Spatie\ImageOptimizer\Optimizers\Svgo;
use Spatie\ImageOptimizer\Optimizers\Optipng;
use Spatie\ImageOptimizer\Optimizers\Gifsicle;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Cwebp;

...

$optimizerChain = (new OptimizerChain)
    ->addOptimizer(new Jpegoptim([
        '-m85',
        '--strip-all',
        '--all-progressive',
    ]))
    ->addOptimizer(new Pngquant([
        '--force',
    ]))
    ->addOptimizer(new Optipng([
        '-i0',
        '-o2',
        '-quiet',
    ]))
    ->addOptimizer(new Svgo([
        '--disable=cleanupIDs',
    ]))
    ->addOptimizer(new Gifsicle([
        '-b',
        '-O3'
    ]))
    ->addOptimizer(new Cwebp([
        '-m 6',
        '-pass 10',
        '-mt',
        '-q 90',
    ]));

$multiSizeImage = new MultiSizeImage($optimizerChain);
```

You can also disable optimization by setting `optimize` to `false` in the `config/multiSizeImage.php` file.

**2.6. Delete original**

The default behavior is to delete the original image after processing if the resized files names don't match the original's (changed name or path). If you choose to keep it set set `keep_original_file` to `true` in the `config/multiSizeImage.php` file.

**3. Render**

Render the image file according to the screen size.

> Remenber to provide a fallback in case the image name does not have a suffix.