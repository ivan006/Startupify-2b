<?php

function FileExtention($name)
{
    $explodedName = explode('.', $name);
    $extention = end($explodedName);

    return $extention;
}
