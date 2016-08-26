<?php
require __DIR__ . '/../vendor/autoload.php';

class test extends PHPUnit_Framework_TestCase
{

    public function testLoading()
    {
        // Create object
        $DomainChecker = new Crecket\DisposablePHP\DomainChecker(true);
        echo "\nCreated domainCheck object\n";

        // Return the domains list
        $this->assertNotEmpty($DomainChecker->getDomains());
        echo "getDomains notEmpty \n";

        // Is array
        $this->assertInternalType('array', $DomainChecker->getDomains());
        echo "getDomains isArray \n";
    }

    public function testEmails()
    {
        // Create object
        $DomainChecker = new Crecket\DisposablePHP\DomainChecker(true);
        echo "\nCreated domainCheck object\n";

        // Get domains list as array
        $Domains = $DomainChecker->getDomains();

        // Return the domains list
        $this->assertNotEmpty($Domains);
        echo "getDomains notEmpty \n";

        // Assert that this mail is disposable
        $this->assertTrue($DomainChecker->isDisposable('mail@' . $Domains[0]));
        echo "mail is disposable \n";

        // Assert that this mail is disposable
        $this->assertFalse($DomainChecker->isDisposable('mail@gmail.com'));
        echo "mail is not disposable \n";
    }
}