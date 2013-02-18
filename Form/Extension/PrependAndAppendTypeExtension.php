<?php

namespace Snowcap\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

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
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setOptional($this->prependAndAppendOptions)
            ->setAllowedTypes(array_combine($this->prependAndAppendOptions, array_fill(0, 4, 'string')));
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