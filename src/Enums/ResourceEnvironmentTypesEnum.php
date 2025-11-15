<?php namespace MetaMods\Enums;

enum ResourceEnvironmentTypesEnum: string
{
    case INCOMPATIBLE = 'incompatible';
    case OPTIONAL = 'optional';
    case REQUIRED = 'required';
}