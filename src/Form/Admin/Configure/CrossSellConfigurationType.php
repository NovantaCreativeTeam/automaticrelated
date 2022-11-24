<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/
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