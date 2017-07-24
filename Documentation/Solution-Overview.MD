# How the system works
## Odroid Board
The Odroid board is setup with three main Cron jobs that are run on boot up:
* boot.py
* button-script.py
* execute_test_final.py

boot.py is the script that is run on boot-up in order to provide a countdown until the tester has booted and is ready to perform the test. This is currently hardcoded at 30 seconds.
The button-script.py is needed to execute an infinite while loop that is listening for changes on the Odroid pins. In other words when the buttons are pressed on the screen.
Depending on the button the script will either be restarted or display the boards MAC address.
Finally the script that actually performs the line test is execute_test_final.py. During the testing process there are various screen prompts. All can be found in Documentation.

The script will perform the following checks to ensure adequate connectivity before performing the test:

* ICMP test to the hostname of the IPerf test server.
* Socket establishment to SSH port 22 to ensure SCP will work correctly.
* Socket establishment to IPerf port 5201 to ensure the IPerf server is available.

Once all three checks pass the IPerf test is performed. The Odroid board will perform the following command line client IPerf command:
```Python
iperf3 -c hostname -J -t 10
```
The above will return an iperf test with the server specified by hostname on port 5201 for 10 seeconds. -J signifies that we want the output of the test to be outputted into a file containing JSON
information. We use this information in extracting the necessary values we would like. By default we use a user on the Odroid board called Iperf. Therefore
the default location for the log files is /home/iperf. One of the main requirements is being able to later retrieve the results of a line test.
As such as need a way to distinguish between the logs. For this we read in the contents of a particular log output, generate a hash from this data, and use that
hash for the filename. As no two tests will be the same, for example timestamps differ, the hash should always be different. Due to the size of the MD5 hash
we decided to take 10 characters of the hash only for the unique identification of each log.

After the test is complete the test will be copied over to the IPerf server. For added security we make use of SCP for the file transfer. The script pulls the log from /home/iperf and uploads the files to the IPerf server, specifically /home/test-logs/<hashed-filename>. After this the script will display the upload and download speeds indefinetly until either the board is rebooted or the left button is pressed to restart the test.
