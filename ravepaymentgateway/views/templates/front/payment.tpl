{capture name=path}
  {l s='Rave Payment Gateway' mod='ravepaymentgateway'}
{/capture}

<h1 class="page-heading">
  {l s='Order summary' mod='ravepaymentgateway'}
</h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nb_products <= 0}
  <p class="alert alert-warning">
    {l s='Your shopping cart is empty.' mod='ravepaymentgateway'}
  </p>
{else}
  <form action="{$link->getModuleLink('ravepaymentgateway', 'validation', [], true)|escape:'html'}" method="post">
    <div class="box cheque-box">
      <h3 class="page-subheading">
        {l s='Rave Payment Gateway' mod='ravepaymentgateway'}
      </h3>
      <p class="cheque-indent">
        <strong class="dark">
          {l s='You have chosen to pay with Rave.' mod='ravepaymentgateway'} {l s='Here is a short summary of your order:' mod='ravepaymentgateway'}
        </strong>
      </p>
      <p>
      - {l s='The total amount of your order is' mod='ravepaymentgateway'}
        <span id="amount" class="price">{displayPrice price=$total_amount}</span>
        {if $use_taxes == 1}
          {l s='(tax incl.)' mod='ravepaymentgateway'}
        {/if}
      </p>
    -
      {if $currencies|@count > 1}
        {l s='We allow several currencies to be sent via Rave.' mod='ravepaymentgateway'}
        <div class="form-group">
          <label>{l s='Choose one of the following:' mod='ravepaymentgateway'}</label>
          <select id="currency_payment" class="form-control" name="currency_payment">
            {foreach from=$currencies item=currency}
              <option value="{$currency.id_currency}" {if $currency.id_currency == $cart_currency}selected="selected"{/if}>
                {$currency.name}
              </option>
            {/foreach}
          </select>
        </div>
      {else}
        {l s='We allow the following currency to be sent via Rave Payment Gateway:' mod='ravepaymentgateway'}&nbsp;<b>{$currencies.0.name}</b>
        <input type="hidden" name="currency_payment" value="{$currencies.0.id_currency}" />
      {/if}


      <br />
      <br />
      ITEMS:

      {foreach from=$products item=product}
      <p>
        {$product.name} x <b>{$product.cart_quantity}</b> -  {displayPrice price=$product.total_wt}
      </p>
      {/foreach}

      <br />
      <p>
        - {l s='Rave payment gateway account information will be displayed on the next page.' mod='ravepaymentgateway'}
        <br />
        - {l s='Please confirm your order by clicking "I confirm my order."' mod='ravepaymentgateway'}.
      </p>
    </div><!-- .cheque-box -->

    <p class="cart_navigation clearfix" id="cart_navigation">
    <a
        class="button-exclusive btn btn-default"
        href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}">
      <i class="icon-chevron-left"></i>
      {l s='Other payment methods' mod='ravepaymentgateway'}
    </a>
    <button
        class="button btn btn-default button-medium rave-payment-gateway"
        type="button">
      <span>
        {l s='I confirm my order' mod='ravepaymentgateway'}
        <i class="icon-chevron-right right"></i>
      </span>
    </button>
    <script>
    
    </script>
    <script type="text/javascript">
        $('.rave-payment-gateway').click(function() {
          var config = {
            amount : "{$amount}",
            custom_description: "{$desc}",
            custom_logo   : "{$logo}",
            custom_title  : "{$title}",
            PBFPubKey : "{$pb_key}",
            currency  : "{$currency}",
            country   : "{$country}",
            txref     : "{$txref}",
            customer_email: "{$customer_email}",
            cbUrl : "{$link->getModuleLink('ravepaymentgateway', 'validation', [], true)}",
          };

          processPayment(config);
        });
    </script>
  </form>
{/if}








