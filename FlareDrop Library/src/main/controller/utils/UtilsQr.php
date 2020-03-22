<?php

/** QR utils */
class UtilsQr
{
    const LEVEL = QR_ECLEVEL_L;
    const SIZE = 7;
    const MARGIN = 2;


    /**
     * Generate a QR code from an string
     *
     * @param string $code
     * @param int $pixelSize
     *
     * @return string QR PNG image blob
     */
    static function generateQr($code, $pixelSize = self::SIZE)
    {
        ob_start();
        QRcode::png($code, null, self::LEVEL, $pixelSize, self::MARGIN);
        $imageString = ob_get_contents();
        ob_end_clean();
        return $imageString;
    }
}