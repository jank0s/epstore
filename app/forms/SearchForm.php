<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';
require_once 'HTML/QuickForm2/Element/Button.php';


class SearchForm extends HTML_QuickForm2 {

    public $search;
    public $button;

    public function __construct($id, $method = 'get') {
        parent::__construct($id, $method);

        $this->setAttribute('action', "/products");

        $this->setAttribute('class', 'form-signin');

        $this->search = new HTML_QuickForm2_Element_InputText('poizvedba');
        $this->search->addRule('required', 'Vnesi poizvedbo');
        $this->search->setAttribute('class', 'form-control');
        $this->search->setAttribute('placeholder', 'Iskanje');
        $this->addElement($this->search);

       
        $this->button = new HTML_QuickForm2_Element_InputSubmit('iskanje');
        $this->button->setValue('Search');
        $this->button->setAttribute('class', 'btn btn-primary btn-block');
        $this->button->setAttribute('value', 'Išči' );
        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}


