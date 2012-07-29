<?php
class Xon_Rcon {
	/*
	// Name: Xonotic RCon Class
	// Created by: Sam Fenton (sqamsqam)
	// Last Edited: 21/07/12
	// Description: Provides functions to send rcon messages
	*/
	public function recv_packet() {
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		socket_bind($socket, Config::get('ip'), Config::get('port'));
		utf8_decode(socket_recvfrom($socket, $packet, 1400, 0, $from, $port));
		
		return array("packet" => $packet, "from" => $from, "port" => $port);
	}
	public function packet_cleaner($packet) {
		$pattern = "/^\xFF\xFF\xFF\xFF\x6E/";
		$clean = preg_replace($pattern, "", $packet);
		return $clean;
	}
	public function name_cleaner($name) {
		$start = "/^\x01/";
		$pattern = "/\^[0-9]/";
		if (preg_match($start, $name)) {
			$clean = preg_replace($start, '', preg_replace($pattern, '', $name));
		}
		else {
			$clean = preg_replace($pattern, '', $name);
		}
		if (preg_match('/: /', $clean)) {
			$clean = preg_replace('/: /', ' ', $clean);
		}
		return $clean;
	}
	public function send_command($command) {
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		$command = utf8_encode($command);
		
		$this->send("\xFF\xFF\xFF\xFFrcon " . Config::get('rconpass') . " $command");
		
		print("[" . date('h:i:s') . "] Rcon Command: $command");
	}
	private function send($command) {
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		socket_sendto($socket, $command, strlen($command), 0, Config::get('rconip'), Config::get('rconport'));
	}
}
?>