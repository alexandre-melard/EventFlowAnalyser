<?php
/**
 * Created by JetBrains PhpStorm.
 * User: A140980
 * Date: 04/11/12
 * Time: 20:13
 * To change this template use File | Settings | File Templates.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Entity\Parser;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service\ParserService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service\EventFlowService;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttributes(array('class' => 'menu'));
        $menu->addChild('Home', array('uri' => '/events'));

        $menu->addChild('Profile', array('class' => 'parent', 'uri' => '/profile'));
        $menu['Profile']->addChild('Login', array('uri' => '/login'));
        $menu['Profile']->addChild('Logout', array('uri' => '/logout'));
        $menu['Profile']->addChild('Register', array('uri' => '/register'));

        $menu->addChild('Events', array('uri' => '/events'));
        $menu['Events']->addChild('Home', array('uri' => '/events'));
        $menu['Events']->addChild('All', array('uri' => '/events/all'));
        $menu['Events']->addChild('Types');
        $parser = new Parser(dirname(__FILE__) . "/../Resources/data/alex/public/soft/dbu.xml");
        ParserService::parse($parser);
        $parsers = ParserService::parseDir(dirname(__FILE__) . "/../Resources/data/alex/public/soft");
        $events = EventFlowService::uniqueEvents($parsers);
        foreach ($events as $event) {
            /** @var $item ItemInterface */
            $item = $menu['Events']['Types']->addChild($event, array('uri' => '/events/event/' . $event));
            $item->setLabelAttribute("class", "test");
        }
        // ... add more children

        return $menu;
    }
}