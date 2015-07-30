#!/bin/sh

DIRNAME=`dirname $0`
java -jar $DIRNAME/nhttpd.jar $@
