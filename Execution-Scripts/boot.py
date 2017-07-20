import wiringpi2
import time

##This script adds a bootup display to the Odroid screen.

###Screen Outputs
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

def ScreenOutput(TopLine, BottomLine):


    wiringpi2.lcdClear(lcdHandle)
    wiringpi2.lcdPosition(lcdHandle, lcdCol, lcdRow)
    wiringpi2.lcdPrintf(lcdHandle, TopLine)
    wiringpi2.lcdPosition(lcdHandle, lcdCol, lcdRow + 1)
    wiringpi2.lcdPrintf(lcdHandle, BottomLine)

ScreenOutput("Speed Tester", "Booting...")
for x in range (30, 0, -1):
    minutes = 0
    seconds = 0

    minutes = x / 60
    seconds = x % 60

    if seconds < 10:
        string_to_show = str(minutes) + ":0" + str(seconds)
    else:
        string_to_show = str(minutes) + ":" + str(seconds)


    time.sleep(1)
    if (x % 2 == 0):
        ScreenOutput("Speed Tester", "Booting " + string_to_show + " |")
    else:
        ScreenOutput("Speed Tester", "Booting " + string_to_show + " -")
