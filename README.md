<p align="center">
    <img src="https://banners.beyondco.de/gksh%2Fphp-mupdf.png?theme=light&packageManager=composer+require&packageName=karkowg%2Fphp-mupdf&pattern=wiggle&style=style_1&description=Minimal+PDF+to+image+converter+using+MuPDF&md=1&showWatermark=0&fontSize=175px&images=photograph&widths=100&heights=100" alt="Package banner">
</p>

# php-mupdf
Minimal PDF to image converter using [MuPDF](https://mupdf.com/docs/mutool.html). Heavily inspired by [spatie/image-to-pdf](https://github.com/spatie/pdf-to-image).

[![Latest Version on Packagist](https://img.shields.io/packagist/v/karkowg/php-mupdf.svg)](https://packagist.org/packages/karkowg/php-mupdf)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/karkowg/php-mupdf/tests.yml?branch=main)](https://github.com/dotgksh/php-mupdf/actions?query=workflow%3Atests+branch%3Amain)
[![License](https://img.shields.io/packagist/l/karkowg/php-mupdf.svg)](https://github.com/dotgksh/php-mupdf/blob/main/LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/karkowg/php-mupdf.svg)](https://packagist.org/packages/karkowg/php-mupdf)

## Install
``` bash
$ composer require karkowg/php-mupdf
```

## Usage
### Convert all the pages to jpg
``` php
$pdf = new Gksh\MuPdf\Pdf('path/to/pdf/file');

$pdf->saveAllPagesAsImages('./images/', 'page-');
```

### Convert a single page to png
``` php
$pdf = new Gksh\MuPdf\Pdf('path/to/pdf/file');

$pdf
    ->setPage(2)
    ->setOutputFormat('png')
    ->saveImage('./images/page-2.png');
```

Please refer to `tests/PdfTest.php` for other use cases.

## [mutool](https://mupdf.com/releases/index.html)
A build script will compile `mutool` and make it available under `bin/mutool`. If for any reason you want/need to use your own installation, you can do so by passing its path as a 2nd argument to the constructor.

``` php
$pdf = new Gksh\MuPdf\Pdf('path/to/pdf/file', 'path/to/mutool');
```

## Testing
``` bash
$ ./build-mupdf.sh
$ composer test
```

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security
If you discover any security related issues, please email karkowg@gmail.com instead of using the issue tracker.

## Credits
- [Gustavo Karkow](https://github.com/karkowg)
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
