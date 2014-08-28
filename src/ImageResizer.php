<?php

namespace ImageResizer;

use PHPImageWorkshop\Core\ImageWorkshopLayer;
use PHPImageWorkshop\ImageWorkshop;
use Symfony\Component\Finder\Finder;

class ImageResizer
{

    private $sourceDirectory;
    private $targetDirectory;

    public function __construct($sourceDirectory, $targetDirectory)
    {
        $this->setSourceDirectory($sourceDirectory);
        $this->setTargetDirectory($targetDirectory);
    }

    public function setSourceDirectory($directory)
    {
        if (!is_dir($directory)) throw new \InvalidArgumentException($directory . " is not a valid directory.");

        $this->sourceDirectory = realpath($directory);

        return $this;
    }

    public function getSourceDirectory()
    {
        return $this->sourceDirectory;
    }

    public function setTargetDirectory($directory, $create = true)
    {
        $create = ($create === true);
        if ($create && !is_dir($directory)) mkdir($directory, 0777, true);
        if (!is_dir($directory)) throw new \InvalidArgumentException($directory . " is not a valid directory.");

        $this->targetDirectory = realpath($directory);

        return $this;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function findSourceImages()
    {
        $finder = new Finder();
        $files  = $finder->files()->name("*.{jpg,png}")->in($this->getSourceDirectory());
        $result = [];

        foreach ($files as $file) $result[] = $file->getRealpath();

        return $result;
    }

    public function resizeToMaxDimension($dimension, $quality = 100)
    {
        $images    = $this->findSourceImages();
        $dimension = (int)$dimension;

        foreach ($images as $path) {
            $layer  = ImageWorkshop::initFromPath($path);
            $width  = null;
            $height = null;

            if ($layer->getWidth() >= $layer->getHeight()) {
                $width = $dimension;
            } else {
                $height = $dimension;
            }

            $this->resizeImage($path, $layer, $width, $height, $quality);
        }

        return true;
    }

    public function resizeToMaxWidth($width, $quality = 100)
    {
        $images = $this->findSourceImages();
        $width  = (int)$width;

        foreach ($images as $path) {
            $this->resizeImage($path, ImageWorkshop::initFromPath($path), $width, null, $quality);
        }

        return true;
    }

    public function resizeToMaxHeight($height, $quality = 100)
    {
        $images = $this->findSourceImages();
        $height = (int)$height;

        foreach ($images as $path) {
            $this->resizeImage($path, ImageWorkshop::initFromPath($path), null, $height, $quality);
        }

        return true;
    }

    public function pad($width, $height, $backgroundColor = null, $quality = 100)
    {
        $images = $this->findSourceImages();

        foreach ($images as $path) {
            $this->padImage($path, ImageWorkshop::initFromPath($path), $width, $height, $backgroundColor, $quality);
        }

        return true;
    }

    protected function resizeImage($path, ImageWorkshopLayer $layer, $width = null, $height = null, $quality = 100)
    {
        $layer->resizeInPixel($width, $height, true);

        return $this->saveImage($path, $layer, $quality);
    }

    protected function padImage($path, ImageWorkshopLayer $layer, $width, $height, $backgroundColor = null, $quality = 100)
    {
        $width  = (int)$width;
        $height = (int)$height;
        $w      = $layer->getWidth();
        $h      = $layer->getHeight();

        if ($w > $width) $width = $w;
        if ($h > $height) $height = $h;

        $posX = ($width - $w) / 2;
        $posY = ($height - $h) / 2;
        $bg   = ImageWorkshop::initVirginLayer($width, $height, $backgroundColor);


        $bg->addLayerOnTop($layer, $posX, $posY);

        unset($layer);

        return $this->saveImage($path, $bg, $quality);
    }

    protected function saveImage($path, ImageWorkshopLayer $layer, $quality = 100)
    {
        $path     = str_replace($this->getSourceDirectory(), $this->getTargetDirectory(), $path);
        $basename = basename($path);
        $dirname  = dirname($path);
        $quality  = (int)$quality;
        if ($quality < 1 || $quality > 100) $quality = 100;

        $layer->save($dirname, $basename, true, null, $quality);

        return file_exists($path);
    }


}