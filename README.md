# Validate IMAP IP Gmail

When you want to connect to Gmail through IMAP you first need verify the IP address of your local machine or server.

Since the php functions `imap_open` and `imap_last_error` do not return the complete error messages, this function was created to work around this problem.

## Prerequisites

Please check that:
1. You enabled IMAP access in Gmail setting
   * **Gmail** > **Settings** > **Forwarding and POP/IMAP** > **IMAP Access**
2. You enabled less secure apps under account settings
   * https://myaccount.google.com/lesssecureapps
   * Note that if you're using Gsuite, your administrator needs to enable this function
3. If you're using 2-factor authentication that you have an app password that you can use for authentication
   * https://myaccount.google.com/apppasswords

## Example usage

```php
<?php

require './validation_helpers.php';

$host = 'imap.gmail.com';
$port = 993;
$username = 'username@mydomain.com'; // Or username@gmail.com if you don't use Gsuite
$password = 'example_password';

$result = validateIMAPIPAccess($host, $port, $username, $password);

if ($result === true) {
    echo 'We\'ve got IMAP access!';
} elseif (is_string($result)) {
    header('Location: '.$result);
} else {
    echo 'Undefined error';
}
```

## Contributors

* Lucas van der Have ([lucasvdh](https://github.com/lucasvdh))

All contributions are appreciated 