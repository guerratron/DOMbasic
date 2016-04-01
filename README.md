# DOMbasic #
[![dombasic logo](assets/DOMbasic_logo.png "DOMbasic GitHub page")](http://guerratron.github.io/DOMbasic "DOMbasic page")  
_DOMbasic. Juan José Guerra Haba - 2014 - dinertron@gmail.com  
dombasic-full@lists.osdn.me - dombasic-private@lists.osdn.me_

## DEFINITION: ##
PHP package to create dynamic __DOM__ elements.  
It follow the __OOP__ paradigm, implemented __SINGLETON__ patterns, _magical_ methods, contains error control ('own exceptions'), _chaining_ methods, optimized memory and resources, ...  

## EXPLANATORY: ##
More flexible and lighter than the native __PHP__. It allows you to create any document labeling: _HTML, XHTML, XML, ..._ 
including any user-defined (this includes those who are yet to be implemented) that are based on hierarchies of tags, 
attributes and content; this You can be achieved simply by modifying the constants file specify, opening and closing 
tags and a couple of other modifications.  

You can create complete websites that adhere to the standards validation of its structure. A tree harbor the only 
variable element created, this includes visible elements (__BODY__) and invisible (__HEAD__), static (_HTML_) and 
dynamic (__SCRIPTS__:. EG _Javascript_), elements and positioning structure (_xHTML_) or style (_CSS_) ...  

Although there are other ways to achieve the same (text variables, other _APIs_, ...) This method is designed for 
flexibility and dynamism, performance and low resource consumption.  
Once you understand the mechanism and its syntax, saving time and effort, errors are minimized and __DOM__ construction 
and automated cleaner is achieved.   
We all know the problems that can be generated when processing a Web page on the fly successive chaining
_'Echo, print, ... "_ making sure that the headers are not sent in advance; these errors multiplied by a thousand if 
we use Frameworks or type _CMS_ (_Joomla, Wordpress, Drupal, ..._)  

## FEATURES: ##
  * They have been implemented utility functions that allow us to quickly convert the __DOM__ tree
_JSON_ text, _HTML_, _XML_, ... and vice versa.
  * Maintain tight control 'Exceptions' providing much information when debugging.
  * Classes that follow the __SINGLETON__ pattern.
  * Contains methods 'constructor' and 'destructor' to optimize memory.
  * Methods called magical (_getter, setter, unset, clone, toString, ..._).
  * Configuration file writable for the accommodation of the basic parameters of _INI DOM_.
  * Chaining methods [_NO GETTER_].
  * Programming entirely within the paradigm __OOP__.
  * ... Other utility functions.

## REQUIREMENTS: ##
 * _PHP_ > 4
 * The modules that support for reading _INI_, _JSON_ and _XML_ files, must be enabled in __PHP__.
 * Having wanted to write code. jejejejj
 
## INSTALATION: ##
 1. You do not require installation.  
 
   Place the pakage in the desired route by which to call to instructions _'include'_ or _'require'_.  
   _(obviously if it's in a compressed format before DECOMPRESS)_  
  We suggest creating a folder (for example _DOM_) and place it inside. 

## USE: ##
 * Load the main input class '_DOM_element_' by 'include' or some variant clause: _include_once, require ..._ by example:  
   `... require(realpath(dirname(__FILE__))."/DOM/DOM_element.php"); ...`  
 * After this, to creating __DOM__ elements:  
   `... $div1=new DOM_element('div1'); ...`  
 * Add attributes and properties:  
   `... $div1->setTag("div")->id="container"; ...`  
 * Add content:  
   `... $div1->setText("TEXT INTO 'container' DIV")->addChild($div2); ...`  
 * Print:  
   `... echo $div1->toHTML(); ...`  

## WEB FLOW CREATION: ##
  * The normal flow for building a Web page would be: DOCTYPE -> HTML (HEAD -> BODY).  
    All this would contain the entire document. (SEE EXAMPLES FOR MORE FULL SHOW)  

  * DOCUMENT:  
	  No special labels or attributes element is purely the DOM representation, the element tree, the container document in full:
		  `... $document=new DOM_element('document'); ...`  
			`... $document->setTag(''); ...`  
			`...   $conf=array( "TYPE"=>"2", "DESC"=>"",
					               "OPEN_TAG_LEFT"=>"", "OPEN_TAG_RIGHT"=>"", 
					               "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" ); ...`  
			`... $document->setConfiguration($conf); ...`  

  * DOCTYPE:  
	  This being another special element (it is an element of definition, structure and style), we should also do it using both special 
		opening tag but no closing and unnamed attributes:  
		  `... $doctype=new DOM_element("doctype"); ...`  
			`... $doctype->setTag("DOCTYPE"); ...`  
			`... $conf=array( "TYPE"=>"doctype", "DESC"=>"Tipo de Documento (DTD)",
											 "OPEN_TAG_LEFT"=>"<!", "OPEN_TAG_RIGHT"=>">", 
											 "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" ); ...`  
			`... $doctype->setConfiguration($conf); ...`  
			//STARTING A KEY FOR '_null' means an attribute without key (doctype)  
			`... $doctype->addAttrib("_null1", "-//W3C//DTD XHTML 1.0 Transitional//EN"); ...`  
			`... $doctype->_null2="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"; //atributo asignado diréctamente ...`  
			_NOTE: Also keep in mind that not harbor any element._  

  * HTML:  
	  Container of elements _HEAD_ and _BODY_. Depending on the type of document to create _(HTML 1.0, xHTML, HTML5, ...)_ 
	  will implement those or other parameters:  
		  `... $html=new DOM_element('html'); ...`  
			`... $html->setTag("html"); ...`  
			`... $html->xmlns="http://www.w3.org/1999/xhtml"; ...`  

  * HEAD:  
	  Invisible element of page:  
		  `... $head=new DOM_element('head'); ...`  
		  `... $head->setTag("head")->addChild($title); ...`  

  * BODY:  
		Visual element of page:  
		  `... $body=new DOM_element('body'); ...`  
			`... $body->setTag("body")->addChild($div1); ...`  

  * SEWING OF ELEMENTS:  
	  `... $html->setChildren(array($html, $body)); ...`  
	  `... $document->setChildren(array($doctype, $html)); ...`  

  * WEB PRINTING:  
	  `... echo $document->toHTML(); ...`  

	_NOTE: (SEE EXAMPLES IN THE 'EXAMPLES' FOLDER FOR A MORE FULL SHOW)_  

