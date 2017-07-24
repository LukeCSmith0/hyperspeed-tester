# Odroid C2 Line Tester
This is a repository for a portable line tester project. All relevant information can be found in the Documentation folder.

## The Aim

To create a portable, cost effective traffic generator that can be used to perform line tests up to a
speed of 1Gbps. The solution should have a front-end that allows for the viewing of test reports and
the necessary systems in place to provide report identification.

Requirements:
  * Be cost effective.
  * Easy to use
  * Able to test speeds up to 1Gbps.
  * Provide front-end access to test reports.
  * Separate test reports per location.
  
  ## The Idea
  
  In terms of how it all fits together the image below should hopfully show you
  
  ![alt text](https://github.com/LukeCSmith0/hyperspeed-tester/blob/master/Documentation/Pictures/Proposal.jpg "Proposal")

1. The user plugs the odroid board into there ISP's provided router
2. A speed test auto-magicaly runs
3. The test ID, Upload and Download speed are displayed on the 16x2 LCD screen
4. The test log is uploded to the 'Iperf Server' using SCP
5. Using Rsync the test log is pulled from the Iperf Server to the Web/DB Server 
 * This was done as the Iperf server in our case was public facing so it was a little more secure

  ![alt text](https://github.com/LukeCSmith0/hyperspeed-tester/blob/master/Documentation/Pictures/Tester.gif "")

  ![alt text](https://github.com/LukeCSmith0/hyperspeed-tester/blob/master/Documentation/Pictures/Screen_Output%20.jpg "")
