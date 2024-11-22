<?php

/**
 * Custom User credential to be used by OAuth
 *
 * PHP version 7+
 *
 * @category    Controllers
 * @package     SG
 * @author      Jonathan Young <jonathan@vansteinengroentjes.nl>
 * @copyright   2021 Van Stein en Groentjes B.V. all rights reserved
 * @license     SG Commercial License
 * @version     GIT: $Id$
 * @link        https://s-g.nu/docs/doku.php/SG:start
*/

namespace OAuth;

use OAuth2\GrantType\GrantTypeInterface;
use OAuth2\Storage\UserCredentialsInterface;
use OAuth2\ResponseType\AccessTokenInterface;
use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;
use LogicException;

/**
 * @author Brent Shaffer <bshafs at gmail dot com>
 */
// phpcs:disable
class UserCredentials implements GrantTypeInterface
{
    /**
     * @var array
     */
    private $userInfo;

    /**
     * @var UserCredentialsInterface
     */
    protected $storage;

    /**
     * @param UserCredentialsInterface $storage - REQUIRED Storage class for retrieving user credentials information
     */
    public function __construct(UserCredentialsInterface $storage) {
        $this->storage = $storage;
    }

    /**
     * @return string
     */
    public function getQueryStringIdentifier() {
        return 'password';
    }

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @return bool|mixed|null
     *
     * @throws LogicException
     */
    public function validateRequest(RequestInterface $request, ResponseInterface $response) {
        if (!$request->request("password") || !$request->request("username")) {
            $response->setError(400, 'invalid_request', 'Missing parameters: "username" and "password" required');

            return null;
        }

        if (!$this->storage->checkUserCredentials($request->request("username"), $request->request("password"))) {
            $response->setError(401, 'invalid_grant', 'Invalid username and password combination');
            
            return null;
        }

        $userInfo = $this->storage->getUserDetails($request->request("username"));

        if (empty($userInfo)) {
            $response->setError(400, 'invalid_grant', 'Unable to retrieve user information');

            return null;
        }

        if (!isset($userInfo['user_id'])) {
            throw new \LogicException("you must set the user_id on the array returned by getUserDetails");
        }

        $this->userInfo = $userInfo;

        return true;
    }

    /**
     * Get client id
     *
     * @return mixed|null
     */
    public function getClientId() {
        return null;
    }

    /**
     * Gets the id value
     * @return mixed
     */
    public function getId() {
        return $this->userInfo['id'];
    }
    
    public function getCompanyId() {
        return isset($this->userInfo['company_id']) ? $this->userInfo['company_id'] : -1;
    }
    
    public function getUserFullName() {
        $fName = isset($this->userInfo['first_name']) ? $this->userInfo['first_name'] : '';
        $lName = isset($this->userInfo['last_name']) ? $this->userInfo['last_name'] : '';
        return $fName . ' ' . $lName;
    }
    
    public function getProfileImage() {
        return isset($this->userInfo['profileimg']) ? $this->userInfo['profileimg'] : '';
    }
    /**
     * Get user id
     *
     * @return mixed
     */
    public function getUserId() {
        return $this->userInfo['user_id'];
    }

    /**
     * Get scope
     *
     * @return null|string
     */
    public function getScope() {
        return isset($this->userInfo['scope']) ? $this->userInfo['scope'] : null;
    }

    /**
     * Create access token
     *
     * @param AccessTokenInterface $accessToken
     * @param mixed                $client_id   - client identifier related to the access token.
     * @param mixed                $user_id     - user id associated with the access token
     * @param string               $scope       - scopes to be stored in space-separated string.
     * @return array
     */
    public function createAccessToken(AccessTokenInterface $accessToken, $client_id, $user_id, $scope) {
        return $accessToken->createAccessToken($client_id, $user_id, $scope);
    }
}
// phpcs:enable
