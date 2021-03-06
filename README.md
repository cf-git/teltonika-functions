# teltonika-functions
Teltonika parse functions for php


===
To understand
``
<pre>
0000 0000 0000 03f3

08                    - codec;

  10                  - Data count (16 records) - number of data;

===================== [First record] ========================

     0000 0162 52fb

de88                  - timestamp - first

     00               - priority

-------------------------------------------------------------

       14 e1dc b0     - Longitude

                 1c

e291 81               - Latitude

       00 61          - Altitude

            00 50     - Angle

                 0d   - Visible sattelites

0000                  - Speed

-------------------------------------------------------------

     00               - Event IO ID - if 0 is generated by hand

       09             - IO elements count - is 9

-------------------------------------------------------------

          04          - One byte elements count - is 4

            01        - First one byte element id

               00     - First one byte element value

                 b3   - Second one byte element id

00                    - Second one byte element value

  f0                  - Third one byte element id

     01               - Third one byte element value

       15             - Fourth one byte element id

          00          - Fourth one byte element value

-------------------------------------------------------------

            02        - Two byte elements count - is 2

               09     - First two byte element id

                 5c 

66                    - First two byte element value (5c66)

  42                  - Second two byte element id

     3cc2             - Second two byte element value

-------------------------------------------------------------

          02          - Four byte elements count - is 2

            c7        - First four byte element id

               0000 

0000                  - First four byte element value

       48             - Second four byte element id

         00 0001 15   - Second four byte element value

-------------------------------------------------------------

                   01 - Eight byte elements count

cf                    - First eight byte element id (01cf)

  00 0000 0000 0000 

00                    - First eight byte element value


===================== [Second record] =======================

  00 0001 6252 fc53 

b8                    - timestamp - second

  00                  - priority ...

     14e1 dcb0        - Longitude

             1ce2 

9181                   - Latitude

     0064 0050 0f00 

0000 0904 0100 b300 

f000 1505 0209 5c65 

423c dc02 c700 0000 

0048 0000 0118 01cf

0000 0000 0000 0000 

0000 0162 52fd 3e18 

0014 e1dc b01c e291 

8100 6400 500f 0000 

0009 0401 00b3 00f0 

0015 0502 095c 6442 

3cea 02c7 0000 0000 

4800 0001 1b01 cf00 

0000 0000 0007 0400 

0001 6252 fe28 7800 

14e1 dcb0 1ce2 9181 

0064 0050 0f00 0000 

0904 0100 b300 f000 

1505 0209 5c6a 423c 

e302 c700 0000 0048 

0000 011f 01cf 0000 

0000 0000 3b04 0000 

0162 52ff 12d8 0014 

e1dc b01c e291 8100 

6400 500f 0000 0009 

0401 00b3 00f0 0015 

0502 095c 6d42 3cec 

02c7 0000 0000 4800 

0001 2301 cf00 0000 

0000 003b 0400 0001 

6252 fffd 3800 14e1 

dcb0 1ce2 9181 005c 

0050 0f00 0000 0904 

0100 b300 f000 1505 

0209 5c6a 423d 0902 

c700 0000 0048 0000 

0127 01cf 0000 0000 

0000 7604 0000 0162 

5300 e798 0014 e1dc 

b01c e291 8100 5c00 

5010 0000 0009 0401 

00b3 00f0 0015 0002 

095c 6442 3d18 02c7

0000 0000 4800 0001

2a01 cf00 0000 0000 

003b 0400 0001 6253 

01d1 f800 14e1 dcb0 

1ce2 9181 005c 0050 

1000 0000 0904 0100 

b300 f000 1500 0209 

5c70 423d 2102 c700 

0000 0048 0000 012d 

01cf 0000 0000 0000 

3b04 0000 0162 5302 

bc58 0014 e1dc b01c 

e291 8100 5c00 5010 

0000 0009 0401 00b3 

00f0 0015 0002 095c 

7042 3d28 02c7 0000 

0000 4800 0001 3101 

cf00 0000 0000 0076 

0400 0001 6253 03a6 

b800 14e1 dcb0 1ce2 

9181 005c 0050 1000 

0000 0904 0100 b300 

f000 1500 0209 5c6a 

423d 3002 c700 0000 

0048 0000 0133 01cf 

0000 0000 0000 7604 

0000 0162 5304 9118 

0014 e1dc b01c e291 

8100 5c00 5011 0000 

0009 0401 00b3 00f0 

0015 0002 095c 6a42 

3d32 02c7 0000 0000 

4800 0001 3601 cf00 

0000 0000 0007 0400 

0001 6253 057b 7800 

14e1 dcb0 1ce2 9181 

005c 0050 1100 0000 

0904 0100 b300 f000 

1500 0209 5c6f 423d 

3902 c700 0000 0048 

0000 0139 01cf 0000 

0000 0000 1d04 0000 

0162 5306 65d8 0014 

e1dc b01c e291 8100 

5c00 5011 0000 0009 

0401 00b3 00f0 0015 

0002 095c 6f42 3d4a 

02c7 0000 0000 4800 

0001 3c01 cf00 0000 

0000 001d 0400 0001

6253 0750 3800 14e1 

dcb0 1ce2 9181 005c 

0050 1100 0000 0904 

0100 b300 f000 1500 

0209 5c6a 423d 4f02 

c700 0000 0048 0000 

013e 01cf 0000 0000 

0000 1d04 0000 0162 

5308 3a98 0014 e1dc 

b01c e291 8100 5c00 

5011 0000 0009 0401 

00b3 00f0 0015 0002 

095c 6c42 3d53 02c7 

0000 0000 4800 0001 

4001 cf00 0000 0000 

0075 0400 0001 6253 

0924 f800 14e1 dcb0 

1ce2 9181 005c 0050 

1100 0000 0904 0100 

b300 f000 1500 0209 

5c70 423d 6302 c700

0000 0048 0000 0143

01cf 0000 0000 0000 

1d04 

     10               - Datas count - number of data

       0000 d8bb      - crc
</pre>
``
