<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" accept-charset="ISO-8859-1">
   <input type="hidden" name="cmd" value="_xclick">
   <input name="currency_code" type="hidden" value="EUR" />
   <input type="hidden" name="business" value="{$mail}">
   <input name="return" type="hidden" value="{$link->getModuleLink('mymodpayment', 'validation', [], true)|escape:'html'}" />
   <input name="cancel_return" type="hidden" value="{$link->getModuleLink('mymodpayment', 'annulation', [], true)|escape:'html'}" />
   <input name="notify_url" type="hidden" value="{$link->getModuleLink('mymodpayment', 'validation', [], true)|escape:'html'}" />
      {foreach from=Context::getContext()->cart->getProducts(true) key=k item=produtos}
   <input type="hidden" class="large clicked" name="item_name" value="{$k}: {$item}">
   {/foreach}
   <input type="hidden" name="amount" value="{Context::getContext()->cart->getOrderTotal(true)}">
   <input name="lc" type="hidden" value="FR" />
   <button class="button btn btn-default button-medium" type="submit">
       <span>Payer ma commande avec Paypal (Payement sécurisé)<i class="icon-chevron-right right"></i></span>
   </button>
</form>