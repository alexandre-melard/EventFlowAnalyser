<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Menu;

use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\Finder\SplFileInfo;

use Symfony\Component\Finder\Finder;

use Liip\ThemeBundle\ActiveTheme;
use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\ParserService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\EventFlowService;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Service\FileService;
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
    /* @var $user User */
    protected $user;

    protected $isLoggedIn;

    /* @var $logger Logger */
    protected $logger;
    
    protected $data_dir;

    /* @var $file FileService*/
    protected $file;
    
    /* @var $parser ParserService */
    protected $parser;

    /* @var $eventFlow EventFlowService */
    protected $evenFlow;
    
    protected $session;
    
    public function __construct(
            FactoryInterface $factory, 
            Logger $logger, 
            SecurityContextInterface $securityContext,
            $data_dir,
            $file,
            $parser,
            $evenFlow,
            $session            
            )
    {
        parent::__construct($factory);

        $this->logger = $logger;
        $this->isLoggedIn = $securityContext->isGranted('IS_AUTHENTICATED_FULLY');
        $this->user = $securityContext->getToken()->getUser();
        $this->data_dir = $data_dir;
        $this->file = $file;
        $this->parser = $parser;
        $this->evenFlow = $evenFlow;        
        $this->session = $session;
    }


    public function createMainMenu(Request $request)
    {
        $this->logger->debug('UcsEventFlowAnalyser::MenuBuilder:: createMainMenu');
        $menu = $this->createNavbarMenuItem();
        $menu->addChild(
                'Home', 
                array(
                        'route' => 'default', 
                        'extras' => array('icon' => 'home')
                        )
                );

        // Build profile menu
        $profile = $this->createDropdownMenuItem($menu, "Profile", false, array('icon' => 'caret'));

        if (!$this->isLoggedIn) {
            $profile->addChild(
                    'Login', 
                    array(
                            'route' => 'fos_user_security_login',
                            'extras' => array('icon' => 'arrow-right')
                        )
                    );
            $profile->addChild(
                    'Register', 
                    array(
                            'route' => 'fos_user_registration_register',
                            'extras' => array('icon' => 'user')
                        )
                    );
            return $menu;
        }
        $profile->addChild(
                'Logout', 
                array(
                        'route' => 'fos_user_security_logout',
                        'extras' => array('icon' => 'off')
                )
                );
        $profile->addChild(
                'Profile', 
                array(
                        'route' => 'fos_user_profile_show',
                        'extras' => array('icon' => 'info-sign')
                        )
                );

        // Build files menu
        $projects = $this->createDropdownMenuItem($menu, "Projects", false, array('icon' => 'caret'));
        $projects->addChild(
                'Create', 
                array(
                        'route' => 'projects_create',
                        'extras' => array('icon' => 'plus-sign')
                    )
                );
        $this->addDivider($projects);
        $projects->addChild('All', array(
            'route' => 'projects_list_all',
            'extras' => array('icon' => 'list')                
        ));
        $projects->addChild('Privates', array(
            'route' => 'projects_list',
            'routeParameters' => array('visibility' => 'private'),
            'extras' => array('icon' => 'folder-close')                
        ));
        $projects->addChild('Public', array(
            'route' => 'projects_list',
            'routeParameters' => array('visibility' => 'public'),
            'extras' => array('icon' => 'folder-open')                
        ));

//         $salt = $this->user->getSalt();

//         $fs = new Filesystem();
//         if ($fs->exists($this->data_dir . '/private/') && $fs->exists($this->data_dir . '/public/'))
//         {
//             // Build Projects menu
//             $projects = $this->createDropdownMenuItem($menu, "Projects", false, array('icon' => 'caret'));
            
//             if ($fs->exists($this->data_dir . '/private/' . $salt))
//             {
//                 $projects->addChild('Private', array(
//                         'uri'    => '#',
//                         'extras' => array('icon' => 'folder-close')
//                 ));
//                 $this->addDivider($projects);
//                 $finder = new Finder();
//                 $finder->in($this->data_dir . '/private/' . $salt);
//                 /* @var $file SplFileInfo */
//                 foreach ($finder->directories() as $dir) {
//                     $projects->addChild($dir->getFilename(), array(
//                             'route' => 'events_all',
//                             'routeParameters' => array(
//                                     'visibility' => 'private',
//                                     'soft' => $dir->getFilename()),
//                             'extras' => array('icon' => 'folder-close')
//                     ));
                
//                 }
//                 $this->addDivider($projects);
//             }            
//             $projects->addChild('Public', array(
//                     'uri'    => '#',
//                     'extras' => array('icon' => 'folder-open')
//             ));
//             $this->addDivider($projects);
    
//             $finder = new Finder();
//             $finder->in($this->data_dir . '/public/' );

//             // get all projects from public dir
//             $finder->depth('>=1');
            
//             /* @var $file SplFileInfo */
//             foreach ($finder->directories() as $dir) {
//                 $projects->addChild($dir->getFilename(), array(
//                         'route' => 'events_all',
//                         'routeParameters' => array(
//                                 'visibility' => 'public',
//                                 'soft' => $dir->getFilename()),
//                         'extras' => array('icon' => 'folder-open')
//                 ));
            
//             }
//         }        
//         // Retrieve file types
//         if ( $this->session->has('event')) {
//             $eventSession = $this->session->get('event');
//             try {
//                 $this->file->getFiles($this->data_dir, $eventSession['visibility'], $eventSession['salt'], $eventSession['soft']);
//                 $parsers = $this->parser->parseFiles($eventSession['files']);
//                 $EventFlowService = $this->evenFlow;
//                 $events = $EventFlowService->uniqueEvents($eventSession['soft'], $parsers);
//                 if (count($events) > 0) {
//                     $this->logger->debug('UcsEventFlowAnalyser::MenuBuilder:: number of events = ' . count($events));

//                     // Build files menu
//                     $eventsMenu = $this->createDropdownMenuItem($menu, "Events", false, array('icon' => 'caret'));
//                     foreach ($events as $event) {
//                         $this->logger->debug("UcsEventFlowAnalyser::MenuBuilder::created event = $event");
//                         $eventsMenu->addChild($EventFlowService->getShortEvent($event),
//                             array(
//                                 'route' => 'events_event',
//                                 'routeParameters' => array(
//                                     'visibility' => $eventSession['visibility'],
//                                     'soft' => $eventSession['soft'],
//                                     'id' => $event)
//                             ));
//                     }
//                 }
//             } catch (\RuntimeException $e) {
//                 $this->logger->info('UcsEventFlowAnalyser::MenuBuilder::no directory yet to exploit to build events list');
//             }
//         }
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
