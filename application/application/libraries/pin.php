<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : pin.php
 * 
 *   Project : saffersmall
 */

/*
 *   <Saffersmall :: Online Ads and Marketing Directory.>
 *   Copyright (C) <2014>  <Sandeep Giri>

 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.

 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.

 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.

 *   This program comes with ABSOLUTELY NO WARRANTY.
 *   This is free software, and you are welcome to redistribute it only if you 
 *   get permissions from the author or the distributor of this code.
 * 
 *   However do not expect any help or support from the author.
 */

class Pin {
    /*
     * The generated pin number
     */

    protected $pin;

    /*
     * Any numbers to exclude
     */
    protected $excludes;

    /*
     * The class is initialized
     */

    public function __construct() {
        //class initialized
        $this->excludes = array();
    }

    /*
     * Set the array of numbers to be excludes
     */

    public function excludes($excludes) {

        if (!is_array($excludes)) {

            $excludes = (array) $excludes;
        }

        $this->excludes = $excludes;
    }
    
    /*
     * This functions generates a unique pin number.
     * 
     * @return 6-digit integer
     */
    public function generate() {
        $pin = array();

        $i = 0;

        while (true) {

            $num = rand(0, 9);

            /*
             * If the first digit in the pin is less than 5 
             * 
             * generate another number
             */
            if ($num <= 5 && count($pin) == 0) {
                continue;
            }

            /*
             * The line prevents repetition of digits
             * 
             * in the pin. Makes sure each digit in the pin
             * 
             * number is unique.
             */
            if (!in_array($num, $pin)) {

                array_push($pin, $num);

                $i++;
            }

            /*
             * The last digit is not greater than 5 and
             * 
             * is also not zero.
             */
            if ($num > 5 && $i == 6 || $num == 0) {
                array_pop($pin);

                $i--;

                continue;
            }

            /*
             * If 6 digits have been calculated
             */
            if ($i == 6) {
                
                /*
                 * Check if the pin has to be excluded
                 */
                if ($this->exclude($pin)) {
                    
                    /*
                     * Reset the array and the counter
                     * 
                     * and regenerate the pin
                     */
                    $pin = array();

                    $i = 0;

                    continue;
                }
                /*
                 * Get out of here
                 */
                break;
            }
        }
        
        /*
         * Convert array into string.
         */
        $this->pin = implode('', $pin);
        
        /*
         * Return equivalent number of the string.
         */
        return intval($this->pin);
    }
    
    /*
     * This function checks if the generated pin has to be excluded or not.
     * 
     * @param array
     * 
     * @return bool
     */
    private function exclude($pin) {
        /*
         * Convert array to string and check if it exists in the 
         * 
         * excludes array. 
         */
        if (in_array(implode('', $pin), $this->excludes)) {
            
            return true;
        }

        return false;
    }

}
