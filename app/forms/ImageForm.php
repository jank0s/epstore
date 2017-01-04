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
require_once 'HTML/QuickForm2/Element/InputFile.php';


class ImageForm extends HTML_QuickForm2 {
    
    public $file;
    public $image;
    public $button;

    public function __construct($id, $method = 'post') {
        parent::__construct($id, $method);

        $this->setAttribute('action', "#");
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-signin');

        $this->file = new HTML_QuickForm2_Element_InputFile("image_path");
        $this->file->setLabel("Naloži sliko");
        
        $this->file->addRule('mimetype', 'Dovoljeni formati: gif, png, jpeg',
                 array('image/gif', 'image/png', 'image/jpeg'));
        $this->file->addRule('maxfilesize', 'Datoteka je prevelika, dovoljena velikost je 400kB', 409600);
        $this->file->addRule('required', 'Izberi datoteko!');
        $this->addElement($this->file);

       
        $this->button = new HTML_QuickForm2_Element_InputSubmit('Dodaj');
        $this->button->setValue('Dodaj');
        $this->button->setAttribute('class', 'btn btn-primary btn-block');
        $this->button->setAttribute('value', 'Dodaj' );
        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }
}


