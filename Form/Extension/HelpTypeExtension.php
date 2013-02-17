<?php

namespace Snowcap\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class HelpTypeExtension extends AbstractTypeExtension
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setOptional(array('help_block', 'help_inline'))
            ->setAllowedTypes(array(
                'help_block' => 'string',
                'help_inline' => 'string',
            ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if(isset($options['help_block']) && isset($options['help_inline'])) {
            throw new \UnexpectedValueException('Cannot set both "help_block" and "help_inline" options');
        }
        elseif(isset($options['help_block'])) {
            $view->vars['help'] = true;
            $view->vars['help_block'] = $options['help_block'];

        }
        elseif(isset($options['help_inline'])) {
            $view->vars['help'] = true;
            $view->vars['help_inline'] = $options['help_inline'];
        }
        else {
            $view->vars['help'] = false;
        }
    }

    /**
     * @return string
     */
    public function getExtendedType()
    {
        return 'form';
    }
}