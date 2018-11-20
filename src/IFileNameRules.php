<?php declare(strict_types=1);

namespace Winnie\LaraDebut;

interface IFileNameRules
{
    public function isValidLogFileName($fileName) : bool;
}