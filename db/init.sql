CREATE DATABASE emails;
use emails;

CREATE TABLE email_sent (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` TEXT,
  `body` TEXT,
  `service`varchar(255),
  `type` varchar(255),
  `status` varchar(255),
  `date_created` DATETIME,
  PRIMARY KEY `id`(`id`)
);
