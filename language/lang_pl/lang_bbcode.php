<?php
/***************************************************************************
 *                         lang_bbcode.php [Polish]
 *                            -------------------
 *   begin                : Wednesday Oct 3, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: lang_bbcode.php,v 1.2.2.1 2002/11/14 14:00:13 psotfx Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// Translation by Mike Paluchowski and Radek Kmiecicki
// http://www.phpbb.pl/
//

// Check for user gender
$he = true;
  
$faq[] = array("--","Wprowadzenie");
$faq[] = array("Czym jest BBCode?", "BBCode jest specjaln� implementacj� HTML'a, a mo�liwo�� jego u�ywania jest uzale�niona od ustawie� dokonanych przez administratora (mo�esz tak�e wy��cza� go dla ka�dego postu osobno w formularzu wysy�ania). Sam BBCode jest podobny stylowo do HTML'a, znaczniki s� zawarte w nawiasach kwadratowych [ i ] a nie &lt; i &gt; oraz oferuje wi�ksz� kontrol� nad tym co i jak b�dzie wy�wietlane. Zale�nie od szablonu, kt�rego u�ywasz mo�esz w bardzo �atwy spos�b dodawa� znaczniki BBCode do post�w poprzez odpowiednie przyciski na stronie wysy�ania postu. Mimo to ten przewodnik powinien by� przydatny.");

$faq[] = array("--","Formatowanie Tekstu");
$faq[] = array("Jak wpisa� pogrubiony, pochylony lub podkre�lony tekst", "BBCode zawiera znaczniki pozwalaj�ce na szybk� zmian� podstawowego wygl�du tekstu. Mo�na to uzyska� na poni�sze sposoby:<ul><li>Aby pogrubi� jaki� tekst wstaw go pomi�dzy <b>[b][/b]</b>, np. <br /><br /><b>[b]</b>Cze��<b>[/b]</b><br /><br />stanie si� <b>Cze��</b></li><li>Do podkre�le� u�yj <b>[u][/u]</b>, na przyk�ad:<br /><br /><b>[u]</b>Dzie� Dobry<b>[/u]</b><br /><br />stanie si� <u>Dzie� Dobry</u></li><li>Aby wpisa� tekst kursyw� u�yj <b>[i][/i]</b>, np.<br /><br />To jest <b>[i]</b>�wietne!<b>[/i]</b><br /><br />co zmieni si� na To jest <i>�wietne!</i></li></ul>");
$faq[] = array("Jak zmieni� kolor lub rozmiar tekstu", "Aby zmieni� kolor lub rozmiar tekstu mo�na u�y� nast�puj�cych znacznik�w. Pami�taj, �e to jaki b�dzie rezultat po wy�wietleniu zale�y od przegl�darki i systemu u�ytkownika:<ul><li>Zmian� koloru tekstu mo�na osi�gn�� przez otoczenie go <b>[color=][/color]</b>. Mo�esz poda� albo nazw� koloru (np. red, blue, yellow, itp.) lub szesnastkow� warto��, np. #FFFFFF, #000000. Na przyk�ad aby stworzy� czerwony tekst mo�esz u�y�<br /><br /><b>[color=red]</b>Cze��!<b>[/color]</b><br /><br />albo<br /><br /><b>[color=#FF0000]</b>Cze��!<b>[/color]</b><br /><br />oba wy�wietl� te same <span style=\"color:red\">Cze��!</span></li><li>Zmiana rozmiaru tekstu jest osi�gana w podobny spos�b u�ywaj�c <b>[size=][/size]</b>. Ten znacznik jest zale�ny od szablonu, kt�rego u�ywasz ale rekomendowanym formatem jest numeryczna warto�� reprezentuj�ca rozmiar tekstu w pikselach, zaczynaj�c od 1 (tak ma�y, �e go nie wida�) a� do 26 (bardzo du�y). Na przyk�ad:<br /><br /><b>[size=9]</b>MA�Y<b>[/size]</b><br /><br /> b�dzie generalnie <span style=\"font-size:9px\">MA�Y</span><br /><br />podczas gdy:<br /><br /><b>[size=24]</b>WIELKI!<b>[/size]</b><br /><br />b�dzie<span style=\"font-size:24px\">WIELKI!</span></li></ul>");
$faq[] = array("Czy mog� ��czy� znaczniki formatuj�ce?", "Tak, naturalnie �e mo�esz, na przyk�ad aby zwr�ci� czyj�� uwag� mo�esz napisa�:<br /><br /><b>[size=18][color=red][b]</b>POPATRZ NA MNIE!<b>[/b][/color][/size]</b><br /><br />co zmieni si� w <span style=\"color:red;font-size:18px\"><b>POPATRZ NA MNIE!</b></span><br /><br />Nie radzimy jednak wpisywa� du�ych ilosci tekstu o takim wygl�dzie! Pami�taj, �e od ciebie zale�y zachowanie poprawnej kolejno�ci pocz�tkowych i ko�cowych znacznik�w. Na przyk�ad poni�sze nie jest prawid�owe:<br /><br /><b>[b][u]</b>Tak jest �le<b>[/b][/u]</b>");

$faq[] = array("--","Cytowanie i wpisywanie tekstu o sta�ej szeroko�ci");
$faq[] = array("Cytowanie tekstu w odpowiedziach", "S� dwa sosoby na cytowanie tekstu, z podaniem �r�d�a lub bez.<ul><li>Kiedy wykorzystujesz funkcj� cytowania odpowiadaj�c na post na forum powin" .  (($he) ? 'iene�' : 'na�') . " zauwa�y�, �e tekst jest dodawany do wiadomo�ci otoczony blokiem <b>[quote=\"\"][/quote]</b>. Ta metoda pozwala cytowa� z podaniem �r�d�a czyli osoby lub czegokolwiek innego, co zechcesz poda�. Na przyk�ad aby zacytowa� kawa�ek tekstu napisanego przez Mr. Blobby mo�esz wpisa�:<br /><br /><b>[quote=\"Mr. Blobby\"]</b>Tekst Mr. Blobby zostanie wstawiony tutaj<b>[/quote]</b><br /><br />Wynikiem czego b�dzie automatyczne dodanie Mr. Blobby napisa�: przed w�a�ciwym tekstem. Pami�taj, <b>musisz</b> wstawi� znaki \"\" wok� nazwy �r�d�a, nie s� one jedynie opcj�.</li><li>Druga metoda pozwala cytowa� co� nie podaj�c �r�d�a. Aby jej u�y� wstaw tekst mi�dzy znaczniki <b>[quote][/quote]</b>. Kiedy b�dziesz przegl�da� wiadomo�ci, zobaczysz po prostu s�owo Cytat: przed samym tekstem.</li></ul>");
$faq[] = array("Wstawianie kodu lub danych o sta�ej szeroko�ci", "Je�li chcesz wstawi� kawa�ek kodu lub cokolwiek wymagaj�cego sta�ej szeroko�ci znak�w, jak w czcionce Courier powin" .  (($he) ? 'iene�' : 'na�') . " zamkn�� tekst wewn�trz znacznik�w <b>[code][/code]</b>, np:<br /><br /><b>[code]</b>echo \"Troch� kodu\";<b>[/code]</b><br /><br />Ca�e formatowanie u�yte wewn�trz znacznik�w <b>[code][/code]</b> jest zachowywane przy przegl�daniu.");

$faq[] = array("--","Tworzenie list");
$faq[] = array("Tworzenie listy Nieuporz�dkowanej", "BBCode umo�liwia wstawianie dw�ch rodzaj�w list, nieuporz�dkowan� i uporz�dkowan�. S� w zasadzie takie same jak ich ekwiwalenty w HTML. Lista nieuporz�dkowana prezentuje kolejne pozycje jedna po drugiej, oznaczaj�c je graficznymi znakami. Aby utworzy� list� nieuporz�dkowan� u�yj znacznika <b>[list][/list]</b> i oznacz ka�d� pozycj� u�ywaj�c <b>[*]</b>. Na przyk�ad aby zrobi� list� twoich ulubionych kolor�w mo�esz u�y�:<br /><br /><b>[list]</b><br /><b>[*]</b>Czerwony<br /><b>[*]</b>Niebieski<br /><b>[*]</b>��ty<br /><b>[/list]</b><br /><br />Zmieni si� to w list�:<ul><li>Czerwony</li><li>Niebieski</li><li>��ty</li></ul>");
$faq[] = array("Tworzenie listy Uporz�dkowanej", "Drugi typ list, uporz�dkowany daje kontrol� nad tym, co jest wy�wietlane przed ka�dym elementem. Aby utworzy� list� uporz�dkowan� u�yj <b>[list=1][/list]</b> dla listy numerowanej lub alterntywnie <b>[list=a][/list]</b> dla listy alfabetycznej. Podobnie jak w li�cie nieuporz�dkowanej elementy s� wyznaczane przez <b>[*]</b>. Na przyk�ad<br /><br /><b>[list=1]</b><br /><b>[*]</b>Id� do sklepu<br /><b>[*]</b>Kup nowy komputer<br /><b>[*]</b>Przeklnij komputer kiedy si� zawiesi<br /><b>[/list]</b><br /><br />co zamieni si� w nast�puj�ce:<ol type=\"1\"><li>Id� do sklepu</li><li>Kup nowy komputer</li><li>Przeklnij komputer kiedy si� zawiesi</li></ol>Podczas gdy dla alfabetycznej listy u�y�" .  (($he) ? '' : 'a') . "by�:<br /><br /><b>[list=a]</b><br /><b>[*]</b>Pierwsza mo�liwa odpowied�<br /><b>[*]</b>Druga mo�liwa odpowied�<br /><b>[*]</b>Trzecia mo�liwa odpowied�<br /><b>[/list]</b><br /><br />co da<ol type=\"a\"><li>Pierwsza mo�liwa odpowied�</li><li>Druga mo�liwa odpowied�</li><li>Trzecia mo�liwa odpowied�</li></ol>");

$faq[] = array("--", "Tworzenie link�w");
$faq[] = array("Odno�niki do innych stron", "BBCode phpBB umo�liwia na r�ne sposoby tworzenie URI, Uniform Resource Indicators znanych jako URL'e.<ul><li>Pierwsza wykorzystuje znacznik <b>[url=][/url]</b>, cokolwiek wpiszesz po znaku = zostanie zmienione na cel odno�nika. Na przyk�ad aby wstawi� link do phpBB.com mo�esz u�y�:<br /><br /><b>[url=http://www.phpbb.com/]</b>Odwied� phpBB!<b>[/url]</b><br /><br />Co zmieni si� w odno�nik <a href=\"http://www.phpbb.com/\" target=\"_blank\">Odwied� phpBB!</a>. Zauwa�, �e odno�nik otwiera si� w nowym oknie, tak wi�c u�ytkownik mo�e kontynuowa� forum je�li chce.</li><li>Je�eli chcesz aby sam URL by� wy�wietlany jako link mo�esz to zrobi� u�ywaj�c zwyczajnie:<br /><br /><b>[url]</b>http://www.phpbb.com/<b>[/url]</b><br /><br />Co utworzy link <a href=\"http://www.phpbb.com/\" target=\"_blank\">http://www.phpbb.com/</a></li><li>Dodatkowo phpBB umo�lwia wykorzystanie tzw. <i>Magicznych Link�w</i>, kt�re zmieniaj� prawid�owo wpisany URL w odno�nik bez potrzeby dodawania jakichkolwiek znacznik� lub nawet dopisywania na pocz�tku http://. Na przyk�ad wpisanie www.phpbb.com w wiadomo�ci zmieni si� automatycznie w <a href=\"http://www.phpbb.com/\" target=\"_blank\">www.phpbb.com</a> przy wy�wietlaniu wiadomo�ci.</li><li>Podobnie jest z adresami email, mo�esz albo poda� adres wyra�nie, np:<br /><br /><b>[email]</b>nikt@domena.adr<b>[/email]</b><br /><br />co zamieni si� na <a href=\"emailto:nikt@domena.adr\">nbikt@domena.adr</a> albo wpisa� jedynie nikt@domena.adr w wiadomo�ci i zostanie to automatycznie zamienione podczas wy�wietlania wiadomo�ci.</li></ul>Podobnie jak ze wszystkimi znacznikami BBCode mo�esz otacza� adresy URL jakimikolwiek innymi znacznikami, jak <b>[img][/img]</b> (zobacz kolejny punkt), <b>[b][/b]</b>, itp. Je�li chodzi o znaczniki formatuj�ce, do ciebie nale�y dba�o�� o poprawn� kolejno�� otwietania i zamykania, na przyk�ad:<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/url][/img]</b><br /><br />jest <u>nieprawid�owe</u> przez co tw�j post mo�e zosta� usuni�ty.");

$faq[] = array("--", "Wstawianie obrazk�w do post�w");
$faq[] = array("Dodawanie obrazka do postu", "BBCode phpBB zawiera znacznik umo�liwiaj�cy wstawianie obrazk�w do post�w. Nale�y jednak pami�ta� o dw�ch istotnych rzeczach: wielu u�ytkownik�w nie lubi du�ych ilo�ci obrazk�w w postach oraz wstawiany obrazek musi by� ju� dost�pny w internecie (nie mo�e na przyk�ad istnie� tylko na twoim komputerze, chyba �e masz u siebie serwer!). Nie ma obecnie mo�liwo�ci przechowywania obrazk�w lokalnie wraz z phpBB (problemy te zostan� prawdopodobnie rozwi�zane w nast�pnej wersji phpBB). Aby wstawi� obrazek musisz otoczy� jego adres URL znacznikami <b>[img][/img]</b>. Na przyk�ad:<br /><br /><b>[img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img]</b><br /><br />Jak zaznaczono w sekcji URL powy�ej mo�esz otoczy� obrazek znacznikami <b>[url][/url]</b> je�li chcesz, np.<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img][/url]</b><br /><br />zmieni si� w:<br /><br /><a href=\"http://www.phpbb.com/\" target=\"_blank\"><img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" /></a><br />");

$faq[] = array("--", "Inne sprawy");
$faq[] = array("Czy mog� doda� w�asne znaczniki?", "Nie, obawiam si� �e nie bezpo�rednio w phpBB 2.0. Planujemy wprowadzenie modyfikowalnej listy znacznik�w BBCode w nast�pnej wersji forum.");

//
// This ends the BBCode guide entries
//

?>