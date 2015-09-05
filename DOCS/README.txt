------------------------------------------------------------
DOMbasic. Juan José Guerra Haba - 2014 - dinertron@gmail.com
dombasic-full@lists.osdn.me - dombasic-private@lists.osdn.me
------------------------------------------------------------

DEFINITION:
----------
PHP package to create dynamic DOM elements.
It follow the OOP paradigm, implemented SINGLETON patterns, magical methods,
contains error control ('own exceptions'), chaining methods,
optimized memory and resources, ...

EXPLANATORY:
-----------
More flexible and lighter than the native PHP. It allows you to create any
document labeling: HTML, XHTML, XML, ... including any
user-defined (this includes those who are yet to be implemented)
that are based on hierarchies of tags, attributes and content; this
You can be achieved simply by modifying the constants file specify, 
opening and closing tags and a couple of other modifications.

You can create complete websites that adhere to the standards
validation of its structure. A tree harbor the only variable element
created, this includes visible elements (BODY) and invisible (HEAD)
static (HTML) and dynamic (SCRIPTS:. EG Javascript), elements
and positioning structure (xHTML) or style (CSS) ...

Although there are other ways to achieve the same (text variables, other APIs, ...)
This method is designed for flexibility and dynamism, performance and low resource consumption.
Once you understand the mechanism and its syntax, saving time and effort, errors are minimized
and DOM construction and automated cleaner is achieved.
We all know the problems that can be generated when processing a Web page on the fly successive chaining
'Echo, print, ... " making sure that the headers are not sent in advance; these errors
multiplied by a thousand if we use Frameworks or type CMS (Joomla, Wordpress, Drupal, ...)

FEATURES:
---------------
  - They have been implemented utility functions that allow us to quickly convert the DOM tree
JSON text, HTML, XML, ... and vice versa.
  - Maintain tight control 'Exceptions' providing much information when debugging.
  - Classes that follow the SINGLETON pattern.
  - Contains methods 'builders' and 'destructive' to optimize memory.
  - Methods called magical (getter, setter, unset, clone, toString, ...).
  - Configuration file writable for the accommodation of the basic parameters of INI DOM.
  - Chaining methods [NO GETTER].
  - Programming entirely within the paradigm OOP.
  - ... Other utility functions.

REQUIREMENTS:
 - PHP > 4
 - The modules that support for reading INI, JSON and XML files, must be enabled in PHP.
 - Having wanted to write code. jejejejj
 
INSTALATION:
 - You do not require installation. Place the Pakete in the desired route by which to call to instructions 'include' or 'require'.
   (obviously if it's in a compressed format before DECOMPRESS)
  We suggest creating a folder (for example DOM) and place it inside.
 
USE:
 - Load the main input class 'DOM_element' by 'include' or some variant clause: include_once, require ...
   by example: ... require(realpath(dirname(__FILE__))."/DOM/DOM_element.php");
 - After this, to creating DOM elements:
   ... $div1=new DOM_element('div1'); ...
 - Add attributes and properties:
   ... $div1->setTag("div")->id="container"; ...
 - Add content:
   ... $div1->setText("TEXT INTO 'container' DIV")->addChild($div2); ...
 - Print:
   ... echo $div1->toHTML(); ...
	 
WEB FLOW CREATION:
  - The normal flow for building a Web page would be: DOCTYPE -> HTML (HEAD -> BODY). All this would contain the entire document.
   (SEE EXAMPLES FOR MORE FULL SHOW)
	
	- DOCUMENT:
	  No special labels or attributes element is purely the DOM representation, the element tree, the container document in full:
		  ... $document=new DOM_element('document'); ...
			... $document->setTag(''); ...
			...   $conf=array( "TYPE"=>"2", "DESC"=>"",
					               "OPEN_TAG_LEFT"=>"", "OPEN_TAG_RIGHT"=>"", 
												 "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" ); ...
			... $document->setConfiguration($conf);
			
	- DOCTYPE:
	  This being another special element (it is an element of definition, structure and style), we should also do it using both special 
		opening tag but no closing and unnamed attributes:
		  ... $doctype=new DOM_element("doctype"); ...
			... $doctype->setTag("DOCTYPE"); ...
			... $conf=array( "TYPE"=>"doctype", "DESC"=>"Tipo de Documento (DTD)",
											 "OPEN_TAG_LEFT"=>"<!", "OPEN_TAG_RIGHT"=>">", 
											 "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" ); ...
			... $doctype->setConfiguration($conf); ...
			//STARTING A KEY FOR '_null' means an attribute without key (doctype)
			... $doctype->addAttrib("_null1", "-//W3C//DTD XHTML 1.0 Transitional//EN"); ...
			... $doctype->_null2="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"; //atributo asignado diréctamente ...
			NOTE: Also keep in mind that not harbor any element.
	
	- HTML:
	  Container of elements HEAD and BODY. Depending on the type of document to create (HTML 1.0, xHTML, HTML5, ...) will implement 
		those or other parameters:
		  ... $html=new DOM_element('html'); ...
			... $html->setTag("html"); ...
			... $html->xmlns="http://www.w3.org/1999/xhtml"; ...
			
	- HEAD:
	  Invisible element of the page:
		  ... $head=new DOM_element('head'); ...
		  ... $head->setTag("head")->addChild($title); ...
	
	- BODY:
		Visual element of the page:
		  ... $body=new DOM_element('body'); ...
			... $body->setTag("body")->addChild($div1); ...
	
	- SEWING OF ELEMENTS:
	  ... $html->setChildren(array($html, $body));
	  ... $document->setChildren(array($doctype, $html)); ...
		
	- WEB PRINTING:
	  ... echo $document->toHTML(); ...
		
	NOTE: (SEE EXAMPLES IN THE 'EXAMPLES' FOLDER FOR A MORE FULL SHOW)
