<?php

namespace PrestaShop\Module\B2BWholesale\Form\Builder;

use PrestaShopBundle\Form\Admin\Type\ShopChoiceTreeType;
use PrestaShopBundle\Form\Admin\Type\TranslatableType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ActivityTypeType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('name', TranslatableType::class, array(
                'label' => $this->trans('Name', 'Admin.Global'),
                "attr" => array(
                    'label' => $this->trans('Name', 'Admin.Global'),
                    "placeholder" => "Name",
                    'type' => TextType::class,
                )
            ));

        $builder->add('save', SubmitType::class);
    }
}
