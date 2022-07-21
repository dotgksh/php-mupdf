<?php

declare(strict_types=1);

namespace Karkow\MuPdf;

use Karkow\MuPdf\Exceptions\InvalidFormat;
use Karkow\MuPdf\Exceptions\PageDoesNotExist;
use Karkow\MuPdf\Exceptions\PdfFileDoesNotExist;
use RuntimeException;
use Symfony\Component\Process\Process;

class Pdf
{
    public const SUPPORTED_FORMATS = ['jpg', 'jpeg', 'png'];

    protected string $file;
    protected string $muToolPath;
    protected string $outputFormat = 'jpg';
    protected int $page = 1;
    protected int $width = 1920;
    protected int $height = 1080;

    public function __construct(string $file, string $muToolPath = 'bin/mutool')
    {
        if (! file_exists($file)) {
            throw new PdfFileDoesNotExist("File `$file` does not exist");
        }

        $this->muToolPath = $muToolPath;

        $command = new Process([$this->muToolPath, '-v']);

        $command->mustRun();

        if (! $command->isSuccessful()) {
            throw new RuntimeException('mutool is not available');
        }

        $this->file = $file;
    }

    public function setPage(int $page) : self
    {
        if ($page > $this->numberOfPages() || $page < 1) {
            throw new PageDoesNotExist("Page $page does not exist");
        }

        $this->page = $page;

        return $this;
    }

    public function setWidth(int $width) : self
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight(int $height) : self
    {
        $this->height = $height;

        return $this;
    }

    public function setOutputFormat(string $format) : self
    {
        if (! $this->isValidOutputFormat($format)) {
            throw new InvalidFormat("Format `$format` is not supported");
        }

        $this->outputFormat = $format;

        return $this;
    }

    private function isValidOutputFormat(string $format) : bool
    {
        return in_array($format, self::SUPPORTED_FORMATS);
    }

    public function numberOfPages() : int
    {
        $command = new Process([
            $this->muToolPath,
            'show',
            $this->file,
            'trailer/Root/Pages/Count',
        ]);

        $command->run();

        return intval($command->getOutput());
    }

    public function saveImage(string $pathToImage) : bool
    {
        if (is_dir($pathToImage)) {
            $pathToImage = rtrim($pathToImage, '\/') . DIRECTORY_SEPARATOR . $this->page . '.' . $this->outputFormat;
        }

        $command = new Process([
            $this->muToolPath,
            'draw',
            '-w',
            $this->width,
            '-h',
            $this->height,
            '-o',
            $pathToImage,
            $this->file,
            $this->page,
        ]);

        $command->run();

        return $command->isSuccessful();
    }

    public function saveAllPagesAsImages(string $directory, string $prefix = '') : array
    {
        $numberOfPages = $this->numberOfPages();

        if ($numberOfPages === 0) {
            return [];
        }

        return array_map(function ($pageNumber) use ($directory, $prefix) {
            $this->setPage($pageNumber);

            $destination = "$directory/$prefix$pageNumber.$this->outputFormat";

            $this->saveImage($destination);

            return $destination;
        }, range(1, $numberOfPages));
    }
}
