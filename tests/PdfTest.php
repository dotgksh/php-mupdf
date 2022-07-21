<?php

declare(strict_types=1);

namespace Karkow\MuPdf\Tests;

use Karkow\MuPdf\Pdf;
use RuntimeException;

beforeEach(function () {
    $this->testFile = __DIR__ . '/files/test.pdf';
    $this->multipageTestFile = __DIR__ . '/files/5-page-test.pdf';

    exec('rm -f -- ' . __DIR__ . '/conversions/*.jpg');
});

it('will throw an exception when try to convert a non existing file', function () {
    new Pdf('does-not-exist.pdf');
})->throws(RuntimeException::class);

it('will throw an exception when trying to convert to invalid file type', function () {
    // (new Pdf($this->testFile))->setOutputFormat('bla');
})
    ->throws(RuntimeException::class)
    ->skip('missing implementation');

it('will throw an exception when passed an invalid page number', function ($invalidPage) {
    (new Pdf($this->multipageTestFile))->setPage($invalidPage);
})
    ->throws(RuntimeException::class)
    ->with([6, 0, -1]);

it('will correctly return the number of pages in pdf file', function () {
    $pdf = new Pdf($this->multipageTestFile);

    expect($pdf->numberOfPages())->toEqual(5);
});

it('will convert to default image dimensions', function () {
    $pdf = new Pdf($this->testFile);

    $pdf->saveAllPagesAsImages($dir = __DIR__ . '/conversions/', 'page-');

    list($width, $height) = getimagesize("$dir/page-1.jpg");

    expect($width)->toBe(1920);
    expect($height)->toBe(1080);
});

it('will convert to custom image dimensions', function () {
    $pdf = new Pdf($this->testFile);

    $pdf
        ->setWidth(1024)
        ->saveAllPagesAsImages($dir = __DIR__ . '/conversions/', 'page-');

    list($width, $height) = getimagesize("$dir/page-1.jpg");

    expect($width)->toBe(1024);
    expect($height)->toBe(576);
});

it('will convert a specified page', function () {
    $pdf = new Pdf($this->multipageTestFile);

    $pdf->setPage(2)->saveImage($path = __DIR__ . '/conversions/page-2.jpg');

    expect(file_exists($path))->toBeTrue();
});

it('will convert all pages', function () {
    $pdf = new Pdf($this->multipageTestFile);

    $pdf->saveAllPagesAsImages($dir = __DIR__ . '/conversions/', $prefix = 'page-');

    for ($i = 1; $i <= 5; $i++) {
        expect(file_exists("$dir/$prefix$i.jpg"))->toBeTrue();
    }
});

it('will accept a specified file type and convert to it', function () {
    $pdf = new Pdf($this->testFile);

    $pdf
        // ->setOutputFormat('png')
        ->saveImage($path = __DIR__ . '/conversions/page-1.png');

    expect(file_exists($path))->toBeTrue();
})->skip('missing implementation');
