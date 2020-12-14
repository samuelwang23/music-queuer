# neoan3-jwt

Simple JWT implementation suited for neoan3 developers.


## Installation

`composer require neoan3-apps/jwt`

## Quick start

```PHP 
require dirname(__FILE__).'/vendor/autoload.php'

use Neoan3\Apps\JWT;

$mySecret = '123456';

JWT::expiresAt('+1 hour');

// encode

$token = JWT::encode($mySecret);

// verify & decode

$decoded = JWT::decode($token, $mySecret);

if($decoded['error'] === false){

  print_r($decoded['decoded']);
  
}

```
