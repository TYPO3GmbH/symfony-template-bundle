<?php declare(strict_types=1);

/*
 * This file is part of the package t3g/symfony-template-bundle.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3G\Bundle\TemplateBundle\Form\Extension\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoteDatalistType extends AbstractType
{
    public function getParent(): string
    {
        return DatalistType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired(['choices', 'source_url'])
            ->setDefaults([
                'choices' => [],
                'search_param' => 'term',
                'search_placeholder' => 'Search...',
                'preview_value' => '',
            ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['choices'] = $options['choices'];
        $view->vars['preview_value'] = $options['preview_value'];
        $view->vars['attr'] = array_merge($view->vars['attr'], [
            'autocomplete' => 'disabled',
            'placeholder' => $options['search_placeholder'],
            'data-last-search' => '',
            'data-source-url' => $options['source_url'],
            'data-search-param' => $options['search_param'],
        ]);
    }

    public function getName(): string
    {
        return 'datalist';
    }
}
