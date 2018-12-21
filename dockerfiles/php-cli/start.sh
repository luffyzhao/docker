#!/bin/bash

if [ -d "$1" ]; then
    cd $1;
    php $2 $3
fi