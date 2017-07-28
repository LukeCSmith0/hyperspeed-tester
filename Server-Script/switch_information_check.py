import MySQLdb
import requests
##Connect to the database
conn = MySQLdb.connect(host= "db-address",
                  user="db-user",
                  passwd="db-pass",
                  db="db-name")
x = conn.cursor()
x.execute("SELECT * FROM switch_information")
returned_info = x.fetchall()
for info_line in returned_info:
    log_id = info_line[0]
    mac_address = info_line[1]
    ##Perform a check to the API to see whether we get sufficient returned data
    url_to_send = "<API Address>" + mac_address
    print "Sending request to " + url_to_send
    r = requests.get(url_to_send, headers={'Authorization': '<API Token>'})
    if r.status_code != 200:
        print "The following log: " + log_id + " still cannot be updated with the switch information."
    else:
        print "The following log " + log_id + " can be updated with the switch informmation."
        returned = r.json()
        switchPortNumber = returned['portNumber']
        switchIpAddress =  returned['ipAddress']
        switchName =  returned['switchName']
        try:
            insert_query = "UPDATE test_logs SET switchPortNumber = '%s', switchIPAddress = '%s', switchName = '%s' WHERE file_hash = '%s'" % (switchPortNumber, switchIpAddress, switchName, log_id)
            x.execute(insert_query)
            delete_query = "DELETE FROM switch_information WHERE log_id = '%s'" % (log_id)
            print delete_query
            x.execute(delete_query)
            conn.commit()
        except:
            print "Something broke."
