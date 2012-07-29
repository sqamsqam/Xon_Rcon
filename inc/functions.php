<?php
/*
// Name: Functions
// Created by: Sam Fenton (sqamsqam)
// Last Edited: 19/07/12
// Description: Helpful functions
*/
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});
?>