<?php
class MyModPaymentPaymentModuleFrontController extends ModuleFrontController
{
  public $ssl = true;

  public function initContent()
  {
  	$this->display_column_left = false;
	$this->display_column_right = false;
    // Call parent init content method
    parent::initContent();
    
    // Set template
    $this->setTemplate('payment.tpl');
    // Check if currency is accepted
    if (!$this->checkCurrency())
    	//Tools::redirect('index.php?controller=order');
    // Assign data to Smarty
    var_dump($this->context->cart->getProducts());
    $this->context->smarty->assign(array(
    	'nb_products' => $this->context->cart->getProducts(),
    	'cart_currency' => $this->context->cart->id_currency,
      'email' => $this->context->
    	'currencies' => $this->module->getCurrency((int)$this->context->cart->id_currency),
    	'path' => $this->module->getPathUri(),
    	));
  }
  private function checkCurrency()
  {
  // Get cart currency and enabled currencies for this module
  	$currency_order = new Currency($this->context->cart->id_currency);
  	$currencies_module = $this->module->getCurrency($this->context->cart->id_currency);

  // Check if cart currency is one of the enabled currencies
  	if (is_array($currencies_module))
  		foreach ($currencies_module as $currency_module)
  			if ($currency_order->id == $currency_module['id_currency'])
  				return true;

  // Return false otherwise
  			return false;
  	}

}