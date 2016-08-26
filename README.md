# disposable-php
A php class to check if a domain is listed on https://github.com/andreis/disposable

## Installation
 - composer require crecket/disposable-php
 
## Usage
``` 
/**
 * @param bool - true will cause the script to throw a exception if the domains list couldn't be loaded
 * @throws \Exception
 * @return bool
 */
$DomainChecker = new \Crecket\DisposablePHP\DomainChecker(true);

/**
 * Check if a email is using a domain name associated with a disposable email service
 * @param string - email as string
 * @param bool - validate the email first, defaults to true
 * @return bool
 */
$DomainChecker->isDisposable('mail@example.com'); 

/**
 * Get the loaded domains list as a array
 * @return array
 */
$Domains = $DomainChecker->getDomains();
```
