<?php 
	$language="es-ES";	//sp-SP
	/*
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $language; ?>" lang="<?php echo $language; ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ARCHIVO DE PRUEBAS PARA POO-PHP</title>
		<link type="image/x-icon" rel="shortcut icon" href="favicon.png" />
		<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/mootools/1.2.2/mootools-yui-compressed.css" />
		<style type="text/css">
			.menuHorz{
				display:inline;
				float:left;
				list-style:none;
			}
			.menuHorz li{
				float:left;
				margin-left: 10px;
				padding: 10px;
				background: lightBlue;
			}
			.menuHorz#seg li{
				background: lightGreen;
			}
		</style>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.2/mootools-yui-compressed.js"></script>
		<script type="text/javascript">
		</script>
	
		<script type="text/javascript">
			window.addEvent('domready', function() {
				$('contenedor').setStyle('background','yellow');
			});
		</script>
	</head>
	<body>
		<div id="contenedor">
		
			<?php 
			*/
				//ZONA PHP 
			//require(realpath(dirname(__FILE__))."/DOM_element.php"); //include
			require("../DOM_element.php"); //include

						
			$document=new DOM_element('document');
			$document->setTag('');
				$conf=array( "TYPE"=>"2", "DESC"=>"",
					"OPEN_TAG_LEFT"=>"", "OPEN_TAG_RIGHT"=>"", "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" );
			$document->setConfiguration($conf);

				$doctype=new DOM_element("doctype");
				$doctype->setTag("DOCTYPE");
					$conf=array( "TYPE"=>"doctype", "DESC"=>"Tipo de Documento (DTD)",
											 "OPEN_TAG_LEFT"=>"<!", "OPEN_TAG_RIGHT"=>">", "CLOSE_TAG_LEFT"=>"", "CLOSE_TAG_RIGHT"=>"" );
				$doctype->setConfiguration($conf);
				$doctype->html=null;
				$doctype->PUBLIC=null;
				//COMENZAR UNA CLAVE POR '_null' significa un atributo sin clave (doctype)
				$doctype->addAttrib("_null1", "-//W3C//DTD XHTML 1.0 Transitional//EN");
				$doctype->_null2="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd";
				
				$html=new DOM_element('html');
				$html->setTag("html");
				$html->xmlns="http://www.w3.org/1999/xhtml";
				/**/
				$html->addAttrib("xml:lang", '<?php echo $language; ?>');
				$html->lang='<?php echo $language; ?>';
				
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
															".menuHorz{
																display:inline;
																float:left;
																list-style:none;
															}
															.menuHorz li{
																float:left;
																margin-left: 10px;
																padding: 10px;
																background: lightBlue;
															}
															.menuHorz#seg li{
															background: lightGreen;
															}"
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
																window.addEvent('domready', function() {
																$('contenedor').setStyle('background','yellow');
																});"
															);

					$head->setChildren(array($meta1, $title, $link1, $link2, $style1, $script1, $script2));
					
					$body=new DOM_element('body');
					$body->setTag("body");
					
						$div1=new DOM_element('div1');
						$div1->setTag("div")->id="contenedor";
						$div1->setText("TEXTO DENTRO DE DIV 'contenedor'
														<?php echo 'EXAMPLE :: PACKAGE DOMBasic - Generation PHP FILE for demostration purpose'; ?>
													 ");
					$body->addChild($div1);
					
				$html->setChildren(array($head, $body));
				
			$document->setText('<?php $language=\"sp-ES\"; ?>')->addChild($doctype)->addChild($html);//
			//$document->addChild($doctype)->addChild($html);

			
			$json=$document->toJSON(true, true);
			//$json=json_decode($json);
			//SALIDA
			//include("./util/Utiles.php");
			//echo "<pre>";
				//print_r($document);
				//echo ($document->toHTML());
				//var_dump ("{".$json."}");
				//$jsonEnc=json_encode(($document->toJSON()) );
				//$jsonEnc=json_encode( var_dump($document) );
				//$salida=var_export($document, true);
				//$salida=var_export_min($document, true);
				//$salida=improved_var_export($document, true);
//$salida=$document->toJSON();
				//$salida=recursive_print("elementoDOM", $document->toJSON());
				
//echo $salida;

echo "<h1>COMPARACI&Oacute;N 'JSON' vs 'DOCUMENT'</h1>";
echo '<p style="background:lightYellow; max-width:400%;"><b>Cadena JSON</b>: <br /><span style="font-size:xx-small;">'.$json."</span></p>";
//var_dump(json_decode(utf8_decode(htmlspecialchars_decode(stripslashes($json)))));

				//var_dump (json_decode( $jsonEnc , JSON_HEX_QUOT && JSON_HEX_TAG && JSON_HEX_AMP && JSON_HEX_APOS ));
				//var_dump (unserialize(( serialize($document) )));
				
//var_dump($document->fromJSON($json));

			//echo "</pre>";
			
			//$document->fromJSON($json, false)
			$doc=new DOM_element();
			
			echo '<div style="float:left; width:45%; background:whiteSmoke; color:maroon; border:1px ridge maroon; overflow:auto;">';
				echo "<h3>DOCUMENT:</h3>";
				echo "<pre>";
					var_dump( $document );
				echo "</pre>";
			echo '</div>';
			echo '<div style="float:left; width:45%; background:lightYellow; color:brown; border:1px ridge brown; overflow:auto;">';
				echo "<h3>DOC:</h3>";
				echo "<pre>";
					var_dump( $doc->fromJSON($json) );
				echo "</pre>";
			echo '</div>';
			echo '<p style="background:lightGray; font-size:smaller;">JSON ==? DOCUMENT -> &nbsp;';
			echo $doc->fromJSON($json)->equals($document)?"true":"false";
			echo "</p>";
			
			//echo $ul2->toURL();
			//echo $document->toHTML()."<br />";
			?>
		</div>
  </body>
</html>
<?php //echo $document->toHTML()."<br />"; ?>