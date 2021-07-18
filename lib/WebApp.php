<?php

namespace Sbehnfeldt\Webapp;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Propel\Runtime\ActiveQuery\Criteria;
use Sbehnfeldt\Webapp\PropelDbEngine\LoginAttempt;
use Sbehnfeldt\Webapp\PropelDbEngine\LoginAttemptQuery;
use Sbehnfeldt\Webapp\PropelDbEngine\PermissionQuery;
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

    /** @var integer */
    private $rememberMeDuration;


    public function __construct($container = [])
    {
        parent::__construct($container);
        $this->renderer
            = $this->logger
            = $this->rememberMeDuration
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
                // Use Twig page renderer by default
                if ($this->getContainer()->get('settings')->has('twig')) {
                    $cfg = $this->getContainer()->get('settings')->get('twig');
                } else {
                    $cfg = [
                        "templates" => "../templates/pages"
                    ];
                }
                $this->renderer = new TwigPageRenderer($cfg);
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
                        'filename' => 'log.log',
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


    protected function getRememberMeDuration()
    {
        if (!$this->rememberMeDuration) {
            if ($this->getContainer()->get('settings')->has('remember')) {
                // Use value specified in config file
                $this->rememberMeDuration = $this->getContainer()->get('settings')->get('remember');
            }
            if (!$this->rememberMeDuration) {
                // If not specified in config file, use 1 month as the default
                $this->rememberMeDuration = 30 * 24 * 60 * 60;   // 1 month
            }
        }

        return $this->rememberMeDuration;
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

        $now = time();
        if ($remember) {
            // Generate new remember-me cookies and record
            $expiration = $now + $this->getRememberMeDuration();
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
        } else {
            $expiration = $now - 1;
        }

        $note = sprintf('User "%s" logged in successfully', $username);
        $attempt = new LoginAttempt();
        $attempt->setUsername($username);
        $attempt->setAttemptedAt($now);
        $attempt->setRemember($expiration);
        $attempt->setUserId($user->getId());
        $attempt->setNote($note);
        $attempt->save();
        $this->getLogger()->info($note);
        $_SESSION['user'] = $user;
        return true;
    }

    public function logout()
    {
        if (isset($_SESSION['user'])) {
            /** @var User $user */
            $user = $_SESSION['user'];

            // Delete "remember me" cookies when user explicitly logs out
            $tokens = TokenAuthQuery::create()->findByUserId($user->getId());
            foreach ($tokens as $token) {
                try {
                    $token->delete();
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
            $loginAttempt = LoginAttemptQuery::create()->filterByUserId($user->getId())->orderByAttemptedAt(Criteria::DESC)->findOne();
            $loginAttempt->setLogoutAt(time());
            $loginAttempt->save();
            $this->getLogger()->info(sprintf('User "%s" logged out', $user->getUsername()));
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


        $this->post('/login', function (Request $req, Response $resp, array $args) use ($web) {
            try {
                if (!$web->login($_POST['username'], $_POST['password'], isset($_POST['remember']))) {
                    throw new Exception('Unauthorized');
                }
                $resp = $resp->withHeader('Location', '/');
            } catch (Exception $e) {
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_LOGIN, []));
            }
            return $resp;
        });


        $this->any('/logout', function (Request $req, Response $resp, array $args) use ($web) {
            $web->logout();
            $resp = $resp->withHeader('Location', '/');
            return $resp;
        });


        // This is a simple route-handler to "initialize" XDebug debugging.
        // When a browser is first opened, the cookie that triggers debugging doesn't trigger debugging.
        // This makes debugging session-related features, such as the remember-me cookie, challenging.
        // This route provides a way of initializing debugging without affecting anything important.
        $this->get('/foo', function (Request $req, Response $resp, array $args) use ($web) {
            $resp->getBody()->write('foo');
            return $resp;
        });


        $this->get('/', function (Request $req, Response $resp, array $args) use ($web) {
            /** @var User $user */
            $user = $_SESSION['user'];
            if (!$user->hasPermission('PAGE_HOME')) {
                $resp = $resp->withStatus(401);
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::HTTP_401, []));
            } else {
                $myPerms = $user->getAllPerms();
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_INDEX, [
                    'myPerms' => $myPerms,
                ]));
            }
            return $resp;
        })->add($isAuthenticated);


        $this->get('/reports', function (Request $req, Response $resp, array $args) use ($web) {
            /** @var User $user */
            $user = $_SESSION['user'];
            if (!$user->hasPermission('PAGE_REPORTS')) {
                $resp = $resp->withStatus(401);
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::HTTP_401, []));
            } else {
                $myPerms = $user->getAllPerms();
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_REPORTS, [
                    'myPerms' => $myPerms,
                ]));
            }
            return $resp;
        })->add($isAuthenticated);


        $this->get('/users', function (Request $req, Response $resp, array $args) use ($web) {
            /** @var User $user */
            $user = $_SESSION['user'];
            if (!$user->hasPermission('PAGE_USERS')) {
                $resp = $resp->withStatus(401);
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::HTTP_401, []));
            } else {
                $myPerms = $user->getAllPerms();
                $allPerms = PermissionQuery::create()->find();
                $users = UserQuery::create()->find()->toArray();

                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_USERS, [
                    'allPerms' => $allPerms,
                    'myPerms' => $myPerms,
                    'users' => $users
                ]));
            }
            return $resp;
        })->add($isAuthenticated);

        $this->get('/groups', function (Request $req, Response $resp, array $args) use ($web) {
            /** @var User $user */
            $user = $_SESSION['user'];
            if (!$user->hasPermission('PAGE_GROUPS')) {
                $resp = $resp->withStatus(401);
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::HTTP_401, []));
            } else {
                $myPerms = $user->getAllPerms();

                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_GROUPS, [
                    'myPerms' => $myPerms,
                ]));
            }
            return $resp;
        })->add($isAuthenticated);


        $this->get('/security', function (Request $req, Response $resp, array $args) use ($web) {
            /** @var User $user */
            $user = $_SESSION['user'];
            if (!$user->hasPermission('PAGE_SECURITY')) {
                $resp = $resp->withStatus(401);
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::HTTP_401, []));
            } else {
                $myPerms = $user->getAllPerms();
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_SECURITY, [
                    'myPerms' => $myPerms,
                ]));
            }
            return $resp;
        })->add($isAuthenticated);


        $this->get('/admin', function (Request $req, Response $resp, array $args) use ($web) {
            /** @var User $user */
            $user = $_SESSION['user'];
            if (!$user->hasPermission('PAGE_ADMIN')) {
                $resp = $resp->withStatus(401);
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::HTTP_401, []));
            } else {
                $myPerms = $user->getAllPerms();
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_ADMIN, [
                    'myPerms' => $myPerms,
                ]));
            }
            return $resp;
        })->add($isAuthenticated);


        $this->get('/profile', function (Request $req, Response $resp, array $args) use ($web) {
            /** @var User $user */
            $user = $_SESSION['user'];
            if (!$user->hasPermission('PAGE_PROFILE')) {
                $resp = $resp->withStatus(401);
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::HTTP_401, []));
            } else {
                $myPerms = $user->getAllPerms();
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_PROFILE, [
                    'myPerms' => $myPerms,
                ]));
            }
            return $resp;
        })->add($isAuthenticated);


        return parent::run($silent); // TODO: Change the autogenerated stub
    }
}
