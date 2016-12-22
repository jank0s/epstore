<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';
require_once 'HTML/QuickForm2/Element/Button.php';
require_once 'HTML/QuickForm2/Element/Captcha/ReCaptcha.php';


abstract class UsersAbstractForm extends HTML_QuickForm2 {

    public $email;
    public $name;
    public $surname;
    public $password;
    public $repeat_password;
    public $phone;
    public $role_id;
    public $user_address;
    public $user_post;
    public $user_city;
    public $user_country;
    public $captcha;

    public $button;

    public function __construct($id) {
        parent::__construct($id);

        $this->setAttribute('class', 'form-register');

        $this->email = new HTML_QuickForm2_Element_InputText('email');
        $this->email->setLabel('Email:');
        $this->email->addRule('required', 'Vnesite email.');
        $this->email->setAttribute('class', 'form-control');
        $this->email->addRule('callback', 'Vnesite veljaven elektronski naslov.', array(
                'callback' => 'filter_var',
                'arguments' => array(FILTER_VALIDATE_EMAIL))
        );
        $this->addElement($this->email);

        $this->name = new HTML_QuickForm2_Element_InputText('name');
        $this->name->setLabel('Ime:');
        $this->name->addRule('required', 'Vnesite ime.');
        $this->name->setAttribute('class', 'form-control');
        $this->name->addRule('regex', 'Pri imenu uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
        $this->name->addRule('maxlength', 'Ime naj bo krajše od 255 znakov.', 255);
        $this->addElement($this->name);

        $this->surname = new HTML_QuickForm2_Element_InputText('surname');
        $this->surname->setLabel('Priimek:');
        $this->surname->addRule('required', 'Vnesite priimek.');
        $this->surname->setAttribute('class', 'form-control');
        $this->surname->addRule('regex', 'Pri priimku uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ\- ]+$/');
        $this->surname->addRule('maxlength', 'Priimek naj bo krajši od 255 znakov.', 255);
        $this->addElement($this->surname);

        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setLabel('Geslo:');
        $this->password->addRule('required', 'Vnesite geslo.');
        $this->password->setAttribute('class', 'form-control');
        $this->password->addRule('minlength', 'Geslo naj vsebuje vsaj 6 znakov.', 6);
        $this->password->addRule('regex', 'V geslu uporabite vsaj 1 številko.', '/[0-9]+/');
        $this->addElement($this->password);

        $this->repeat_password = new HTML_QuickForm2_Element_InputPassword('repeat_password');
        $this->repeat_password->setLabel('Ponovitev gesla:');
        $this->repeat_password->addRule('eq', 'Gesli se ne ujamata.', $this->password);
        $this->repeat_password->addRule('required', 'Ponovno vnesite izbrano geslo.');
        $this->repeat_password->setAttribute('class', 'form-control');
        $this->addElement($this->repeat_password);

        $this->phone = new HTML_QuickForm2_Element_InputText('phone');
        $this->phone->setLabel('Telefon:');
        $this->phone->addRule('required', 'Vnesite telefon.');
        $this->phone->setAttribute('class', 'form-control');
        $this->addElement($this->phone);

        $this->user_address = new HTML_QuickForm2_Element_InputText('user_address');
        $this->user_address->setLabel('Ulica in hišna št.:');
        $this->user_address->addRule('required', 'Vnesite ulico in hišna št.');
        $this->user_address->setAttribute('class', 'form-control');
        $this->user_address->addRule('regex', 'Uporabiti smete le črke, številke in presledek.', '/^[a-zA-ZščćžŠČĆŽ 0-9]+$/');
        $this->user_address->addRule('maxlength', 'Vnos naj bo krajši od 255 znakov.', 255);
        $this->addElement($this->user_address);

        $this->user_post = new HTML_QuickForm2_Element_InputText('user_post');
        $this->user_post->setLabel('Poštna št:');
        $this->user_post->addRule('required', 'Vnesite poštno št.');
        $this->user_post->setAttribute('class', 'form-control');
        $this->addElement($this->user_post);

        $this->user_city = new HTML_QuickForm2_Element_InputText('user_city');
        $this->user_city->setLabel('Kraj:');
        $this->user_city->addRule('required', 'Vnesite kraj');
        $this->user_city->setAttribute('class', 'form-control');
        $this->addElement($this->user_city);

        $this->user_country = new HTML_QuickForm2_Element_InputText('user_country');
        $this->user_country->setLabel('Država:');
        $this->user_country->addRule('required', 'Vnesite državo');
        $this->user_country->setAttribute('class', 'form-control');
        $this->addElement($this->user_country);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}

class RegisterUserForm extends UsersAbstractForm {

    public function __construct($id)
    {
        parent::__construct($id);

        $this->captcha = new HTML_QuickForm2_Element_Captcha_ReCaptcha(
            'captcha[recaptcha]',
            array('id' => 'captcha_recaptcha'),
            array(
                'label' => 'ReCaptcha',
                'public-key'  => '6LdoaA8UAAAAAN6ttm_N-4GQ9chkl-BqAlOVm0Y5',
                'private-key' => '6LdoaA8UAAAAAGxGH1xAfgEMlNJegCmeGMcccRAv'
            )
        );
        $this->addElement($this->captcha);

        $this->button = new HTML_QuickForm2_Element_InputSubmit('register');
        $this->button->setValue('Registracija');
        $this->button->setAttribute('class', 'btn btn-primary pull-right');
        $this->button->setAttribute('value', 'Registracija');
        $this->addElement($this->button);
    }
}

class CreateUserForm extends UsersAbstractForm {

    public function __construct($id)
    {
        parent::__construct($id);

        $this->captcha = new HTML_QuickForm2_Element_Captcha_ReCaptcha(
            'captcha[recaptcha]',
            array('id' => 'captcha_recaptcha'),
            array(
                'label' => 'ReCaptcha',
                'public-key'  => '6LdoaA8UAAAAAN6ttm_N-4GQ9chkl-BqAlOVm0Y5',
                'private-key' => '6LdoaA8UAAAAAGxGH1xAfgEMlNJegCmeGMcccRAv'
            )
        );
        $this->addElement($this->captcha);

        $this->button = new HTML_QuickForm2_Element_InputSubmit('register');
        $this->button->setValue('Registracija');
        $this->button->setAttribute('class', 'btn btn-primary pull-right');
        $this->button->setAttribute('value', 'Registracija');
        $this->addElement($this->button);
    }
}

