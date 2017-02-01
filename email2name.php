<?php

class Email2name {
    public $verbose = false;
    public function resolveAndDiscover($email, $nameOnly = true) {
        $email = trim($email);
        $name = $this->resolve($email, $nameOnly);
        if ($name === false) {
            return $this->discover($email);
        }
        return $name;
    }

    public function resolve($email, $nameOnly = true) {
        $email = trim($email);
        $data = file_get_contents("http://www.spokeo.com/social/profile?q={$email}&loaded=1");
        if (preg_match("/profile_summary_title\'\>(.+)\<\/div\>/", $data, $matches)) {
            if ($this->isEmail($matches[1])) {
                return false;
            }
            if ($nameOnly) {
                return explode(" ", $matches[1])[0];
            } else {
                return $matches[1];
            }
        } else {
            return false;
        }
    }

    public function discover($email) {
        $email = trim($email);
        $name = explode("@", $email)[0];
        $name = preg_replace('/\d+/', '', $name);
        $name = explode(".", $name)[0];
        $name = explode("_", $name)[0];
        $name = explode("-", $name)[0];
        $name = ucfirst(strtolower($name));
        if (empty($name)) {
            return explode("@", $email)[0];
        }
        return $name;
    }

    public function resolveAndDiscoverFromFile($path) {
        $resolvedEmails = array();
        $emails = explode("\n", trim(file_get_contents($path)));
        foreach($emails as $email) {
            $email = trim($email);
            if ($this->verbose) echo "Working with $email... ";
            $name = $this->resolveAndDiscover($email, true);
            if ($this->verbose) echo "$name\n";
            $resolvedEmails[] = array("name" => $name, "email" => $email);
        }
        return $resolvedEmails;
    }

    public function resolveFromFile($emailsFilePath, $csvFilePath = false) {
        $resolvedEmails = array();
        $emails = explode("\n", trim(file_get_contents($emailsFilePath)));
        $k = 0;
        foreach($emails as $email) {
            $k++;
            $email = trim($email);
            if ($this->verbose) echo "$k Working with $email... ";
            $name = $this->resolve($email, true);
            if ($name) {
                if ($this->verbose) echo "$name\n";
                $resolvedEmails[] = array("name" => $name, "email" => $email);
                if ($csvFilePath) {
                    file_put_contents($csvFilePath, "$name,$email\n", FILE_APPEND | LOCK_EX);
                }
            } else {
                if ($this->verbose) echo "not found, skipping\n";
            }
        }
        return $resolvedEmails;
    }

    public function formatToCSV($resolvedEmails) {
        $csv = '';
        foreach ($resolvedEmails as $resolvedEmail) {
            $csv .= "{$resolvedEmail['name']},{$resolvedEmail['email']}\n";
        }
        return trim($csv);
    }

    private function isEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}
