<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Form;

use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Entity\Project;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('name', 'text', array('label' => 'Name'));
        $builder->add('path', 'hidden');
        $builder->add('tmp', 'hidden');
        $builder->add(
                'visibility', 
                'choice',
                array(
                        'label' => 'Visibility', 
                        'expanded' => true, 
                        'choices' => array(
                                'public' => 'Public', 
                                'private' => 'Private'
                                )
                        )
                );
    }

    public function getName()
    {
        return 'file';
    }
}
