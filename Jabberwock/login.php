<?php

session_start();

require "../../vendor/autoload.php";
require_once "../util/User.php";

$provider = new \League\OAuth2\Client\Provider\GenericProvider([
    'clientId'                => '8456',    // The client ID assigned to you by the provider
    'clientSecret'            => '0a68c3ccbb339a5d783efa9dde01cf08',   // The client password assigned to you by the provider
    'redirectUri'             => 'https://adoptapedia.com/Jabberwock/login.php',
    'urlAuthorize'            => 'https://www.deviantart.com/oauth2/authorize',
    'urlAccessToken'          => 'https://www.deviantart.com/oauth2/token',
    'urlResourceOwnerDetails' => 'https://www.deviantart.com/api/v1/oauth2/user/whoami'
]);

// If we don't have an authorization code then get one
if (!isset($_GET['code'])) {

    // Fetch the authorization URL from the provider; this returns the
    // urlAuthorize option and generates and applies any necessary parameters
    // (e.g. state).
    $authorizationUrl = $provider->getAuthorizationUrl();

    // Get the state generated for you and store it to the session.
    $_SESSION['oauth2state'] = $provider->getState();

    // Redirect the user to the authorization URL.
    header('Location: ' . $authorizationUrl);
    exit;
} else {
    try {
        // Try to get an access token using the authorization code grant.
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        // Using the access token, we may look up details about the resource owner.
        $resourceArray = $provider->getResourceOwner($accessToken)->toArray();

        $user = new User($resourceArray);
        $user->addUserToJabberwockDatabase();
        $user->saveToSession();

        header('Location: https://adoptapedia.com/Jabberwock/index.php');

    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

        // Failed to get the access token or user details.
        exit($e->getMessage());

    }
}
