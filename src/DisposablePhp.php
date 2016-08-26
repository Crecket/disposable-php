<?php

namespace Crecket\DisposablePHP;

class DomainChecker
{

    /**
     * List with domain names
     * @var array
     */
    private $domains = array();

    /**
     * True/False whether failing to load the domains.json will throw a exception
     * @var bool
     */
    private $strict;

    /**
     * DomainChecker constructor.
     * @param bool $strict
     */
    public function __construct($strict = false)
    {
        $this->strict = $strict;
        $this->loadDomains();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function loadDomains()
    {
        // The file location for composer install enviroments
        $domains_location = __DIR__ . '/../../../andreis/disposable/domains.json';
        // Local debugging, this is the correct location of the file
        $domains_location_alt = __DIR__ . '/../vendor/andreis/disposable/domains.json';

        // Check if the file exists
        if (file_exists($domains_location)) {
            // Get the file contents
            $json_contents = file_get_contents($domains_location);
        } else if (file_exists($domains_location_alt)) {
            // Get the file contents for alternate file location
            $json_contents = file_get_contents($domains_location_alt);
        } else {
            // Check if strict mode is enabled
            if ($this->strict) {
                // Strict mode is enabled and we couldn't load the files, throw a exception
                throw new \Exception("Couldn't load the domains.json in " . $domains_location);
            }
            // Clear the domains list
            $this->domains = array();

            return false;
        }

        // Json encode to associative array
        $this->domains = json_decode($json_contents, true);
        return true;
    }


    /**
     * @param $email
     * @param bool $validate
     * @return bool
     */
    public function isDisposable($email, $validate = true)
    {
        // Check if this is a valid email
        if ($validate && !$this->isValid($email)) {
            // Invalid email
            return false;
        }

        // Split the email
        $mail_parts = explode("@", $email);

        // Check if we got 2 parts
        if (count($mail_parts) === 2) {
            // Flip the array
            $flipped_domains = array_flip($this->domains);
            // Check if it is set (faster than in_array())
            if (isset($flipped_domains[strtolower($mail_parts[1])])) {
                // In array
                return true;
            }
            // Not in array
            return false;
        }
    }

    /**
     * @param $email
     * @return bool
     */
    private function isValid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getDomains()
    {
        return $this->domains;
    }
}