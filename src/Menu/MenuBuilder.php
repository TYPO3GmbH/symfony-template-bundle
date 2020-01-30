<?php
declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Matcher\MatcherInterface;
use Knp\Menu\MenuFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * MenuBuilder
 */
class MenuBuilder
{
    /**
     * @var ContainerInterface
     */
    public $container;

    /**
     * @var MenuFactory
     */
    public $factory;

    /**
     * @var MatcherInterface
     */
    public $matcher;

    /**
     * @var AuthorizationCheckerInterface
     */
    public $authorizationChecker;

    /**
     * @var TokenStorageInterface
     */
    public $tokenStorage;

    /**
     * @var TranslatorInterface
     */
    public $translator;

    /**
     * @param ContainerInterface $container
     * @param FactoryInterface $factory
     * @param MatcherInterface $matcher
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param TokenStorageInterface $tokenStorage
     * @param TranslatorInterface $translator
     */
    public function __construct(
        ContainerInterface $container,
        FactoryInterface $factory,
        MatcherInterface $matcher,
        AuthorizationCheckerInterface $authorizationChecker,
        TokenStorageInterface $tokenStorage,
        TranslatorInterface $translator
    ) {
        $this->container = $container;
        $this->factory = $factory;
        $this->matcher = $matcher;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
        $this->translator = $translator;
    }

    /**
     * @param array $options
     * @return \Knp\Menu\ItemInterface|\Knp\Menu\MenuItem
     */
    public function mainDefault(array $options)
    {
        $menu = $this->factory->createItem('root');
        return $menu;
    }

    /**
     * @param array $options
     * @return \Knp\Menu\ItemInterface|\Knp\Menu\MenuItem
     */
    public function mainProfile(array $options)
    {
        $menu = $this->factory->createItem('root');
        return $menu;
    }

    /**
     * @param array $options
     * @return \Knp\Menu\ItemInterface|\Knp\Menu\MenuItem
     */
    public function mainFooter(array $options)
    {
        $config = $this->container->getParameter('t3g.template.config');
        $menu = $this->factory->createItem('root');
        if (!empty($config['application']['routes']['privacy'])) {
            $menu->addChild(
                'privacy',
                [
                    'label' => 'Privacy Policy',
                    'uri' => $config['application']['routes']['privacy'],
                ]
            );
        }
        if (!empty($config['application']['routes']['legal'])) {
            $menu->addChild(
                'legal',
                [
                    'label' => 'Legal Information',
                    'uri' => $config['application']['routes']['legal'],
                ]
            );
        }
        return $menu;
    }
}
