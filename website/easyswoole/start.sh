#!/bin/bash

if [ -d "$1" ]; then
    echo "开始"
    cd $1;
    php $2 $3
fi
