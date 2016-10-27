#!/usr/bin/php

<?php
include 'sendMail.php';

$tt = new sendMail();
$tt->sendMail2CustomerOnLead("mukesh_arya@yahoo.com","Mukesh","Gwalior");
$tt->sendMail2CallingTeam("mukesh.arya","12345");

?>
