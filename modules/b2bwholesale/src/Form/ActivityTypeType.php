<?php

namespace PrestaShop\Module\B2BWholesale\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatableType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ActivityTypeType extends TranslatorAwareType
{/**
 * @var bool
 */
    private $isMultistoreEnabled;

    /**
     * @param TranslatorInterface $translator
     * @param array $locales
     * @param bool $isMultistoreEnabled
     */
    public function __construct(
        TranslatorInterface $translator,
        array $locales,
        $isMultistoreEnabled
    ) {
        parent::__construct($translator, $locales);

        $this->isMultistoreEnabled = $isMultistoreEnabled;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('name', TranslatableType::class, array(
                "attr" => array(
                    'label' => $this->trans('Name', 'Admin.Global'),
                    "placeholder" => "Name",
                    'type' => TextType::class,
                )
            ))
            ->add('save', SubmitType::class);
    }
}
