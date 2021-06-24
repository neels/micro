<?php
namespace MicroEmail\Services;

use \Mailjet\Resources;

class MailJetService {

    /**
     * @param $emailAddress
     * @param $toName
     * @param $subject
     * @param $body
     * @return bool
     */
    public function send($emailAddress, $toName, $subject, $body){

        $mj = new \Mailjet\Client(
            getenv('MAILJET_API_KEY'),
            getenv('MAILJET_API_SECRET'),
            true,['version' => 'v3.1']
        );

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => getenv('MAILJET_API_FROM_EMAIL'),
                        'Name' => getenv('MAILJET_API_FROM_NAME')
                    ],
                    'To' => [
                        [
                            'Email' => $emailAddress,
                            'Name' => $toName
                        ]
                    ],
                    'Subject' => $subject,
                    'HTMLPart' => $body,
                ]
            ]
        ];
        try{
            $mj->post(Resources::$Email, ['body' => $body]);
        }catch (\Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
            return false;
        }

        return true;
    }
}