<?php 
/*
 * File containing the Example1.php, 
 * PACKAGE DOMBasic - Generation PHP FILE for demostration purpose
*
* @package DOMBasic
* @version 1.0
* @copyright Copyright (C) 2014-2020 Juan Jose Guerra Haba. All rights reserved.
* @license http://www.jumla-droid.com/licenses/new_bsd New BSD License
*/

  $language="es-ES";
	//$ruta=realpath( dirname(realpath( dirname(__FILE__) ) ) )."/../DOM_element.php";
	$ruta="../DOM_element.php";
	//echo $ruta;
	require($ruta);

	$document=new DOM_element('document');
	$document->setTag('');
	$conf=array( "TYPE"=>"document", "DESC"=>"document DOM",
			"OPEN_TAG_LEFT"=>"", "OPEN_TAG_RIGHT"=>"", "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" );
	$document->setConfiguration($conf);

		$doctype=new DOM_element("doctype");
		$doctype->setTag("DOCTYPE");
		$conf=array( "TYPE"=>"doctype", "DESC"=>"Tipo de Documento (DTD)",
									 "OPEN_TAG_LEFT"=>"<!", "OPEN_TAG_RIGHT"=>">", "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" );
		$doctype->setConfiguration($conf);
		//IGUALAR UNA CLAVE A NULL SIGNIFICA UNA CLAVE SIN VALOR
		$doctype->html=null;
		$doctype->addAttrib('PUBLIC',null); //$doctype->PUBLIC=null;
		//COMENZAR UNA CLAVE POR '_null' significa un atributo sin clave (doctype) (SOLO VALOR)
		$doctype->addAttrib("_null1", "-//W3C//DTD XHTML 1.0 Transitional//EN");
		$doctype->_null2="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd";
		
		$html=new DOM_element('html');
		$html->setTag("html");
		$html->xmlns="http://www.w3.org/1999/xhtml";
		$html->addAttrib("xml:lang", $language);
		$html->lang=$language;
		
			$head=new DOM_element('head');
			$head->setTag("head");
			
				$meta1=new DOM_element("meta1");
				$meta1->setTag("meta");
				$conf=array( "TYPE"=>"meta", "DESC"=>"meta-tag HTML",
						"OPEN_TAG_LEFT"=>"<", "OPEN_TAG_RIGHT"=>" />", "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" );
				$meta1->setConfiguration($conf);
				$meta1->addAttrib("http-equiv", "Content-Type")->addAttrib("content", 'text/html; charset=utf-8');
				
				$title=new DOM_element('title');
				$title->setTag('title')->setText("ARCHIVO DE PRUEBAS PARA POO-PHP");
				
				$link1=new DOM_element("link1");
				$link1->setTag("link");
				$conf=array( "TYPE"=>"link", "DESC"=>"link-resource HTML",
						"OPEN_TAG_LEFT"=>"<", "OPEN_TAG_RIGHT"=>" />", "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" );
				$link1->setConfiguration($conf);
				$link1->addAttrib("type", "image/x-icon")->addAttrib("rel", "shortcut icon")->addAttrib("href", "favicon.png");
				
				$link2=new DOM_element("link2");
				$link2->setTag("link");
				$conf=array( "TYPE"=>"link", "DESC"=>"link-resource HTML",
						"OPEN_TAG_LEFT"=>"<", "OPEN_TAG_RIGHT"=>" />", "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" );
				$link2->setConfiguration($conf);
				$link2->addAttrib("type", "text/css")->addAttrib("rel", "stylesheet");
				$link2->addAttrib("href", "http://ajax.googleapis.com/ajax/libs/mootools/1.2.2/mootools-yui-compressed.css");
				
				$style1=new DOM_element("style1");
				$style1->setTag("style")->type="text/css";
				$style1->setText(
													"#container{
														padding:10px;
														margin:10px;
													}
													#container2{
													  background:lightGray;
													  border: 1px ridge coral;
														border-radius:8px;
														padding:10px;
														max-width:250px;
														margin:auto;
													}
													img{
													  border: 1px solid gray;
														border-radius:6px;
														box-shadow:4px 6px 8px;
														width:85%;
														margin:10px;
														cursor:pointer;
													}
													img:hover{ width:84%;}"
												);

				$script1=new DOM_element("script1");
				$script1->setTag("script")->type="text/javascript";
				$conf=array( "TYPE"=>"link", "DESC"=>"link-resource HTML",
						"OPEN_TAG_LEFT"=>"<", "OPEN_TAG_RIGHT"=>">", "CLOSE_TAG_LEFT"=>"</", "CLOSE_TAG_RIGHT"=>">" );
				$script1->setConfiguration($conf);
				$script1->src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.2/mootools-yui-compressed.js";
				
				$script2=new DOM_element("script2");
				$script2->setTag("script")->type="text/javascript";
				$script2->setText("
														window.addEvent(\"domready\", function() {
														  $(\"container\").highlight(\"#AAAA00\");
														});"
													);

			$head->setChildren(array($meta1, $title, $link1, $link2, $style1, $script1, $script2));
			
			$body=new DOM_element('body');
			$body->setTag("body");
			
				$h1=new DOM_element('h1_1');
				$h1->setTag("h1");
				$h1->setText('EXAMPLE1 :: Paquete DOMBasic <br /><small style="color:#666666;">- Generaci&oacute;n de archivo HTML para prop&oacute;sitos de demostraci&oacute;n <br /><small><a href="mailto:dinertron@gmail.com">guerraTron - 2014</a></small></small>');
											 
				$div1=new DOM_element('div1');
				$div1->setTag("div")->id="container";
				$div1->setText('<hr />"El fondo de este DIV resaltará dinámicamente mediante Javascript [Mootools]"<hr />');
				
				$div2=new DOM_element('div2');
				$div2->setTag("div")->id="container2";
				$div2->setText('Pulsar en la primera im&aacute;gen de Lego<br />');
				
					$img1=new DOM_element('img1');
						$conf=array( "TYPE"=>"img", "DESC"=>"image-resource HTML",
						"OPEN_TAG_LEFT"=>"<", "OPEN_TAG_RIGHT"=>"/>", "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" );
					$img1->setConfiguration($conf);
					$img1->setTag("img")->addAttribs(array("src"=>"./img1.png", 
																							 "alt"=>"img1.png - Legotron 1", 
																							 "title"=>"Legotron 1",
																							 "onclick"=>"javascript: alert('LegoTron 1');"));

					$img2=new DOM_element('img2');
						$conf=array( "TYPE"=>"img", "DESC"=>"image-resource HTML",
						"OPEN_TAG_LEFT"=>"<", "OPEN_TAG_RIGHT"=>"/>", "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" );
					$img2->setConfiguration($conf);
					$img2->setTag("img")->addAttribs(array("src"=>"./img2.png", 
																							 "alt"=>"img2.png - Legotron 2", 
																							 "title"=>"Legotron 2"));
				$div2->addChildren(array($img1, $img2));
			$body->setChildren(array( $h1, $div1, $div2 ));
			
		$html->setChildren(array($head, $body));
		
	$document->addChild($doctype)->addChild($html);


	//SALIDA
	echo $document->toHTML();
	//DEPURACION
	/*
	echo "<pre>";
		print_r($document);
	echo "</pre>";
	*/
?>