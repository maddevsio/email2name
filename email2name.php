<?php

class Email2name {
    public function resolve($email, $nameOnly = true) {
        $data = file_get_contents("http://www.spokeo.com/social/profile?q={$email}&loaded=1");
        if (preg_match("/profile_summary_title\'\>(.+)\<\/div\>/", $data, $matches)) {
            if ($nameOnly) {
                return explode(" ", $matches[1])[0];
            } else {
                if ($this->isEmail($matches[1])) {
                    return $this->discover($matches[1]);
                }
                return $matches[1];
            }
        } else {
            return false;
        }
    }

    public function discover($email) {
        $name = explode("@", $email)[0];
        $name = preg_replace('/\d+/', '', $name);
        $name = explode(".", $name)[0];
        $name = explode("_", $name)[0];
        $name = explode("-", $name)[0];
        $name = ucfirst($name);
        return $name;
    }

    private function isEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}
