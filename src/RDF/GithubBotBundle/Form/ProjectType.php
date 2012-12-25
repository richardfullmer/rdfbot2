<?php

namespace RDF\GithubBotBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('repository')
            ->add('configuration')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RDF\GithubBotBundle\Entity\Project'
        ));
    }

    public function getName()
    {
        return 'rdf_githubbotbundle_projecttype';
    }
}
