<?php

require __DIR__ . '/vendor/autoload.php';
use PHPUnit\Framework\TestCase;
require_once "email2name.php";

class StackTest extends TestCase {
    public function testResolveAndDiscoverName() {
        $email2name = new Email2name();
        $name = $email2name->resolveAndDiscover("puzanov@gmail.com");
        $this->assertEquals("Oleg", $name);
    }
    public function testResolveAndDiscoverName2() {
        $email2name = new Email2name();
        $name = $email2name->resolveAndDiscover("ezekielbear@hotmail.com");
        $this->assertEquals("Ezekielbear", $name);
    }
    public function testResolveAndDiscoverName3() {
        $email2name = new Email2name();
        $name = $email2name->resolveAndDiscover("     puzanov@gmail.com");
        $this->assertEquals("Oleg", $name);
    }
    public function testResolveAndDiscoverName4() {
        $email2name = new Email2name();
        $name = $email2name->resolveAndDiscover("321123@yahoo.com");
        $this->assertEquals("321123", $name);
    }
    public function testResolveAndDiscoverFullName() {
        $email2name = new Email2name();
        $name = $email2name->resolveAndDiscover("puzanov@gmail.com", false);
        $this->assertEquals("Oleg Puzanov", $name);
    }
    public function testResolveAndDiscoverNameBulk() {
        $email2name = new Email2name();
        $name = $email2name->resolveAndDiscover("marinochka_artemonova@gmail.com");
        $this->assertEquals("Marinochka", $name);

        $name = $email2name->resolveAndDiscover("ANECHKA.artemonova@gmail.com");
        $this->assertEquals("Anechka", $name);

        $name = $email2name->resolveAndDiscover("Lenochka-artemonova@gmail.com");
        $this->assertEquals("Lenochka", $name);

        $name = $email2name->resolveAndDiscover("puzanov@gmail.com");
        $this->assertEquals("Oleg", $name);
    }
    public function testResolveName() {
        $email2name = new Email2name();
        $name1 = $email2name->resolve("marinochka_artemonova@gmail.com");
        $this->assertFalse($name1);

        $name2 = $email2name->resolve("ANECHKA.artemonova@gmail.com");
        $this->assertFalse($name2);

        $name3 = $email2name->resolve("Lenochka-artemonova@gmail.com");
        $this->assertFalse($name3);

        $name4 = $email2name->resolve("puzanov@gmail.com");
        $this->assertEquals("Oleg", $name4);

        $name5 = $email2name->resolve("minkin.andrew@gmail.com");
        $this->assertFalse($name5);
    }
    public function testResolveAndDiscoverFromFile() {
        $path = "./test-emails.txt";
        $email2name = new Email2name();
        $resolvedEmails = $email2name->resolveAndDiscoverFromFile($path);
        $this->assertEquals("Oleg", $resolvedEmails[0]["name"]);
        $this->assertEquals("Minkin", $resolvedEmails[1]["name"]);
        $this->assertEquals("Marinochka", $resolvedEmails[2]["name"]);
    }
    public function testResolveFromFile() {
        $path = "./test-emails.txt";
        $email2name = new Email2name();
        $resolvedEmails = $email2name->resolveFromFile($path);
        $this->assertEquals(1, sizeof($resolvedEmails));
        $this->assertEquals("Oleg", $resolvedEmails[0]["name"]);
    }
    public function testFormatResultsToCSV() {
        $path = "./test-emails.txt";
        $email2name = new Email2name();
        $resolvedEmails = $email2name->resolveAndDiscoverFromFile($path);
        $resolvedEmailsCSV = $email2name->formatToCSV($resolvedEmails);
        $this->assertEquals("Oleg,puzanov@gmail.com\nMinkin,minkin.andrew@gmail.com\nMarinochka,marinochka_artemonova@gmail.com", $resolvedEmailsCSV);

        $resolvedEmails = $email2name->resolveFromFile($path);
        $resolvedEmailsCSV = $email2name->formatToCSV($resolvedEmails);
        $this->assertEquals("Oleg,puzanov@gmail.com", $resolvedEmailsCSV);
    }
}
