<?php

  /**
   * Front Payment Controller
   */

  class RavePaymentGatewayPaymentModuleFrontController extends ModuleFrontController
  {
    public $ssl = true;

    public function initContent()
    {

      $this->display_column_left = false;
      $this->display_column_right = false;
      parent::initContent();

      if (!$this->checkCurrency())
        Tools::redirect('index.php?controller=order');

      $go_live = Configuration::get('RAVE_GO_LIVE');

      $publicKey = Configuration::get('RAVE_TEST_PUBLIC_KEY');
      $this->context->cookie->base_url = 'https://ravesandboxapi.flutterwave.com';

      if ( $go_live ) {
        $this->context->cookie->base_url = 'https://api.ravepay.co';
        $publicKey = Configuration::get('RAVE_LIVE_PUBLIC_KEY');
      }


      $publicKey = str_replace(' ', '', $publicKey);

      $currency_order = new Currency($this->context->cart->id_currency);
      $customer = new Customer($this->context->cart->id_customer);

      $all_products = self::$cart->getProducts();

      $this->context->smarty->assign(array(
        'nb_products' => $this->context->cart->nbProducts(),
        'cart_currency' => $this->context->cart->id_currency,
        'currencies' => $this->module->getCurrency((int)$this->context->cart->id_currency),
        'total_amount'=> $this->context->cart->getOrderTotal(true, Cart::BOTH),
        'path' => $this->module->getPathUri(),
        'pb_key'  => $publicKey,
        'title'   => Configuration::get('RAVE_MODAL_TITLE'),
        'desc'    => Configuration::get('RAVE_MODAL_DESC'),
        'logo'    => Configuration::get('RAVE_MODAL_LOGO'),
        'currency'=> $currency_order->iso_code,
        'country' => Configuration::get('RAVE_COUNTRY'),
        'txref'   => "PS_" . $this->context->cart->id . '_' . time(),
        'amount'  => (float)$this->context->cart->getOrderTotal(true, Cart::BOTH),
        'customer_email' => $customer->email,
        'products' => $all_products,
      ));

      $this->context->controller->addJS($this->context->cookie->base_url . '/flwv3-pug/getpaidx/api/flwpbf-inline.js');
      $this->context->controller->addJS($this->module->getLocalPath().'views/js/rave.js');
      $this->setTemplate('payment.tpl');
    }

    private function checkCurrency()
    {

      $currency_order = new Currency($this->context->cart->id_currency);
      $currencies_modules = $this->module->getCurrency($this->context->cart->id_currency);

      if (is_array($currencies_modules)) {
        foreach ($currencies_modules as $currency_module) {
          if ($currency_order->id == $currency_module['id_currency']) {
            return true;
          }
        }

        return false;
      }
    }
  }
