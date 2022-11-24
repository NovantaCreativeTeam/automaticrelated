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
namespace Novanta\AutomaticRelated\Controller\Admin;

use Novanta\AutomaticRelated\Form\Admin\Configure\CrossSellConfigurationType;
use Novanta\AutomaticRelated\Form\Admin\Configure\UpSellConfigurationType;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class ConfigureController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request)
    {
        $configuration = $this->get('prestashop.adapter.legacy.configuration');

        $cross_sell_form = $this->createForm(CrossSellConfigurationType::class);
        $cross_sell_form->handleRequest($request);

        if ($cross_sell_form->isSubmitted() and $cross_sell_form->isValid()) {
            // Save Configuration
            // We should use Form Handler and not use business logic here: $saveErrors = $this->get('prestashop.adapter.performance.form_handler')->save($data);
            $data = $cross_sell_form->getData();

            $configuration->set('AUTOMATICRELATED_CS_ENABLED', $data['cross_sell_enabled']);
            $configuration->set('AUTOMATICRELATED_CS_FEATURE', $data['cross_sell_feature']);
            $configuration->set('AUTOMATICRELATED_CS_CATEGORY', $data['cross_sell_category']);
            $configuration->set('AUTOMATICRELATED_CS_MANUFACTURER', $data['cross_sell_manufacturer']);
            $configuration->set('AUTOMATICRELATED_CS_LIMIT', $data['cross_sell_limit']);
            //$configuration->set('AUTOMATICRELATED_CS_ORDER', $data['cross_sell_order']);

            $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

            return $this->redirectToRoute('admin_automaticrelated_configure_index');
        }

        $up_sell_form = $this->createForm(UpSellConfigurationType::class);
        $up_sell_form->handleRequest($request);

        if ($up_sell_form->isSubmitted() and $up_sell_form->isValid()) {
            // Save Configuration
            // We should use Form Handler and not use business logic here: $saveErrors = $this->get('prestashop.adapter.performance.form_handler')->save($data);
            $data = $up_sell_form->getData();

            $configuration->set('AUTOMATICRELATED_US_ENABLED', $data['up_sell_enabled']);
            $configuration->set('AUTOMATICRELATED_US_FEATURE', $data['up_sell_feature']);
            $configuration->set('AUTOMATICRELATED_US_CATEGORY', $data['up_sell_category']);
            $configuration->set('AUTOMATICRELATED_US_MANUFACTURER', $data['up_sell_manufacturer']);
            $configuration->set('AUTOMATICRELATED_US_LIMIT', $data['up_sell_limit']);
            //$configuration->set('AUTOMATICRELATED_US_ORDER', $data['up_sell_order']);

            $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

            return $this->redirectToRoute('admin_automaticrelated_configure_index');
        }

        return $this->render(
            '@Modules/automaticrelated/views/templates/admin/configure/configure.html.twig',
            [
                'layoutTitle' => $this->trans('Automatic Related', 'Modules.Automatocrealated.Admin'),
                'cross_sell_configuration_form' => $cross_sell_form->createView(),
                'up_sell_configuration_form' => $up_sell_form->createView(),
            ]
        );
    }
}