<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : imageuploader.php
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
 *   get permissions from the author or the distrubutor of this code.
 * 
 *   However do not expect any help or support from the author.
 */

class ImageUploader {

    var $file;
    var $name;
    var $uploadType;
    var $fileType;
    var $root;
    var $directory;
    var $fileName;
    var $ext;
    var $maxSize = 16777216;
    var $fileLength = 32;
    var $minWidth = 32;
    var $minHeight = 32;
    var $maxWidth = 2500;
    var $maxHeight = 2500;
    var $width;
    var $height;
    var $res;
    var $header;
    var $message;

    public function FileUploader() {
        //class initialized
    }

    public function set($item, $value) {
        $this->{$item} = $value;
        return $this;
    }

    public function upload() {
        try {
            if (empty($this->file)) {
                throw new Exception('File to be uploaded not specified', '400');
            }

            if (empty($this->name)) {
                throw new Exception('File name not specified', '400');
            }

            if (empty($this->uploadType)) {
                throw new Exception('Type of upload not specified', '400');
            }

            if (empty($this->fileType)) {
                throw new Exception('Type of file not specified', '400');
            }

            if (empty($this->directory)) {
                throw new Exception('File upload directory not specified', '400');
            }

            if (empty($this->root)) {
                $this->root = VIEWDIR;
            }

            return $this->doUpload();
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

    private function doUpload() {

        switch (strtolower($this->uploadType)) {

            case 1:
            case 'single':

                if ($this->isFileValid($this->file[$this->name])) {

                    $this->ext = $this->getFileExtension($this->file[$this->name]['name']);

                    $fileName = $this->getFileRandomName();

                    $this->fileName = $this->attachNameAndExt($fileName, $this->ext);

                    while ($this->fileExists($this->directory, $this->fileName)) {

                        $this->fileName = $this->getFileRandomName();

                        $this->fileName .= $this->attachNameAndExt($this->fileName);
                    }

                    return $this->nowUpload($this->file[$this->name]['tmp_name'], $this->fileName);
                } else {

                    echo $this->error;
                }
                break;

            case 2:
            case 'multiple':

                $this->res = array();

                $this->fileName = array();

                $this->file[$this->name] = $this->flipArray($this->file[$this->name]);

                for ($i = 0; $i < count($this->file[$this->name]); $i++) {

                    if ($this->isFileValid($this->file[$this->name][$i])) {

                        $this->ext = $this->getFileExtension($this->file[$this->name][$i]['name']);

                        $fileName = $this->getFileRandomName();

                        $this->fileName[$i] = $this->attachNameAndExt($fileName, $this->ext);

                        while ($this->fileExists($this->directory, $this->fileName[$i])) {

                            $this->fileName[$i] = $this->getFileRandomName();

                            $this->fileName[$i] .= $this->attachNameAndExt($fileName[i], $this->ext);
                        }

                        $this->res[$i] = $this->nowUpload($this->file[$this->name][$i]['tmp_name'], $this->fileName[$i]);
                    }
                }
                return $this->res;

                break;
        }
    }

    private function flipArray(&$file) {
        $i = 0;

        for ($i = 0; $i < count($file['tmp_name']); $i++) {

            $temp = array(
                'tmp_name' => $file['tmp_name'][$i],
                'name' => $file['name'][$i],
                'size' => $file['size'][$i],
                'error' => $file['error'][$i],
                'type' => $file['type'][$i]
            );

            $new_array[$i] = $temp;
        }

        return $new_array;
    }

    private function nowUpload($tmpName, $name) {

        $curDir = getcwd();

        chdir($this->root);
      
        list($width, $height) = getimagesize($tmpName);

        $this->directory = ltrim($this->directory, '/');

        $this->directory = rtrim($this->directory, '/');

        $dirs = explode(DS, trim($this->directory));

        //Only for kathmandu197.com
        $date = date('Y/m/d H:I:s A');
        $format = "<?php\n 
            /*
            * Author   :   Sandeep Giri
            * Email    :   ioesandeep@gmail.com 
            * Date     :   {$date} 
            * File     :   index.php 
            * Project  :   saffersmal            
            */
            \n?>";

        foreach ($dirs as $dir) {

            if (!file_exists($dir) || !is_dir($dir)) {
                mkdir($dir);
            }

            chdir($dir);
            if (!file_exists('index.php')) {
                $handle = fopen('index.php', 'w');
                fwrite($handle, $format);
                fclose($handle);
            }
        }

        $return = 0;

        if (move_uploaded_file($tmpName, $name)) {
            $return = 1;
        }

        chdir($curDir);

        return (bool) $return;
    }

    private function attachNameAndExt($name, $ext) {

        $temp = array($name, $ext);

        return implode('.', $temp);
    }

    private function getFileRandomName() {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ__01234567890__ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $default = 'saffersmall_';

        $str = $default;

        for ($i = 0; $i < $this->fileLength - strlen($default); $i++) {

            $str .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $str;
    }

    private function getFileExtension($file) {
        $dots = explode('.', trim($file));

        return $dots[count($dots) - 1];
    }

    private function isFileValid($file) {

        $mimesClassified = array(
            'application' => array(
                'hqx' => 'application/mac-binhex40',
                'cpt' => 'application/mac-compactpro',
                'csv' => array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel'),
                'bin' => 'application/macbinary',
                'dms' => 'application/octet-stream',
                'lha' => 'application/octet-stream',
                'lzh' => 'application/octet-stream',
                'exe' => array('application/octet-stream', 'application/x-msdownload'),
                'class' => 'application/octet-stream',
                'psd' => 'application/x-photoshop',
                'so' => 'application/octet-stream',
                'sea' => 'application/octet-stream',
                'dll' => 'application/octet-stream',
                'oda' => 'application/oda',
                'pdf' => array('application/pdf', 'application/x-download'),
                'ai' => 'application/postscript',
                'eps' => 'application/postscript',
                'ps' => 'application/postscript',
                'smi' => 'application/smil',
                'smil' => 'application/smil',
                'mif' => 'application/vnd.mif',
                'xls' => array('application/excel', 'application/vnd.ms-excel', 'application/msexcel'),
                'ppt' => array('application/powerpoint', 'application/vnd.ms-powerpoint'),
                'wbxml' => 'application/wbxml',
                'wmlc' => 'application/wmlc',
                'dcr' => 'application/x-director',
                'dir' => 'application/x-director',
                'dxr' => 'application/x-director',
                'dvi' => 'application/x-dvi',
                'gtar' => 'application/x-gtar',
                'gz' => 'application/x-gzip',
                'php' => 'application/x-httpd-php',
                'php4' => 'application/x-httpd-php',
                'php3' => 'application/x-httpd-php',
                'phtml' => 'application/x-httpd-php',
                'phps' => 'application/x-httpd-php-source',
                'js' => 'application/x-javascript',
                'swf' => 'application/x-shockwave-flash',
                'sit' => 'application/x-stuffit',
                'tar' => 'application/x-tar',
                'tgz' => array('application/x-tar', 'application/x-gzip-compressed'),
                'xhtml' => 'application/xhtml+xml',
                'xht' => 'application/xhtml+xml',
                'zip' => array('application/x-zip', 'application/zip', 'application/x-zip-compressed')
            ),
            'audio' => array(
                'mid' => 'audio/midi',
                'midi' => 'audio/midi',
                'mpga' => 'audio/mpeg',
                'mp2' => 'audio/mpeg',
                'mp3' => array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'),
                'aif' => 'audio/x-aiff',
                'aiff' => 'audio/x-aiff',
                'aifc' => 'audio/x-aiff',
                'ram' => 'audio/x-pn-realaudio',
                'rm' => 'audio/x-pn-realaudio',
                'rpm' => 'audio/x-pn-realaudio-plugin',
                'ra' => 'audio/x-realaudio',
                'wav' => array('audio/x-wav', 'audio/wave', 'audio/wav')
            ),
            'video' => array(
                'qt' => 'video/quicktime',
                'mov' => 'video/quicktime',
                'avi' => 'video/x-msvideo',
                'movie' => 'video/x-sgi-movie',
                'rv' => 'video/vnd.rn-realvideo',
                'wmv' => 'video/x-ms-wmv'
            ),
            'image' => array(
                'bmp' => array('image/bmp', 'image/x-windows-bmp'),
                'gif' => 'image/gif',
                'jpeg' => 'image/jpeg',
                'jpg' => 'image/pjpeg',
                'jpe' => array('image/jpeg', 'image/pjpeg'),
                'png' => array('image/png', 'image/x-png'),
                'tiff' => 'image/tiff',
                'tif' => 'image/tiff'
            )
        );

        if (!is_array($file)) {
            return false;
        }

        if ($file['error'] > 0) {

            $this->error = $file['error'];

            return false;
        }

        if (!array_key_exists($this->fileType, $mimesClassified)) {

            $this->error = 'Not a valid file type supplied.';

            return false;
        }

        $mime = $mimesClassified[$this->fileType];

        if (!$this->validateFileMime($mime, $file['type'])) {

            $this->error = 'Not a valid file uploaded.';

            return false;
        }

        if (!$this->validateFileSize($file['size'])) {

            $this->error = "File exceeds maximum size";

            return false;
        }

        if (!isset($file['tmp_name'])) {

            $this->error = 'File not uploaded properly.';

            return false;
        }

        if (!$this->setImageResolution($file['tmp_name'])) {

            $this->error = 'Cannot Obtain image Resolution';

            return false;
        }

        if (!$this->validateWidth($this->width)) {

            $this->error = "Image width is invalid.";

            return false;
        }

        if (!$this->validateHeight($this->height)) {

            $this->error = "Image height is invalid.";

            return false;
        }
        return true;
    }

    private function validateFileSize($size) {

        return $this->maxSize > $size;
    }

    private function validateWidth($width) {
        if ($this->fileType != 'image') {
            return true;
        }

        return $width >= $this->minWidth && $width <= $this->maxWidth;
    }

    private function validateHeight($height) {
        if ($this->fileType != 'image') {
            return true;
        }

        return $height >= $this->minHeight && $height <= $this->maxHeight;
    }

    private function setImageResolution($image) {
        if ($this->fileType != 'image') {
            return true;
        }
        list($this->width, $this->height) = getimagesize($image);

        if ($this->width > 0 && $this->height > 0) {
            return true;
        }

        return false;
    }

    private function fileExists($dir, $name) {
        $dir = str_replace('/', DS, $dir);

        $dir = str_replace('\\', DS, $dir);

        $file = $this->root . DS . $dir . DS . $name;

        if (file_exists($file)) {
            if (!is_dir($file)) {
                return true;
            }
        }

        return false;
    }

    private function validateFileMime($mimes, $type) {

        foreach ($mimes as $k => $mime) {

            if (is_array($mime)) {

                if (in_array($type, $mime)) {
                    return true;
                }
            } else {

                if ($mime == $type)
                    return true;
            }
        }
        return false;
    }

    public function get($item) {
        return $this->{$item};
    }

}

/*
 * E.G.
 * $uploader = $this->imageuploader->
                    set('file', $_FILE)->
                    set('name', 'logo')->
                    set('uploadType', 'single')->
                    set('fileType', 'image')->
                    set('root', VIEWDIR)->
                    set('directory', $directory)->
                    set('minWidth',150)->
                    set('minHeight',150);
            if ($uploader->upload()) {
                $this->name = $uploader->get('fileName');
 */