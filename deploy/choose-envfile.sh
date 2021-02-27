#!/bin/bash

if [[ "homolog" == "$CODEBUILD_GIT_BRANCH" ]] 
then
    cp .env.development .env
else [[ "production" == "$CODEBUILD_GIT_BRANCH" ]]
    cp .env.development .env
fi