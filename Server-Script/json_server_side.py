
import json
import glob
import MySQLdb
import os
import shutil
import pwd
import grp
import calendar
import time

# This is the server side script that runs repeatedly to collect the results
# that are FTP'd from the client/LineTester. It then extracts the JSON data and
# inserts it into the mySQL database, stores the log file in another directory
# and removes the old file.

#The single function that runs all
def run_script():
    #Get list of the files in the directory
    dir_list = glob.glob("/home/iperf/*")

    #For every file in the dir
    for file_name in dir_list:
        with open(file_name) as json_data:
            #Load JSON form each file in this for loop
            jdata = json.load(json_data)

        #Extract all needed JSON elements
        counter = 0
        speed_interval_list = list()
        for x in jdata["intervals"]:
            var = jdata['intervals'][counter]['sum']['bits_per_second']
            speed_interval_list.append(var)
            counter = counter+1



        test_duration =  jdata['start']['test_start']['duration']
        connecting_to =  jdata['start']['connecting_to']['host']
        sent_bps = jdata['end']['sum_sent']['bits_per_second']
        received_bps =  jdata['end']['sum_received']['bits_per_second']
        mac_address =  jdata['end']['host_information']['mac_address']
        hash_value = jdata['end']['host_information']['hash']
        gateway_mac = jdata['end']['host_information']['gateway_mac']
        peak = max(speed_interval_list)
        #Set the time stamp to the server time
        timestamp_ = calendar.timegm(time.gmtime())

        #Convert from bps to Giga bps
        sent_gbps = sent_bps / 1000000000
        received_gbps = received_bps / 1000000000
        peak_gbps = peak / 1000000000

        #Round Giga bps to two decial places
        sent_gbps = round(sent_gbps, 2)
        received_gbps = round(received_gbps, 2)
        peak_gbps = round(peak_gbps, 2)

        #In this loop we are inserting all the data into the database

        #Server Connection to MySQL params
        conn = MySQLdb.connect(host= "db-host",
                          user="db-user",
                          passwd="db-passwd",
                          db="db-name")
        x = conn.cursor()
        #Try Except statment to catch if the insert was sucsessful or not
        #If it was not then it rolls back
        try:
           x.execute("INSERT INTO test_logs VALUES (Null, %s, %s, %s, %s, %s, %s, %s, %s, %s)", (hash_value, timestamp_, connecting_to, test_duration, sent_gbps, received_gbps, mac_address, gateway_mac, peak_gbps))
           print
           #test = x.execute("""Select * from test_logs""")
           conn.commit()
        except:
           conn.rollback()
           #Close DB connection
        conn.close()

        #Here is where we move the file into a perminant log directory
        #Define path value including the file hash from the JSON
        path_to_file = "/home/test-logs/" + hash_value
        #Move the file to the new directory
        shutil.move("/home/iperf/" + hash_value, path_to_file)
        #Change the ownership of the file so that www-data is the owner. This
        #allows for the JSON file downloads from the apache webserver to work
        os.chown(path_to_file, pwd.getpwnam("www-data").pw_uid, grp.getgrnam("www-data").gr_gid)

#On boot we run this python script as a cron job which can only be done every
#mintue so uing this look it allows the script to run every 15 seconds to
#speed up the time it takes to display the results on the front end.
#This is pretty crappy but it works :)
for t in range(60,-1,-1):
    seconds = t % 60
    time.sleep(1.0)
    if seconds == 59:
        run_script()
    elif seconds == 45:
        run_script()
    elif seconds == 30:
        run_script()
    elif seconds == 15:
        run_script()
