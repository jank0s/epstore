<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'model/RoleDB.php';


abstract class ProductsAbstractForm extends HTML_QuickForm2 {
    /*
  DB Params:   
  `product_id` 
  `product_name` 
  `product_description` 
  `product_price` 
  `product_rating` 
  `product_valid` 
     */
    public $name;
    public $description;
    public $price;
    
    public function __construct($id) {
        parent::__construct($id);
        
        $this->setAttribute("class", "form-edit");
        
        $this->name = new HTML_QuickForm2_Element_InputText('product_name');
        $this->name->setAttribute('size', 30);
        $this->name->setLabel('Ime izdelka:');
        $this->name->addRule('required', 'Vnesite ime.');
        $this->name->addRule('maxlength', 'Ime naj bo krajše od 255 znakov.', 255);
        $this->addElement($this->name);
        
        $this->price = new HTML_QuickForm2_Element_InputText('product_price');
        $this->price->setAttribute('size', 8);
        $this->price->setLabel('Cena (€)');
        $this->price->addRule('required', 'Vnesite ceno.');
        $this->price->addRule('maxlength', 'Opis naj bo krajši od 1000 znakov.', 1000);
        $this->addElement($this->price);
        
        $this->description = new HTML_QuickForm2_Element_Textarea('product_description');
        $this->description->setAttribute('rows', 10);
        $this->description->setAttribute('cols', 60);
        $this->description->setLabel('Opis:');
        $this->description->addRule('required', 'Vnesite opis.');
        $this->description->addRule('maxlength', 'Opis naj bo krajši od 1000 znakov.', 1000);
        $this->addElement($this->description);
        
       

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}

class EditProductForm extends ProductsAbstractForm {

    public function __construct($id)
    {
        parent::__construct($id);

        
        $this->button = new HTML_QuickForm2_Element_InputSubmit('edit');
        $this->button->setValue('Edit');
        $this->button->setAttribute('class', 'btn btn-primary pull-right');
        $this->button->setAttribute('value', 'Posodobi');
        $this->addElement($this->button);
    }
}


class AddProductForm extends ProductsAbstractForm {

    public function __construct($id)
    {
        parent::__construct($id);

        $this->button = new HTML_QuickForm2_Element_InputSubmit('add');
        $this->button->setValue('Add');
        $this->button->setAttribute('class', 'btn btn-primary pull-right');
        $this->button->setAttribute('value', 'Dodaj');
        $this->addElement($this->button);
    }
}


