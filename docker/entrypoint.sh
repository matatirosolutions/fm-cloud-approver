#!/usr/bin/env bash

composer update -n
vendor/bin/bdi detect drivers

exec "$@"
