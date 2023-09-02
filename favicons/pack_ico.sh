#!/bin/sh
for size in 16 32 48; do
    inkscape -w $size -h $size -o ${size}.png favicon.svg;
done
convert *.png favicon.ico
