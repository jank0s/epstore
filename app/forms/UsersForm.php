<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';
require_once 'HTML/QuickForm2/Element/Button.php';


abstract class UsersAbstractForm extends HTML_QuickForm2 {

    public $email;
    public $name;
    public $surname;
    public $password;
    public $phone;
    public $role_id;
    public $user_address;
    public $user_post;
    public $user_city;
    public $user_country;

    public $button;

    public function __construct($id) {
        parent::__construct($id);

        $this->setAttribute('class', 'form-register');

        $this->email = new HTML_QuickForm2_Element_InputText('email');
        $this->email->setLabel('Email:');
        $this->email->addRule('required', 'Manjka email');
        $this->email->setAttribute('class', 'form-control');
        $this->addElement($this->email);

        $this->name = new HTML_QuickForm2_Element_InputText('name');
        $this->name->setLabel('Ime:');
        $this->name->addRule('required', 'Manjka ime');
        $this->name->setAttribute('class', 'form-control');
        $this->addElement($this->name);

        $this->surname = new HTML_QuickForm2_Element_InputText('surname');
        $this->surname->setLabel('Priimek:');
        $this->surname->addRule('required', 'Manjka priimek');
        $this->surname->setAttribute('class', 'form-control');
        $this->addElement($this->surname);

        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setLabel('Geslo');
        $this->password->addRule('required', 'Manjka geslo');
        $this->password->setAttribute('class', 'form-control');
        $this->addElement($this->password);

        $this->phone = new HTML_QuickForm2_Element_InputText('phone');
        $this->phone->setLabel('Telefon:');
        $this->phone->addRule('required', 'Manjka ptelefon');
        $this->phone->setAttribute('class', 'form-control');
        $this->addElement($this->phone);

        $this->user_address = new HTML_QuickForm2_Element_InputText('user_address');
        $this->user_address->setLabel('Ulica in hišna št.:');
        $this->user_address->addRule('required', 'Manjka ulica in hišna št.');
        $this->user_address->setAttribute('class', 'form-control');
        $this->addElement($this->user_address);

        $this->user_post = new HTML_QuickForm2_Element_InputText('user_post');
        $this->user_post->setLabel('Poštna št:');
        $this->user_post->addRule('required', 'Manjka potšna št.');
        $this->user_post->setAttribute('class', 'form-control');
        $this->addElement($this->user_post);

        $this->user_city = new HTML_QuickForm2_Element_InputText('user_city');
        $this->user_city->setLabel('Kraj:');
        $this->user_city->addRule('required', 'Manjka kraj');
        $this->user_city->setAttribute('class', 'form-control');
        $this->addElement($this->user_city);

        $this->user_country = new HTML_QuickForm2_Element_InputText('user_country');
        $this->user_country->setLabel('Država:');
        $this->user_country->addRule('required', 'Manjka država');
        $this->user_country->setAttribute('class', 'form-control');
        $this->addElement($this->user_country);


        $this->button = new HTML_QuickForm2_Element_InputSubmit('register');
        $this->button->setValue('Registracija');
        $this->button->setAttribute('class', 'btn btn-primary');
        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}

class RegisterForm extends UsersAbstractForm {

    public function __construct($id)
    {
        parent::__construct($id);

        $this->button->setAttribute('value', 'Registracija');
    }
}

