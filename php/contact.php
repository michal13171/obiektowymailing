<?php

header('Content-type: application/json');

abstract class resultMail
{
    protected $error;
    protected $mail;
    protected $subject;
    private $message;
    private $to;
    private $htmlStarterStart;
    private $htmlStarterEnd;
    protected $s_mail;
    protected $headers;

    protected function index()
    {
        $this->error = [];
        //trim usuwa spacje
        $this->mail = trim($_POST['mail']);
        $this->subject = trim($_POST['subject']);
        $this->message = trim($_POST['message']);

        $this->subject = filter_var($this->subject, FILTER_SANITIZE_STRING);
        $this->message = filter_var($this->message, FILTER_SANITIZE_STRING);
    }
}
class anotherFunc extends resultMail
{
    public function store()
    {
        $this->index();
        if (!filter_var($this->mail, FILTER_SANITIZE_EMAIL)) {
            $this->error['mail'] = 'Adres email nieprawidowy';
        }
        if (strlen($this->subject) < 3) {
            $this->error['subject'] = 'Musi miec wiecej niż trzy znaki';
        }
        if (strlen($this->message) < 3) {
            $this->error['message'] = 'Tresć jest za krótka';
        }
        if (!$_POST['captchaG']) {
            $this->error['Captched'] = 'Nie wybrano tej opcji';
        }
        if (count($this->error) === 0) {
            $this->to = 'codeskillsschool@gmail.com';
            $this->subject = "=?UTF-8?B?" . base64_encode($this->subject) . "?=";
            $this->htmlStarterStart = '
              <!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"><html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-2\">

               </head>
               <body>
        ';
            $this->htmlStarterEnd = '
             </body>
             </html>
        ';
            $this->message = $this->htmlStarterStart . $this->message . $this->htmlStarterEnd;
            $this->headers = "MIME-Version: 1.0\n";
            $this->headers .= "Content-type: text/html; charset=UTF-8\n";
            $this->headers .= "From: codeskillsschool@gmail.com\n";
            $this->s_mail = mail($this->to, $this->subject, $this->message, $this->headers);
            if ($this->s_mail) {
                echo json_encode(['success' => 'Dziekujemy za wypelnienie formularza']);
            }
        } else {
            echo json_encode($this->error);
        }
    }

 
}

$obj = new anotherFunc();
echo $obj->store();
//echo var_dump($error);
//     echo <<<END
//     <h1>$mail</h1>
//     <br>
// <b> $subject </b>
// <br>
// $message
// END;

//json encode koduje tylko tablice i obiekty

