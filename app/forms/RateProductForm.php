<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';
require_once 'HTML/QuickForm2/Element/Button.php';
require_once 'HTML/QuickForm2/Element/Select.php';

class RateProductForm extends HTML_QuickForm2 {

    public $rating;
    public $button;

    public function __construct($id, $method = 'post') {
        parent::__construct($id, $method);

        $this->setAttribute('action', "#");

        $this->setAttribute('class', 'form-signin');

        $this->rating = new HTML_QuickForm2_Element_Select('rating_value');
        $this->rating->addRule('required', 'Izberi oceno!');
        $this->rating->setAttribute('class', 'form-control');
        $this->rating->addOption(1, 1);
        $this->rating->addOption(2, 2);
        $this->rating->addOption(3, 3);
        $this->rating->addOption(4, 4);
        $this->rating->addOption(5, 5);
        $this->rating->addRule('gte', 'Ocena mora biti višja od 0', 0);
        $this->rating->addRule('lte', 'Ocena mora biti nižja od 6', 6);
        $this->addElement($this->rating);

       
        $this->button = new HTML_QuickForm2_Element_InputSubmit('oceni');
        $this->button->setValue('Oceni');
        $this->button->setAttribute('class', 'btn btn-primary btn-block');
        $this->button->setAttribute('value', 'Oceni');
        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}


