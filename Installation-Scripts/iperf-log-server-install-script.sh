echo *******Updating Repositories*******
sleep 2
apt-get update
echo *******Installing RSSH for RCP Pulls*******
sleep 2
apt-get install rssh -y
echo ******Creating directories required for logs*******
sleep 2
mkdir /home/iperf-scripts
mkdir /home/iperf
mkdir /home/test-logs
echo ******Copying scripts*******
sleep 2
wget -O /home/iperf-scripts/json_server_side.py https://raw.githubusercontent.com/LukeCSmith0/hyperspeed-tester/master/Server-Script/json_server_side.py
wget -O /home/iperf-scripts/switch_information_check.py https://raw.githubusercontent.com/LukeCSmith0/hyperspeed-tester/master/Server-Script/switch_information_check.py
echo *******Setup complete*******
sleep 2
