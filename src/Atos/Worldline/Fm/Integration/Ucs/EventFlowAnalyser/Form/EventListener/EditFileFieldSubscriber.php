<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Form\EventListener;

use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class EditFileFieldSubscriber implements EventSubscriberInterface
{
    private $factory;
    
    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }
    
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }
    
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
    
        // During form creation setData() is called with null as an argument
        // by the FormBuilder constructor. You're only concerned with when
        // setData is called with an actual Entity object in it (whether new
        // or fetched with Doctrine). This if statement lets you skip right
        // over the null condition.
        if (null === $data) {
            return;
        }
    
        // check if the product object is "new"
        if (!$data->name) {
            $form->add($this->factory->createNamed('name', 'text'));
        }
    }
}