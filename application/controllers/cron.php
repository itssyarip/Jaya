<?php
class Cron extends CI_Controller
{
  public function index() {
  }

  public function sendemail()  {
        $from = "admin.dmsolidwood";
        $message = "Hello! from your website";
        $headers = 'From: '.$from."\r\n" .
        'Reply-To:agra.kurnia@indonet.co.id'."\r\n" .
        "Content-Type: text/html; charset=iso-8859-1\n".
        'X-Mailer: PHP/' . phpversion();

        mail('agra.kurnia@indonet.co.id', "Message From Your WebSite", $message, $headers);
  }
}

?>
