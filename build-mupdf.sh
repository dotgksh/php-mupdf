#!/usr/bin/env bash

VERSION=1.24.10

rm -rf ./build
mkdir -p build
mkdir -p bin

cd build || exit
curl "https://mupdf.com/downloads/archive/mupdf-$VERSION-source.tar.gz" -o "mupdf.tar.gz"
tar -xf mupdf.tar.gz
cd mupdf-$VERSION-source || exit
if [[ "$OS" == "linux" ]]; then
    if [[ "$ARCH" == "x86_64" ]]; then
        export CC="gcc"
        export XCFLAGS="-m64"
    elif [[ "$ARCH" == "arm64" ]]; then
        export CC="aarch64-linux-gnu-gcc"
        export CXX="aarch64-linux-gnu-g++"
        export XCFLAGS="-march=armv8-a"
    fi
    make HAVE_X11=no HAVE_GLUT=no prefix=../. install
else
    if [[ "$ARCH" == "x86_64" ]]; then
        export CC="clang"
        export CXX="clang++"
        export XCFLAGS="-arch x86_64"
        export XLDFLAGS="-L/opt/X11/lib -lX11 -framework OpenGL"
        export XCXXFLAGS="-v"
    elif [[ "$ARCH" == "arm64" ]]; then
        export CC="gcc-12"
        export CXX="g++-12"
        export XCFLAGS="-arch arm64 -I/opt/X11/include"
        export XLDFLAGS="-L/opt/X11/lib -lX11 -framework OpenGL"
        export XCXXFLAGS="-v"
    fi
    which xterm
    ps aux | grep XQuartz
    make prefix=../. install
fi

cd ..
ls -la
cp ./bin/mutool ../bin/mutool
cd ..
ls -la bin
