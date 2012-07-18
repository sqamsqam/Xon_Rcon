<?php
class Xon_Rcon {
	/*
	// Name: Xonotic RCon Class
	// Created by: Sam Fenton (sqamsqam)
	// Last Edited: 18/07/12
	// Description: Provides functions to send rcon messages
	*/
	public function send_command($command) {
		// Non-Flexible. takes ip and port from config
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		$header = "\xFF\xFF\xFF\xFF";
		
		if (Config::get('rconsecure') == 0) {
			$rcon_command = $header . "rcon " . Config::get('rconpass') . " $command";
			socket_sendto($socket, $rcon_command, strlen($rcon_command), 0, Config::get('rconip'), Config::get('rconport'));
		}
		elseif (Config::get('rconsecure') == 1) { // Time
			// ToDo
		}
		elseif (Config::get('rconsecure') == 2) { // Challenge
			// ToDo
		}
		print("[" . date('h:i:s') . "] Rcon Command: $command");
	}
	public function send_command_flexi($command, $rconip, $rconport) {
		// Flexible Version of the send_comand function that takes the ip and port of the server requesting the command.
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		$header = "\xFF\xFF\xFF\xFF";
		
		if (Config::get('rconsecure') == 0) {
			$rcon_command = $header . "rcon " . Config::get('rconpass') . " $command";
			socket_sendto($socket, $rcon_command, strlen($rcon_command), 0, $rconip, $rconport);
		}
		elseif (Config::get('rconsecure') == 1) { // Time
			// ToDo
		}
		elseif (Config::get('rconsecure') == 2) { // Challenge
			// ToDo
		}
		print("[" . date('h:i:s') . "] Rcon Command: $command");
	}
}
?>