<?php

class MyModPaymentDisplayPaymentController
{
  public function __construct($module, $file, $path)
  {
    $this->file = $file;
    $this->module = $module;
    $this->context = Context::getContext();
    $this->_path = $path;
  }

  public function run($params)
  {
    global $smarty; 
  $sql = 'SELECT value FROM `'._DB_PREFIX_.'configuration` WHERE name = "MYMODULE_NAME"';
  $sql1 = Db::getInstance()->executeS($sql);
  $smarty->assign('mail', $sql1[0]['value']);
    $this->context->controller->addCSS($this->_path.'views/css/mymodpayment.css', 'all');
    return $this->module->display($this->file,
    'displayPayment.tpl');
  }
}