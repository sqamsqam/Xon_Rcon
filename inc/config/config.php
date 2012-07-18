<?php
/*
// Name: Config File
// Created by: Sam Fenton (sqamsqam)
// Last Edited: 18/07/12
// Description: Config settings for the script.
*/

// UDP Listen Server Settings.
// This is the ip and port that Xon_Rcon will receive the logs through
Config::set("ip",		"localhost");
Config::set("port",		"9000");

// Xonotic Server Details
Config::set("rconip",	"127.0.0.1");
Config::set("rconport",	"26000");
Config::set("rconpass",	"rcon_pass");
Config::set("rconsecure","0");

// General Script Settings
Config::set("timezone",	"Pacific/Auckland");
Config::set("prefix",	"!");
Config::set("maps",		"afterslime,dance,g-23,glowplant,leave_em_behind,newtonian-nightmare,nexballarena,red-planet,runningman,space-elevator,stormkeep,techassault,xoylent");
?>