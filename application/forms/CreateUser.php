<?php

class Application_Form_CreateUser extends Zend_Form
{

	public function init(){
		
		$this-> setAction($_SERVER['PHP_SELF']);
		
		$firstName = new Zend_Form_Element_Text('inputFirstName');
		$firstName ->setName('inputFirstName')
				   ->setValue('Neuen Vornamen eintragen')
				   ->setAttrib('class', 'typeText')
					->setFilters(array('StringTrim','HtmlEntities','StripTags'))
				   ->addErrorMessage('Du musst eine gültige eMail-Adresse angeben!')
				   ->setAttrib('onclick', "this.value=''; this.onclick=null;");
		
		$lastName = new Zend_Form_Element_Text('inputLastName');		   
		$lastName ->setName('inputLastName')
				  ->setValue('Neuen Nachnamen eintragen')
				  ->setAttrib('class', 'typeText')
				  ->setFilters(array('StringTrim','HtmlEntities','StripTags'))
				  ->addErrorMessage('Du musst einen Nachnamen angeben!')
				  ->setAttrib('onclick', "this.value=''; this.onclick=null;");
				   
		$userName = new Zend_Form_Element_Text('inputUserName');		   
		$userName ->setName('inputUserName')
				  ->setValue('Einen Username eintragen')
				  ->setAttrib('class', 'typeText')
				  ->setFilters(array('StringTrim','HtmlEntities','StripTags'))
				  ->addErrorMessage('Du musst einen Username angeben!')
				  ->setAttrib('onclick', "this.value=''; this.onclick=null;");
				  
		$password = new Zend_Form_Element_Password('inputPassword');		   
		$password ->setName('inputPassword')
				  ->setValue('Einen Username eintragen')
				  ->setAttrib('class', 'typeText')
				  ->setFilters(array('StringTrim','HtmlEntities','StripTags'))
				  ->addErrorMessage('Du musst einen Username angeben!')
				  ->setAttrib('onclick', "this.value=''; this.onclick=null;");
		
				  
		$submitBtn = new Zend_Form_Element_Submit('inputSubmit');
		$submitBtn	->setName('inputSubmit');
		
		$this->addElements(array(
				$firstName,
				$lastName,
				$userName,
				$password,
				$submitBtn
			)
		);

		/*$this->setElementDecorators(array(	'ViewHelper',
											'Errors'));
	*/
	}


}