<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('utf8tohtml'))
{
	// From Php.net -> silverbeat -eat- gmx -hot-
	// converts a UTF8-string into HTML entities
	// Romaric : modif, valeur par défaut de $encodeTags
	//  - $utf8:        the UTF8-string to convert
	//  - $encodeTags:  boolean. TRUE will convert "<" to "&lt;"
	//  - return:       returns the converted HTML-string
	function utf8tohtml($utf8, $encodeTags = TRUE)
	{
	    $result = '';
	    for ($i = 0; $i < strlen($utf8); $i++) {
	        $char = $utf8[$i];
	        $ascii = ord($char);
	        if ($ascii < 128) {
	            // one-byte character
	            $result .= ($encodeTags) ? htmlentities($char) : $char;
	        } else if ($ascii < 192) {
	            // non-utf8 character or not a start byte
	        } else if ($ascii < 224) {
	            // two-byte character
	            $result .= htmlentities(substr($utf8, $i, 2), ENT_QUOTES, 'UTF-8');
	            $i++;
	        } else if ($ascii < 240) {
	            // three-byte character
	            $ascii1 = ord($utf8[$i+1]);
	            $ascii2 = ord($utf8[$i+2]);
	            $unicode = (15 & $ascii) * 4096 +
	                       (63 & $ascii1) * 64 +
	                       (63 & $ascii2);
	            $result .= "&#$unicode;";
	            $i += 2;
	        } else if ($ascii < 248) {
	            // four-byte character
	            $ascii1 = ord($utf8[$i+1]);
	            $ascii2 = ord($utf8[$i+2]);
	            $ascii3 = ord($utf8[$i+3]);
	            $unicode = (15 & $ascii) * 262144 +
	                       (63 & $ascii1) * 4096 +
	                       (63 & $ascii2) * 64 +
	                       (63 & $ascii3);
	            $result .= "&#$unicode;";
	            $i += 3;
	        }
	    }
	    return $result;
	}
}

if ( ! function_exists('get_url_contents'))
{
	// fonction récupérant une page web par cURL
	function get_url_contents($url){
        $crl = curl_init();

        curl_setopt ($crl, CURLOPT_URL, $url);
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, FALSE); 
    	curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($crl, CURLOPT_HEADER, 0);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, 30); // timeout, secondes
        $ret = curl_exec($crl);
        curl_close($crl);
		
        return $ret;
	}
}

if ( ! function_exists('echo_array'))
{
	// fonction récupérant une page web par cURL
	function echo_array($array){
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
}

if ( ! function_exists('is_lowercase'))
{
	// fonction vérifiant si un string ne contient bien que des lettres minuscules & des chiffres
	function is_lowercase($str) {
		if (preg_match('/[^a-z0-9]+/', $str) == 0) {
		    return TRUE;
		}
		
		return FALSE;
	}
}

if ( ! function_exists('back_button'))
{
	// fonction vérifiant si un string ne contient bien que des lettres minuscules & des chiffres
	function back_button() {
		return '<a href="javascript:history.go(-1)">Revenir &agrave; la page pr&eacute;c&eacute;dente</a>';
	}
}

if ( ! function_exists('date_mysql'))
{
	// conversion des dates à un format ok pour MySQL
	// on a pas de $conv quand appelé par CI
	function date_mysql($DateMysql, $conv = 'mysql') {
		if ($conv == 'fr')
		{
			list($annee, $mois, $jour) = explode('-', $DateMysql);
			
			if ((is_numeric($jour) === TRUE) && (is_numeric($mois) === TRUE) && (is_numeric($annee) === TRUE))
			{
				return ($jour.'/'.$mois.'/'.$annee);	
			} else {
				return $DateMysql; // ce n'est peut-être pas au bon format
			}
		} else {
			// par défaut, $conv = mysql
			list($jour, $mois, $annee) = explode('/', $DateMysql);
			
			if ((is_numeric($jour) === TRUE) && (is_numeric($mois) === TRUE) && (is_numeric($annee) === TRUE))
			{
				return ($annee.'-'.$mois.'-'.$jour);
			} else {
				return $DateMysql; // ce n'est peut-être pas au bon format
			}
		}
	}
}

if ( ! function_exists('json_pretty_encode'))
{
	function json_pretty_encode($value, $options = 0, $indentationCharacter = '	')
	{
		$string	= json_encode($value, $options);
		$string = str_replace('\/', '/', $string); // on enlève les / escapés
		$out = '';
		$indent	= 0;
		$istext	= false;
		for($i = 0; $i < strlen($string); $i++)
		{
			$character = substr($string, $i, 1);
			$breakBefore = $breakAfter	= false;
			$charBefore	= $charAfter	= '';
	
			if($character === '"' && ($i > 0 && substr($string, $i - 1, 1) !== '\\'))
				$istext = !$istext; // toggle
			if(!$istext)
				switch($character)
				{
					case '[':
					case '{':
						$indent++;
					case ',':
						$breakAfter = true;
					break;
					case ']':
					case '}':
						$indent--;
						$breakBefore = true;
					break;
					case ':':
						$charBefore = $charAfter = ' ';
					break;
				}
			$out	.= ($breakBefore ? PHP_EOL.str_repeat($indentationCharacter, $indent) : '')
					.  $charBefore.$character.$charAfter
					.  ($breakAfter ? PHP_EOL.str_repeat($indentationCharacter, $indent) : '')
					;
		}
		
		return $out;
	}
}

/* EOF */