<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';

abstract class ProductsAbstractForm extends HTML_QuickForm2 {


    public function __construct($id) {
        parent::__construct($id);

    }

}

class BooksInsertForm extends BooksAbstractForm {

    public function __construct($id)
    {
        parent::__construct($id);

    }
}

