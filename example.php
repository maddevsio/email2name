<?php

require_once "email2name.php";

$path = "./emails.txt";
$email2name = new Email2name();
$email2name->verbose = true;
$resolvedEmails = $email2name->resolveFromFile($path);
echo $email2name->formatToCSV($resolvedEmails);