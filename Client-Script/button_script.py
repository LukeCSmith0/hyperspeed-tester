import wiringpi2
import subprocess
import time
import os
from uuid import getnode as get_mac

script_folder = "/home/iperf-script"

##This script is used to make the two buttons on the LCD screen operational

# --LCD
LCD_ROW = 2 # 16 Char
LCD_COL = 16 # 2 Line
LCD_BUS = 4 # Interface 4 Bit mode

PORT_LCD_RS = 7 # GPIOY.BIT3(#83)
PORT_LCD_E = 0 # GPIOY.BIT8(#88)
PORT_LCD_D4 = 2 # GPIOX.BIT19(#116)
PORT_LCD_D5 = 3 # GPIOX.BIT18(#115)
PORT_LCD_D6 = 1 # GPIOY.BIT7(#87)
PORT_LCD_D7 = 4 # GPIOX.BIT4(#104)
# --Buttons
PORT_LCD_5 = 5


# --LCD

wiringpi2.wiringPiSetup()
# --LCD
lcdHandle = wiringpi2.lcdInit(LCD_ROW, LCD_COL, LCD_BUS,
PORT_LCD_RS, PORT_LCD_E,
PORT_LCD_D4, PORT_LCD_D5,
PORT_LCD_D6, PORT_LCD_D7, 0, 0, 0, 0);
lcdRow = 0 # LCD Row
lcdCol = 0 # LCD Column
# --LCD

wiringpi2.pinMode(5,0)
wiringpi2.pinMode(6,0)

###Screen Outputs

def ScreenOutput(TopLine, BottomLine):

    wiringpi2.lcdClear(lcdHandle)
    wiringpi2.lcdPosition(lcdHandle, lcdCol, lcdRow)
    wiringpi2.lcdPrintf(lcdHandle, TopLine)
    wiringpi2.lcdPosition(lcdHandle, lcdCol, lcdRow + 1)
    wiringpi2.lcdPrintf(lcdHandle, BottomLine)

while (1 == 1):
    if wiringpi2.digitalRead(5) == 0:
        ScreenOutput("Stopping Script", "Please Wait...")
        ##Launch shell script to terminate any running testing scriipts
        subprocess.call([script_folder + "/button_shell_script"])
        time.sleep(3)
        ScreenOutput("Restart Script", "Please Wait...")
        time.sleep(3)
        os.system("python " + script_folder + "/execute_test_final.py > /dev/null 2>&1 &")

    elif wiringpi2.digitalRead(6) == 0:
        board_mac = get_mac()
        formatted_board_mac = str(':'.join(("%012X" % board_mac)[i:i+2] for i in range(0, 12, 2)))
        firstpart, secondpart = formatted_board_mac[:len(formatted_board_mac)/2], formatted_board_mac[len(formatted_board_mac)/2:]
        ScreenOutput(firstpart, secondpart)
        time.sleep(4)
