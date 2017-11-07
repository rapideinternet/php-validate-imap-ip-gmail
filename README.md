# Validate IMAP IP Gmail

When you want to connect to Gmail through IMAP you first need verify the IP address of your local machine or server. The error that is returned by the IMAP server is a long string containing a description and a verification url.

Since the php functions `imap_open` and `imap_last_error` do not return the complete error messages, this function was created to work around this problem.

## Prerequisites

Please check that:
1. You enabled IMAP access in Gmail setting
   * **Gmail** > **Settings** > **Forwarding and POP/IMAP** > **IMAP Access**
2. You enabled less secure apps under account settings
   * https://myaccount.google.com/lesssecureapps
   * **Note** - If you're using Gsuite, your administrator needs to enable this function
   * **Note** - If you're using 2FA you can't enable less secure apps, but don't worry, follow the steps in the following section and use an app password for authentication instead 

### 2 Factor Authentication
**Important** - This will **only** work if you have 2 factor authentication disabled.

If you are using 2FA follow these steps:
1. Disable 2FA for your account
2. Generate a verification url as seen in the example usage
3. Open the verification url
4. Enable 2FA for your account
5. Generate an app password for authentication (https://myaccount.google.com/apppasswords)

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