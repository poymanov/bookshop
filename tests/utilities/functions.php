<?php

function create($class, $arguments = [], $times = null)
{
    return factory($class, $times)->create($arguments);
}

function make($class, $arguments = [], $times = null)
{
    return factory($class, $times)->make($arguments);
}