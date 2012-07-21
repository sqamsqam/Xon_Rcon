<?php
class Commands {
	/*
	// Name: Commands Class
	// Created by: Sam Fenton (sqamsqam)
	// Last Edited: 21/07/12
	// Description: Ingame Commands
	*/
	
	public function command($data) {
		$rcon = new Xon_Rcon;
		$name =  explode(" " . Config::get('prefix'), $data, 2);
		foreach (explode(',', Config::get('users')) as $user) {
			if ($user == $name[0]) {
				$action = trim($name[1], "\n");
				$action = explode(" ", $name[1], 2);
				switch ($action[0]) {
					case "say":
						$rcon->send_command("$action[0] $action[1]");
						break;
					case "map":
						$option = explode(' ', $action[1], 2);
						if (isset($option[1])) {
							foreach (explode(',', Config::get('maps')) as $map) {
								if (preg_match("/^(" . $option[0] . ")/", $map) == true) {
									foreach(explode(',', Config::get('gametypes')) as $gametype) {
										if (preg_match("/^(" . $option[1] . ")/", $gametype) == true) {
											$rcon->send_command("say ^3Changing map and gametype to: ^2$map ^3$gametype");
											$rcon->send_command("gametype $gametype");
											$rcon->send_command("chmap $map");
										}
									}
								}
							}
						}
						else {
							foreach (explode(',', Config::get('maps')) as $map) {
								if (preg_match("/^(" . $action[1] . ")/", $map) == true) {
									$rcon->send_command("say ^3Changing map to: ^2$map");
									$rcon->send_command("chmap $map");
									break;
								}
							}
						}
						break;
					case "gametype":
						foreach(explode(',', Config::get('gametypes')) as $gametype) {
							if (preg_match("/^(" . $action[1] . ")/", $gametype) == true) {
								$rcon->send_command("say ^3Changing gametype to: ^2$action[1]");
								$rcon->send_command("$action[0] $gametype");
								$rcon->send_command("restart");
								break;
							}
						}
						break;
					case "kick":
						$rcon->send_command("$action[0] $action[1]");
						break;
					case "ban":
						$rcon->send_command("$action[0] $action[1]");
						break;
					case "rcon":
						$rcon->send_command("$action[1]");
						break;
					case "restart":
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