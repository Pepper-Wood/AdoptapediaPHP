<?php

session_start();

require "../vendor/autoload.php";
require_once "util/User.php";

$provider = new \League\OAuth2\Client\Provider\GenericProvider([
    'clientId'                => '5336',    // The client ID assigned to you by the provider
    'clientSecret'            => 'd1ee13677f33cf583bc1aaee068d8fe7',   // The client password assigned to you by the provider
    'redirectUri'             => 'https://adoptapedia.com/oauth.php',
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
        
        // Using the access token, we may look up details about the
        // resource owner.
        $resourceArray = $provider->getResourceOwner($accessToken)->toArray();
        
        $user = new User($resourceArray);
        $user->addUserToDatabase();
        $user->saveToSession();
        
        if ($user->getUsername() == 'Adoptapedia-Lucy') {
            // The images on the Species Generator page are gathered from a DeviantArt collection
            // This makes an API call to update the DB with these images any time you log in with Adoptapedia-Lucy (the main admin)

            $offset = 0;
            $limit = 24;
            $file_array = array();
            // DeviantArt limits the number of images you can grab per call to 24

            do {
                $request = $provider->getAuthenticatedRequest(
                'GET',
                'https://www.deviantart.com/api/v1/oauth2/collections/A924BA84-BE97-677E-C31A-F1A70D297CC9?offset='.$offset.'&limit='.$limit,
                $accessToken
                );
                
                $response = json_decode($provider->getHttpClient()->send($request)->getBody(), TRUE);
                
                for ($i = 0; $i < count($response['results']); $i++) {
                    $src = str_replace('http://','https://',$response['results'][$i]['content']['src']);
                    $page = $response['results'][$i]['url'];
                    $username = $response['results'][$i]['author']['username'];
                    $image_array = array('src' => $src, 'page' => $page, 'username' => $username);
                    $file_array[] = $image_array;
                    $id++;
                }
                
                $offset += $limit;
            } while ($response['has_more']);
            
            file_put_contents('assets/inspirations.json', json_encode($file_array, JSON_PRETTY_PRINT));
        }
        
        header('Location: https://adoptapedia.com/index.php?status=login');

    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

        // Failed to get the access token or user details.
        exit($e->getMessage());

    }
}
