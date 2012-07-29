<?php
/*
// Name: Xonotic RCon
// Created by: Sam Fenton (sqamsqam)
// Last Edited: 21/07/12
// Description: Base Script used for starting Xonotic RCon
//
// About:
// PHP-RCon for xonotic by sqamsqam (Sam Fenton, sqamsqam.com)
// 
// How to Run:
// php -f xon_rcon.php
//
// Commands:
// - say
// - map (only needs part of the map name, also accepts a third optional argument to change the gametype)
// - gametype (only need part of the gametype)
// - kick (needs to be worked on)
// - ban (needs to be worked on)
// - rcon (send an rcon command through chat)
// - restart (restarts current map)
*/

require_once ("inc/functions.php");
require_once ("inc/config/config.php");
require_once ("inc/config/users.php");
date_default_timezone_set(Config::get('timezone'));
$rcon = new Xon_Rcon;
$commands = new Commands;

print("Xon_Rcon Starting...\n");

while (true) {
	$packet = $rcon->recv_packet();
	
	$packet['packet'] = $rcon->name_cleaner($rcon->packet_cleaner($packet['packet']));
	print("[" . date('h:i:s') . "] From: " . $packet['from'] . ":" . $packet['port'] . "; Recv: " . $packet['packet']);
	
	$commands->command($packet['packet']);
}
?>