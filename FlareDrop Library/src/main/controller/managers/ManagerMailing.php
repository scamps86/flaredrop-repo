<?php

/**
 * Email manager
 */
class ManagerMailing
{
    /** Array containing all files to send */
    private $_files = [];

    /**
     * Send a mail
     *
     * @param string $sender The address for the person who sends the email
     * @param string $receiver The address where the email will be sent
     * @param string $subject Title for the message to send
     * @param string $message Message body
     *
     * @return boolean
     */
    public function send($sender, $receiver, $subject, $message)
    {
        // Encode the subject and message to the UTF-8 only if necessary
        if (mb_detect_encoding($subject) != 'UTF-8') {
            $subject = utf8_encode($subject);
        }
        if (mb_detect_encoding($message) != 'UTF-8') {
            $message = utf8_encode($message);
        }

        // Generate the HTML email page
        $message = '<html><head></head><body>' . $message . '</body></html>';

        // Definition for the headers
        $headers = "MIME-Version: 1.0\n";
        $headers .= 'From: ' . $sender . "\n";
        $headers .= 'Return-Path: ' . $sender . "\n";
        $headers .= 'Reply-To: ' . $sender . "\n";

        // Set the content type
        $contentType = 'Content-type: text/html; charset=UTF-8';

        // Check if there are attached files to send
        if (count($this->_files) > 0) {
            $mimeBoundary = '==Multipart_Boundary_x' . md5(time()) . 'x';
            $headers .= 'Content-Type: multipart/mixed; boundary="{' . $mimeBoundary . "}\"\n";

            // Add the message to the email to send
            $emailMessage = "This is a multi-part message in MIME format.\n\n";
            $emailMessage .= '--{' . $mimeBoundary . "}\n";
            $emailMessage .= $contentType . "\n";
            $emailMessage .= "Content-Transfer-Encoding: 7bit\n\n";
            $emailMessage .= $message . "\n\n";

            // Add the files to the email to send
            foreach ($this->_files as $f) {
                $emailMessage .= '--{' . $mimeBoundary . "}\n";
                $emailMessage .= "Content-Type: application/octet-stream;\n";
                $emailMessage .= ' name="{' . $f['name'] . "}\"\n";
                $emailMessage .= "Content-Disposition: attachment;\n";
                $emailMessage .= ' filename="' . $f['name'] . "\"\n";
                $emailMessage .= "Content-Transfer-Encoding: base64\n\n";
                $emailMessage .= $f['data'] . "\n\n";
            }

        } else {
            $emailMessage = $message;
            $headers .= $contentType . "\n";
        }

        // Reset the attached files array
        $this->_files = [];

        // Send the mail
        return mail($receiver, $subject, $emailMessage, $headers);
    }


    /**
     * Attach a file from drive to the email
     *
     * @param string $name The file email name
     * @param string $path The file path
     * @param string $binaryData The file binary data
     *
     * @return void
     */
    public function attachFile($name, $path = '', $binaryData = '')
    {
        $f['name'] = $name;

        if ($path != '') {
            $f['data'] = chunk_split(base64_encode(file_get_contents($path)));
        }
        if ($binaryData != '') {
            $f['data'] = chunk_split(base64_encode($binaryData));
        }
        array_push($this->_files, $f);
    }
}