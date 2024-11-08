#!/usr/bin/env bash

VERSION=1.24.10

rm -rf ./build
mkdir build
(
    cd build || exit
    curl "https://mupdf.com/downloads/archive/mupdf-$VERSION-source.tar.gz" -o "mupdf.tar.gz"
    tar -xf mupdf.tar.gz
    (
        cd mupdf-$VERSION-source || exit
        make HAVE_X11=no HAVE_GLUT=no prefix=../. install
    )
)
cp ./build/bin/mutool ./bin/mutool
