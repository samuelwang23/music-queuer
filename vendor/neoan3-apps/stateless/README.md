[![Maintainability](https://api.codeclimate.com/v1/badges/5ef75b2080e797b9e9e5/maintainability)](https://codeclimate.com/github/sroehrl/neoan3-stateless/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/5ef75b2080e797b9e9e5/test_coverage)](https://codeclimate.com/github/sroehrl/neoan3-stateless/test_coverage)
[![Build Status](https://travis-ci.com/sroehrl/neoan3-stateless.svg?branch=master)](https://travis-ci.com/sroehrl/neoan3-stateless)

# PHP stateless JWT authentication

Easy implementation of JWT authentication & handling in PHP. 

- [Installation](#installation)
- [Quick Start](#quick-start)
- [Methods](#methods)
- [Simple Example](#simple-example)


## Installation 

`composer require neoan3-apps/stateless`


## Quick Start


```PHP
// static
Neoan3\Apps\Stateless::setSecret('My-super-secure-Key');

// or as object
// (method names are the same as static calls)
$stateless = new Neoan3\Apps\StatelessOOP('my-secure-key');

// create JWT
$jti = 'someId';
$scope = ['read', 'write'];
$payload = ['additional'=>'info']; // optional
$jwt = Neoan3\Apps\Stateless::assign($jti, $scope, $payload);

// validate JWT
try{
    $decrypted = Neoan3\Apps\Stateless::validate();
    $user = $decrypted['jti'];
} catch(Exception $e) {
    die('ups');
}

```

## Methods

### setAuthorization($jwt)
If this method is not used, _Stateless_ will read the Authorization from the $_SERVER variable "HTTP_AUTHORIZATION"
and the following format "baerer _token_"

### setCustomException($class)
Can be used to trigger a custom exception when encountering validation errors.

### setSecret($secret)
Key used for the HS256 algorithm (decryption/encryption/signing). Make sure a key is set prior to any other interactions.

### validate()
Returns the decoded JWT or throws an Exception

### restrict($scope = [])
Accepts a string or an array. Same as _validate_, but additionally checks if the right kind of scope is present.

### assign($jti, $scope, $payload = [])
Generates a JWT.


## Simple Example

There is a simple example in /example. In order to run it, simply type

`php -S localhost:8080 example/index.php`

after cloning this repo.

