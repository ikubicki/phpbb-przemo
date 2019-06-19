<?php
// BRAMKA WWW2GG V2.2 W CALOSCI W PHP A WIEC MULIPLATFORMOWA
// MOZLIWA DO ZAMIESZCZENIA NA SERWERACH BEZ OBSLUGI CGI
// DO POPRANIA WRAZ Z INSTRUKCJAMI Z http://gg.wha.la
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class GaduGadu
{
	var $fp;
	var $wiadomosci = array();
	var $status_kontaktu = array();
	var $status_dostarczenia = array();
	var $wyniki_szukania = array();

	function GaduGadu()
	{
		mt_srand((double)microtime() * 1000000);
	}

	function status_dostarczenia($seq)
	{
		if ($this->status_dostarczenia[$seq]) return $this->status_dostarczenia[$seq];
		else return 0;
	}

	function oblicz_nowy_hash($haslo, $klucz)
	{
		$x0=0;
		$x1=0;
		$y0=0;
		$y1=0;
		$z=0;
		$tmp=0;
		$y0 = ($klucz << 16) >> 16;
		$y1 = $klucz >> 16 ;

		for ($i=0; $i<strlen($haslo); $i++)
		{
			$x0 = ($x0 & 0xFF00) | ord($haslo[$i]); $x1 &= 0xFFFF;
			$y0 ^= $x0; $y1 ^= $x1;
			$y0 += $x0; $y1 += $x1;
			$x1 <<= 8; $x1 |= ($x0 >> 8); $x0 <<= 8;
			$y0 ^= $x0; $y1 ^= $x1;
			$x1 <<= 8; $x1 |= ($x0 >> 8); $x0 <<= 8;
			$y0 -= $x0; $y1 -= $x1;
			$x1 <<= 8; $x1 |= ($x0 >> 8); $x0 <<= 8;
			$y0 ^= $x0; $y1 ^= $x1;
			$z = $y0 & 0x1F;

			$y0 &= 0xFFFF; $y1 &= 0xFFFF;
			if ( $z <= 16 )
			{
				$tmp= ($y1 << $z) | ($y0 >> (16-$z));
				$y0 = ($y1 >> (16-$z)) | ($y0 << $z);
				$y1 = $tmp;
			}
			else
			{
				$tmp= $y0 << ($z-16);
				$y0 = ($y0 >> (32-$z)) | ( (($y1 << $z) >> $z) << ($z-16) );
				$y1 = ($y1 >> (32-$z)) | $tmp;
			}
			$y0 &= 0xFFFF; $y1 &= 0xFFFF;
		}

		$hash = hexdec(sprintf("%04x%04x", $y1, $y0));
		settype($hash, 'integer');

		return $hash;
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
			//$this->debug("Nie mozna polaczyæ z serwerem Gadu-Gadu: $errno - $errstr");
			$default_server = $this->default_serwer();
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
				$default_server = $this->default_serwer();
				return array($default_server[0], $default_server[1]);
			}

			return array($host, $port);
		}
	}


	function login($numer, $haslo, $host, $port, $opis = "", $wersja = 0x22)
	{
		$this->fp = @fsockopen($host, $port, $errno, $errstr, 10);
		if ( !$this->fp )
		{
			$this->debug("PROBLEM Z POLACZENIEM: $errno - $errstr<br />\n");
			return 0x0100;
		}

		if ( !$data = fread($this->fp, 12) )
		{
			$this->debug("Polaczenie z serwerem GG nieoczekiwanie zamkniete<br />\n");
			return 0x0100;
		}

		$tab = unpack("Vtyp/Vrozmiar/Vklucz", $data);

		$hash = $this->oblicz_nowy_hash($haslo, $tab['klucz']);

		$data = pack("VVVVVVvVvVvCCa".strlen($opis), 0x0015, 0x20 + strlen($opis), $numer, $hash, ($opis)?0x0004:0x0014, $wersja, 0, 0, 0, 0, 0, 0x14, 0xbe , $opis );

		@fwrite($this->fp, $data);

		if ( !$data1 = @fread($this->fp, 8) ) return 0x000B;

                $tab = @unpack("Vlogin_status/Vrozmiar", $data1);
                if ($tab['rozmiar']>0)
                        $work = @fread($this->fp, $tab['rozmiar']);

                return $tab['login_status'];
	}


	function wyslij_liste_kontaktow ($uin)
	{
		$data = pack ("VVVC",0x0010, 5, $uin, 0x0003);

		return @fwrite($this->fp,$data);
	}
	
	function pusta_lista_kontaktow ()
        {
                $data = pack ("VV",0x0012, 0);
                return @fwrite($this->fp,$data);
        }
	
	function wyslij_wiadomosc($adresat, $tresc, $potwierdzenie = TRUE)
	{
		$tresc = txt::iso2cp($tresc);
		$seq = mt_rand();

		$data = pack("VVVVVa".strlen($tresc)."C", 0x000b, 0x0d + strlen($tresc), $adresat, $seq, ($potwierdzenie)?0x0004:0x0004 | 0x0020, $tresc, 0);

		$this->status_dostarczenia[$seq] = FALSE;

		if (!@fwrite($this->fp, $data)) return FALSE;

		return $seq;
	}


	function odbierz_dane()
	{
		if ( !$data = fread($this->fp, 8) ) return FALSE;
		$tab = @unpack("Vtyp/Vrozmiar", $data);

		while ($tab['typ'] == 0x0011 || $tab['typ'] == 0x0002)
		{
			$data = @fread($this->fp, $tab['rozmiar']);

	if ( $tab['rozmiar'] > 0 )
			{
				switch($tab['typ'])
				{
					case 0x0002:
					case 0x0011:
						$tab = @unpack("Vuin/Vrozmiar", $data);
					break;
				}
			}

			$data = @fread($this->fp, 8);
			$tab = @unpack("Vtyp/Vrozmiar", $data);
		}

		if ( !$data = @fread($this->fp, $tab['rozmiar']) ) return FALSE;

		if ( $tab['typ'] == 0x0005 )
		{
			$tab = unpack("Vstatus/Vadresat/Vseq", $data);
			$this->status_dostarczenia[$tab['seq']] = $tab['status'];
		}
		else if ( $tab['typ'] == 0x000e )
		{
			$tab = unpack("Cunknown/Vczas/A*results", $data);
			$this->wyniki_szukania = $tab['results'];
		}

		return TRUE;
	}


	function logoff ($opis = "")
	{
		$data = pack("VVVa".strlen($opis), 0x0002, 0x04 + strlen($opis), ($opis)?0x0015:0x0001, $opis);
		@fwrite($this->fp, $data);
		@fclose($this->fp);
	}


	function debug($info)
	{
		message_die(GENERAL_MESSAGE, $info);
	}
}

