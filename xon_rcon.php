<?php
/*
// Name: Xonotic RCon
// Created by: Sam Fenton (sqamsqam)
// Last Edited: 19/07/12
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
// implement TIME and CHALENGE authentication.
// finish set of rcon commands
// use printf and sprintf
// OOP! < semi-complete
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


print("Xon_Rcon Starting...\n");


while (true) {
	$packet = $rcon->recv_packet();
	$packet['packet'] = substr($packet['packet'], 5);
	print("[" . date('h:i:s') . "] From: " . $packet['from'] . ":" . $packet['port'] . "; Recv: " . $packet['packet']);
	if (strpos($packet['packet'], " " . Config::get('prefix')) == true) {
		if (strpos($packet['packet'], ": " . Config::get('prefix')) == true) {
			$name = explode(": " . Config::get('prefix'), $packet['packet'], 2);
		}
		elseif (strpos($packet['packet'], "> " . Config::get('prefix')) == true) {
			$name = explode(" " . Config::get('prefix'), $packet['packet'], 2);
		}
		foreach (explode(',', Config::get('users')) as $user) {
			if ($user == $name[0]) {
				$action = explode(" ", $name[1], 2);
				switch ($action[0]) {
					case "say":
						$rcon->send_command("$action[0] $action[1]");
						break;
					case "map":
						$action[1] = trim($action[1], "\n");
						$option = explode(' ', $action[1], 2)
						if (isset($option[1])) {
							foreach(explode(',', Config::get('gametypes')) as $gametype) {
								if (preg_match("/^(" . $option[1] . ")/", $gametype) == true) {
									$rcon->send_command("say ^3Changing gametype to: ^2$gametype");
									$rcon->send_command("gametype $gametype");
								}
							}
						}
						foreach (explode(',', Config::get('maps')) as $map) {
							if (preg_match("/^(" . $action[1] . ")/", $map) == true) {
								$rcon->send_command("say ^3Changing map to: ^2$map");
								$rcon->send_command("chmap $map");
								break;
							}
						}
						break;
					case "gametype":
						$action[1] = trim($action[1], "\n");
						$rcon->send_command("say ^3Changing gametype to: ^2$action[1]");
						$rcon->send_command("$action[0] $action[1]");
						$rcon->send_command("restart");
						break;
					case "kick":
						$action[1] = trim($action[1], "\n");
						$rcon->send_command("$action[0] $action[1]");
						break;
					case "ban":
						$action[1] = trim($action[1], "\n");
						$rcon->send_command("$action[0] $action[1]");
						break;
					case "rcon":
						$action[1] = trim($action[1], "\n");
						$rcon->send_command("$action[1]");
						break;
					case "restart":
						$action[1] = trim($action[1], "\n");
						$rcon->send_command("$action[0]");
						break;
					/*
					case "status":
						$rcon->send_command("status");
						// need to finish
						break;
					*/
				}
			}
		}
	}
}
?>