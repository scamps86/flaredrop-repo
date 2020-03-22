<?php

class SystemGenerateIssue1 extends SystemGenerateIssueBase
{

    private static $_SOLUTION = '';

    /**
     * Generate the issue image. It needs an initialized session
     *
     * @param int $max The max operand value (from 0 to 99)
     */
    public static function generate($max)
    {
        // CUSTOM ISSUE SETUP (EDIT)
        self::$_ISSUE_ID = 1;

        /**
         * ASSET POSITIONS: (asset, posX, posY)
         *
         * Operands: a to z
         * Operations: A (+), S (-), E (=)
         * Enigma: X
         * Lines: L
         * Square: _2 to _5
         * Parenthesis: _L, _R
         */
        self::$_ASSETS = [
            ['X', 60, 40],
            ['E', 80, 40],
            ['a', 110, 35],
            ['A', 135, 35],
            ['b', 160, 35],
            ['L', 105, 40],
            ['L', 125, 40],
            ['L', 145, 40],
            ['L', 165, 40],
            ['c', 135, 65]
        ];

        // NOT MODIFY - - - - - - - - - - - - - -
        self::$_OMAX = $max;
        self::configure();

        set_error_handler(function () {
            self::$_SOLUTION = 'E';
        });
        // - - - - - - - - - - - - - - - - - - - -

        // CALCULATE CUSTOM SOLUTION (EDIT)
        self::$_SOLUTION = (self::getOperand('a') + self::getOperand('b')) / self::getOperand('c');
        self::$_SOLUTION = round(self::$_SOLUTION, 2, PHP_ROUND_HALF_UP);

        // NOT MODIFY - - - - - - - - - - - - - -
        Managers::errors()->initialize();
        self::setSolution(self::$_SOLUTION);
        self::build();
    }

}