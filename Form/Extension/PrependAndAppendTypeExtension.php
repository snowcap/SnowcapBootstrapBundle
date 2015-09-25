<?php

namespace Snowcap\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

/**
 * Class PrependAndAppendTypeExtension
 * @package Snowcap\BootstrapBundle\Form\Extension
 */
class PrependAndAppendTypeExtension extends AbstractTypeExtension
{
    /**
     * @var array
     */
    private $prependAndAppendOptions = array(
        'prepend_text',
        'prepend_icon',
        'append_text',
        'append_icon',
    );

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined($this->prependAndAppendOptions);
        foreach ($this->prependAndAppendOptions as $option) {
            $resolver->setAllowedTypes($option, 'string');
        }
    }

    /**
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['prepend'] = isset($options['prepend_text']) || isset($options['prepend_icon']);
        $view->vars['append'] = isset($options['append_text']) || isset($options['append_icon']);
        foreach($this->prependAndAppendOptions as $option) {
            if(isset($options[$option])) {
                $view->vars[$option] = $options[$option];
            }
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