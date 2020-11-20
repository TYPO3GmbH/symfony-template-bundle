<?php declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Form\Extension\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ButtonTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkButtonType extends AbstractType implements ButtonTypeInterface
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace(
            $view->vars,
            ['url' => isset($options['url']) ? $options['url'] : '#']
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(['url']);
    }

    public function getParent()
    {
        return ButtonType::class;
    }

    public function getBlockPrefix()
    {
        return 'linkbutton';
    }
}
