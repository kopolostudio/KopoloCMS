<?php

/**
 * Класс для работы с почтой
 *
 * @version 0.1 / 11.12.2010
 * @author kopolo.ru
 * @developer Elena Kondratieva [elena@kopolo.ru]
 */
class Kopolo_Mail
{
    /**
    * отправка письма
    * 
    * @param string от (email), если false, определяется автоматически
    * @param string адрес подписчика
    * @param string HTML письма
    * @param array  параметры SMTP
    * 
    * @return boolean
    */
    public static function send($from=false, $to, $subject, $body, $html=false, $charset = 'UTF-8', $attachments = array (), $smtp_params=array())
    {
        if (defined('USE_SMTP') && USE_SMTP==true) {
            $smtp_params = array (
                'host'     => SMTP_HOST,
                'auth'     => SMTP_AUTH,
                'username' => SMTP_USERNAME,
                'password' => SMTP_PASSWORD,
                'debug' => false
            );
            if ($from == false) {
                $from = SMTP_FROM_MAIL;
            }
            $res = Kopolo_Mail::sendMailSMTP($from, $to, $subject, $body, $html, $charset, $attachments, $smtp_params);
        } else {
            if ($from == false) {
                $from = 'noreply@' . $_SERVER['SERVER_NAME'];
            }
            $res = Kopolo_Mail::sendMail($from, $to, $subject, $body, $html, $charset);
        }
        return $res;
    }
    
    public static function sendMailSMTP($from, $to, $subject, $body, $html=false, $charset = 'UTF-8', $attachments = array (), $smtp_params=array())
    {
        //подключение необходимых классов PEAR
        require_once ('PEAR.php');
        require_once ('Mail.php');
        require_once ('Mail/mime.php');
        
        if ($charset != 'UTF-8') {
            $body = iconv('UTF-8', $charset, $body);
            $subject = iconv('UTF-8', $charset, $subject);
        }
        
        $headers['From']         = $from;
        $headers['To']           = $to;
        $headers['Subject']      = $subject;
        
        if (!empty($attachments)) {
            $mime = new Mail_mime("\r\n");
            
            if ($html == true) {
                $mime->setHTMLBody($body);
            } else {
                $mime->setTXTBody($body);
            }
            
            if (count($attachments)) {
                foreach ($attachments as $file) {
                    //TO DO проверять, добавился ли файл
                    $mime->addHTMLImage( $file, mime_type($file) );
                }
            }
            
            $param['text_charset'] = $charset;
            $param['html_charset'] = $charset;
            $param['head_charset'] = $charset;
            
            $body = $mime->get($param);
            $headers = $mime->headers($headers); 
        } else {
            $headers['Content-Type'] = "text/".($html?"html":"plain")."; charset=$charset;";
        }
        
        $mail = Mail::factory ('smtp', $smtp_params); 
        $res = $mail->send($to, $headers, $body);
        
        return $res;
    }
    
    /**
     * Отправка почты
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param boolean $html
     * @param string $charset
     * @return boolean
     */
    public static function sendMail($from, $to, $subject, $body, $html=false, $charset='UTF-8')
    {
        require_once ('Mail.php');

        if ($charset != 'UTF-8') {
            $body = iconv('UTF-8', $charset, $body);
            $subject = iconv('UTF-8', $charset, $subject);
        }
        
        $headers['From']    = $from;
        $headers['Subject'] = $subject;
        $headers['Content-Type'] = "text/".($html?"html":"plain")."; charset=$charset;";
        
        /*Отправка через mail*/
        $mail = Mail::factory ('mail');
        $res = $mail->send($to, $headers, $body);
        
        return $res;
    }

    //получение MIME-типа файла
    function mime_type ($filename) { 
        /*
        $ext = strtolower(array_pop(".",explode($filename)));
        $mime = mime_pseudo_type($ext); echo $mime;
        */
        $finfo = finfo_open(FILEINFO_MIME);
        $mime = finfo_file($finfo, $filename);
        finfo_close($finfo);
        return $mime;
    }
}