<?php
class MyModPayment extends PaymentModule
{
  public function __construct()
  {
    $this->name = 'mymodpayment';
    $this->tab = 'payments_gateways';
    $this->version = '0.1';
    $this->author = 'Vincent Jorge';
    $this->bootstrap = true;
    parent::__construct();
    $this->displayName = $this->l('MyMod payment');
    $this->description = $this->l('Module pour payer');
  }
  public function install()
  {
    if (!parent::install() ||
     !$this->registerHook('displayPayment') ||
     !$this->registerHook('displayPaymentReturn'))
      return false;
    return true;
  }
  public function hookDisplayPayment($params)
  {
    $controller = $this->getHookController('displayPayment');
    return $controller->run($params);
  }
  public function getHookController($hook_name)
  {
    require_once(dirname(__FILE__).'/controllers/hook/'.$hook_name.'.php');
    $controller_name = $this->name.$hook_name.'Controller';
    $controller = new $controller_name($this, __FILE__,$this->_path);
    return $controller;
  }
  public function getContent()
{
    $output = null;
 
    if (Tools::isSubmit('submit'.$this->name))
    {
        $my_module_name = strval(Tools::getValue('MYMODULE_NAME'));
        if (!$my_module_name  || empty($my_module_name) || !Validate::isGenericName($my_module_name))
            $output .= $this->displayError( $this->l('Invalid Configuration value') );
        else
        {
            Configuration::updateValue('MYMODULE_NAME', $my_module_name);
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }
    }
    return $output.$this->displayForm();
}
public function displayForm()
{
    // Get default Language
    $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
     
    // Init Fields form array
    $fields_form[0]['form'] = array(
        'legend' => array(
            'title' => $this->l('Settings'),
        ),
        'input' => array(
            array(
                'type' => 'text',
                'label' => $this->l('Configuration value'),
                'name' => 'MYMODULE_NAME',
                'size' => 20,
                'required' => true
            )
        ),
        'submit' => array(
            'title' => $this->l('Save'),
            'class' => 'button'
        )
    );
     
    $helper = new HelperForm();
     
    // Module, token and currentIndex
    $helper->module = $this;
    $helper->name_controller = $this->name;
    $helper->token = Tools::getAdminTokenLite('AdminModules');
    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
     
    // Language
    $helper->default_form_language = $default_lang;
    $helper->allow_employee_form_lang = $default_lang;
     
    // Title and toolbar
    $helper->title = $this->displayName;
    $helper->show_toolbar = true;        // false -> remove toolbar
    $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
    $helper->submit_action = 'submit'.$this->name;
    $helper->toolbar_btn = array(
        'save' =>
        array(
            'desc' => $this->l('Save'),
            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
            '&token='.Tools::getAdminTokenLite('AdminModules'),
        ),
        'back' => array(
            'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Back to list')
        )
    );
     
    // Load current value
    $helper->fields_value['MYMODULE_NAME'] = Configuration::get('MYMODULE_NAME');
     
    return $helper->generateForm($fields_form);
}
}