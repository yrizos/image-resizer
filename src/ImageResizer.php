<?php

namespace ImageResizer;

use PHPImageWorkshop\Core\ImageWorkshopLayer;
use PHPImageWorkshop\ImageWorkshop;
use Symfony\Component\Finder\Finder;

class ImageResizer
{

    private $sourceDirectory;
    private $targetDirectory;
    private $quality = 100;
    private $extensions = ["jpg", "png"];

    public function __construct($sourceDirectory, $targetDirectory, $quality = 100, $extensions = ["jpg", "png"])
    {
        $this->setSourceDirectory($sourceDirectory);
        $this->setTargetDirectory($targetDirectory);
        $this->setQuality($quality);
        $this->setExtensions($extensions);
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

    public function setQuality($quality)
    {
        $quality = (int)$quality;
        if ($quality < 0) $quality = 0;
        if ($quality > 100) $quality = 100;

        $this->quality = $quality;

        return $this;
    }

    public function getQuality()
    {
        return $this->quality;
    }

    public function setExtensions($extensions)
    {
        if (!is_array($extensions)) $extensions = explode(",", $extensions);


        $extensions = array_map(function ($ext) {
            $ext = strval($ext);
            $ext = trim($ext);
            $ext = strtolower($ext);

            return $ext;
        }, $extensions);

        $extensions = array_filter($extensions, function ($ext) {
            return !empty($ext);
        });

        $this->extensions = $extensions;

        return $this;
    }

    public function getExtensions()
    {
        return $this->extensions;
    }

    public function findSourceImages()
    {
        $extensions = implode(",", $this->getExtensions());
        $finder     = new Finder();
        $files      = $finder->files()->name("*.{" . $extensions . "}")->in($this->getSourceDirectory());
        $result     = [];

        foreach ($files as $file) $result[] = $file->getRealpath();

        return $result;
    }

    public function resizeToMaxDimension($dimension)
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

            $this->resizeImage($path, $layer, $width, $height);
        }

        return true;
    }

    public function resizeToMaxWidth($width)
    {
        $images = $this->findSourceImages();
        $width  = (int)$width;

        foreach ($images as $path) {
            $this->resizeImage($path, ImageWorkshop::initFromPath($path), $width, null);
        }

        return true;
    }

    public function resizeToMaxHeight($height)
    {
        $images = $this->findSourceImages();
        $height = (int)$height;

        foreach ($images as $path) {
            $this->resizeImage($path, ImageWorkshop::initFromPath($path), null, $height);
        }

        return true;
    }

    public function pad($width, $height, $backgroundColor = null)
    {
        $images = $this->findSourceImages();

        foreach ($images as $path) {
            $this->padImage($path, ImageWorkshop::initFromPath($path), $width, $height, $backgroundColor);
        }

        return true;
    }

    protected function resizeImage($path, ImageWorkshopLayer $layer, $width = null, $height = null)
    {
        $layer->resizeInPixel($width, $height, true);

        return $this->saveImage($path, $layer);
    }

    protected function padImage($path, ImageWorkshopLayer $layer, $width, $height, $backgroundColor = null)
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

        return $this->saveImage($path, $bg);
    }

    protected function saveImage($path, ImageWorkshopLayer $layer)
    {
        $path     = str_replace($this->getSourceDirectory(), $this->getTargetDirectory(), $path);
        $basename = basename($path);
        $dirname  = dirname($path);


        $layer->save($dirname, $basename, true, null, $this->getQuality());

        return file_exists($path);
    }


}