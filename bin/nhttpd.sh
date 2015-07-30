#!/bin/bash

pushd `dirname $0` > /dev/null
DIRNAME=`pwd`
popd > /dev/null

cd $DIRNAME/..
java -jar $DIRNAME/nhttpd.jar $@