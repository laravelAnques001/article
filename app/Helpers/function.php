<?php 
use App\Jobs\SendEmail;

function js_send_email($subject, $data=[], $email, $view = 'general', DateTimeInterface $schedule = null){
    $details = [
        'subject' => $subject,
        'data' => $data,
        'email' => $email,
        'view' => $view,
    ];

    if($schedule){
        return SendEmail::dispatch($details)->delay($schedule);
    }else{
        return SendEmail::dispatchSync($details);
    }
}
?>
