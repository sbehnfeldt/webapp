<?php


namespace Sbehnfeldt\Webapp;


use Psr\Container\ContainerInterface;
use Slim\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class TwigPageRenderer implements IPageRenderer
{
    /** @var ContainerInterface|Container  */
    private $container;

    /** @var Environment */
    private $twig;

    public function __construct($container = [])
    {
        if (is_array($container)) {
            $container = new Container($container);
        }

        if (!$container instanceof ContainerInterface) {
            throw new \InvalidArgumentException('Expected a ContainerInterface');
        }

        $this->container = $container;
    }

    /**
     * @return ContainerInterface|Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return Environment
     */
    public function getTwig(): Environment
    {
        if ( !$this->twig) {
            if ($this->getContainer()->has('twig')) {
                $this->twig = $this->getContainer()->get('twig');
            }

            if (!$this->twig) {
                $loader = new FilesystemLoader($this->getContainer()->get('templates'));
                $this->twig = new Environment($loader);
            }
        }
        return $this->twig;
    }

    /**
     * @param Environment $twig
     */
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }


    public function render(int $page, array $context = []) : string
    {
        $templates = [
            self::PAGE_LOGIN => 'login.html.twig',
            self::PAGE_INDEX => 'index.html.twig',
            self::PAGE_REPORTS => 'reports.html.twig',
            self::PAGE_USERS => 'users.html.twig',
            self::PAGE_SECURITY => 'security.html.twig',
            self::PAGE_ADMIN => 'admin.html.twig',
            self::PAGE_PROFILE => 'profile.html.twig',

            self::HTTP_401 => '401.html.twig'
        ];
        return $this->getTwig()->render($templates[ $page], $context);
    }
}