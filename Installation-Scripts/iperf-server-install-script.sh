#!/bin/bash
echo *******Updating respositories*******
sleep 2
apt-get update
echo *******Installing IPerf3*******
sleep 2
apt-get install iperf3 -y
echo *******Installing RSSH for RCP Pulls*******
sleep 2
apt-get install rssh -y
echo *******Installing PIP for Flask Installation*******
sleep 2
apt-get install python-pip -y
echo *******Installing Flask*******
sleep 2
pip install flask
echo *******Installing WSGI for the Flask application*******
sleep 2
apt-get install libapache2-mod-wsgi -y
echo *******Creating the required directories for scripts and pulling scripts*******
sleep 2
mkdir /home/whats-my-ip
wget -O /home/whats_my_ip.py https://raw.githubusercontent.com/LukeCSmith0/hyperspeed-tester/master/Server-Script/whats-my-ip/whats_my_ip.py
wget -O /home/whats-my-ip.wsgi https://raw.githubusercontent.com/LukeCSmith0/hyperspeed-tester/master/Server-Script/whats-my-ip.wsgi
wget -O /etc/apache2/sites-available/whats-my-ip.conf https://raw.githubusercontent.com/LukeCSmith0/hyperspeed-tester/master/Server-Script/whats-my-ip.conf
echo *******Registering App with Apache*******
sleep 2
a2ensite whats-my-ip
echo *******Restarting Apache*******
sleep 2
/etc/init.d/apache2 restart
echo *******Setup complete*******
sleep 2
