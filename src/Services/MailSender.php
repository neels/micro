<?php
namespace MicroEmail\Services;

use MicroEmail\Models\EmailsModel;
use MicroEmail\Services\SendGridService;
use MicroEmail\Services\MailJetService;

class MailSender {

    /**
     * @param $data
     * @return bool
     */
    public function sendNow($data){

        $toEmail = trim($data['email']);
        $toName = trim($data['name']);
        $subject = trim($data['subject']);
        $body = trim($data['body']);
        $type = isset($data['type']) ? trim($data['type']) : "text/plain";
        $sendingStatus = 'failed';
        $service = 'no_service';
        $emailSent = false;

        // Fallback that if SendGrid fails it will use MailJet
        if(SendGridService::send($toEmail, $toName, $subject, $body, $type)){
            $emailSent = true;
            $service = 'sendgrid';
            $sendingStatus = 'sent';

        }else{
            if(MailJetService::send($toEmail, $toName, $subject, $body, $type)){
                $emailSent = true;
                $service = 'mailjet';
                $sendingStatus = 'sent';
            }
        }

        $emails = new EmailsModel();
        $emails->save($toEmail, $toName, $subject, $body, $service, $type, $sendingStatus);

        return $emailSent;
    }
}