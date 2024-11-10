<?php

$binDir = __DIR__ . "/../vendor/bin";

function getArchitecture()
{
    $arch = strtolower(php_uname("m"));
    $archMap = [
        "x86_64" => "amd64",
        "amd64" => "amd64",
        "aarch64" => "arm64",
        "arm64" => "arm64",
    ];

    return $archMap[$arch] ?? null;
}

function getBinaryUrl($os, $architecture)
{
    $binaryUrls = [
        "linux" => [
            "amd64" => "https://github.com/dotgksh/php-mupdf/releases/latest/download/mutool_linux_amd64",
            "arm64" => "https://github.com/dotgksh/php-mupdf/releases/latest/download/mutool_linux_arm64",
        ],
        "darwin" => [
            "amd64" => "https://github.com/dotgksh/php-mupdf/releases/latest/download/mutool_darwin_amd64",
            "arm64" => "https://github.com/dotgksh/php-mupdf/releases/latest/download/mutool_darwin_arm64",
        ],
        "windows" => [],
    ];

    return $binaryUrls[$os][$architecture] ?? null;
}

function downloadBinary($url, $target)
{
    $content = file_get_contents($url);

    if ($content === false) {
        throw new Exception("Failed to download from $url");
    }

    file_put_contents($target, $content);
}

$os = strtolower(PHP_OS_FAMILY);
$architecture = getArchitecture();

if (! $architecture) {
    echo "Unsupported architecture: " . php_uname("m") . "\n";
    exit(1);
}

$url = getBinaryUrl($os, $architecture);

if (! $url) {
    echo "Unsupported OS: $os or architecture: $architecture\n";
    exit(1);
}

if (! file_exists($binDir)) {
    mkdir($binDir, 0755, true);
}

$target = "$binDir/mutool" . ($os === "windows" ? ".exe" : "");

echo "Downloading mutool binary for $os ($architecture)...\n";

try {
    downloadBinary($url, $target);

    if ($os !== "windows") {
        chmod($target, 0755);
    }

    echo "Installed mutool binary in $target\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
