<?php

namespace Novanta\AutomaticRelated\Form\Admin\Configure;

use PrestaShop\PrestaShop\Adapter\Form\ChoiceProvider\FeaturesChoiceProvider;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;

class CrossSellConfigurationType extends TranslatorAwareType
{
    private $configuration;
    private $featuresChoiceProvider;

    public function __construct(
        TranslatorInterface $translator,
        array $locales,
        ConfigurationInterface $configuration,
        FeaturesChoiceProvider $featuresChoiceProvider
    ) {
        parent::__construct($translator, $locales);

        $this->configuration = $configuration;
        $this->featuresChoiceProvider = $featuresChoiceProvider;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cross_sell_enabled', SwitchType::class, [
            'label' => $this->trans('Enable cross sells', 'Modules.Automaticrelated.Admin'),
            'data' => $this->configuration->get('AUTOMATICRELATED_CS_ENABLED', true),
            'required' => true,
        ]);

        $builder->add('cross_sell_feature', ChoiceType::class, [
            'label' => $this->trans('Feature to match', 'Modules.Automaticrelated.Admin'),
            'data' => $this->configuration->get('AUTOMATICRELATED_CS_FEATURE', null),
            'choices' => $this->featuresChoiceProvider->getChoices(),
            'required' => false,
            'placeholder' => $this->trans('Choose a feature', 'Modules.Automaticrelated.Admin')
        ]);

        $builder->add('cross_sell_category', SwitchType::class, [
            'label' => $this->trans('Enable category matching', 'Modules.Automaticrelated.Admin'),
            'data' => $this->configuration->get('AUTOMATICRELATED_CS_CATEGORY', true),
            'required' => false,
        ]);

        $builder->add('cross_sell_manufacturer', SwitchType::class, [
            'label' => $this->trans('Enable manufacturer matching', 'Modules.Automaticrelated.Admin'),
            'data' => $this->configuration->get('AUTOMATICRELATED_CS_MANUFACTURER', true),
            'required' => false,
        ]);

        $builder->add('cross_sell_limit', NumberType::class, [
            'label' => $this->trans('Cross sell to show', 'Modules.Automaticrelated.Admin'),
            'data' => $this->configuration->get('AUTOMATICRELATED_CS_LIMIT', 4),
            'required' => false,
        ]);
    }
}