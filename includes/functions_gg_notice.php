<?php
// BRAMKA WWW2GG V2.2 W CALOSCI W PHP A WIEC MULIPLATFORMOWA
// MOZLIWA DO ZAMIESZCZENIA NA SERWERACH BEZ OBSLUGI CGI
//
// (C) Copyright 2001-2004 Piotr Mach <pm@gg.wha.la>
// Nowych wersji szukaj na http://gg.wha.la
//
// Bramka powstala dziêki opisowi protoko³u gadu-gadu
// z projektu EKG http://dev.null.pl/ekg/
//
// nazwy pakietów pochodz± w wiêkszo¶ci z EKG
//
// Dostosowanie do phpBB (C) Przemo ( http://www.przemo.org/phpBB2/ )
// Formatowanie skrocone, oryginalne formatowanie w pliku functions_gg.php

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

function default_serwer()
{
	$ip = array(79,46,75,15,9,16); 
	$host = '91.214.237.'.$ip[rand(0,sizeof($ip)-1)];
	$port = 8074;

	return array($host, $port);
}

function znajdz_serwer($numer)
{
	$http_fp = @fsockopen("appmsg.gadu-gadu.pl", 80, $errno, $errstr, 3);
	if (!$http_fp)
	{
		$default_server = default_serwer();
		return array($default_server[0], $default_server[1]);
	}
	else
	{
		$get = "GET /appsvc/appmsg.asp?fmnumber=<$numer> HTTP/1.0\r\n";
		$get.= "Host: appmsg.gadu-gadu.pl\r\n";
		$get.= "User-Agent: Mozilla/4.7 [en] (Win98; I)\r\n";
		$get.= "Pragma: no-cache\r\n\r\n";
	
		@fputs($http_fp, $get);
		while(!feof($http_fp))
		{
			$tmp .= @fgets($http_fp, 128);
		}
		@fclose($http_fp);

		preg_match("/\s([\d\.]{8,16})\:([\d]{1,5})\s/", $tmp, $addres);
		$host = $addres[1];
		$port = $addres[2];
		
		if($host == '' || $port == '')
		{
			$default_server = default_serwer();
			return array($default_server[0], $default_server[1]);
		}

		return array($host, $port);
	}
}

function wiadomosc_gg($list_addressats, $tresc, $numer, $haslo)
{
	$wersja = 0x22;
	$opis = '';
	$tresc = strtr($tresc, "\xA1\xA6\xAC\xB1\xB6\xBC", "\xA5\x8C\x8F\xB9\x9C\x9F");

	$numer = trim($numer);
	if (@get_magic_quotes_gpc())
	{
		$tresc = @stripslashes($tresc);
	}

	@list($host, $port) = znajdz_serwer($numer);

	$fp = @fsockopen($host, $port, $errno, $errstr, 4);
	$tab = @unpack("Vtyp/Vrozmiar/Vklucz", @fread($fp, 12));
	$klucz = $tab['klucz'];$x0=0;$x1=0;$y0=0;$y1=0;$z=0;$tmp=0;$y0 = ($klucz << 16) >> 16;$y1 = $klucz >> 16 ;for ($i=0; $i<@strlen($haslo); $i++){$x0 = ($x0 & 0xFF00) | @ord($haslo[$i]); $x1 &= 0xFFFF;$y0 ^= $x0; $y1 ^= $x1;$y0 += $x0; $y1 += $x1;$x1 <<= 8; $x1 |= ($x0 >> 8); $x0 <<= 8;$y0 ^= $x0; $y1 ^= $x1;$x1 <<= 8; $x1 |= ($x0 >> 8); $x0 <<= 8;$y0 -= $x0; $y1 -= $x1;$x1 <<= 8; $x1 |= ($x0 >> 8); $x0 <<= 8;$y0 ^= $x0; $y1 ^= $x1;$z = $y0 & 0x1F;$y0 &= 0xFFFF; $y1 &= 0xFFFF;if ( $z <= 16 ){$tmp= ($y1 << $z) | ($y0 >> (16-$z));$y0 = ($y1 >> (16-$z)) | ($y0 << $z);$y1 = $tmp;}else{$tmp= $y0 << ($z-16);$y0 = ($y0 >> (32-$z)) | ( (($y1 << $z) >> $z) << ($z-16) );$y1 = ($y1 >> (32-$z)) | $tmp;}$y0 &= 0xFFFF; $y1 &= 0xFFFF;}$hash = @hexdec(@sprintf("%04x%04x", $y1, $y0));@settype($hash, 'integer');
	$data = @pack("VVVVVVvVvVvCCa".strlen($opis), 0x0015, 0x20 + strlen($opis), $numer, $hash, ($opis)?0x0004:0x0014, $wersja, 0, 0, 0, 0, 0, 0x14, 0xbe , $opis );
	@fwrite($fp, $data);
	if ( !$data = @fread($fp, 8) ) return 0x000B;

        @fwrite($fp, @pack("VV", 0x0012, 0));

	if ( is_array($list_addressats) )
	{
		for($i = 0; $i < count($list_addressats); $i++)
		{
			$data = @pack("VVVVVa".strlen($tresc)."C", 0x000b, 0x0d + strlen($tresc), trim($list_addressats[$i]), mt_rand(), 0, $tresc, 0);
			@fwrite($fp, $data);
		}
	}
	else
	{
		$data = @pack("VVVVVa".strlen($tresc)."C", 0x000b, 0x0d + strlen($tresc), trim($list_addressats), mt_rand(), 0, $tresc, 0);
		@fwrite($fp, $data);
	}

	@fclose($fp);
}

?>