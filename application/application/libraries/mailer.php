<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : mailer.php
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

class Mailer {
    /*
     * The sender of message
     */

    private $from;

    /*
     * The receiver of message
     */
    private $to;

    /*
     * Header associated with message
     */
    private $headers;

    /*
     * The subject of meesage
     */
    private $subject;

    /*
     * The message
     */
    private $message;

    /*
     * CC to
     */
    private $cc;

    /*
     * BCC to
     */
    private $bcc;

    /*
     * Reply to
     */
    private $reply;

    /*
     * Do not reply flag
     */
    private $noreply;

    /*
     * Mimes associated with a file
     */
    private $mime;

    /*
     * The mailing application
     */
    private $xmailer;

    /*
     * The character set of email
     */
    private $charset;

    /*
     * The content of file read
     */
    private $content;

    /*
     * The directory to read a file from
     */
    private $dir;

    /*
     * The file to be read
     */
    private $file;

    /*
     * The variables to be included in the message.
     */
    private $vars;

    /*
     * The processed content
     */
    private $processed;

    /*
     * Switch from message to headers and vice versa
     */
    protected $active;

    /*
     * The response header of the script
     */
    protected $header;

    /*
     * The response message of the script
     */
    protected $response;

    /*
     * Error display flag
     */
    protected $error;

    /*
     * Initialize the mailing library
     */

    public function __construct() {

        $this->from = $this->to = $this->message = $this->subject = null;

        $this->headers = array();

        $this->header = '200';

        $this->error = false;
    }

    /*
     * Set different variables of the class
     */

    public function set($item, $value = false) {

        if (!is_array($item)) {

            $this->{$item} = $value;
        } else {

            foreach ($item as $k => $v) {
                if (!is_numeric($k))
                    $this->{$k} = $v;
            }
        }

        return $this;
    }

    /*
     * Switch between message or headers. The function activates the 
     * 
     * varible to be set.
     * 
     * We can either set headers or message at a time.
     */

