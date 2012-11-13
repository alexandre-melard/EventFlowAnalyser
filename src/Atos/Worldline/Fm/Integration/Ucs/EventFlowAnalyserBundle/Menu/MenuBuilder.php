<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Menu;

use Liip\ThemeBundle\ActiveTheme;
use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service\ParserService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyserBundle\Service\EventFlowService;
use Atos\Worldline\Fm\UserBundle\Entity\User;
use Monolog\Logger;
use Doctrine\Common\Cache\Cache;

/**
 * An example howto inject a default KnpMenu to the Navbar
 * see also Resources/config/example_menu.yml
 * and example_navbar.yml
 * @author phiamo
 *
 */
class MenuBuilder extends AbstractNavbarMenuBuilder
{
    /** @var User */
    protected $user;

    /** @var Kernel */
    protected $kernel;

    protected $isLoggedIn;

    /** @var Logger */
    protected $logger;

    /** @var Cache */
    protected $cache;

    public function __construct(FactoryInterface $factory, Logger $logger, SecurityContextInterface $securityContext,
                                Kernel $kernel, Cache $cache)
    {
        parent::__construct($factory);

        $this->logger = $logger;
        $this->isLoggedIn = $securityContext->isGranted('IS_AUTHENTICATED_FULLY');
        $this->user = $securityContext->getToken()->getUser();
        $this->kernel = $kernel;
        $this->cache = $cache;
    }


    public function createMainMenu(Request $request)
    {
        $this->logger->debug('UcsEventFlowAnalyserBundle::MenuBuilder:: createMainMenu');
        $menu = $this->createNavbarMenuItem();
        $menu->addChild('Home', array('route' => 'default'));

        // Build profile menu
        $profile = $this->createDropdownMenuItem($menu, "Profile", false, array('icon' => 'caret'));

        if (!$this->isLoggedIn) {
            $profile->addChild('Login', array('route' => 'fos_user_security_login'));
            $profile->addChild('Register', array('route' => 'fos_user_registration_register'));
            return $menu;
        }
        $dir = $this->user->getSalt();
        $profile->addChild('Logout', array('route' => 'fos_user_security_logout'));
        $profile->addChild('Profile', array('route' => 'fos_user_profile_show'));

        $use = 'public';
        $soft = 'soft';

        // Build files menu
        $files = $this->createDropdownMenuItem($menu, "Files", false, array('icon' => 'caret'));
        $files->addChild('All', array(
            'route' => 'files_all',
            'routeParameters' => array(
                'use' => $use,
                'soft' => $soft,
            )
        ));
        $files->addChild('Privates', array(
            'route' => 'files_edit',
            'routeParameters' => array('use' => 'private')
        ));
        $files->addChild('Public', array(
            'route' => 'files_edit',
            'routeParameters' => array('use' => 'public')
        ));

        // Retrieve file types
        try {
            $path = $this->kernel->locateResource("@UcsEventFlowAnalyserBundle/Resources/data/$dir/$use/$soft");
            $parsers = (new ParserService($this->cache))->parseDir($path);
            $EventFlowService = new EventFlowService($this->cache);
            $events = $EventFlowService->uniqueEvents($soft, $parsers);
            if (count($events) > 0) {
                $this->logger->debug('UcsEventFlowAnalyserBundle::MenuBuilder:: number of events = ' . count($events));
                // Build files menu
                $eventsMenu = $this->createDropdownMenuItem($menu, "Events", false, array('icon' => 'caret'));
                $eventsMenu->addChild("All",
                    array(
                        'route' => 'events_all',
                        'routeParameters' => array(
                            'use' => $use,
                            'soft' => $soft)
                    ));
                foreach ($events as $event) {
                    $this->logger->debug("UcsEventFlowAnalyserBundle::MenuBuilder::created event = $event");
                    $eventsMenu->addChild($EventFlowService->getShortEvent($event),
                        array(
                            'route' => 'events_event',
                            'routeParameters' => array(
                                'use' => $use,
                                'soft' => $soft,
                                'id' => $event)
                        ));
                }
            }
        } catch (\RuntimeException $e) {
            $this->logger->info('UcsEventFlowAnalyserBundle::MenuBuilder::no directory yet to exploit to build events list');
        }
        return $menu;
    }

    public function createNavbarsSubnavMenu(Request $request)
    {
        $menu = $this->createSubnavbarMenuItem();
        $menu->addChild('Top', array('route' => '#top'));
        $menu->addChild('Navbars', array('route' => '#navbars'));
        $menu->addChild('Template', array('route' => '#template'));
        $menu->addChild('Menus', array('route' => '#menus'));
        // ... add more children
        return $menu;
    }

    public function createComponentsSubnavMenu(Request $request)
    {
        $menu = $this->createSubnavbarMenuItem();
        $menu->addChild('Top', array('route' => '#top'));
        $menu->addChild('Flashs', array('route' => '#flashs'));
        $menu->addChild('Session Flashs', array('route' => '#session-flashes'));
        $menu->addChild('Labels & Badges', array('route' => '#labels-badges'));
        // ... add more children
        return $menu;
    }
}
