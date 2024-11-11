#!/usr/bin/env bash

VERSION=1.24.10

rm -rf ./build
mkdir -p build
mkdir -p bin

target_dir="./build/${OS}_${ARCH}"
mkdir -p "$target_dir"

(
    cd "$target_dir" || exit
    curl "https://mupdf.com/downloads/archive/mupdf-$VERSION-source.tar.gz" -o "mupdf.tar.gz"
    tar -xf mupdf.tar.gz
    (
        cd mupdf-$VERSION-source || exit
        if [[ "$OS" == "linux" ]]; then
            if [[ "$ARCH" == "x86_64" ]]; then
                export CC="gcc"
                export CFLAGS="-m64"
            elif [[ "$ARCH" == "arm64" ]]; then
                export CC="aarch64-linux-gnu-gcc"
            fi
            make HAVE_X11=no HAVE_GLUT=no prefix=../../install_${OS}_${ARCH} install
        else
            # if [[ "$ARCH" == "x86_64" ]]; then
            #     export CC="clang"
            #     export XCFLAGS="-arch x86_64"
            #     export XLDFLAGS="-L/usr/local/lib -lX11 -lGL"
            # elif [[ "$ARCH" == "arm64" ]]; then
                # export CC="clang"
                # export XCFLAGS="-arch arm64"
                # export XLDFLAGS="-L/usr/local/lib -lX11 -lGL"
            # fi
            make HAVE_X11=no HAVE_GLUT=no prefix=../../install_${OS}_${ARCH} install
        fi
    )
)

ls -la
ls -la build
# cp ./build/${OS}_${ARCH}/mupdf-${VERSION}-source/bin/mutool ./bin/mutool_${OS}_${ARCH}
cp ./build/install_${OS}_${ARCH}/bin/mutool ./bin/mutool_${OS}_${ARCH}
