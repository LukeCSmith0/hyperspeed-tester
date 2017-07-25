# On-screen Messages
The Odroid board is programmmed to display various messages at different stages of the testing process. The following explain what each mean, the majority are self explanatory

* Ping Test Executing
  * The Odroid board is performing an ICMP connectivity test to the IPerf server
  * If it returns Ping Test Successful the test is passed
  * If it returns Ping Test Unsuccessful the test has failed to verify connectivity to the IPerf Server and will restart from the beginning.
* SFTP Test Executing
  * The Odroid board is performing a socket connectivity check to the SCP port to verify the IPerf server is available for SCP
  * If it returns SFTP Test Successful the test is passed
  * If it returns SFTP Test Unsuccessful the socket could not be established for SCP on the IPerf server. This will cause the script to restart as a result from the beginning.
* IPerf Test Executing
  * The Odroid board is performing a socket connectivity check to the default IPerf port of 5201 to verify the IPerf server is listening for IPerf client requests.
  * If it returns IPerf Test Successful the test is passed
  * If it returns IPerf Test Unsuccessful the socket could not be established which is required to perform the test. This will cause the script to restart from the beginning.
 * Speed Test Executing
   * The Odroid board is currently executing the line test against the IPerf server. The time this takes will vary depending on the settings in the script. By default this will take 15 seconds.
   * It is possible that at this stage the board will display a Server Busy Retrying message. This means that another test is currently taking up the IPerf server and therefore another test cannot be run at this time. This will cause the script to restart and try again. The reason for this is that IPerf3 has a limitation of only being able to perform a single test at a time.
 * Default Gateway MAC
   * This will show the default gateway MAC address of the Odroid board. This is needed for some additional information gathering server side.
 * Test Copied to Server
   * The test has been successfully copied via SCP to the IPerf server.
 * Test ID
   * This will show the test ID of the test just performed. This can be used to view the test results at a later time on the web front end.
