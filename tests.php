<?php

require __DIR__ . '/vendor/autoload.php';
use PHPUnit\Framework\TestCase;
require_once "email2name.php";

class StackTest extends TestCase {
    public function testResolveName() {
        $email2name = new Email2name();
        $name = $email2name->resolve("puzanov@gmail.com");
        $this->assertEquals("Oleg", $name);
    }
    public function testResolveFullName() {
        $email2name = new Email2name();
        $name = $email2name->resolve("puzanov@gmail.com", false);
        $this->assertEquals("Oleg Puzanov", $name);
    }
    public function testResolveDiscoverName() {
        $email2name = new Email2name();
        $name = $email2name->resolve("marinochka_artemonova@gmail.com", false);
        $this->assertEquals("Marinochka", $name);

        $name = $email2name->resolve("ANECHKA.artemonova@gmail.com", false);
        $this->assertEquals("Anechka", $name);

        $name = $email2name->resolve("Lenochka-artemonova@gmail.com", false);
        $this->assertEquals("Lenochka", $name);
    }
}
