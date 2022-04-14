#!/usr/bin/env bash
set -x
awslocal s3 mb s3://${BUCKET_NAME}
set +x