<?php

require_once "email2name.php";
$emailsFilePath = "./emails.txt";
$csvFilePath = "./resolved.csv";
$email2name = new Email2name();
$email2name->verbose = true;
$resolvedEmails = $email2name->resolveFromFile($emailsFilePath, $csvFilePath);
