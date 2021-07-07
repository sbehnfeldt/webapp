<?php

namespace Sbehnfeldt\Webapp;

use Sbehnfeldt\Webapp\PropelDbEngine\LoginAttempt;
use Sbehnfeldt\Webapp\PropelDbEngine\UserQuery;
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class WebApp extends App
{
    private $renderer;

    public function __construct($container = [])
    {
        parent::__construct($container);
        $this->renderer = null;
    }


    /**
     * @return mixed
     */
    public function getRenderer()
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
     * Search "users" table for matching submitted username and password
     *
     * @param string $username
     * @param string $password
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function login(string $username, string $password): bool
    {
        if (empty($username) || empty($password)) {
            $note = sprintf( 'Invalid login attempt: missing %s', empty($username) && empty($password) ? 'username and password' : empty($username) ? 'username' : 'password');
            $attempt = new LoginAttempt();
            $attempt->setAttemptedAt(time());
            $attempt->setPass(0);
            $attempt->setNote($note);
            $attempt->save();
            throw new \Exception($note);
        }

        // Look up user in "users" table
        $user = UserQuery::create()->findOneByUsername($username);
        if (!$user) {
            $note = sprintf('Login denied: no account for user "%s"', $username);
            $attempt = new LoginAttempt();
            $attempt->setUsername($username);
            $attempt->setAttemptedAt(time());
            $attempt->setPass(0);
            $attempt->setNote($note);
            $attempt->save();
            $this->getLogger()->info($note);
            throw new \Exception($note);
        }

        // Verify the submitted password
        if (!password_verify($password, $user->getPassword())) {
            // Wrong password
            $note = sprintf('Login denied: incorrect password for user "%s"', $username);
            $attempt = new LoginAttempt();
            $attempt->setUsername($username);
            $attempt->setAttemptedAt(time());
            $attempt->setPass(0);
            $attempt->setNote($note);
            $attempt->save();
            $this->getLogger()->info($note);

            throw new \Exception($note);
        }

        // User authenticated
        $attempt = new LoginAttempt();
        $attempt->setUsername($username);
        $attempt->setAttemptedAt(time());
        $attempt->setPass(1);
        $attempt->setNote('OK');
        $attempt->save();
        $_SESSION['user'] = $user;

        return true;
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }


    public function run($silent = false)
    {
        $web = $this;

        // Middleware checking whether user is logged in
        $isAuthenticated = function (Request $req, Response $resp, $next) use ($web) {
            if (empty($_SESSION['user'])) {
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_LOGIN, []));
                return $resp;
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
                if (!$web->login($_POST['username'], $_POST['password'])) {
                    throw new \Exception('Unauthorized');
                }
                $resp = $resp->withHeader('Location', '/');
            } catch (\Exception $e) {
                $resp->getBody()->write($web->getRenderer()->render(IPageRenderer::PAGE_LOGIN, []));
            }
            return $resp;
        });

        $this->get('/logout', function (Request $req, Response $resp, array $args) use ($web) {
            $web->logout();
            $resp = $resp->withHeader('Location', '/');
            return $resp;
        });


        return parent::run($silent); // TODO: Change the autogenerated stub
    }
}
