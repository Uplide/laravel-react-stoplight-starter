#!/bin/bash

# Vite build işlemini gerçekleştir
yarn tsc && vite build

# Build klasöründeki dosyaları Laravel public klasörüne kopyala
cp -r dist/* ../public/

echo "Build files have been copied to Laravel public directory."
