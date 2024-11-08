<?php

$os = strtolower(PHP_OS_FAMILY);
$binDir = __DIR__ . '/../vendor/bin';

$binaryUrls = [
    'linux' => 'https://github.com/dotgksh/php-mupdf/releases/latest/download/mutool-linux',
    'darwin' => 'https://github.com/dotgksh/php-mupdf/releases/latest/download/mutool-macos',
    'windows' => 'https://github.com/dotgksh/php-mupdf/releases/latest/download/mutool-windows.exe',
];

if (!array_key_exists($os, $binaryUrls)) {
    echo "Unsupported OS: $os\n";
    exit(1);
}

if (!file_exists($binDir)) {
    mkdir($binDir, 0755, true);
}

$target = "$binDir/mutool" . ($os === 'windows' ? '.exe' : '');

echo "Downloading mutool binary for $os...\n";

file_put_contents($target, file_get_contents($binaryUrls[$os]));

if ($os !== 'windows') {
    chmod($target, 0755);
}

echo "Installed mutool binary in $target\n";