    public function activate($item) {
        try {

            if ($this->processed($item)) {

                throw new Exception("{$item} already set.", '907');
            }

            $active = $this->active();

            if ($active) {

                $this->process();

                $this->reset();

                $this->activate($item);
            } else {

                $this->reset();

                $this->active = strtolower($item);
            }

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Return particular variable of the class
     */

    public function get($item) {

        if (!empty($this->{$item})) {

            return $this->{$item};
        }

        return '0';
    }

    /*
     * Set the sender of the message.
     */

    public function from($from) {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            if (!$this->isEmail($from)) {

                throw new Exception('Not a valid email.', '907');
            }

            $this->from = $from;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Set the receiver of the message
     */

    public function to($to) {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            if (!$this->isEmail($to)) {

                throw new Exception('Not a valid email.', '907');
            }

            $this->to = $to;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * The CC receiver
     */

    public function cc($cc) {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            if (!$this->isEmail($cc)) {

                throw new Exception('Not a valid email.', '907');
            }

            $this->cc = $cc;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * The BCC receiver
     */

    public function bcc($bcc) {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            if (!$this->isEmail($bcc)) {

                throw new Exception('Not a valid email.', '907');
            }

            $this->cc = $bcc;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Set the mime version
     */

    public function mime($mime = '1.0') {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            $this->mime = $mime;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Set receiver of message, if someone wants to send a reply
     */

    public function reply($reply) {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            $this->reply = $reply;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Set the mailing application
     */

    public function xmailer($xmailer) {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            $this->xmailer = $xmailer;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Set the subject of message
     */

    public function subject($subject) {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            $this->subject = $subject;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Set the charset of the message
     */

    public function charset($charset = 'ISO-8859-1') {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            $this->charset = $charset;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Set the content of message
     */

    public function content($content = 'text/html') {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            $this->content = $content;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Set the content type of message
     */

    public function contentType($content = 'text/html') {
        try {

            if (!$this->active('headers')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            $this->content = $content;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Set the message
     */

    public function message($message) {
        try {

            if (!$this->active('message')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            if (empty($this->dir) && empty($this->file)) {

                $this->message = $message;
            } else {

                throw new Exception('Message set to be read from a file.', '900');
            }

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Set variables of the message
     */

    public function vars($var) {
        try {

            if (!$this->active('message')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            $this->vars = $var;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Read email message from a file
     */

    public function read($dir, $file) {
        try {

            if (!$this->active('message')) {

                throw new Exception('This function cannot be called with ' . $this->active . ' activated', '900');
            }

            if (!empty($this->message)) {

                throw new Exception('Message already set.', '900');
            }

            $this->dir = $dir;
            $this->file = $file;

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return $this;
        }
    }

    /*
     * Check if the email supplied is valid or not.
     */

    protected function isEmail($string) {

        $string = filter_var($string, FILTER_VALIDATE_EMAIL);

        return (bool) $string;
    }

    /*
     * Reset all the class varibles.
     */

    public function reset($item = false) {

        if ((bool) $item == true) {

            $this->{$item} = null;
        } else {

            $this->from = null;

            $this->cc = null;

            $this->bcc = null;

            $this->reply = null;

            $this->mime = null;

            $this->content = null;

            $this->charset = null;

            $this->file = null;

            $this->dir = null;

            $this->vars = null;

            $this->xmailer = null;

            $this->subject = null;

            $this->active = null;

            $this->header = '200';
        }

        return $this;
    }

    /*
     * The current active item
     */

    public function active($item = false) {
        try {

            if ($item == false) {

                if (!empty($this->active)) {

                    return true;
                }
            } else {

                if ($this->active == strtolower($item)) {

                    return true;
                }
            }

            return false;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            return false;
        }
    }

    /*
     * Now Process the whole message
     */

    public function process() {
        try {

            switch ($this->get('active')) {

                case 'header':
                case 'headers':

                    if (!empty($this->from)) {

                        $this->headers['from'] = 'From: ' . $this->from;
                    }

                    if (!empty($this->cc)) {

                        $this->headers['cc'] = 'CC: ' . $this->cc;
                    }

                    if (!empty($this->bcc)) {

                        $this->headers['bcc'] = 'BCC: ' . $this->bcc;
                    }

                    if (!empty($this->mime)) {

                        $this->headers['mime'] = 'MIME-Version: ' . $this->mime;
                    }

                    if (!empty($this->reply)) {

                        $this->headers['reply'] = 'Reply-To: ' . $this->reply;
                    }

                    if (!empty($this->charset)) {

                        $this->headers['charset'] = 'charset: ' . $this->charset;
                    }

                    if (!empty($this->content)) {

                        $this->headers['content'] = 'Content-type: ' . $this->content;
                    }

                    if (!empty($this->subject)) {

                        $this->headers['subject'] = 'Subject: ' . $this->subject;
                    }

                    if (!empty($this->xmailer)) {

                        $this->headers['xmailer'] = 'X-Mailer: ' . $this->xmailer;
                    }

                    break;

                case 'message':

                    if (!empty($this->dir) && !empty($this->file)) {

                        $file = $this->dir . DIRECTORY_SEPARATOR . $this->file . '.php';

                        if (!empty($this->vars)) {

                            $this->writeFile($this->vars, $file);

                            $this->readFile('temp.php');

                            //@unlink('temp.php');
                        } else {

                            if (file_exists($file)) {

                                if (!is_dir($file)) {

                                    $this->readFile($file);
                                }
                            }
                        }
                    } else {

                        $this->message = $this->message;
                    }

                    break;

                default:

                    throw new Exception('Quantity to be processed unknown.', '900');
            }

            $this->processed[] = strtolower($this->get('active'));

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getCode();

            return $this;
        }
    }

    /*
     * Read the contents from a file.
     */

    private function readFile($file) {
        try {

            if (!file_exists($file)) {

                throw new Exception('File to be read not found.', '904');
            }

            if (is_dir($file)) {

                throw new Exception('File is actually a directory.', '900');
            }

            //$data = $this->data;

            ob_start();

            @require_once $file;

            $this->message = ob_get_contents();

            ob_end_clean();

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();
            return $this;
        }
    }

    /*
     * Write the message to a temporary file
     */

    protected function writeFile($vars, $file) {
        try {

            if (!file_exists($file)) {

                throw new Exception('File to be read not found.', '904');
            }

            if (is_dir($file)) {

                throw new Exception('File is actually a directory.', '900');
            }

            $handle = fopen('temp.php', 'w');

            fwrite($handle, '<?php' . "\n");

            $numeric = false;

            foreach ($vars as $k => $v) {

                if (is_numeric($k)) {

                    $numeric = true;

                    continue;
                }

                $k = str_replace(' ', '_', $k);

                if (!is_array($v)) {

                    fwrite($handle, '$' . $k . " = '" . $v . "';\n");
                } else {

                    fwrite($handle, '$' . $k . " = " . var_export($v, true) . ";\n");
                }
            }

            if ($numeric == true) {

                fwrite($handle, '$datas = ' . var_export($vars, true) . ";\n");
            }

            fwrite($handle, '?>' . "\n");

            fwrite($handle, file_get_contents($file));

            fclose($handle);

            return $this;
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();
            return $this;
        }
    }

    /*
     * Check if an item is processed or not
     */

    public function processed($item) {
        if (is_array($this->processed)) {

            if (count($this->processed) > 0) {

                foreach ($this->processed as $p) {

                    if ($p == $item) {

                        return true;
                    }
                }
            }
        }

        return false;
    }

    /*
     * Be Prepared to send the email
     */

    public function mail() {
        try {

            if (empty($this->headers)) {

                throw new Exception('Headers not set.', '900');
            }

            if (count($this->headers) == 0) {

                throw new Exception('Headers not set.', '900');
            }

            if (empty($this->headers['from'])) {

                throw new Exception('Mail sender not defined.', '900');
            }

            if (empty($this->to)) {

                throw new Exception('Receiver of the mail not defined.', '900');
            }

            if (empty($this->headers['subject'])) {

                throw new Exception('Subject of message not defined.', '900');
            }

            if (empty($this->message)) {

                throw new Exception('Cannot send empty message to user.', '900');
            }

            return $this->now();
        } catch (Exception $e) {

            $this->header = $e->getCode();
            $this->response = $e->getMessage();

            return false;
        }
    }

    /*
     * Function similar to mail()
     */

    public function deliver() {
        $this->mail();
    }

    /*
     * Function similar to mail()
     */

    public function send() {
        $this->mail();
    }

    /*
     * Finally, Send the email
     */

    private function now() {
        $sent = false;

        switch ($this->header) {

            case 200:

                $headers = implode("\r\n", $this->headers);

                $sent = @mail($this->to, $this->headers['subject'], $this->message, $headers);

                if (!$sent) {

                    if ($this->error) {

                        echo 'The mail engine says it could not deliver email.';
                    }

                    return false;
                }
                break;

            default:

                if ($this->error) {

                    echo 'The mail engine responsed with header status ';

                    echo $this->header . ' with message ' . $this->response;
                }
                return false;
        }

        return true;
    }

}
