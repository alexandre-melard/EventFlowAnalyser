<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\Form;

use Symfony\Component\Form\AbstractExtensiontType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectEditType extends ProjectType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('edit', 'hidden', array('mapped' => false));
        $builder->add('original_name', 'hidden', array('mapped' => false));
        $builder->add('original_visibility', 'hidden', array('mapped' => false));
    }
}
