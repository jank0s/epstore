<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';
require_once 'HTML/QuickForm2/Element/Button.php';
require_once 'HTML/QuickForm2/Element/InputImage.php';


class ImageForm extends HTML_QuickForm2 {

    public $image;
    public $button;

    public function __construct($id, $method = 'post') {
        parent::__construct($id, $method);

        $this->setAttribute('action', "#");

        $this->setAttribute('class', 'form-signin');

        $this->image = new HTML_QuickForm2_Element_InputImage('poizvedba');
        $this->image->addRule('required', 'Izberi sliko');
        $this->image->setAttribute('class', 'form-control');
        $this->image->setAttribute('placeholder', 'Dodaj');
        $this->addElement($this->image);

       
        $this->button = new HTML_QuickForm2_Element_InputSubmit('Dodaj');
        $this->button->setValue('Dodaj');
        $this->button->setAttribute('class', 'btn btn-primary btn-block');
        $this->button->setAttribute('value', 'Dodaj' );
        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}


