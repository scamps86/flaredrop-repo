<?php

/**
 * Class used to do automated System testing
 */
class SystemTesting
{

    private static $_domain = '';
    private static $_folder = '';
    private static $_language = '';
    private static $_timeSummary = '';
    private static $_currentResult = null; // The current iteration error
    private static $_DATA_FTP_PATH = '';
    private static $_DATA_SIMPLE_ARRAY = null;
    private static $_DATA_ASSOCIATIVE_ARRAY = null;
    private static $_DATA_ASSOCIATIVE_ARRAY2 = null;
    private static $_DATA_CLASS = null;
    private static $_DATA_CLASS_ARRAY = null;
    private static $_DATA_DATE = '';
    private static $_DATA_VO_FILE = null;


    /**
     * Run the system testing (utils)
     *
     * @return VoResult
     */
    public static function run()
    {
        // Validate if we have a manager user session
        Managers::mySQL();

        // Set the testing data
        self::$_currentResult = UtilsResult::generateSuccessResult('System Testing Starting');
        self::$_domain = WebConstants::getDomain();
        self::$_folder = WebConstants::isInProduction() ? '' : '/_preview/';
        self::$_language = WebConstants::getLanguage();
        self::_resetData();

        // Start the timer
        Managers::timer()->start('full');

        // TEST UTILS (Not be tested: UtilsCookie, UtilsResult, UtilsHttp(1/2), UtilsJavascript, UtilsPicture)
        self::_executeValidation('UtilsArray: Extract property from an array of 2 same associative arrays', UtilsArray::extractProperty([self::$_DATA_ASSOCIATIVE_ARRAY, self::$_DATA_ASSOCIATIVE_ARRAY], 'b'), [1, 1]);
        self::_executeValidation('UtilsArray: Extract property from an array of 2 different associative arrays', UtilsArray::extractProperty([self::$_DATA_ASSOCIATIVE_ARRAY, self::$_DATA_ASSOCIATIVE_ARRAY2], 'b'), [1]);
        self::_executeValidation('UtilsArray: Remove values from an array', UtilsArray::removeValues(self::$_DATA_SIMPLE_ARRAY, ['a', 'd']), [1 => 'b', 2 => 'c']);
        self::_executeValidation('UtilsArray: Replace characters from a simple array', UtilsArray::replaceChars(self::$_DATA_SIMPLE_ARRAY, 'c', 'e'), ['a', 'b', 'e', 'd']);
        self::_executeValidation('UtilsArray: Replace characters from an associative array', UtilsArray::replaceChars(self::$_DATA_ASSOCIATIVE_ARRAY, 2, 5), ['a' => 0, 'b' => 1, 'c' => 5, 'd' => 3]);
        self::_executeValidation('UtilsArray: Move an item to the first position', UtilsArray::moveItemToFirstPosition(self::$_DATA_ASSOCIATIVE_ARRAY, 'd'), ['d' => 3, 'a' => 0, 'b' => 1, 'c' => 2]);
        self::_executeValidation('UtilsArray: Check if a simple array is associative', UtilsArray::isAssociative(self::$_DATA_SIMPLE_ARRAY), false);
        self::_executeValidation('UtilsArray: Check if an associative array is associative', UtilsArray::isAssociative(self::$_DATA_ASSOCIATIVE_ARRAY), true);
        self::_executeValidation('UtilsArray: Serialize a class to an associative array', UtilsArray::arrayToClass(self::$_DATA_CLASS_ARRAY, new VoFile()), self::$_DATA_CLASS);
        self::_executeValidation('UtilsArray: Serialize an array to a class', UtilsArray::classToArray(self::$_DATA_CLASS), self::$_DATA_CLASS_ARRAY);
        self::_executeValidation('UtilsArray: Create an array of objects', UtilsArray::arrayToClassArray([self::$_DATA_CLASS_ARRAY, self::$_DATA_CLASS_ARRAY], 'VoFile'), [self::$_DATA_CLASS, self::$_DATA_CLASS]);
        self::_executeValidation('UtilsArray: Generate an SQL condition through an array', UtilsArray::sqlArrayToCondition(self::$_DATA_SIMPLE_ARRAY, '-', 'AND'), '(-a AND -b AND -c AND -d)');
        self::_executeValidation('UtilsArray: Sort an array of associative arrays', UtilsArray::arrayOfAssociativeArraysSort([self::$_DATA_ASSOCIATIVE_ARRAY, ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]], 'c', SORT_DESC), [['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], self::$_DATA_ASSOCIATIVE_ARRAY]);
        self::_executeValidation('UtilsArray: Array to CSV', UtilsArray::arrayToCsv(self::$_DATA_SIMPLE_ARRAY, [self::$_DATA_ASSOCIATIVE_ARRAY, self::$_DATA_ASSOCIATIVE_ARRAY]), "a;b;c;d\n0;1;2;3\n0;1;2;3\n");
        self::_executeValidation('UtilsArray: CSV to Array', UtilsArray::csvToArray("a;b;c;d\n0;1;2;3"), [self::$_DATA_ASSOCIATIVE_ARRAY]);

        self::_executeValidation('UtilsConversion: Base64 obfuscate', UtilsConversion::base64Obfuscate('Test1234'), '.Vpqj8091');
        self::_executeValidation('UtilsConversion: Base64 deobfuscate', UtilsConversion::base64Deobfuscate('.Vpqj8091'), 'Test1234');

        self::_executeValidation('UtilsDate: Create a new date', UtilsDate::create(2000, 10, 30, 12, 30, 10), self::$_DATA_DATE);
        self::_executeValidation('UtilsDate: Date to timestamp', UtilsDate::toTimestamp(self::$_DATA_DATE), '972905410');
        self::_executeValidation('UtilsDate: Is a valid timestamp', UtilsDate::isValidTimestamp(UtilsDate::toTimestamp(self::$_DATA_DATE)), true);
        self::_executeValidation('UtilsDate: Is not a valid timestamp', UtilsDate::isValidTimestamp('abcde'), false);
        self::_executeValidation('UtilsDate: Date to DDMMYYYY', UtilsDate::toDDMMYYYY(self::$_DATA_DATE, '*'), '30*10*2000');
        self::_executeValidation('UtilsDate: Date to YYYYMMDD', UtilsDate::toYYYYMMDD(self::$_DATA_DATE, '*'), '2000*10*30');
        self::_executeValidation('UtilsDate: DDMMYYYY to date', UtilsDate::DDMMYYYYToDate('05-11-1998'), '1998-11-05 00:00:00');
        self::_executeValidation('UtilsDate: YYYYMMDD to date', UtilsDate::YYYYMMDDToDate('1998-11-05'), '1998-11-05 00:00:00');
        self::_executeValidation('UtilsDate: Date operate +5 years', UtilsDate::operate('YEAR', self::$_DATA_DATE, 5), '2005-10-30 12:30:10');
        self::_executeValidation('UtilsDate: Date operate +3 months', UtilsDate::operate('MONTH', self::$_DATA_DATE, 3), '2001-01-30 12:30:10');
        self::_executeValidation('UtilsDate: Date operate +10 days', UtilsDate::operate('DAY', self::$_DATA_DATE, 10), '2000-11-09 12:30:10');
        self::_executeValidation('UtilsDate: Date operate -1 hour', UtilsDate::operate('HOUR', self::$_DATA_DATE, 1, false), '2000-10-30 11:30:10');
        self::_executeValidation('UtilsDate: Date operate -30 minutes', UtilsDate::operate('MINUTE', self::$_DATA_DATE, 30, false), '2000-10-30 12:00:10');
        self::_executeValidation('UtilsDate: Date operate -45 seconds', UtilsDate::operate('SECOND', self::$_DATA_DATE, 45, false), '2000-10-30 12:29:25');
        self::_executeValidation('UtilsDate: Get month name', UtilsDate::getMonthName(self::$_DATA_DATE), 'OCTOBER');
        self::_executeValidation('UtilsDate: Get day name', UtilsDate::getDayName(self::$_DATA_DATE), 'MONDAY');
        self::_executeValidation('UtilsDate: Get year', UtilsDate::getYear(self::$_DATA_DATE), 2000);
        self::_executeValidation('UtilsDate: Get month', UtilsDate::getMonth(self::$_DATA_DATE), 10);
        self::_executeValidation('UtilsDate: Get day', UtilsDate::getDay(self::$_DATA_DATE), 30);
        self::_executeValidation('UtilsDate: Get hour', UtilsDate::getHour(self::$_DATA_DATE), 12);
        self::_executeValidation('UtilsDate: Get minute', UtilsDate::getMinute(self::$_DATA_DATE), 30);
        self::_executeValidation('UtilsDate: Get second', UtilsDate::getSecond(self::$_DATA_DATE), 10);

        self::_executeValidation('UtilsDiskObject: Get files array', UtilsDiskObject::filesArrayGet('1,fileName1,0;1,fileName1,0'), [self::$_DATA_VO_FILE, self::$_DATA_VO_FILE]);
        self::_executeValidation('UtilsDiskObject: Get first file', UtilsDiskObject::firstFileGet('1,fileName1,0;1,fileName1,0'), self::$_DATA_VO_FILE);
        self::_executeValidation('UtilsDiskObject: Folder ids get', UtilsDiskObject::folderIdsGet('1;2;3;4;5'), [1, 2, 3, 4, 5]);
        self::_executeValidation('UtilsDiskObject: First folder id get', UtilsDiskObject::firstFolderIdGet('1;2;3;4;5'), 1);

        self::_executeValidation('UtilsFormatter: Set decimals to an integer', UtilsFormatter::setDecimals(35, 5), 35.00000);
        self::_executeValidation('UtilsFormatter: Format as currency', UtilsFormatter::currency(50, '$'), '50,00$');
        self::_executeValidation('UtilsFormatter: Pad an string', UtilsFormatter::pad('test', 10, '-', 'RIGHT'), 'test------');
        self::_executeValidation('UtilsFormatter: Pad a number', UtilsFormatter::pad(2, 3, 0, 'LEFT'), '0002');

        self::_executeValidation('UtilsHttp: Get a section URL', UtilsHttp::getSectionUrl('section1'), self::$_folder . 'section1/' . self::$_language);
        self::_executeValidation('UtilsHttp: Get a section URL with params', UtilsHttp::getSectionUrl('section1', ['a' => 1, 'b' => 2]), self::$_folder . 'section1/' . self::$_language . '&amp;.poAnUgukYSAwUguomM%3D%3D');
        self::_executeValidation('UtilsHttp: Get a section URL with dummy', UtilsHttp::getSectionUrl('section1', null, 'This is dummy text'), self::$_folder . 'section1/' . self::$_language . '&amp;this-is-dummy-text');
        self::_executeValidation('UtilsHttp: Get a section URL with language', UtilsHttp::getSectionUrl('section1', null, '', 'it'), self::$_folder . 'section1/it');
        self::_executeValidation('UtilsHttp: Get a section full URL', UtilsHttp::getSectionUrl('section1', null, '', '', true), 'http://' . self::$_domain . self::$_folder . 'section1/' . self::$_language);
        self::_executeValidation('UtilsHttp: Get a webservice URL', UtilsHttp::getWebServiceUrl('ws1'), self::$_folder . '_webservice/ws1');
        self::_executeValidation('UtilsHttp: Get a webservice URL with params', UtilsHttp::getWebServiceUrl('ws1', ['a' => 1, 'b' => 2]), self::$_folder . '_webservice/ws1&amp;.poAnUgukYSAwUguomM==');
        self::_executeValidation('UtilsHttp: Get a webservice full URL', UtilsHttp::getWebServiceUrl('ws1', null, true), 'http://' . self::$_domain . self::$_folder . '_webservice/ws1');
        self::_executeValidation('UtilsHttp: Get a file URL', UtilsHttp::getFileUrl(5), self::$_folder . '_webservice/FileGet&amp;.poAryGksEGMwNgF5');
        self::_executeValidation('UtilsHttp: Get a file URL with validation key', UtilsHttp::getFileUrl(5, 'abcde'), self::$_folder . '_webservice/FileGet&amp;.poAryGksEGMwNgBqUtXnxHsbOLThx07YXLbwNwAnOrJbXEA5');
        self::_executeValidation('UtilsHttp: Get a picture URL with no dimensions', UtilsHttp::getPictureUrl(2), self::$_folder . '_webservice/FileGet&amp;.poAryGksEGMwNgA5');
        self::_executeValidation('UtilsHttp: Get a picture URL with dimensions', UtilsHttp::getPictureUrl(2, '100x100'), self::$_folder . '_webservice/FileGet&amp;.poAryGksEGMwNgUqUrThxGFia0sextWwNwUkWPD1WVCdUt6=');
        self::_executeValidation('UtilsHttp: Get a picture URL with dimensions and validation key', UtilsHttp::getPictureUrl(2, '100x100', 'abcde'), self::$_folder . '_webservice/FileGet&amp;.poAryGksEGMwNgUqUrThxGFia0sextWwNwUkWPD1WVCdUwdwfrIqyGTnfHsexbjspEU3UrIwO0TsUt6=');
        self::_executeValidation('UtilsHttp: Get a relative URL', UtilsHttp::getRelativeUrl('folder1/folder2.test'), self::$_folder . 'folder1/folder2.test');

        self::_executeValidation('UtilsString: Cut an string (max 5)', UtilsString::cut('hola que tal?', 5), 'hola ');
        self::_executeValidation('UtilsString: Cut an string', UtilsString::cut('hola que tal?'), 'hola que tal?');
        self::_executeValidation('UtilsString: JSON encode', UtilsString::jsonEncode('[0,1,2,3,4]', 5), '[0,1,2,3,4]');
        self::_executeValidation('UtilsString: Regex encode', UtilsString::regexEncode('()'), '\(\)');
        self::_executeValidation('UtilsString: Quote for SQL queries', UtilsString::sqlQuote('value'), "'value'");
        self::_executeValidation('UtilsString: Remove special characters', UtilsString::specialCharsRemove('Hi! how are you? (says them...)'), 'Hihowareyousaysthem');

        self::_executeValidation('UtilsUnits: Bytes to Kilobytes', UtilsUnits::bytesToKilobytes(1024), 1);
        self::_executeValidation('UtilsUnits: Bytes to Megabytes', UtilsUnits::bytesToMegabytes(1048576), 1);
        self::_executeValidation('UtilsUnits: Bytes to Gigabytes', UtilsUnits::bytesToGibabytes(1073741824), 1);
        self::_executeValidation('UtilsUnits: Bytes to Terabytes', UtilsUnits::bytesToTerabytes(1099511627776), 1);
        self::_executeValidation('UtilsUnits: Kilobytes to Bytes', UtilsUnits::kilobytesToBytes(1), 1024);
        self::_executeValidation('UtilsUnits: Kilobytes to Megabytes', UtilsUnits::kilobytesToMegabytes(1024), 1);
        self::_executeValidation('UtilsUnits: Kilobytes to Gigabytes', UtilsUnits::kilobytesToGigabytes(1048576), 1);
        self::_executeValidation('UtilsUnits: Kilobytes to Terabytes', UtilsUnits::kilobytesToTerabytes(1073741824), 1);
        self::_executeValidation('UtilsUnits: Megabytes to Bytes', UtilsUnits::megabytesToBytes(1), 1048576);
        self::_executeValidation('UtilsUnits: Megabytes to Kilobytes', UtilsUnits::megabytesToKiloytes(1), 1024);
        self::_executeValidation('UtilsUnits: Megabytes to Gigabytes', UtilsUnits::megabytesToGigabytes(1024), 1);
        self::_executeValidation('UtilsUnits: Megabytes to Terabytes', UtilsUnits::megabytesToTerabytes(1048576), 1);

        // Get the timer
        self::$_timeSummary .= "\n\nTotal time: " . Managers::timer()->get('full') . 'ms</p>';

        // Return the data
        return self::$_currentResult->state ? UtilsResult::generateSuccessResult(self::$_timeSummary) : self::$_currentResult;
    }


    /**
     * Execute a function validation
     *
     * @param string $description The validation description
     * @param mixed $result The function result
     * @param mixed $estimatedResult The estimated result
     */
    private static function _executeValidation($description = '', $result, $estimatedResult = null)
    {
        if (self::$_currentResult->state) {
            $time = Managers::timer()->get('action');

            if ($time != -1) {
                self::$_timeSummary .= "\n" . $time . 'ms: ' . $description;
            }

            Managers::timer()->start('action');
            self::$_currentResult = $result != $estimatedResult ? UtilsResult::GenerateErrorResult($description, ['Estimated' => $estimatedResult, 'Result' => $result], false) : UtilsResult::generateSuccessResult('OK: ' . $description);
        }
    }


    /**
     * Reset the testing data to the default
     */
    private static function _resetData()
    {
        self::$_DATA_SIMPLE_ARRAY = ['a', 'b', 'c', 'd'];
        self::$_DATA_ASSOCIATIVE_ARRAY = ['a' => 0, 'b' => 1, 'c' => 2, 'd' => 3];
        self::$_DATA_ASSOCIATIVE_ARRAY2 = ['w' => 3, 'x' => 2, 'y' => 1, 'z' => 0];
        self::$_DATA_CLASS = new VoFile();
        self::$_DATA_CLASS->fileId = 1;
        self::$_DATA_CLASS->filename = 'fileName1';
        self::$_DATA_CLASS_ARRAY = ['fileId' => 1, 'filename' => 'fileName1', 'private' => 0];
        self::$_DATA_DATE = '2000-10-30 12:30:10';
        self::$_DATA_VO_FILE = new VoFile();
        self::$_DATA_VO_FILE->fileId = 1;
        self::$_DATA_VO_FILE->filename = 'fileName1';
        self::$_DATA_VO_FILE->private = 0;
    }

}