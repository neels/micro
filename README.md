# micro
This is a Docker service that sends emails using Flask, RabbitMQ, Mysql and PHP. Languages used to complete this Project `PHP, Python, SQL`

"I am just playing around with some technology here and was a fun project."

#### flask (API)
* gets the POST request and then validates the JSON and passes it RabbitMQ
* View list of sent emails.
#### RabbitMQ
* stores all the messages that needs to be send in the email queue.
#### PHP (Consumer and sender)
* This service connects to rabbitMQ, processes the messages and sends it to mailer service via API
* It has 2 mailing services to switch if one fails.
* Emails can be send directly from the terminal
* Saves data of sent emails to Database
#### Mysql 
* The storage of choice for this project

### Instructions
* Insert your api keys for SendGrid and Mailjet in .env file
* run ``docker-compose up`` in the folder

All systems go!

#### Sending email via POST:

* POST JSON to `localhost:5000/email` 
* example: 
```
{
    "email":"micromailer@cocobean.co.za", 
    "name":"Micro Emailer", "subject":"example subject", 
    "body":"body", 
    "type":"text/html"
}
```

#### View all emails sent:
* `http://localhost:5000/email_logs`


#### Sending mail from terminal:
* run `docker exec -it micro_email_php bash`
* run 
```
php src/cmd.php --email="micromailer@cocobean.co.za" --name="Micro Mail" --subject="Example Subject" --body="Welcome" --type="text/plain"
```
type is optional and can be `text/html` or `text/plain` 