class www2gg extends GaduGadu
{
	function www2gg($numer, $haslo)
	{
		$this->GaduGadu();
		$this->numer = $numer;
		$this->haslo = $haslo;
	}


	function wiadomosc($adresat, $tresc)
	{
		if (get_magic_quotes_gpc()) $tresc = stripslashes($tresc);

		$tresc = txt::odlinkuj($tresc);

		list ($host, $port) = $this->znajdz_serwer($this->numer);

                switch ($this->login($this->numer, $this->haslo, $host, $port, ""))
                {
                        case 0x0003:
                                $this->pusta_lista_kontaktow();
                                if ( $seq = $this->wyslij_wiadomosc($adresat, $tresc) )
				{
					if ( $this->odbierz_dane() ) $this->logoff("");
					return $seq;
				}
				else
				{
					$this->debug("Polaczenie zerwane po zalogowaniu");
					break;
				}

			case 0x0100:
				$this->debug("Polaczenie odrzucone dla: $host ".@gethostbyaddr($host).": $port");
				break;

			case 0x0009:
				$this->debug("LOGIN FAILED - zle haslo");
				return FALSE;

			case 0x000B:
				$this->debug("LOGIN FAILED");
				return FALSE;

			default:
				$this->debug("LOGIN FAILED - hm, to nie powinno sie zdarzyc..."); 
				return FALSE;
		}

		$this->debug("LOGIN FAILED - polaczenie odrzucone <br />\n"."Mozesz sprobowac jeszcze raz (odwiez strone)");
		return FALSE;
	}
}


class txt
{
	function txt()
	{
		die('to jest statyczna klasa');
	}

	function iso2cp($co)
	{
		return strtr($co, "\xA1\xA6\xAC\xB1\xB6\xBC", "\xA5\x8C\x8F\xB9\x9C\x9F");
	}

	function dodajspacje($text)
	{
		return preg_replace("/([\.@:])/","\\1 ","$text");
	}

	function rep($str)
	{
		$keys = 'abcdefghijklmnopqrstuwxyz.,0123456789ABCDEFGHIJKLMOPQRSTUWXYZ';
		for($i=0; $i < count($str); $i++) $str_ret .= $keys{$str[$i]};
		return $str_ret;
	}

	function odlinkuj($text)
	{
		$search = array(
			"/(\S+([\@\.])+?\S+)|(\S+:\/\/)/e",
			"/www/i",
			"/http/i"
		);

		$replace = array(
			"txt::dodajspacje('\\1\\3')",
			"w*w",
			"ht*p"
		);

		return preg_replace($search, $replace ,$text);
	}
}

?>