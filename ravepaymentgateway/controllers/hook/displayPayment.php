<?php

  /**
   * Display Payment Controller
   */

  class RavePaymentGatewayDisplayPaymentController
  {
    public function __construct($module, $file, $path)
    {

      $this->file = $file;
      $this->module = $module;
      $this->context = Context::getContext();
      $this->_path = $path;
      $this->context->cookie->base_url = 'https://ravesandboxapi.flutterwave.com';

    }

    public function run ()
    {
      $go_live = Configuration::get('RAVE_GO_LIVE');

      $publicKey = Configuration::get('RAVE_TEST_PUBLIC_KEY');

      if ( $go_live ) {
        $this->context->cookie->base_url = 'https://api.ravepay.co';
        $publicKey = Configuration::get('RAVE_LIVE_PUBLIC_KEY');
      }

      $currency_order = new Currency($this->context->cart->id_currency);
      $customer = new Customer($this->context->cart->id_customer);
      $this->context->smarty->assign(array(
        'pb_key'  => $publicKey,
        'title'   => Configuration::get('RAVE_MODAL_TITLE'),
        'desc'    => Configuration::get('RAVE_MODAL_DESC'),
        'logo'    => Configuration::get('RAVE_MODAL_LOGO'),
        'currency'=> $currency_order->iso_code,
        'country' => Configuration::get('RAVE_COUNTRY'),
        'txref'   => "PS_" . $this->context->cart->id . '_' . time(),
        'amount'  => (float)$this->context->cart->getOrderTotal(true, Cart::BOTH),
        'customer_email' => $customer->email,
      ));
      $this->context->controller->addCSS($this->_path.'views/css/ravepaymentgateway.css', 'all');
      $this->context->controller->addJS($this->context->cookie->base_url . '/flwv3-pug/getpaidx/api/flwpbf-inline.js');
      $this->context->controller->addJS($this->_path.'views/js/rave.js');
      return $this->module->display($this->file, 'displayPayment.tpl');
    }
  }

