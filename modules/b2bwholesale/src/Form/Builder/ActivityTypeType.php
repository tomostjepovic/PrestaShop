<?php

namespace PrestaShop\Module\B2BWholesale\Form\Builder;

use PrestaShopBundle\Form\Admin\Type\ShopChoiceTreeType;
use PrestaShopBundle\Form\Admin\Type\TranslatableType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
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
    /*public function __construct(
        TranslatorInterface $translator,
        array $locales,
        bool $isMultistoreEnabled
    ) {
        parent::__construct($translator, $locales, $isMultistoreEnabled);

        $this->isMultistoreEnabled = $isMultistoreEnabled;
    }*/

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
            ));
        if ($this->isMultistoreEnabled) {
            $builder->add('shop_association', ShopChoiceTreeType::class, [
                'label' => $this->trans('Shop association', 'Admin.Global'),
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => $this->trans(
                            'You have to select at least one shop to associate this item with',
                            'Admin.Notifications.Error'
                        ),
                    ]),
                ],
            ]);
        }

        $builder->add('save', SubmitType::class);
    }
}
