# Installation Steps
The following contains the necessary actions to take to ensure the system functions as a whole.

## Odroid Board Installation
The necessary files and packages are included in the install script. The script is a very basic method to list the required packages and install them. It is in no way indestructible. In the event of issues the packages can be manually installed. On top of the packages there are a couple of directories we use by default:

* /home/iperf
* /home/iperf-scripts

These can be changed freely but will be created in the install script.

To install with the script go to the 'odroid-install_script.sh' in Installation-Scripts

	1. Copy the script to odroid board

	2. Chmod file so that you can run it 'chmod u+x odroid-install_script.sh'

	3. Run the odroid-install_script.sh file 

## IPerf Server Installation
The IPerf server has a relatively small footprint in terms of required packages. The only two packages needed are the IPerf package and rssh packages.

To install with the script go to the 'iperf-server-install-script.sh' in Installation-Scripts

	1. Copy the script to odroid board

	2. Chmod file so that you can run it 'iperf-server-install-script.sh'

	3. Run the iperf-server-install-script.sh file 

