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
use Novanta\AutomaticRelated\Adapter\Install\InstallerFactory;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;

if (!defined('_PS_VERSION_')) {
    exit;
}

$autoloadPath = dirname(__FILE__) . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

class AutomaticRelated extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'automaticrelated';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Novanta';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Automatic Related Products', [], 'Modules.Automaticrelated.Admin');
        $this->description = $this->trans('Display Automatic Related Product based on custom rules', [], 'Modules.Automaticrelated.Admin');

        $this->ps_versions_compliancy = array('min' => '1.7.8', 'max' => _PS_VERSION_);
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function install()
    {
        $installer = InstallerFactory::create();

        return parent::install() &&
            $installer->install($this);
    }

    public function uninstall()
    {
        $installer = InstallerFactory::create();

        return parent::uninstall() &&
            $installer->uninstall();
    }

    public function getContent()
    {
        Tools::redirectAdmin(SymfonyContainer::getInstance()->get('router')->generate('admin_automaticrelated_configure_index'));
    }

    #region OLD version TO REMOVE

    // /**
    //  * Load the configuration form
    //  */
    // public function getContent()
    // {
    //     /**
    //      * If values have been submitted in the form, process.
    //      */
    //     if (((bool)Tools::isSubmit('submitAutomaticrelatedModule')) == true) {
    //         $this->postProcess();
    //     }

    //     $this->context->smarty->assign('module_dir', $this->_path);

    //     $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

    //     return $output.$this->renderForm();
    // }

    // /**
    //  * Create the form that will be displayed in the configuration of your module.
    //  */
    // protected function renderForm()
    // {
    //     $helper = new HelperForm();

    //     $helper->show_toolbar = false;
    //     $helper->table = $this->table;
    //     $helper->module = $this;
    //     $helper->default_form_language = $this->context->language->id;
    //     $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

    //     $helper->identifier = $this->identifier;
    //     $helper->submit_action = 'submitAutomaticrelatedModule';
    //     $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
    //         .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
    //     $helper->token = Tools::getAdminTokenLite('AdminModules');

    //     $helper->tpl_vars = array(
    //         'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
    //         'languages' => $this->context->controller->getLanguages(),
    //         'id_language' => $this->context->language->id,
    //     );

    //     return $helper->generateForm(array($this->getConfigForm()));
    // }

    // /**
    //  * Create the structure of your form.
    //  */
    // protected function getConfigForm()
    // {
    //     return array(
    //         'form' => array(
    //             'legend' => array(
    //                 'title' => $this->l('Settings'),
    //                 'icon' => 'icon-cogs',
    //             ),
    //             'tabs' => array(
    //                 'cross_sell' => $this->l('Cross Sell'),
    //                 'up_sell' => $this->l('Up Sell')
    //             ),
    //             'input' => array(
    //                 array(
    //                     'type' => 'switch',
    //                     'label' => $this->l('Abilita Prodotti Cross Sell'),
    //                     'name' => 'RELATED_CS_ENABLED',
    //                     'tab'=> 'cross_sell',
    //                     'is_bool' => true,
    //                     'values' => array(
    //                         array(
    //                             'id' => 'active_on',
    //                             'value' => true,
    //                             'label' => $this->l('Enabled')
    //                         ),
    //                         array(
    //                             'id' => 'active_off',
    //                             'value' => false,
    //                             'label' => $this->l('Disabled')
    //                         )
    //                     ),
    //                 ),
    //                 array(
    //                     'type' => 'select',                              
    //                     'label' => $this->l('Match Attributi Cross Sell'),         
    //                     'name' => 'RELATED_CS_FEATURE', 
    //                     'tab'=> 'cross_sell',                    
    //                     'required' => false,                         
    //                     'options' => array(
    //                       'query' => Feature::getFeatures($this->context->language->id),                           
    //                       'id' => 'id_feature',                           
    //                       'name' => 'name',
    //                       'default' => array(
    //                         'label' => $this->l('Nessun Attributo'),
    //                         'value' => 0,
    //                        )                             
    //                     )
    //                   ),
    //                 array(
    //                     'type' => 'switch',
    //                     'label' => $this->l('Match Categoria Cross Sell'),
    //                     'name' => 'RELATED_CS_CATEGORY',
    //                     'tab'=> 'cross_sell',
    //                     'is_bool' => true,
    //                     'values' => array(
    //                         array(
    //                             'id' => 'active_on',
    //                             'value' => true,
    //                             'label' => $this->l('Enabled')
    //                         ),
    //                         array(
    //                             'id' => 'active_off',
    //                             'value' => false,
    //                             'label' => $this->l('Disabled')
    //                         )
    //                     ),
    //                 ),
    //                 array(
    //                     'type' => 'switch',
    //                     'label' => $this->l('Match Brand Cross Sell'),
    //                     'name' => 'RELATED_CS_MANUFACTURER',
    //                     'tab'=> 'cross_sell',
    //                     'is_bool' => true,
    //                     'values' => array(
    //                         array(
    //                             'id' => 'active_on',
    //                             'value' => true,
    //                             'label' => $this->l('Enabled')
    //                         ),
    //                         array(
    //                             'id' => 'active_off',
    //                             'value' => false,
    //                             'label' => $this->l('Disabled')
    //                         )
    //                     ),
    //                 ),
    //                 array(
    //                     'type' => 'text',
    //                     'label' => $this->l('Elementi da mostrare Cross Sell'),
    //                     'name' => 'RELATED_CS_LIMIT',
    //                     'tab'=> 'cross_sell'
    //                 ),
                    
    //                 array(
    //                     'type' => 'switch',
    //                     'label' => $this->l('Abilita Prodotti Up Sell'),
    //                     'name' => 'RELATED_US_ENABLED',
    //                     'tab'=> 'up_sell',
    //                     'is_bool' => true,
    //                     'values' => array(
    //                         array(
    //                             'id' => 'active_on',
    //                             'value' => true,
    //                             'label' => $this->l('Enabled')
    //                         ),
    //                         array(
    //                             'id' => 'active_off',
    //                             'value' => false,
    //                             'label' => $this->l('Disabled')
    //                         )
    //                     ),
    //                 ),
    //                 array(
    //                     'type' => 'select',                              
    //                     'label' => $this->l('Match Attributi Up Sell'),         
    //                     'name' => 'RELATED_US_FEATURE', 
    //                     'tab'=> 'up_sell',                    
    //                     'required' => false,                           
    //                     'options' => array(
    //                       'query' => Feature::getFeatures($this->context->language->id),                           
    //                       'id' => 'id_feature',                           
    //                       'name' => 'name',
    //                       'default' => array(
    //                         'label' => $this->l('Nessun Attributo'),
    //                         'value' => 0,
    //                        )                         
    //                     )
    //                   ),
    //                 array(
    //                     'type' => 'switch',
    //                     'label' => $this->l('Match Categoria Up Sell'),
    //                     'name' => 'RELATED_US_CATEGORY',
    //                     'tab'=> 'up_sell',
    //                     'is_bool' => true,
    //                     'values' => array(
    //                         array(
    //                             'id' => 'active_on',
    //                             'value' => true,
    //                             'label' => $this->l('Enabled')
    //                         ),
    //                         array(
    //                             'id' => 'active_off',
    //                             'value' => false,
    //                             'label' => $this->l('Disabled')
    //                         )
    //                     ),
    //                 ),
    //                 array(
    //                     'type' => 'switch',
    //                     'label' => $this->l('Match Brand Up Sell'),
    //                     'name' => 'RELATED_US_MANUFACTURER',
    //                     'tab'=> 'up_sell',
    //                     'is_bool' => true,
    //                     'values' => array(
    //                         array(
    //                             'id' => 'active_on',
    //                             'value' => true,
    //                             'label' => $this->l('Enabled')
    //                         ),
    //                         array(
    //                             'id' => 'active_off',
    //                             'value' => false,
    //                             'label' => $this->l('Disabled')
    //                         )
    //                     ),
    //                 ),
    //                 array(
    //                     'type' => 'text',
    //                     'label' => $this->l('Elementi da mostrare Up Sell'),
    //                     'name' => 'RELATED_US_LIMIT',
    //                     'tab'=> 'up_sell'
    //                 ),
    //             ),
    //             'submit' => array(
    //                 'title' => $this->l('Save'),
    //             ),
    //         ),
    //     );
    // }

    // /**
    //  * Set values for the inputs.
    //  */
    // protected function getConfigFormValues()
    // {
    //     return array(
    //         'RELATED_CS_ENABLED' => Configuration::get('RELATED_CS_ENABLED', true),
    //         'RELATED_CS_FEATURE' => Configuration::get('RELATED_CS_FEATURE', null),
    //         'RELATED_CS_CATEGORY' => Configuration::get('RELATED_CS_CATEGORY', true),
    //         'RELATED_CS_MANUFACTURER' => Configuration::get('RELATED_CS_MANUFACTURER', null),
    //         'RELATED_CS_LIMIT' => Configuration::get('RELATED_CS_LIMIT', 10),
    //         // RELATED_CS_ORDER
            
    //         'RELATED_US_ENABLED' => Configuration::get('RELATED_US_ENABLED', true), 
    //         'RELATED_US_FEATURE' => Configuration::get('RELATED_US_FEATURE', null),
    //         'RELATED_US_CATEGORY' => Configuration::get('RELATED_US_CATEGORY', true),
    //         'RELATED_US_MANUFACTURER' => Configuration::get('RELATED_US_MANUFACTURER', null),
    //         'RELATED_US_LIMIT' => Configuration::get('RELATED_US_LIMIT', 10),
    //         // RELATED_US_ORDER
    //     );
    // }

    // /**
    //  * Save form data.
    //  */
    // protected function postProcess()
    // {
    //     $form_values = $this->getConfigFormValues();

    //     foreach (array_keys($form_values) as $key) {
    //         Configuration::updateValue($key, Tools::getValue($key));
    //     }
    // }

    #endregion

    public function hookDisplayFooterProduct($params)
    {
        $cross_sell = null;
        $up_sell = null;

        // 1. Verifico se il CrossSell è abilitato
        if(Configuration::get('AUTOMATICRELATED_CS_ENABLED', false)) {
            // 1.1 Recupero i prodotti CrossSell
            $cross_sell = $this->getCrossSellProducts($params['product']);
            $cross_feature_info = $this->getFeatureInfo($params['product']['id_product'], Configuration::get('AUTOMATICRELATED_CS_FEATURE'));
            $cross_category = Configuration::get('AUTOMATICRELATED_CS_CATEGORY') ? $params['category']->name : null;
        }
        
        // 2. Verifico se l'UpSell è abilitato
        if(Configuration::get('AUTOMATICRELATED_US_ENABLED', false)) {
            // 2.1 Recupero i prodotti UpSell
            $up_sell = $this->getUpSellProducts($params['product']);
            $up_feature_info = $this->getFeatureInfo($params['product']['id_product'], Configuration::get('AUTOMATICRELATED_US_FEATURE'));
            $up_category = Configuration::get('AUTOMATICRELATED_US_CATEGORY') ? $params['category']->name : null;
        }

        // $this->context->controller->registerJavascript('remote-mymodule-js', 'modules/' . $this->name . '/views/js/front.js', ['position' => 'bottom', 'priority' => 150]);
        $this->context->smarty->assign(array(
            'cross_sell' => isset($cross_sell) ? $cross_sell : null,
            'cross_feature_name' => isset($cross_feature_info) ? $cross_feature_info['name'] : null,
            'cross_feature_value' => isset($cross_feature_info) ? $cross_feature_info['value'] : null,
            'cross_category' => isset($cross_category) ? $cross_category : null,
            'up_sell' => isset($up_sell) ? $up_sell : null,
            'up_feature_name' => isset($up_feature_info) ? $up_feature_info['name'] : null,
            'up_feature_value' => isset($up_feature_info) ? $up_feature_info['value'] : null,
            'up_category' => isset($up_category) ? $up_category : null,
        ));

        $html = $this->context->smarty->fetch('module:automaticrelated/views/templates/hook/related_productfooter.tpl');
        return $html;
    }

    private function getCrossSellProducts($product) {
        $cross_sell = null;
        $cross_feature = Configuration::get('AUTOMATICRELATED_CS_FEATURE');
        $cross_category = Configuration::get('AUTOMATICRELATED_CS_CATEGORY', false);
        $cross_manufacturer = Configuration::get('AUTOMATICRELATED_CS_MANUFACTURER', false);
        $cross_limit = Configuration::get('AUTOMATICRELATED_CS_LIMIT', 10);

        // 1. Verifico che sia stato passato il product
        if($product == null) {
            return $cross_sell;
        }

        // 2. Recupero il valore degli attribute per effettuare il match
        $feature_values = array();
        
        if($cross_feature) {
            $product_features = Product::getFeaturesStatic($product['id_product']);
            $match_feature_key = array_search($cross_feature, array_column($product_features, 'id_feature'));

            if($match_feature_key !== false) {
                array_push($feature_values, $product_features[$match_feature_key]['id_feature_value']);
            }
        }

        // 3. Recupero la categoria per effettuare il match
        // 4. Recupero la lista di prodotti
        if(sizeof($feature_values) > 0 || $cross_category) {
            $sql = new DbQuery();
            $sql->select('p.id_product');
            $sql->from('product', 'p');

            if(sizeof($feature_values) > 0) {
                $sql->innerJoin('feature_product', 'fp', 'p.id_product = fp.id_product');
                $sql->innerJoin('feature_value', 'fv', 'fp.id_feature_value = fv.id_feature_value'); 
                $sql->where('fv.id_feature_value IN (' . implode (", ", $feature_values) . ')');
            }

            if($cross_category) {
                $sql->where('p.id_category_default = ' . $product['id_category_default']);
            }

            if($cross_manufacturer) {
                $sql->where('p.id_manufacturer = ' . $product['id_manufacturer']);
            }

            if($cross_limit && $cross_limit > -1) {
                $sql->limit($cross_limit);
            }

            $sql->where('p.id_product <> ' . $product['id_product']);
            $sql->orderBy('rand()');

            $results = Db::getInstance()->executeS($sql);
            $cross_sell = $this->getProductForTemplates($results);
        }

        return $cross_sell;
    }

    private function getUpSellProducts($product) {
        $up_sell = null;
        $up_feature = Configuration::get('AUTOMATICRELATED_US_FEATURE');
        $up_category = Configuration::get('AUTOMATICRELATED_US_CATEGORY', false);
        $up_manufacturer = Configuration::get('AUTOMATICRELATED_US_MANUFACTURER', false);
        $up_limit = Configuration::get('AUTOMATICRELATED_US_LIMIT', 10);

        // 1. Verifico che sia stato passato il product
        if($product == null) {
            return $up_sell;
        }

        // 2. Recupero il valore degli attribute per effettuare il match
        $feature_values = array();
        
        if($up_feature) {
            $product_features = Product::getFeaturesStatic($product['id_product']);
            $match_feature_key = array_search($up_feature, array_column($product_features, 'id_feature'));

            if($match_feature_key !== false) {
                array_push($feature_values, $product_features[$match_feature_key]['id_feature_value']);
            }        
        }

        // 3. Recupero la categoria per effettuare il match
        // 4. Recupero la lista di prodotti
        if(sizeof($feature_values) > 0 || $up_category) {
            $sql = new DbQuery();
            $sql->select('p.id_product');
            $sql->from('product', 'p');

            if(sizeof($feature_values) > 0) {
                $sql->innerJoin('feature_product', 'fp', 'p.id_product = fp.id_product');
                $sql->innerJoin('feature_value', 'fv', 'fp.id_feature_value = fv.id_feature_value'); 
                $sql->where('fv.id_feature_value IN (' . implode (", ", $feature_values) . ')');
            }

            if($up_category) {
                $sql->where('p.id_category_default = ' . $product['id_category_default']);
            }

            if($up_manufacturer) {
                $sql->where('p.id_manufacturer = ' . $product['id_manufacturer']);
            }

            if($up_limit && $up_limit > -1) {
                $sql->limit($up_limit);
            }

            $sql->where('p.id_product <> ' . $product['id_product']);
            $sql->orderBy('rand()');
            
            $results = Db::getInstance()->executeS($sql);
            $up_sell = $this->getProductForTemplates($results);
        }

        return $up_sell;
    }

    private function getProductForTemplates($products) {
        
        $assembler = new ProductAssembler($this->context);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $this->context->link
            ),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->context->getTranslator()
        );

        $productsForTemplate = array();


        if (is_array($products)) {
            foreach ($products as $productId) {
                $productsForTemplate[] = $presenter->present(
                    $presentationSettings,
                    $assembler->assembleProduct(array('id_product' => $productId['id_product'])),
                    $this->context->language
                );
            }
        }

        return $productsForTemplate;
        
    }

    private function getFeatureInfo($id_product, $id_feature) {
        $sql = new DbQuery();
        $sql->select('fl.name, fv.value');
        $sql->from('product', 'p');
        $sql->innerJoin('feature_product', 'fp', 'p.id_product = fp.id_product');
        $sql->innerJoin('feature_lang', 'fl', 'fp.id_feature = fl.id_feature AND fl.id_lang = ' . $this->context->language->id);
        $sql->innerJoin('feature_value_lang', 'fv', 'fp.id_feature_value = fv.id_feature_value AND fv.id_lang = ' . $this->context->language->id); 
        $sql->where('fp.id_feature =' . $id_feature . ' AND p.id_product = '. $id_product);

        return Db::getInstance()->getRow($sql);
    }
}
