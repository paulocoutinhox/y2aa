#!/bin/sh

CMD_NAME=console-test

if ps -ef | grep -v grep | grep "make ${CMD_NAME}" ; then
  echo "Already running: ${CMD_NAME}"
  exit 0
else
  echo "Starting: ${CMD_NAME}"
  make ${CMD_NAME} docker=1
  exit 0
fi