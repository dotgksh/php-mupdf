#!/usr/bin/env bash

rm -f ./bin/mutool
rm -rf ./build
mkdir build
cd build
curl "https://mupdf.com/downloads/archive/mupdf-1.20.0-source.tar.gz" -o "mupdf.tar.gz"
tar -xf mupdf.tar.gz
cd mupdf-1.20.0-source
make HAVE_X11=no HAVE_GLUT=no prefix=../. install
cd ..
cp bin/mutool ../bin/mutool
