<?php
/*
// Name: Xonotic RCon
// Created by: Sam Fenton (sqamsqam)
// Last Edited: 18/07/12
// Description: Base Script used for starting Xonotic RCon
//
// About:
// PHP-RCon for xonotic by sqamsqam (Sam Fenton, sqamsqam.com)
// 
// Notes:
// 377 octal = 255 dec, 0xFF hex
// Packet Buffer "\xFF\xFF\xFF\xFF"
// 
// To-Do:
// implement HMAC and CHALENGE authentication.
// finish set of rcon commands
// use printf and sprintf
// OOP! < semi-complete
// 
// How to Run:
// php -f xon_rcon.php
//
// Commands:
// - say
// - map (only needs part of the map name)
// - kick (needs to be worked on)
// - status (testing command)
// - rcon (send an rcon command through chat)
*/

require_once ("inc/functions.php");
require_once ("inc/config/config.php");
require_once ("inc/config/users.php");
date_default_timezone_set(Config::get('timezone'));
$rcon = new Xon_Rcon;


print("Xonotic PHP-RCon Starting...\n");


$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($socket, Config::get('ip'), Config::get('port'));

while (true) {
	socket_recvfrom($socket, $packet, 1400, 0, $from, $port);
	$packet = substr($packet, 5);
	print("[" . date('h:i:s') . "] From: " . $from . ":" . $port . "; Recv: " . $packet);
	if (strpos($packet, " " . Config::get('prefix')) == true) {
		if (strpos($packet, ": " . Config::get('prefix')) == true) {
			$name = explode(": " . Config::get('prefix'), $packet, 2);
		}
		elseif (strpos($packet, "> " . Config::get('prefix')) == true) {
			$name = explode(" " . Config::get('prefix'), $packet, 2);
		}
		
		foreach (explode(',', Config::get('users')) as $user) {
			if ($user == $name[0]) {
				$action = explode(" ", $name[1], 2);
				switch ($action[0]) {
					case "say":
						$rcon->send_command("$action[0] $action[1]");
						break;
					case "map":
						$action[1] = trim($action[1], " \n");
						foreach (explode(',', Config::get('maps')) as $map) {
							if (preg_match("/^(" . $action[1] . ")/", $map) == true) {
								$rcon->send_command("say ^3Changing map to: ^2$map");
								$rcon->send_command("chmap $map");
								break;
							}
						}
						break;
					case "kick":
						$rcon->send_command("$action[0] $action[1]");
						break;
					case "status":
						$rcon->send_command("status");
						break;
					case "rcon":
						$action[1] = trim($action[1], " \n");
						$rcon->send_command("$action[1]");
						break;
				}
			}
		}
	}
}
?>