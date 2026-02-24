import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import sys

sender_email = "filipenetocunha@gmail.com"
receiver_email = "filipenetocunha@gmail.com"
password = "tyso tyjl jzpm bpdj"

msg = MIMEMultipart()
msg["From"] = sender_email
msg["To"] = receiver_email
msg["Subject"] = "Email enviado por: " + sys.argv[1]

body = " ".join(sys.argv[2:])
msg.attach(MIMEText(body, "plain", "utf-8"))

with smtplib.SMTP("smtp.gmail.com", 587) as server:
    server.starttls()
    server.login(sender_email, password)
    server.sendmail(sender_email, receiver_email, msg.as_string())

print("E-mail enviado com sucesso!")
