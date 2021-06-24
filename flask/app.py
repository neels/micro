from typing import List, Dict
from flask import Flask, request, render_template
import mysql.connector
import json
import pika
import re

app = Flask(__name__)
regex = '^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$'

@app.route('/email', methods=['POST'])
def send_to_service():

    try:
        json.loads(request.get_data())
    except ValueError as e:
        return "Please make sure you post json. Error: {} ".format(e)

    if not validate_fields(json.loads(request.get_data())):
        return 'Please make sure you have the following in your JSON: ' \
               'email (to e-mail address), ' \
               'name (to name), ' \
               'subject, ' \
               'body ' \
               'and type (type "text/plain" or "text/html" ***optional***)', 400


    add_msg(request.get_data())
    return 'the following data was submitted successfully to RabbitMQ:{}'.format(request.get_data())

@app.route('/', methods=['GET'])
def index():
    return render_template("index.html")

@app.route('/email_logs', methods=['GET'])
def mail_logs():
    config = {
        'user': 'root',
        'password': 'root',
        'host': 'micro_email_db',
        'port': '3306',
        'database': 'emails'
    }
    connection = mysql.connector.connect(**config)
    cursor = connection.cursor()
    cursor.execute('SELECT * FROM email_sent order by `date_created` DESC ')
    rows = cursor.fetchall()
    cursor.close()
    connection.close()
    return render_template("emails_sent.html", data=rows)

def add_msg(msg):
    rabbitconnection = pika.BlockingConnection(pika.ConnectionParameters('micro_email_rabbitmq'))
    channel = rabbitconnection.channel()
    channel.queue_declare(queue='emails')

    channel.basic_publish(exchange='',
                      routing_key='emails',
                      body=msg)
    rabbitconnection.close()

def validate_fields(data):
    if 'email' not in data or 'name' not in data or 'subject' not in data or 'body' not in data:
        return False

    if not (re.search(regex, data['email'])):
        return False

    if 'type' in data:
        allowed_type = ['text/plain', 'text/html']
        if data['type'] not in allowed_type:
            return False

    return True


if __name__ == '__main__':
    app.run(host='0.0.0.0')