<?php

declare(strict_types=1);

namespace WapplerSystems\Avif\Converter;

interface Converter
{
    public function __construct(string $parameters);

    /**
     * Converts a file $originalFilePath to avif in $targetFilePath.
     *
     * @throws \RuntimeException
     */
    public function convert(string $originalFilePath, string $targetFilePath): void;
}
