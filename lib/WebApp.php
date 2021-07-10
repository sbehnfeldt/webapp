<?php

namespace Sbehnfeldt\Webapp;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Sbehnfeldt\Webapp\PropelDbEngine\LoginAttempt;
use Sbehnfeldt\Webapp\PropelDbEngine\TokenAuth;
use Sbehnfeldt\Webapp\PropelDbEngine\TokenAuthQuery;
use Sbehnfeldt\Webapp\PropelDbEngine\User;
use Sbehnfeldt\Webapp\PropelDbEngine\UserQuery;
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class WebApp extends App
{
    /** @var IPageRenderer */
    private $renderer;

    /** @var Logger */
    private $logger;

    public function __construct($container = [])
    {
        parent::__construct($container);
        $this->renderer
            = $this->logger
            = null;
    }


    /**
     * @return mixed
     */
    public function getRenderer(): ?IPageRenderer
    {
        if (!$this->renderer) {
            if ($this->getContainer()->has('renderer')) {
                $this->renderer = $this->getContainer()->get('renderer');
            }
            if (!$this->renderer) {
                $this->renderer = new TwigPageRenderer($this->getContainer()->get('settings')->get('twig'));
            }
        }
        return $this->renderer;
    }

    /**
     * @param mixed $renderer
     */
    public function setRenderer($renderer): void
    {
        $this->renderer = $renderer;
    }

    /**
     * @return Logger
     */
    public function getLogger(): ?Logger
    {
        if ( !$this->logger) {
            if ( $this->getContainer()->has( 'logger')) {
                $this->logger = $this->getContainer()->get('logger');
            }
            if ( !$this->logger) {
                if ( $this->getContainer()->get('settings')->has('monolog')) {
                    $cfg = $this->getContainer()->get('settings')->get('monolog');
                } else {
                    $cfg = [
                        'directory' => '.',
                        'filename' => 'log.log',
                        'channel' => 'default'
                    ];
                }
                $cfg = $this->getContainer()->get('settings')->get('monolog');
                $handler = new StreamHandler(implode( DIRECTORY_SEPARATOR, [ '..',  $cfg[ 'directory' ], $cfg[ 'filename' ]]));
                $this->logger = new Logger($cfg[ 'channel']);
                $this->logger->pushHandler($handler);
            }
        }
        return $this->logger;
    }

    /**
     * @param Logger $logger
     */
    public function setLogger(?Logger $logger): void
    {
        $this->logger = $logger;
    }


    /**
     * Generate a (non-cryptographically secure) random string of a specified length
     *
     * @param $length
     * @return string
     * @throws Exception
     */
    static public function generateToken($length)
    {
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        $token = "";
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }


    /**
     * Authenticate submitted username and password
     *
     * @param string $username
     * @param string $password
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function login(string $username, string $password, bool $remember = false): bool
    {
        if (empty($username) || empty($password)) {
            $note = sprintf('Invalid login attempt: missing %s', (empty($username) && empty($password)) ? 'username and password' : (empty($username) ? 'username' : 'password'));
            $attempt = new LoginAttempt();
            $attempt->setUsername('');
            $attempt->setAttemptedAt(time());
            $attempt->setRemember($remember);
            $attempt->setUserId(null);
            $attempt->setNote($note);
            $attempt->save();
            $this->getLogger()->notice($note);
            throw new Exception($note);
        }

        // Look up user in "users" table
        $user = UserQuery::create()->findOneByUsername($username);
        if (!$user) {
            $note = sprintf('Login denied: no account for user "%s"', $username);
            $attempt = new LoginAttempt();
            $attempt->setUsername($username);
            $attempt->setAttemptedAt(time());
            $attempt->setRemember($remember);
            $attempt->setUserId(null);
            $attempt->setNote($note);
            $attempt->save();
            $this->getLogger()->notice($note);
            throw new Exception($note);
        }

        // Verify the submitted password
        if (!password_verify($password, $user->getPassword())) {
            // Wrong password
            $note = sprintf('Login denied: incorrect password for user "%s"', $username);
            $attempt = new LoginAttempt();
            $attempt->setUsername($username);
            $attempt->setAttemptedAt(time());
            $attempt->setRemember($remember);
            $attempt->setUserId($user->getId());
            $attempt->setNote($note);
            $attempt->save();
            $this->getLogger()->notice($note);

            throw new Exception($note);
        }
        // User authenticated

        // Clear any current remember-me cookies and records
        setcookie("user_id", null, time() - 1);
        setcookie("remember-me", null, time() - 1);
        $tokens = TokenAuthQuery::create()->findByUserId($user->getId());
        foreach ($tokens as $token) {
            try {
                $token->delete();
            } catch (Exception $e) {
                die ($e->getMessage());
            }
        }

        if ($remember) {
            // Generate new remember-me cookies and record
            $expiration = time() + (30 * 24 * 60 * 60);  // for 1 month
            $random = WebApp::generateToken(32);   // A random string to simulate "password" for remember-me
            setcookie("user_id", $user->getId(), $expiration);
            setcookie("remember-me", $random, $expiration);

            $token = new TokenAuth();
            $token->setUserId($user->getId());
            $token->setCookieHash(password_hash($random, PASSWORD_DEFAULT));   // Hash the remember-me "password"
            $token->setExpires(date("Y-m-d H:i:s", $expiration));
            try {
                $token->save();
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        $note = sprintf( 'User "%s" logged in successfully', $username);
        $attempt = new LoginAttempt();
        $attempt->setUsername($username);
        $attempt->setAttemptedAt(time());
        $attempt->setRemember($remember);
        $attempt->setUserId($user->getId());
        $attempt->setNote($note);
        $attempt->save();
        $this->getLogger()->info($note);
        $_SESSION['user'] = $user;
        return true;
    }

    public function logout()
    {
        if ( isset($_SESSION[ 'user'])) {
            /** @var User $user */
            $user = $_SESSION[ 'user' ];

            // Delete "remember me" cookies when user explicitly logs out
            $tokens = TokenAuthQuery::create()->findByUserId($user->getId());
            foreach ($tokens as $token) {
                try {
                    $token->delete();
                } catch ( Exception $e) {
                    die($e->getMessage());
                }
            }
            $this->getLogger()->info( sprintf( 'User "%s" logged out', $user->getUsername()));
            unset($_SESSION['user']);
        }
        setcookie("user_id", null, time() - 1);
        setcookie("remember-me", null, time() - 1);
        session_destroy();
    }


    public function run($silent = false)
    {
        $web = $this;

        // Middleware checking whether user is logged in
        $isAuthenticated = function (Request $req, Response $resp, $next) use ($web) {
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
                    $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_LOGIN, []));
                    return $resp;
                }
            }

            // User is authenticated
            return $next($req, $resp);
        };

        $this->get('/', function (Request $req, Response $resp, array $args) use ($web) {
            $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_INDEX, []));
            return $resp;
        })->add($isAuthenticated);


        $this->get('/login', function (Request $req, Response $resp, array $args) use ($web) {
            $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_LOGIN, []));
            return $resp;
        });

        $this->post('/login', function (Request $req, Response $resp, array $args) use ($web) {
            try {
                if (!$web->login($_POST['username'], $_POST['password'], isset($_POST[ 'remember']))) {
                    throw new Exception('Unauthorized');
                }
                $resp = $resp->withHeader('Location', '/');
            } catch (Exception $e) {
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_LOGIN, []));
            }
            return $resp;
        });

        $this->get('/logout', function (Request $req, Response $resp, array $args) use ($web) {
            $web->logout();
            $resp = $resp->withHeader('Location', '/');
            return $resp;
        });
        $this->get('/user', function (Request $req, Response $resp, array $args) use ($web) {
            $user = new User();
            $user->setUsername('stephen');
            $user->setPassword(password_hash('stephen', PASSWORD_DEFAULT));
            $user->setEmail('stephen@behnfeldt.pro');
            $user->save();
            $resp = $resp->withHeader('Location', '/');
            return $resp;
        });


        return parent::run($silent); // TODO: Change the autogenerated stub
    }
}
