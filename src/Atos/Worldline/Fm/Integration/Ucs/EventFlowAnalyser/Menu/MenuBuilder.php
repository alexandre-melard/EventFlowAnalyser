<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Menu;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\ProjectDao;

use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\Finder\SplFileInfo;

use Symfony\Component\Finder\Finder;

use Liip\ThemeBundle\ActiveTheme;
use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;
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
    
    /* @var $request Request */
    protected $request;

    /* @var $projectDao ProjectDao */
    protected $projectDao;        
    
    public function __construct(
            FactoryInterface $factory, 
            Logger $logger, 
            SecurityContextInterface $securityContext,
            $data_dir,
            ProjectDao $projectDao
            )
    {
        parent::__construct($factory);

        $this->logger = $logger;
        $this->isLoggedIn = $securityContext->isGranted('IS_AUTHENTICATED_FULLY');
        $this->user = $securityContext->getToken()->getUser();
        $this->data_dir = $data_dir;
        $this->projectDao = $projectDao;        
    }


    public function createMainMenu(Request $request)
    {
        $this->logger->debug('UcsEventFlowAnalyser::MenuBuilder:: createMainMenu');
        $menu = $this->createNavbarMenuItem('root', true);
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
        $public = $projects->addChild('Public', array(
            'route' => 'projects_list',
            'routeParameters' => array('visibility' => 'public'),
            'extras' => array('icon' => 'folder-open')                
        ));
        
        $crumbs = explode('/', $request->getPathInfo());
        if ( array_search('event', $crumbs) ) {
            list ($visibility, $name, $type) = array_slice($crumbs, 3, 3);
            $name = urldecode($name);
            
            $eventsMenu = $this->createDropdownMenuItem($menu, "Events", false, array('icon' => 'caret'));
            
            /* @var $project Project */
            $project = $this->projectDao->get($this->user, $visibility, $name);
            foreach ($project->getEvents() as $event ) {
                /* @var $event Event */
                $eventsMenu->addChild($event->getShortEvent(), array(
                        'route' => 'events_event',
                        'routeParameters' => array(
                                'visibility' => $visibility,
                                'name' => $name,
                                'type' => $event->getType(),
                        ),
                        'extras' => array('icon' => 'cog')
                ));
            }
        }
                
        return $menu;
    }
}
