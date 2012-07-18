<?php
/*
// Name: Functions
// Created by: Sam Fenton (sqamsqam)
// Last Edited: 18/07/12
// Description: Helpful functions
*/
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});
?>