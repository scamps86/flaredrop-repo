<?php

/**
 * Picture utilities
 */
class UtilsPicture
{

    /**
     * Fit an image in a new a width and height
     *
     * @param string $binaryData The image binary data
     * @param int $width The limit width
     * @param int $height The limit height
     * @param int $limitDimensions Set the maximum width and height dimensions. Infinite by default
     *
     * @return string The optput image binary data
     */
    public static function fit($binaryData, $width, $height, $limitDimensions = 0)
    {
        $img = new Imagick();
        $img->readImageBlob($binaryData);

        $width = $width > $limitDimensions && $limitDimensions > 0 ? $limitDimensions : $width;
        $height = $height > $limitDimensions && $limitDimensions > 0 ? $limitDimensions : $height;

        $img->resizeimage($width, $height, imagick::FILTER_LANCZOS, 1, true);
        return $img->getImageBlob();
    }


    /**
     * Resize an image. If the dimensions are not proportionally it will be distorted. If a dimension is passed as 0 or not passed, it will resize proportionally
     *
     * @param string $binaryData The image binary data
     * @param int $width The new image width
     * @param int $height The new image height
     *
     * @return string    The output image binary data
     */
    public static function resize($binaryData, $width = 0, $height = 0)
    {
        $img = new Imagick();
        $img->readImageBlob($binaryData);
        $img->resizeimage($width, $height, imagick::FILTER_LANCZOS, 1);
        return $img->getImageBlob();
    }


    /**
     * Crop an image from the center and resizing it if necessary.
     *
     * The crop from center are only applied if the resizing is enabled
     *
     * @param string $binaryData The binary image data
     * @param int $width The cropping width
     * @param int $height The cropping height
     * @param boolean $resize Enable the image resize when cropping (true by default)
     * @param int $xFrom The X pixel that the cropping starts, only if resize is disabled
     * @param int $yFrom The Y pixel that the cropping starts, only if resize is disabled
     *
     * @return string    The output image binary data
     */
    public static function crop($binaryData, $width, $height, $resize = true, $xFrom = 0, $yFrom = 0)
    {
        $img = new Imagick();
        $img->readImageBlob($binaryData);

        if ($resize) {
            $img->cropThumbnailImage($width, $height);
        } else {
            $img->cropImage($width, $height, $xFrom, $yFrom);
        }
        return $img->getImageBlob();
    }


    /**
     * Reduce the quality of an image (only for JPG files)
     *
     * @param string $binaryData The image binary data
     * @param int $quality The quality percent (0 to 100)
     *
     * @return string    The output image binary data
     */
    public static function setQuality($binaryData, $quality = 70)
    {
        // Get the image content type
        $contentType = Managers::ftpFileSystem()->fileContentType('', $binaryData);

        // Only compress JPG files
        if ($contentType == 'image/jpeg') {
            $img = new Imagick();
            $img->readimageblob($binaryData);
            $img->setImageCompression(Imagick::COMPRESSION_JPEG);
            $img->setImageCompressionQuality($quality);
            $binaryData = $img->getImageBlob();
        }

        return $binaryData;
    }


    /**
     * Get the image dimensions from a binary image data
     *
     * @param string $binaryData The binary image data
     *
     * @return array The image dimensions as an array [width, height]
     */
    public static function getDimensions($binaryData)
    {
        $img = new Imagick();
        $img->readImageBlob($binaryData);
        $geometry = $img->getImageGeometry();

        return [$geometry['width'], $geometry['height']];
    }


    /**
     * @param string $binaryData The pattern binary data
     * @param int $width The image width to apply the pattern
     * @param int $height The image height to apply the pattern
     *
     * @return string The output image binary data
     */
    public static function createPattern($binaryData, $width, $height)
    {
        $img = new Imagick();
        $img->readImageBlob(self::createEmptyImage($width, $height));
        $pattern = new Imagick();
        $pattern->readImageBlob($binaryData);
        $img = $img->textureImage($pattern);
        return $img->getImageBlob();
    }


    /**
     * Combine two image layers
     *
     * @param string $baseBinaryData The base image data
     * @param string $toAddBinaryData The image data to combine
     * @param int $x The X where to combine the image
     * @param int $y The Y where to combine the image
     *
     * @return string The output image binary data
     */
    public static function combine($baseBinaryData, $toAddBinaryData, $x, $y)
    {
        $img = new Imagick();
        $img->readImageBlob($baseBinaryData);
        $img2 = new Imagick();
        $img2->readImageBlob($toAddBinaryData);

        $img->compositeImage($img2, Imagick::COMPOSITE_DEFAULT, $x, $y);
        return $img->getImageBlob();
    }


    /**
     * Append two images
     *
     * @param string $baseBinaryData The base image data
     * @param string $toAddBinaryData The append image data
     * @param boolean $toRight Append the image on the right or on the bottom. (On the right by default)
     *
     * @return string The output image binary data
     */
    public static function append($baseBinaryData, $toAddBinaryData, $toRight = true)
    {
        $img = new Imagick();
        $img->readImageBlob($baseBinaryData);
        $img->readImageBlob($toAddBinaryData);
        $img->resetIterator();
        $combined = $img->appendImages(!$toRight);
        return $combined->getImageBlob();
    }


    /**
     * Create an empty image
     *
     * @param int $width The image width
     * @param int $height The image height
     * @param string $format The image format (JPG by default)
     *
     * @return string The output image binary data
     */
    public static function createEmptyImage($width, $height, $format = 'JPG')
    {
        $img = new Imagick();
        $img->newImage($width, $height, new ImagickPixel('transparent'));
        $img->setImageFormat($format);
        return $img->getImageBlob();
    }


    public static function setDpi($baseBinaryData, $density)
    {
        $img = new Imagick();
        $img->readImageBlob($baseBinaryData);
        $img->setResolution($density, $density);
        return $img->getImageBlob();
    }


    public static function addText($baseBinaryData, $x, $y, $angle, $text, $fontSize = 14, $textColor = 'white', $fontFamily = 'Helvetica')
    {
        $draw = new ImagickDraw();
        $draw->setFillColor($textColor);
        $draw->setFontSize($fontSize);
        $draw->setFont($fontFamily); // print_r(Imagick::queryFonts('*'));

        $img = new Imagick();
        $img->readImageBlob($baseBinaryData);
        $img->annotateImage($draw, $x, $y, $angle, $text);
        return $img->getImageBlob();
    }


    public static function addRectangle($baseBinaryData, $x1, $y1, $x2, $y2, $color = 'black', $opacity = 1)
    {
        $draw = new ImagickDraw();
        $draw->setFillColor(new ImagickPixel($color));
        $draw->setFillOpacity($opacity);
        $draw->rectangle($x1, $y1, $x2, $y2);

        $img = new Imagick();
        $img->readImageBlob($baseBinaryData);
        $img->drawImage($draw);
        return $img->getImageBlob();
    }


    public static function fitInA4Pdf($baseBinaryData, $resolution = 300)
    {
        $width = 2480 * $resolution / 300;
        $height = 3508 * $resolution / 300;

        $base = self::createEmptyImage($width, $height, 'PNG');
        $base = self::combine($base, $baseBinaryData, 100, 100);
        $img = new Imagick();
        $img->readImageBlob($base);
        $img->setResolution($resolution, $resolution);
        $img->setImageFormat('PDF');
        return $img->getImageBlob();
    }

}