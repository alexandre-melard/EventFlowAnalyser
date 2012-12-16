<?php

namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Menu;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Knp\Menu\ItemInterface;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Request;

use Knp\Menu\FactoryInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;
use Monolog\Logger;

use Atos\Worldline\Fm\UserBundle\Entity\User;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Document;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Event;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Dao\ProjectDao;

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

    /* @var $projectDao ProjectDao */
    protected $projectDao;

    /* @var $securityContext SecurityContextInterface */
    protected $securityContext;

    public function createMainMenu(Request $request)
    {
        $this->logger->debug('UcsEventFlowAnalyser::MenuBuilder:: createMainMenu');
        $menu = $this->createNavbarMenuItem('root', true);
        $menu->addChild('Home', array('route' => 'default', 'extras' => array('icon' => 'home')));
        $this->createUserMenu($menu);
        
        if ($this->isLoggedIn) {
            $this->createProjectsMenu($menu);
            if ($request->attributes->has('projectName')) {
                $projectName = $request->attributes->get('projectName');
    
                /* @var $project Project */
                $project = $this->projectDao->get($this->user, $projectName);
    
                $this->createEventsMenu($project, $menu);
                $this->createDocumentsMenu($project, $menu);
            }
        }

        return $menu;
    }

    public function createUserMenu(ItemInterface $menu)
    {
        // Build profile menu
        $profile = $this->createDropdownMenuItem($menu, "Profile", false, array('icon' => 'caret'));

        if (!$this->isLoggedIn) {
            $profile->addChild('Login', array('route' => 'fos_user_security_login', 'extras' => array('icon' => 'arrow-right')));
            $profile
                    ->addChild('Register', array('route' => 'fos_user_registration_register', 'extras' => array('icon' => 'user')));
        } else {
            $profile->addChild('Logout', array('route' => 'fos_user_security_logout', 'extras' => array('icon' => 'off')));
            $profile->addChild('Profile', array('route' => 'fos_user_profile_show', 'extras' => array('icon' => 'user')));
            $profile->addChild('Edit', array('route' => 'fos_user_profile_edit', 'extras' => array('icon' => 'pencil')));
            $profile
                    ->addChild('Change Password', array('route' => 'fos_user_change_password', 'extras' => array('icon' => 'lock')));
        }
    }

    public function createProjectsMenu(ItemInterface $menu)
    {
        // Build files menu
        $projects = $this->createDropdownMenuItem($menu, "Projects", false, array('icon' => 'caret'));
        $projects->addChild('Create', array('route' => 'projects_create', 'extras' => array('icon' => 'plus-sign')));
        $this->addDivider($projects);
        $projects->addChild('All', array('route' => 'projects_list_all', 'extras' => array('icon' => 'list')));
        $projects
                ->addChild('Privates',
                        array('route' => 'projects_list', 'routeParameters' => array('visibility' => 'private'), 'extras' => array('icon' => 'folder-close')));
        $public = $projects
                ->addChild('Public',
                        array('route' => 'projects_list', 'routeParameters' => array('visibility' => 'public'), 'extras' => array('icon' => 'folder-open')));
    }

    public function createEventsMenu(Project $project, ItemInterface $menu)
    {
        $eventsMenu = $this->createDropdownMenuItem($menu, "Events", false, array('icon' => 'caret'));
        $eventsMenu->addChild('All',
                        array(
                                'route' => 'events_all', 
                                'routeParameters' => array('projectName' => $project->getName()),
                                'extras' => array('icon' => 'cog')
                                )
                );
        foreach ($project->getEvents() as $event) {
            /* @var $event Event */
            $eventsMenu->addChild($event->getShortEvent(),
                            array('route' => 'events_event', 'routeParameters' => array('projectName' => $project->getName(), 'type' => $event->getType(),),
                                    'extras' => array('icon' => 'cog')));
        }
    }

    public function createDocumentsMenu(Project $project, ItemInterface $menu)
    {
        $documentsMenu = $this->createDropdownMenuItem($menu, "Documents", false, array('icon' => 'caret'));
        foreach ($project->getDocuments() as $document) {
            /* @var $document Document */
            $documentsMenu
                    ->addChild($document->getName(),
                            array('route' => 'projects_documents_document',
                                    'routeParameters' => array('projectName' => urlencode($project->getName()),
                                            'documentName' => urlencode($document->getName()),), 'extras' => array('icon' => 'file')));
        }
    }

    /**
     * @param Logger $logger
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ProjectDao $projectDao
     */
    public function setProjectDao(ProjectDao $projectDao)
    {
        $this->projectDao = $projectDao;
    }

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function setSecurityContext(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
        try {
            $this->isLoggedIn = $securityContext->isGranted('IS_AUTHENTICATED_FULLY');
            $this->user = $securityContext->getToken()->getUser();
        } catch (\Exception $e) {
            $this->isLoggedIn = false;
        }
    }

}
