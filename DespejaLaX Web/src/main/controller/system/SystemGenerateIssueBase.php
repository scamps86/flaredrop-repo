<?php

/**
 * Class SystemGenerateIssueBase
 */
class SystemGenerateIssueBase
{

    private static $_WIDTH = 352,
        $_HEIGHT = 128,
        $_FORMAT = 'JPG',
        $_PATTERNS_QUANTITY = 3,
        $_PATTERNS_SIZE = 32,
        $_ASSETS_SIZE = 20;

    // NOT MODIFY IT
    private static $_PATTERN_I = 1,
        $_PATTERN_X = 0,
        $_PATTERN_Y = 0,
        $_GENERATED_CODE = '',
        $_OPERANDS = [];
    public static
        $_ISSUE_ID = '',
        $_OMAX = 0,
        $_OPERANDS_QUANTITY = 0,
        $_ASSETS = [],
        $_EQUATION = '';


    /**
     * Configure the issue and process it
     */
    public static function configure()
    {
        // Set this issue to the generated code
        self::$_GENERATED_CODE = 'I' . self::$_ISSUE_ID;

        // Randomize the operands for this issue and set to the generated code
        self::$_GENERATED_CODE .= 'O';

        $count = count(self::$_ASSETS);

        for ($i = 0; $i < $count; $i++) {
            // If it is an operand, save it and update the assets value
            if (preg_match('/[a-z]/', self::$_ASSETS[$i][0])) {
                $o = rand(0, self::$_OMAX);

                self::$_OPERANDS[self::$_ASSETS[$i][0]] = $o;
                self::$_ASSETS[$i][0] = $o;

                if ($i == 0) {
                    self::$_GENERATED_CODE .= $o;
                } else {
                    self::$_GENERATED_CODE .= '_' . $o;
                }
            }
        }

        // Generate pattern configuration
        self::$_PATTERN_I = rand(0, self::$_PATTERNS_QUANTITY - 1);
        self::$_PATTERN_X = rand(0, self::$_PATTERNS_SIZE);
        self::$_PATTERN_Y = rand(0, self::$_PATTERNS_SIZE);

        // Set the pattern configuration to the generated code (PATTERN ID, CROP X POSITION, CROP Y POSITION)
        self::$_GENERATED_CODE .= 'P' . self::$_PATTERN_I . '_' . self::$_PATTERN_X . '_' . self::$_PATTERN_Y;
    }


    /**
     * Build the issue image if necessary and echo the headers and data contents
     */
    public static function build()
    {
        // Check if this issue is previously generated and prevent render it again
        $result = self::_checkGenerated() ? self::_getGenerated() : self::_render();

        UtilsHttp::fileGenerateHeaders('image/jpeg', strlen($result), self::$_GENERATED_CODE, false);
        echo $result;
    }


    // Check if it is previously generated
    private static function _checkGenerated()
    {
        // Check if it is previously generated
        return Managers::ftpFileSystem()->fileExists(PATH_MODEL . 'generated/' . self::$_GENERATED_CODE);
    }


    /**
     * Get the previously generated issue image binary data
     */
    private static function _getGenerated()
    {
        return Managers::ftpFileSystem()->fileData(PATH_MODEL . 'generated/' . self::$_GENERATED_CODE);
    }


    /**
     * Render the issue image
     *
     * @return string The render binary data
     */
    private static function _render()
    {
        // Generate the pattern
        $pattern = self::_generatePattern();

        // Generate the assets
        $assets = self::_generateAssets();

        // Combine the background pattern with the assets
        return UtilsPicture::combine($pattern, $assets, 0, 0);
    }


    /**
     * Generate a random pattern for the issue image
     * @return string The output binary data
     */
    private static function _generatePattern()
    {
        // Create the pattern
        $patternBinaryData = Managers::ftpFileSystem()->fileData(PATH_CONTROLLER . 'resources/patterns/' . self::$_PATTERN_I . '.png');
        $patternBinaryData = UtilsPicture::createPattern($patternBinaryData, self::$_WIDTH, self::$_HEIGHT, 'PNG');

        // Return the pattern binary data
        return UtilsPicture::crop($patternBinaryData, 320, 96, false, self::$_PATTERN_X, self::$_PATTERN_Y);
    }


    /**
     * Generate the configured assets for the issue image
     * @return string The output binary data
     */
    private static function _generateAssets()
    {
        $result = UtilsPicture::createEmptyImage(self::$_WIDTH, self::$_HEIGHT, 'PNG');

        // Loop for each operand and print it
        foreach (self::$_ASSETS as $a) {
            $val = strval($a[0]);
            $i = 0;
            $assetData = '';

            while (isset($val[$i])) {
                $ai = $val[$i];

                // Get the operand asset
                $operandAsset = Managers::ftpFileSystem()->fileData(PATH_CONTROLLER . 'resources/' . $ai . '.png');

                if ($assetData == '') {
                    $assetData = $operandAsset;
                } else {
                    $assetData = UtilsPicture::append($assetData, $operandAsset);
                }
                $i++;
            }

            // Get the assets dimensions
            $dimensions = UtilsPicture::getDimensions($assetData);

            // Center the assets (space is 40px, assets 20px)
            if ($dimensions[0] == self::$_ASSETS_SIZE) {
                $pad = UtilsPicture::createEmptyImage(self::$_ASSETS_SIZE / 2, self::$_ASSETS_SIZE, 'PNG');
                $assetData = UtilsPicture::append($pad, $assetData);
                $assetData = UtilsPicture::append($assetData, $pad);
            }

            // Append the number to the main assets layer to the configured position
            $result = UtilsPicture::combine($result, $assetData, $a[1], $a[2]);
        }

        // Return the binary data result
        return $result;
    }


    /**
     * Set the solution to the generated code
     * @param mixed $solution The solution
     */
    public static function setSolution($solution)
    {
        self::$_GENERATED_CODE .= 'R' . strval($solution);
        $_SESSION['game_issue_solution'] = $solution;
    }


    /**
     * Get an operand
     *
     * @param string $operand The operand identifier
     *
     * @return int
     */
    public static function getOperand($operand)
    {
        return intval(self::$_OPERANDS[$operand]);
    }

}