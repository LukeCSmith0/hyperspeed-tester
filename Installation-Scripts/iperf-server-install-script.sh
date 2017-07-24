#!/bin/bash
echo *******Updating respositories*******
sleep 2
apt-get update
echo *******Installing IPerf3*******
sleep 2
apt-get install iperf3 -y
echo *******Installing RSSH for RCP Pulls*******
sleep 2
apt-get rssh -y
echo *******Setup complete*******
sleep 2
