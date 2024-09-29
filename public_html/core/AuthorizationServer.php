<?php
namespace Bosbar;

use OAuth;

class AuthorizationServer
{
    private $storageHandler;
    private $authServer;
    private $requestHandler;
    private $responseHandler;

    /**
     * Constructor for AuthorizationServer
     * Sets up the authorization server and processes requests.
     */
    public function __construct() {
        $this->initializeServer();

        if ($this->requestHandler) {
            // Handle token request
            if ($this->requestHandler->request('grant_type', false) !== false) {
                $this->issueAccessToken();
            }

            // Handle authorization code request
            if ($this->requestHandler->query('response_type') === "code") {
                if (!$this->authServer->validateAuthorizeRequest($this->requestHandler, $this->responseHandler)) {
                    $this->responseHandler->send();
                    exit();
                }
                if ($this->requestHandler->request('authorized') == '1') {
                    $this->processAuthorization(true);
                }
            }

            // Validate resource request
            if (!$this->validateRequest()) {
                $this->authServer->getResponse();
            }
        }
    }

    /**
     * Initializes the OAuth2 server and sets up storage, request, and response handling.
     */
    private function initializeServer() {
        if (is_callable('OAuth2\Autoloader::register')) {
            \OAuth2\Autoloader::register();
            $this->storageHandler = new OAuth\Pdo(array(
                'dsn' => 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, 
                'username' => DB_USER, 
                'password' => DB_PASSWORD
            ));
            $this->authServer = new \OAuth2\Server($this->storageHandler, array(
                "access_lifetime" => 3600, 
                "refresh_token_lifetime" => 7889400
            ));
            $this->requestHandler = \OAuth2\Request::createFromGlobals();
            $this->responseHandler = new \OAuth2\Response();
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            die();
        }
    }

    /**
     * Retrieves the OAuth2 server instance.
     *
     * @return OAuth2\Server
     */
    public function getAuthorizationServer() {
        return $this->authServer;
    }

    /**
     * Retrieves the current request object.
     *
     * @return OAuth2\Request
     */
    public function getCurrentRequest() {
        return $this->requestHandler;
    }

    /**
     * Retrieves the current response object.
     *
     * @return OAuth2\Response
     */
    public function getCurrentResponse() {
        return $this->responseHandler;
    }

    /**
     * Issues a new access token based on the request.
     */
    private function issueAccessToken() {
        $this->authServer->handleTokenRequest($this->requestHandler)->send();
        die();
    }

    /**
     * Handles the authorization request and generates an authorization code.
     *
     * @param boolean $clientAuthorized Whether the client is authorized or not
     */
    private function processAuthorization($clientAuthorized) {
        $this->authServer->handleAuthorizeRequest($this->requestHandler, $this->responseHandler, $clientAuthorized);
        
        if ($clientAuthorized) {
            $authCode = substr($this->responseHandler->getHttpHeader('Location'), strpos($this->responseHandler->getHttpHeader('Location'), 'code=') + 5, 40);
            die("SUCCESS! Authorization Code: $authCode");
        }

        $this->responseHandler->send();
        die();
    }

    /**
     * Validates the incoming request information to check if it's a valid resource request.
     *
     * @return boolean
     */
    private function validateRequest() {
        return $this->authServer->verifyResourceRequest($this->requestHandler);
    }
}