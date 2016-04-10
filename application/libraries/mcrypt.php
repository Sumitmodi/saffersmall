<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : mcrypt.php
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

class Mcrypt {
    /*
     * The resource variable.
     */

    protected $res;

    /*
     * The algorithm to be used.
     */
    protected $algorithm;

    /*
     * The directory for algorithm
     */
    protected $directory;

    /*
     * The mode of encryption
     */
    protected $mode;

    /*
     * The directory of mode
     */
    protected $mDirectory;

    /*
     * The key size of encryption
     */
    protected $key;

    /*
     * The iv size of encryption
     */
    protected $iv;

    /*
     * The encrypted string
     */
    protected $encrypt;

    /*
     * The string to be encrypted
     */
    protected $string;

    /*
     * Show error or not.
     */
    protected $error;

    /*
     * Initialize the class
     */

    public function __construct() {

        /*
         * The default algorithm
         */

        $this->algorithm = MCRYPT_RIJNDAEL_256;

        /*
         * Let it be empty
         */

        $this->directory = '';

        /*
         * The default encryption mode
         */

        $this->mode = MCRYPT_MODE_CFB;

        /*
         * Let it be empty.
         */

        $this->mDirectory = '';

        /*
         * Lets not display errors
         */

        $this->error = false;
    }

    /*
     * Set class variables
     */

    public function set($item, $value = false) {
        if (is_array($item)) {

            foreach ($item as $k => $v) {

                $this->{$k} = $v;
            }
        } else {

            $this->{$item} = $value;
        }

        return $this;
    }

    /*
     * This function either encrypts or decrypts data based
     * on the argument supplied.
     * 
     * @param string
     * 
     * @return the encrypted/decrypted string on success and
     * false on failure.
     */

    public function eord($mode = 'e') {
        try {

            /*
             * Better ignore if the string is empty.
             */
            if (empty($this->string)) {

                throw new Exception('Please enter an encryption string.');
            }

            /*
             * Open encryption module
             */
            $this->res = mcrypt_module_open(
                    $this->algorithm, $this->directory, $this->mode, $this->mDirectory
            );

            /*
             * Set/Manage the key size
             */
            if (empty($this->key)) {

                $this->key = mcrypt_enc_get_key_size($this->res);
            }

            /*
             * Set/Manage iv size
             */
            if (empty($this->iv)) {

                $this->iv = mcrypt_enc_get_iv_size($this->res);
            }

            /*
             * Initialize encryption.
             */
            $init = mcrypt_generic_init($this->res, $this->key, $this->iv);

            /*
             * Check if encryption has been initialized or not
             */
            switch ($init) {

                case -3:

                    throw new Exception('The length of the key is not correct.');

                    break;

                case -4:

                    throw new Exception('Memory could not be allocated properly.');

                    break;

                case 0:

                    throw new Exception('An unknown error occured while trying to initialize encryption.');

                    break;
            }

            /*
             * Validate the mode supplied during method call.
             */

            if ($mode == 'e' || strtolower($mode) == 'encrypt') {

                /*
                 * Encryption mode
                 */

                $this->encrypt = mcrypt_generic($this->res, $this->string);
            } elseif ($mode == 'd' || strtolower($mode) == 'decrypt') {

                /*
                 * Decrypt mode
                 */
                $this->string = base64_decode($this->string);

                $this->encrypt = mdecrypt_generic($this->res, $this->string);
            } else {

                throw new Exception('Unknown mode specified.');
            }

            /*
             * Deinitialize encryption
             */
            mcrypt_generic_deinit($this->res);

            /*
             * Close the encryption module
             */
            mcrypt_module_close($this->res);

            /*
             * Return the result
             */
            if ($mode == 'e' || strtolower($mode) == 'encrypt') {

                return base64_encode($this->encrypt);
            } else {
                
                return rtrim($this->encrypt, "\0");
            }
        } catch (Exception $e) {

            /*
             * If error reporting is enable display the error.
             */

            if ($this->error == true) {

                echo $e->getMessage();
            }

            return false;
        }
    }

}
