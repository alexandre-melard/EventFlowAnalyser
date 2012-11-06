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
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service\ParserService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service\EventFlowService;
use Atos\Worldline\Fm\UserBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;
use Monolog\Logger;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        /** @var $logger Logger */
        $logger = $this->container->get('logger');

        $menu = $factory->createItem('root');
        $menu->setChildrenAttributes(array('class' => 'jd_menu'));
        $menu->addChild('Home', array('uri' => '/events'));

        // Build profile menu
        $profile = $menu->addChild('Profile', array());

        // Get user info
        /** @var $securityContext SecurityContext */
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        /** @var $user User */
        if (!is_object($user)) {
                $profile->addChild('Login', array('uri' => '/login'));
                $profile->addChild('Register', array('uri' => '/register'));
                return $menu;
        }
        $dir = $user->getSalt();
        $profile->addChild('Logout', array('uri' => '/logout'));
        $profile->addChild('Profile', array('uri' => '/profile'));


        // Analyse menu
        $analyse = $menu->addChild('Analyse');
        $analyse->addChild('Home', array('uri' => '/events'));
        $analyse->addChild('All', array('uri' => '/events/all'));

        $analyseFiles = $analyse->addChild('Files');
        $analyseFiles->addChild('All', array('uri' => '/files'));
        $analyseFiles->addChild('Privates', array('uri' => '/files/private'));
        $analyseFiles->addChild('Public', array('uri' => '/files/public'));

        // Retrieve file types
        try {
            $parsers = ParserService::parseDir(dirname(__FILE__) . "/../Resources/data/$dir/public/soft");
            $events = EventFlowService::uniqueEvents($parsers);
            if (count($events) > 0) {
                $analyseEventTypes = $analyse->addChild('Events');
                foreach ($events as $event) {
                    $analyseEventTypes->addChild(str_replace("CORE_MSG_TYPE_", "", $event), array('uri' => '/events/event/' . $event));
                }
            }
        } catch (\RuntimeException $e) {
            $logger->info("UcsEventFlowAnalyserBundle::MenuBuilder::no directory yet to exploit to build events list");
        }

        return $menu;
    }
}