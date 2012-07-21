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
		$pattern = "/\^[1-9]/";
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
		// Non-Flexible. takes ip and port from config
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		$header = "\xFF\xFF\xFF\xFF";
		$command = utf8_encode($command);
		
		if (Config::get('rconsecure') == 2) { // Challenge
			$this->send($header . "getchallenge");
			$c = $this->recv_challenge();
			if (!defined($c)) {
				return 0;
			}
			$key = hash_hmac('md4', "$c $command", Config::get('rconpass'));
			$this->send($header . "srcon HMAC-MD4 CHALLENGE $key $c $command");
		}
		else {
			$this->send($header . "rcon " . Config::get('rconpass') . " $command");
		}
		print("[" . date('h:i:s') . "] Rcon Command: $command");
	}
	private function send($command) {
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		socket_sendto($socket, $command, strlen($command), 0, Config::get('rconip'), Config::get('rconport'));
		print("[" . date('h:i:s') . "] Sent: $command");
	}
	private function recv_challenge() {
		$endtime_max = microtime() + 1;
		$endtime = $endtime_max;
		while(($dt  = $endtime - microtime()) > 0) {
			$packet = $this->recv_packet();
			if (strpos($packet['packet'], "\xFF\xFF\xFF\xFF" . "challenge ") == true) {
				$challenge = explode(' ', $packet['packet'], 2);
				return $challenge[1];
			}
		}
	}
	
	/*
	public function send_command_flexi($command, $ip, $port) {
		// Non-Flexible. takes ip and port from config
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		$header = "\xFF\xFF\xFF\xFF";
		$command = utf8_encode($command);
		
		if (Config::get('rconsecure') < 1) {
			$this->send_flexi($header . "rcon " . Config::get('rconpass') . " $command", $ip, $port);
		}
		elseif (Config::get('rconsecure') == 1) { // Time
			$t = sprintf("%d.%06d",time(), rand(0,1000000));
			$key = hash_hmac('md4', "$t $command", Config::get('rconpass'));
			$this->send_flexi($header . "srcon HMAC-MD4 TIME $key $t $command", $ip, $port);
		}
		elseif (Config::get('rconsecure') == 2) { // Challenge
			$this->send_flexi($header . "getchallenge", $ip, $port);
			$c = $this->recv_challenge();
			$key = hash_hmac('md4', "$c $command", Config::get('rconpass'));
			$this->send_flexi($header . "srcon HMAC-MD4 CHALLENGE $key $c $command", $ip, $port);
		}
		print("[" . date('h:i:s') . "] Rcon Command: $command");
	}
	public function send_flexi($command, $ip, $port) {
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		socket_sendto($socket, $command, strlen($command), 0, $ip, $port);
		print("[" . date('h:i:s') . "] Sent: $command");
	}
	*/
}
?>