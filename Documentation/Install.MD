# Installation Steps
The following contains the necessary actions to take to ensure the system functions as a whole.

## Odroid Ubuntu MATE Install

Go to:
http://adjarvis.com/odroid-c2-ubuntu-install/

## Odroid Board Installation
The necessary files and packages are included in the install script. The script is a very basic method to list the required packages and install them. It is in no way indestructible. In the event of issues the packages can be manually installed. On top of the packages there are a couple of directories we use by default:

* /home/iperf
* /home/iperf-scripts

These can be changed freely but will be created in the install script.

To install with the script go to the 'odroid-install_script.sh' in Installation-Scripts

	1. Copy the script to odroid board - wget https://raw.githubusercontent.com/LukeCSmith0/hyperspeed-tester/master/Installation-Scripts/odroid-install_script.sh

	2. Chmod file so that you can run it 'chmod u+x odroid-install_script.sh'

	3. Run the odroid-install_script.sh file
	
In addition to the necessary packages the following scripts need to be included on the Odroid board:

* boot.py
* button_script.py
* button_shell_script.py
* execute_test_final.py

By default all of these are stored in the /home/iperf-scripts folder. All of the necessary packages for the Odroid board can be found in Client-Script

## IPerf Server Installation
The IPerf server has a relatively small footprint in terms of required packages. The only two packages needed are the IPerf package and rssh packages.

To install with the script go to the 'iperf-server-install-script.sh' in Installation-Scripts

	1. Copy the script to server - https://raw.githubusercontent.com/LukeCSmith0/hyperspeed-tester/master/Installation-Scripts/iperf-server-install-script.sh

	2. Chmod file so that you can run it 'iperf-server-install-script.sh'

	3. Run the iperf-server-install-script.sh file 
	
Of importance as well is the cron jobs that are run on the server. The required ones can be found in Server-Script.
	
## IPerf Log Server Installation
The IPerf log server is where things are a bit more tricky. This server store the logs for the tests along with the front-end interface to display them. For the server we have used a simple LAMP deployment (Apache, MySQL, PHP), however this can be changed. As such the installation guide for LAMP stack installation on Ubuntu should be followed here:

* http://howtoubuntu.org/how-to-install-lamp-on-ubuntu

We also made use of a basic database structure consistsing of just two tables to store all the data we need. We have the following two tables:

* Engineer to board mappings
* IPerf test results

The following SQL snippets are below for both tables:

```SQL
CREATE TABLE 'engineer_assignment' (
  'engineer_id' int(11) NOT NULL,
  'engineer_name' varchar(255) NOT NULL,
  'engineer_email' varchar(255) NOT NULL,
  'board_id' varchar(255) NOT NULL
);
```
```SQL
CREATE TABLE 'test_logs' (
  'log_id' int(11) NOT NULL,
  'file_hash' varchar(255) NOT NULL,
  'timestamp' int(255) NOT NULL,
  'connecting_to' varchar(255) NOT NULL,
  'test_duration' varchar(255) NOT NULL,
  'gbps_sent' varchar(255) NOT NULL,
  'gbps_received' varchar(255) NOT NULL,
  'board_id' varchar(255) NOT NULL,
  'gateway_mac' varchar(255) DEFAULT NULL,
  'peak_gbps' varchar(255) NOT NULL
);
```

On top of this the only other package needed is RSSH for the RCP copies between log server and iperf server. Of importance as well is the cron jobs that are run on the server. The required cron jobs can be found in Server-Script.

The following scripts are needed on the IPerf log server:

* json_server_side.py
* rsync_copy.py

To install: 

	1. Copy the script to server - https://raw.githubusercontent.com/LukeCSmith0/hyperspeed-tester/master/Installation-Scripts/iperf-log-server-install-script.sh

	2. Chmod file so that you can run it 'iperf-log-server-install-script.sh'

	3. Run the iperf-log-server-install-script.sh file 


By default these are in the /home/iperf-scripts installation directory.

For the front-end we used Semantic for the stlying of the webpage. If using the same webpage this will need to be installed as well. This can be done through the information from Semantic here:

* https://semantic-ui.com/introduction/getting-started.html

