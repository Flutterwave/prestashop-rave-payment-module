<?php

  /**
   * Get Content Controller Class
   */

class RavePaymentGatewayGetContentController
{
  public function __construct($module, $file, $path)
  {
    $this->file = $file;
    $this->module = $module;
    $this->context = Context::getContext();
    $this->_path = $path;
  }

  public function processConfiguration()
  {
    if (Tools::isSubmit('ravepaymentgateway_form'))
    {
      Configuration::updateValue('RAVE_COUNTRY', Tools::getValue('RAVE_COUNTRY'));
      Configuration::updateValue('RAVE_LIVE_PUBLIC_KEY', Tools::getValue('RAVE_LIVE_PUBLIC_KEY'));
      Configuration::updateValue('RAVE_LIVE_SECRET_KEY', Tools::getValue('RAVE_LIVE_SECRET_KEY'));
      Configuration::updateValue('RAVE_TEST_PUBLIC_KEY', Tools::getValue('RAVE_TEST_PUBLIC_KEY'));
      Configuration::updateValue('RAVE_TEST_SECRET_KEY', Tools::getValue('RAVE_TEST_SECRET_KEY'));
      Configuration::updateValue('RAVE_GO_LIVE', Tools::getValue('RAVE_GO_LIVE'));
      Configuration::updateValue('RAVE_MODAL_TITLE', Tools::getValue('RAVE_MODAL_TITLE'));
      Configuration::updateValue('RAVE_MODAL_DESC', Tools::getValue('RAVE_MODAL_DESC'));
      Configuration::updateValue('RAVE_MODAL_LOGO', Tools::getValue('RAVE_MODAL_LOGO'));
      $this->context->smarty->assign('confirmation', 'ok');
    }
  }

  public function renderForm()
  {
    $golive_option = array(
      array(
        'id'    => 'GO_LIVE',
        'name'  => $this->module->l('Switch to live account'),
        'val'   => 1
      ),
    );

    $rave_countries = array(
      array(
        'id'    => 'NG',
        'name'  => $this->module->l('Nigeria'),
        'val'   => 'NG'
      ),
      array(
        'id'    => 'GH',
        'name'  => $this->module->l('Ghana'),
        'val'   => 'GH'
      ),
      array(
        'id'    => 'KE',
        'name'  => $this->module->l('Kenya'),
        'val'   => 'KE'
      ),
      array(
        'id'    => 'ZA',
        'name'  => $this->module->l('South Africa'),
        'val'   => 'ZA'
      )
    );

    $inputs = array(
      array(
        'name'  => 'RAVE',
        'label' => $this->module->l('Go Live'),
        'desc'  => 'Switch to live credentials (Live Public and Secret Key)',
        'type'  => 'checkbox',
        'values'=> array(
          'query' => $golive_option ,
          'id'    => 'id',
          'name'  => 'name'
        )
      ),
      array(
        'name'  => 'RAVE_COUNTRY',
        'label' => $this->module->l('Merchant Country'),
        'desc'  => $this->module->l('Your country'),
        'type'  => 'select',
        'required' => true,
        'options'=> array(
          'query' => $rave_countries ,
          'id'    => 'id',
          'name'  => 'name'
        )
      ),
      array(
        'name'  => 'RAVE_LIVE_PUBLIC_KEY',
        'label' => $this->module->l('Rave Live Public Key'),
        'desc'  => 'Your live public key',
        'type'  => 'text'
      ),
      array(
        'name'  => 'RAVE_LIVE_SECRET_KEY',
        'label' => $this->module->l('Rave Live Secret Key'),
        'desc'  => 'Your live secret key',
        'type'  => 'text'
      ),
      array(
        'name'  => 'RAVE_TEST_PUBLIC_KEY',
        'label' => $this->module->l('Rave Test Public Key'),
        'desc'  => 'Your test public key',
        'type'  => 'text'
      ),
      array(
        'name'  => 'RAVE_TEST_SECRET_KEY',
        'label' => $this->module->l('Rave Test Secret Key'),
        'desc'  => 'Your test secret key',
        'type'  => 'text'
      ),
      array(
        'name'  => 'RAVE_MODAL_TITLE',
        'label' => $this->module->l('Modal Title'),
        'desc'  => '(Optional) default: FLW PAY',
        'type'  => 'text'
      ),
      array(
        'name'  => 'RAVE_MODAL_DESC',
        'label' => $this->module->l('Modal Description'),
        'desc'  => '(Optional) default: FLW PAY MODAL',
        'type'  => 'text'
      ),
      array(
        'name'  => 'RAVE_MODAL_LOGO',
        'label' => $this->module->l('Modal Logo'),
        'desc'  => "(Optional) - Full URL (with 'http') to the custom logo. default: Rave logo",
        'type'  => 'text'
      ),
    );

    $fields_form = array(
      'form' => array(
        'legend' => array(
          'title' => $this->module->l('Rave payment gateway module configuration'),
          'icon' => 'icon-wrench'
        ),
        'input' => $inputs,
        'submit' => array('title' => $this->module->l('Save'))
      )
    );

    $helper = new HelperForm();
    $helper->table = 'mymodpayment';
    $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
    $helper->allow_employee_form_lang = (int)Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
    $helper->submit_action = 'ravepaymentgateway_form';
    $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->module->name.'&tab_module='.$this->module->tab.'&module_name='.$this->module->name;
    $helper->token = Tools::getAdminTokenLite('AdminModules');
    $helper->tpl_vars = array(
      'fields_value' => array(
        'RAVE_COUNTRY' => Tools::getValue('RAVE_COUNTRY', Configuration::get('RAVE_COUNTRY')),
        'RAVE_LIVE_PUBLIC_KEY' => Tools::getValue('RAVE_LIVE_PUBLIC_KEY', Configuration::get('RAVE_LIVE_PUBLIC_KEY')),
        'RAVE_LIVE_SECRET_KEY' => Tools::getValue('RAVE_LIVE_SECRET_KEY', Configuration::get('RAVE_LIVE_SECRET_KEY')),
        'RAVE_TEST_PUBLIC_KEY' => Tools::getValue('RAVE_TEST_PUBLIC_KEY', Configuration::get('RAVE_TEST_PUBLIC_KEY')),
        'RAVE_TEST_SECRET_KEY' => Tools::getValue('RAVE_TEST_SECRET_KEY', Configuration::get('RAVE_TEST_SECRET_KEY')),
        'RAVE_GO_LIVE' => Tools::getValue('RAVE_GO_LIVE', Configuration::get('RAVE_GO_LIVE')),
        'RAVE_MODAL_TITLE' => Tools::getValue('RAVE_MODAL_TITLE', Configuration::get('RAVE_MODAL_TITLE')),
        'RAVE_MODAL_DESC' => Tools::getValue('RAVE_MODAL_DESC', Configuration::get('RAVE_MODAL_DESC')),
        'RAVE_MODAL_LOGO' => Tools::getValue('RAVE_MODAL_LOGO', Configuration::get('RAVE_MODAL_LOGO')),
      ),
      'languages' => $this->context->controller->getLanguages()
    );

    return $helper->generateForm(array($fields_form));
  }

  public function run()
  {
    $this->processConfiguration();
    $html_confirmation_message = $this->module->display($this->file, 'getContent.tpl');
    $html_form = $this->renderForm();
    return $html_confirmation_message.$html_form;
  }
}
