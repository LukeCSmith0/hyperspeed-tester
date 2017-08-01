## The following Cron jobs are running on the log server:

* \* \* \* \* \* iperf3 -s -D
@reboot python /home/whats-my-ip/whats-my-ip.py

This will start the IPerf daemon every minute. This is to ensure that in the event that it goes down it can be brought back up. If it is already up nothing will happen. The second job is to start the whats-my-ip flask app on bootup so that the clients IP addresses can be obtained for switch identification.
