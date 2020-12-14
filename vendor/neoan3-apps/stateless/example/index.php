<?php
define('path',__DIR__);
define('base','http://your-domain.com');

require_once dirname(path) . '/vendor/autoload.php';

\Neoan3\Apps\Stateless::setSecret('my-secret-123');

$templateVars = [
    'jwt' => ''
];

// login
if(isset($_POST['username'])){
    // fake check
    if($_POST['username'] == 'demo' && $_POST['password']=='123456'){
        $templateVars['jwt'] = \Neoan3\Apps\Stateless::assign('#123','read',['custom'=>'payload']);
    }
}

// test call
if(isset($_GET['token'])){
    /*
     * START
     * The following line only for this particular use-case.
     * Not using this (default behavior) would read the token from $_SERVER['AUTHORIZATION']
     * The method setAuthorization is more for testing than for production.
     *
     * NOTE:
     * Commonly, this header is stripped when using Apache.
     * Solution httpd.conf:
     * SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
     *
     * Solution .htaccess:
     * RewriteEngine On
     * RewriteCond %{HTTP:Authorization} ^(.*)
     * RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
     *
     * */
    \Neoan3\Apps\Stateless::setAuthorization($_GET['token']);
    /*
     * END OF HACK
     * */


    echo json_encode(\Neoan3\Apps\Stateless::validate());
    exit();
}

echo Neoan3\Apps\Template::embraceFromFile('/view.html', $templateVars);