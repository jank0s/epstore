<?php
# Opens file log.txt
	$log = fopen('/var/log/epstore/log.txt', "a+");
        fputs($log, date("[d.m.Y, H:i:s]") .
                " user ID: " . $user . " " . $action .
                "\n");
	fclose($log);
