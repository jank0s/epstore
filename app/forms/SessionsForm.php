<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';
require_once 'HTML/QuickForm2/Element/Button.php';


abstract class SessionsAbstractForm extends HTML_QuickForm2 {

    public $email;
    public $password;
    public $button;

    public function __construct($id) {
        parent::__construct($id);

        $this->setAttribute('class', 'form-signin');

        $this->email = new HTML_QuickForm2_Element_InputText('email');
        $this->email->setLabel('Email');
        $this->email->addRule('required', 'Manjka email');
        $this->email->setAttribute('class', 'form-control');
        $this->email->setAttribute('placeholder', 'Email');
        $this->addElement($this->email);

        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setLabel('Geslo');
        $this->password->addRule('required', 'Manjka geslo');
        $this->password->setAttribute('class', 'form-control');
        $this->password->setAttribute('placeholder', 'Geslo');
        $this->addElement($this->password);

        $this->button = new HTML_QuickForm2_Element_Button();
        $this->button->setAttribute('class', 'btn btn-lg btn-primary btn-block');
        $this->button->setAttribute('type', 'submit');
        $this->button->setValue('Prijava');
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

