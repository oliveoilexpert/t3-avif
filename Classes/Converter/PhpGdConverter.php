<?php

declare(strict_types=1);

namespace WapplerSystems\Avif\Converter;

use TYPO3\CMS\Core\Imaging\GraphicalFunctions;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Uses the php gd library to generate avif images.
 */
final class PhpGdConverter extends AbstractConverter
{
    private const DEFAULT_QUALITY = 80;

    public function convert(string $originalFilePath, string $targetFilePath): void
    {
        if (!$this->gdSupportsAvif()) {
            throw new \RuntimeException(\sprintf('File "%s" was not created: GD is not active or does not support avif!', $targetFilePath));
        }

        $image = $this->getImage($originalFilePath);
        $result = \imageavif($image, $targetFilePath, $this->getQuality());

        if (!$result || !@\is_file($targetFilePath)) {
            throw new \RuntimeException(\sprintf('File "%s" was not created!', $targetFilePath));
        }
    }

    private function getGraphicalFunctionsObject(): GraphicalFunctions
    {
        static $graphicalFunctionsObject = null;

        if (null === $graphicalFunctionsObject) {
            /** @var GraphicalFunctions $graphicalFunctionsObject */
            $graphicalFunctionsObject = GeneralUtility::makeInstance(GraphicalFunctions::class);
        }

        return $graphicalFunctionsObject;
    }

    private function gdSupportsAvif(): bool
    {
        return \function_exists('imageavif')
            && \defined('IMG_WEBP')
            && (\imagetypes() & IMG_WEBP) === IMG_WEBP;
    }

    /**
     * @return resource
     */
    private function getImage(string $originalFilePath)
    {
        $image = $this->getGraphicalFunctionsObject()->imageCreateFromFile($originalFilePath);
        // Convert CMYK to RGB
        if (!\imageistruecolor($image)) {
            \imagepalettetotruecolor($image);
        }

        return $image;
    }

    private function getQuality(): int
    {
        \preg_match('/quality(\s|=)(\d{1,3})/', $this->parameters, $matches);

        if (isset($matches[2]) && (int) $matches[2] > 0) {
            return (int) $matches[2];
        }

        return self::DEFAULT_QUALITY;
    }
}
