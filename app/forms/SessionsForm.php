<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';

abstract class SessionsAbstractForm extends HTML_QuickForm2 {

    public $email;
    public $password;
    public $button;

    public function __construct($id) {
        parent::__construct($id);

        $this->email = new HTML_QuickForm2_Element_InputText('email');
        $this->email->setAttribute('size', 70);
        $this->email->setLabel('Email');
        $this->email->addRule('required', 'Vpisi email');
        $this->addElement($this->email);

        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setAttribute('size', 70);
        $this->password->setLabel('Geslo');
        $this->password->addRule('required', 'Vpisi geslo');
        $this->addElement($this->password);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}

class LoginForm extends SessionsAbstractForm {

    public function __construct($id)
    {
        parent::__construct($id);

    }
}

