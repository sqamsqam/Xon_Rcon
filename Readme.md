# Xon_Rcon
**Created by: Sam Fenton (sqamsqam), Version: 0.1**

[Xonotic Forum Thread](http://forums.xonotic.org/showthread.php?tid=3284)


## About
Xon_Rcon aims to make server administration easier. Xon_Rcon does this by reading the server log and issuing rcon commands depending on what is typed in chat (e.g a user on the admin list types "!map stor" in the ingame chat. Xon_Rcon then looks for any map beginning with "stor". since stormkeep is the only map that matches the expression Xon_Rcon sends the rcon command "chmap stormkeep" to the server.

**Current Features:**

- Sends rcon commands to the server.
- Checks to make sure the user is allowed to issue commands.
- Receives server log over udp using "log_dest_udp"


**Todo:**

- Implement rcon_secure 1 and 2
- Command access levels. (let only certain users issue some of the commands such as "!rcon")
- bug fixes...


**Possible Features:**

- Manage multiple Xonotic servers from one Xon_Rcon instance.


**Command List:**

- say ("!say hi everyone" -> "rcon say hi everyone")
- map ("!map stor" -> "rcon chmap stormkeep")
- gametype ("!gametype ctf" -> "rcon gametype ctf")
- kick ("!kick player name" -> "rcon kick player name")
- ban ("!ban player name" -> "rcon ban player name")
- rcon ("!rcon set g_minstagib 1" -> "rcon set g_minstagib 1")


##How to Run
Simply launch the start script that matches your operating system.

- Linux: start-linux.sh
- windows: start-windows.bat


or in the command line like this:

    php -f xon_rcon.php


## Notes
please make sure you look at the config files in 'inc/config/'

Xon_Rcon requires that you have:

```
log_dest_udp "127.0.0.1:9000"
rcon_secure 0
```

in your server config. you change the ip and port of log_dest_udp to the ip and
port that Xon_Rcon is running on. 

---

Readme last updated on (19/07/2012)