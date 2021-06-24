<?php
namespace MicroEmail\Services;

class SendGridService {

    /**
     * @param $emailAddress
     * @param $toName
     * @param $subject
     * @param $body
     * @param string $type
     * @return bool
     * @throws \SendGrid\Mail\TypeException
     */
    public function send($emailAddress, $toName, $subject, $body, $type = "text/plain"){
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(getenv('SENDGRID_API_FROM_EMAIL'), getenv('SENDGRID_API_FROM_NAME'));
        $email->setSubject($subject);
        $email->addTo($emailAddress, $toName);
        $email->addContent($type, $body);
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);

        } catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
            return false;
        }
        return true;
    }
}