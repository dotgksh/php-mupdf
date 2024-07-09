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

Via Composer

``` bash
$ composer require karkowg/php-mupdf
```

## Usage

### Convert all the pages to jpg

``` php
$pdf = new Karkow\MuPdf\Pdf('path/to/pdf/file');

$pdf->saveAllPagesAsImages('./images/', 'page-');
```

### Convert a single page to png

``` php
$pdf = new Karkow\MuPdf\Pdf('path/to/pdf/file');

$pdf
    ->setPage(2)
    ->setOutputFormat('png')
    ->saveImage('./images/page-2.png');
```

Please refer to `tests/PdfTest.php` for other use cases.

## [mutool](https://mupdf.com/releases/index.html)

A compiled binary (v1.20.0) is available at `bin/mutool`. If for any reason you want/need to use your own installation, you can do so by passing its path as a 2nd argument to the constructor.

``` php
$pdf = new Karkow\MuPdf\Pdf('path/to/pdf/file', 'path/to/mutool');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email karkowg@gmail.com instead of using the issue tracker.

## Credits

- [Gustavo Karkow][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/karkowg/php-mupdf.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/karkowg/php-mupdf/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/karkowg/php-mupdf.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/karkowg/php-mupdf.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/karkowg/php-mupdf.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/karkowg/php-mupdf
[link-travis]: https://travis-ci.org/karkowg/php-mupdf
[link-scrutinizer]: https://scrutinizer-ci.com/g/karkowg/php-mupdf/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/karkowg/php-mupdf
[link-downloads]: https://packagist.org/packages/karkowg/php-mupdf
[link-author]: https://github.com/karkowg
