#!/bin/bash
echo *******Updating respositories*******
sleep 2
apt-get update
echo *******Installing IPerf3*******
sleep 2
apt-get install iperf3 -y
echo *******Installing PIP*******
sleep 2
apt-get install python-pip -y
echo *******Installing PIP*******
sleep 2
pip install paramiko
echo *******Installing SCP*******
sleep 2
pip install scp
echo *******Installing Iperf3 Python Wrapper*******
sleep 2
pip install iperf3
echo *******Installing required files for SCP*******
sleep 2
apt-get install libffi6 libffi-dev
echo *******Installing ARP module for Python*******
sleep 2
pip install python_arptable
echo *******Installing network interface module for Python*******
sleep 2
pip install netifaces
echo *******Creating directory for iperf files*******
sleep 2
mkdir /home/iperf
sleep 2
echo *******Installing Git for Odroid Screen Package******
apt-get install git -y
sleep 2
echo ******Installing dependencies for Odroid Screen******
apt-get install python-dev python-setuptools swig3.0 -y
echo ******Copying Screen Package from Git********
mkdir /home/screen
git clone https://github.com/hardkernel/WiringPi2-Python.git
cd WiringPi2-Python
git submodule init
git submodule update
sleep 2
echo *******Building Screen Package*******
swig3.0 -python -threads wiringpi.i
sudo python setup.py build install
sleep 2
echo *******Importing subprocess module for Python********
cd /home
git clone https://github.com/google/python-subprocess32
cd python-subprocess32
python setup.py install
sleep 2
echo *******Setting Cron to execute on startup for script execution********
(crontab -l 2>/dev/null; echo "@reboot python /home/iperf-script/button_script.py") | crontab -
(crontab -l 2>/dev/null; echo "@reboot python /home/iperf-script/boot.py") | crontab -
(crontab -l 2>/dev/null; echo "@reboot sleep 30; python /home/iperf-script/execute_test_final.py") | crontab -
echo ******Installing cifs-utils for file mounting*******
apt-get install cifs-utils -y
sleep 2
echo ******Mounting share for necessary files*******
###change to git clone
echo ******Copying scripts*******
mkdir /home/iperf-script
##change to git clone
echo *******Setup complete*******
sleep 2
