<?php

namespace Sbehnfeldt\Webapp;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Sbehnfeldt\Webapp\PropelDbEngine\GroupQuery;
use Sbehnfeldt\Webapp\PropelDbEngine\TokenAuth;
use Sbehnfeldt\Webapp\PropelDbEngine\TokenAuthQuery;
use Sbehnfeldt\Webapp\PropelDbEngine\UserQuery;
use Slim\App;
use Sbehnfeldt\Webapp\PropelDbEngine\User;


/**
 * Class ApiApp
 * @package Sbehnfeldt\Webapp
 *
 * Slim App-derived class for handling the Webapp API
 */
class ApiApp extends App
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct($container = [])
    {
        parent::__construct($container);
        $this->logger = null;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): ?LoggerInterface
    {
        if (!$this->logger) {
            if ($this->getContainer()->has('logger')) {
                $this->logger = $this->getContainer()->get('logger');
            }
            if (!$this->logger) {
                // If no logger is specified in the dependency container,
                // use a Monolog logger by default.
                if ($this->getContainer()->get('settings')->has('monolog')) {
                    // Check config file for settings for monolog
                    $cfg = $this->getContainer()->get('settings')->get('monolog');
                } else {
                    $cfg = [
                        'directory' => '.',
                        'filename' => 'api.log',
                        'channel' => 'default'
                    ];
                }
                $handler = new StreamHandler(implode(DIRECTORY_SEPARATOR, ['..', $cfg['directory'], $cfg['filename']]));
                $this->logger = new Logger($cfg['channel']);
                $this->logger->pushHandler($handler);
            }
        }
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(?LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }


    public function run($silent = false)
    {
        $api = $this;

        // Middleware checking whether user is logged in
        $isAuthenticated = function (Request $req, Response $resp, $next) use ($api) {
            if (empty($_SESSION['user'])) {
                // Check for "remember me" cookies, validate if found
                // ref: https://phppot.com/php/secure-remember-me-for-login-using-php-session-and-cookies/
                if (!empty($_COOKIE['user_id']) && !empty($_COOKIE['remember-me'])) {
                    $tokens = TokenAuthQuery::create()->filterByUserId($_COOKIE['user_id']);
                    /** @var TokenAuth $token */
                    foreach ($tokens as $token) {
                        if (password_verify($_COOKIE['remember-me'], $token->getCookieHash()) && $token->getExpires() >= date("Y-m-d H:i:s", time())) {
                            $_SESSION['user'] = UserQuery::create()->findPk($_COOKIE['user_id']);
                        } else {
                            $token->delete();
                        }
                    }
                }
                if (empty($_SESSION['user'])) {
                    $api->getLogger()->warning( 'Unauthenticated API attempt');

                    // TODO: Handle not validated attempt
                    $resp = $resp->withStatus(401, 'Unauthorized');
                    return $resp;
                }
            }

            // User is authenticated
            return $next($req, $resp);
        };


        $this->get('/api/', function (Request $req, Response $resp, array $args) use ($api) {
            $resp->getBody()->write('ok');
            return $resp;
        });


        // Get all users
        $this->get('/api/users', function (Request $req, Response $resp, array $args) use ($api) {
            $users = UserQuery::create()->find();
            $users = $users->toArray();
            $users = json_encode($users);
            $resp->getBody()->write($users);
            return $resp;
        })->add($isAuthenticated);


        // Create new user
        $this->post('/api/users', function (Request $req, Response $resp, array $args) use ($api) {
            /** @var User $user */
            $user = $_SESSION[ 'user' ];
//            if ( !$user->hasPermission('API_INSERT_USER')) {
//                $api->getLogger()->warning(sprintf( 'Unauthorized attempt to add new user by "%s"', $user->getUsername()));
//                $resp = $resp->withStatus(403, 'Forbidden');
//                $resp = $resp->withHeader('Content-Type', 'application/json');
//                $resp->getBody()->write( json_encode( []));
//                return $resp;
//            }
            $newUser = new User();
            $newUser->setUsername($_POST['Username']);
            $newUser->setEmail($_POST['Email']);
            $newUser->setPassword(password_hash('password', PASSWORD_DEFAULT));
            $b = $newUser->save();
            $api->getLogger()->info(sprintf('New user "%s" (user ID %d") added by user "%s"', $newUser->getUsername(), $newUser->getId(), $user->getUsername()));

            $resp = $resp->withStatus(201, 'Created');
            $resp = $resp->withHeader('Content-Type', 'application/json');
            $resp->getBody()->write(json_encode($newUser->toArray()));

            return $resp;
        })->add($isAuthenticated);


        $this->get( '/api/permissions', function ( Request $req, Response $resp, array $args) use ($api) {
//            /** @var User $user */
//            $user = $_SESSION[ 'user' ];
//            if ( !$user->hasPermission('API_READ_PERMISSIONS')) {
//                $api->getLogger()->warning(sprintf( 'Unauthorized attempt to add new user by "%s"', $user->getUsername()));
//                $resp = $resp->withStatus(403, 'Forbidden');
//                $resp = $resp->withHeader('Content-Type', 'application/json');
//                $resp->getBody()->write( json_encode( []));
//                return $resp;
//            }

            $userId = $req->getQueryParam('userId');
            $u = UserQuery::create()->findOneById($userId);
            $perms = $u->getUserPermissionsJoinPermission();

            $resp = $resp->withStatus(200, 'OK');
            $resp = $resp->withHeader( 'Content-Type', 'application/json');
            $resp->getBody()->write(json_encode( $perms->toArray()));
            return $resp;
        })->add($isAuthenticated);


        $this->get('/api/groups', function( Request $req, Response $resp, array $args) use ($api) {
            $groups = GroupQuery::create()->find();
            $resp->getBody()->write(json_encode($groups->toArray()));
            return $resp;
        })->add($isAuthenticated);

        return parent::run($silent); // TODO: Change the autogenerated stub
    }
}
