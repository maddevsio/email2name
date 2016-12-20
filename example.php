<?php

require_once "email2name.php";

$path = "./emails.txt";
$email2name = new Email2name();
$resolvedEmails = $email2name->resolveFromFile($path);

var_dump($resolvedEmails);
