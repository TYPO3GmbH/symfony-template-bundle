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
use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\MatcherInterface;
use Knp\Menu\MenuFactory;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * MenuBuilder
 */
class MenuBuilder
{
    public ParameterBagInterface $parameters;
    public MenuFactory $factory;
    public MatcherInterface $matcher;
    public AuthorizationCheckerInterface $authorizationChecker;
    public TokenStorageInterface $tokenStorage;
    public TranslatorInterface $translator;

    public function __construct(
        ParameterBagInterface $parameters,
        FactoryInterface $factory,
        MatcherInterface $matcher,
        AuthorizationCheckerInterface $authorizationChecker,
        TokenStorageInterface $tokenStorage,
        TranslatorInterface $translator
    ) {
        $this->parameters = $parameters;
        $this->factory = $factory;
        $this->matcher = $matcher;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
        $this->translator = $translator;
    }

    public function mainDefault(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        return $menu;
    }

    public function mainProfile(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        return $menu;
    }

    public function mainFooter(array $options): ItemInterface
    {
        $config = $this->parameters->get('t3g.template.config');
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
                    'label' => 'Legal Notice',
                    'uri' => $config['application']['routes']['legal'],
                ]
            );
        }
        if (!empty($config['application']['routes']['feedback'])) {
            $menu->addChild(
                'feedback',
                [
                    'label' => 'Feedback',
                    'uri' => $config['application']['routes']['feedback'],
                ]
            );
        }
        return $menu;
    }

    public function getDivider(): ItemInterface
    {
        return new DividerItem($this->factory);
    }
}
