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
$he = ($userdata['user_gender'] != 2) ? true : false;
  
$faq[] = array("--","Wprowadzenie");
$faq[] = array("Czym jest BBCode?", "BBCode jest specjalną implementacją HTML'a, a możliwość jego używania jest uzależniona od ustawień dokonanych przez administratora (możesz także wyłączać go dla każdego postu osobno w formularzu wysyłania). Sam BBCode jest podobny stylowo do HTML'a, znaczniki są zawarte w nawiasach kwadratowych [ i ] a nie &lt; i &gt; oraz oferuje większą kontrolę nad tym co i jak będzie wyświetlane. Zależnie od szablonu, którego używasz możesz w bardzo łatwy sposób dodawać znaczniki BBCode do postów poprzez odpowiednie przyciski na stronie wysyłania postu. Mimo to ten przewodnik powinien być przydatny.");

$faq[] = array("--","Formatowanie Tekstu");
$faq[] = array("Jak wpisać pogrubiony, pochylony lub podkreślony tekst", "BBCode zawiera znaczniki pozwalające na szybką zmianę podstawowego wyglądu tekstu. Można to uzyskać na poniższe sposoby:<ul><li>Aby pogrubić jakiś tekst wstaw go pomiędzy <b>[b][/b]</b>, np. <br /><br /><b>[b]</b>Cześć<b>[/b]</b><br /><br />stanie się <b>Cześć</b></li><li>Do podkreśleń użyj <b>[u][/u]</b>, na przykład:<br /><br /><b>[u]</b>Dzień Dobry<b>[/u]</b><br /><br />stanie się <u>Dzień Dobry</u></li><li>Aby wpisać tekst kursywą użyj <b>[i][/i]</b>, np.<br /><br />To jest <b>[i]</b>Świetne!<b>[/i]</b><br /><br />co zmieni się na To jest <i>Świetne!</i></li></ul>");
$faq[] = array("Jak zmienić kolor lub rozmiar tekstu", "Aby zmienić kolor lub rozmiar tekstu można użyć następujących znaczników. Pamiętaj, że to jaki będzie rezultat po wyświetleniu zależy od przeglądarki i systemu użytkownika:<ul><li>Zmianę koloru tekstu można osiągnąć przez otoczenie go <b>[color=][/color]</b>. Możesz podać albo nazwę koloru (np. red, blue, yellow, itp.) lub szesnastkową wartość, np. #FFFFFF, #000000. Na przykład aby stworzyć czerwony tekst możesz użyć<br /><br /><b>[color=red]</b>Cześć!<b>[/color]</b><br /><br />albo<br /><br /><b>[color=#FF0000]</b>Cześć!<b>[/color]</b><br /><br />oba wyświetlą te same <span style=\"color:red\">Cześć!</span></li><li>Zmiana rozmiaru tekstu jest osiągana w podobny sposób używając <b>[size=][/size]</b>. Ten znacznik jest zależny od szablonu, którego używasz ale rekomendowanym formatem jest numeryczna wartość reprezentująca rozmiar tekstu w pikselach, zaczynając od 1 (tak mały, że go nie widać) aż do 26 (bardzo duży). Na przykład:<br /><br /><b>[size=9]</b>MAŁY<b>[/size]</b><br /><br /> będzie generalnie <span style=\"font-size:9px\">MAŁY</span><br /><br />podczas gdy:<br /><br /><b>[size=24]</b>WIELKI!<b>[/size]</b><br /><br />będzie<span style=\"font-size:24px\">WIELKI!</span></li></ul>");
$faq[] = array("Czy mogę łączyć znaczniki formatujące?", "Tak, naturalnie że możesz, na przykład aby zwrócić czyjąć uwagę możesz napisać:<br /><br /><b>[size=18][color=red][b]</b>POPATRZ NA MNIE!<b>[/b][/color][/size]</b><br /><br />co zmieni się w <span style=\"color:red;font-size:18px\"><b>POPATRZ NA MNIE!</b></span><br /><br />Nie radzimy jednak wpisywać dużych ilosci tekstu o takim wyglądzie! Pamiętaj, że od ciebie zależy zachowanie poprawnej kolejności początkowych i końcowych znaczników. Na przykład poniższe nie jest prawidłowe:<br /><br /><b>[b][u]</b>Tak jest źle<b>[/b][/u]</b>");

$faq[] = array("--","Cytowanie i wpisywanie tekstu o stałej szerokości");
$faq[] = array("Cytowanie tekstu w odpowiedziach", "Są dwa sosoby na cytowanie tekstu, z podaniem źródła lub bez.<ul><li>Kiedy wykorzystujesz funkcję cytowania odpowiadając na post na forum powin" .  (($he) ? 'ieneś' : 'naś') . " zauważyć, że tekst jest dodawany do wiadomości otoczony blokiem <b>[quote=\"\"][/quote]</b>. Ta metoda pozwala cytować z podaniem źródła czyli osoby lub czegokolwiek innego, co zechcesz podać. Na przykład aby zacytować kawałek tekstu napisanego przez Mr. Blobby możesz wpisać:<br /><br /><b>[quote=\"Mr. Blobby\"]</b>Tekst Mr. Blobby zostanie wstawiony tutaj<b>[/quote]</b><br /><br />Wynikiem czego będzie automatyczne dodanie Mr. Blobby napisał: przed właściwym tekstem. Pamiętaj, <b>musisz</b> wstawić znaki \"\" wokół nazwy źródła, nie są one jedynie opcją.</li><li>Druga metoda pozwala cytować coś nie podając źródła. Aby jej użyć wstaw tekst między znaczniki <b>[quote][/quote]</b>. Kiedy będziesz przeglądał wiadomości, zobaczysz po prostu słowo Cytat: przed samym tekstem.</li></ul>");
$faq[] = array("Wstawianie kodu lub danych o stałej szerokości", "Jeśli chcesz wstawić kawałek kodu lub cokolwiek wymagającego stałej szerokości znaków, jak w czcionce Courier powin" .  (($he) ? 'ieneś' : 'naś') . " zamknąć tekst wewnątrz znaczników <b>[code][/code]</b>, np:<br /><br /><b>[code]</b>echo \"Trochę kodu\";<b>[/code]</b><br /><br />Całe formatowanie użyte wewnątrz znaczników <b>[code][/code]</b> jest zachowywane przy przeglądaniu.");

$faq[] = array("--","Tworzenie list");
$faq[] = array("Tworzenie listy Nieuporządkowanej", "BBCode umożliwia wstawianie dwóch rodzajów list, nieuporządkowaną i uporządkowaną. Są w zasadzie takie same jak ich ekwiwalenty w HTML. Lista nieuporządkowana prezentuje kolejne pozycje jedna po drugiej, oznaczając je graficznymi znakami. Aby utworzyć listę nieuporządkowaną użyj znacznika <b>[list][/list]</b> i oznacz każdą pozycję używając <b>[*]</b>. Na przykład aby zrobić listę twoich ulubionych kolorów możesz użyć:<br /><br /><b>[list]</b><br /><b>[*]</b>Czerwony<br /><b>[*]</b>Niebieski<br /><b>[*]</b>Żółty<br /><b>[/list]</b><br /><br />Zmieni się to w listę:<ul><li>Czerwony</li><li>Niebieski</li><li>Żółty</li></ul>");
$faq[] = array("Tworzenie listy Uporządkowanej", "Drugi typ list, uporządkowany daje kontrolę nad tym, co jest wyświetlane przed każdym elementem. Aby utworzyć listę uporządkowaną użyj <b>[list=1][/list]</b> dla listy numerowanej lub alterntywnie <b>[list=a][/list]</b> dla listy alfabetycznej. Podobnie jak w liście nieuporządkowanej elementy są wyznaczane przez <b>[*]</b>. Na przykład<br /><br /><b>[list=1]</b><br /><b>[*]</b>Idź do sklepu<br /><b>[*]</b>Kup nowy komputer<br /><b>[*]</b>Przeklnij komputer kiedy się zawiesi<br /><b>[/list]</b><br /><br />co zamieni się w następujące:<ol type=\"1\"><li>Idź do sklepu</li><li>Kup nowy komputer</li><li>Przeklnij komputer kiedy się zawiesi</li></ol>Podczas gdy dla alfabetycznej listy użył" .  (($he) ? '' : 'a') . "byś:<br /><br /><b>[list=a]</b><br /><b>[*]</b>Pierwsza możliwa odpowiedź<br /><b>[*]</b>Druga możliwa odpowiedź<br /><b>[*]</b>Trzecia możliwa odpowiedź<br /><b>[/list]</b><br /><br />co da<ol type=\"a\"><li>Pierwsza możliwa odpowiedź</li><li>Druga możliwa odpowiedź</li><li>Trzecia możliwa odpowiedź</li></ol>");

$faq[] = array("--", "Tworzenie linków");
$faq[] = array("Odnośniki do innych stron", "BBCode phpBB umożliwia na różne sposoby tworzenie URI, Uniform Resource Indicators znanych jako URL'e.<ul><li>Pierwsza wykorzystuje znacznik <b>[url=][/url]</b>, cokolwiek wpiszesz po znaku = zostanie zmienione na cel odnośnika. Na przykład aby wstawić link do phpBB.com możesz użyć:<br /><br /><b>[url=http://www.phpbb.com/]</b>Odwiedź phpBB!<b>[/url]</b><br /><br />Co zmieni się w odnośnik <a href=\"http://www.phpbb.com/\" target=\"_blank\">Odwiedź phpBB!</a>. Zauważ, że odnośnik otwiera się w nowym oknie, tak więc użytkownik może kontynuować forum jeśli chce.</li><li>Jeżeli chcesz aby sam URL był wyświetlany jako link możesz to zrobić używając zwyczajnie:<br /><br /><b>[url]</b>http://www.phpbb.com/<b>[/url]</b><br /><br />Co utworzy link <a href=\"http://www.phpbb.com/\" target=\"_blank\">http://www.phpbb.com/</a></li><li>Dodatkowo phpBB umożlwia wykorzystanie tzw. <i>Magicznych Linków</i>, które zmieniają prawidłowo wpisany URL w odnośnik bez potrzeby dodawania jakichkolwiek znacznikó lub nawet dopisywania na początku http://. Na przykład wpisanie www.phpbb.com w wiadomości zmieni się automatycznie w <a href=\"http://www.phpbb.com/\" target=\"_blank\">www.phpbb.com</a> przy wyświetlaniu wiadomości.</li><li>Podobnie jest z adresami email, możesz albo podać adres wyraźnie, np:<br /><br /><b>[email]</b>nikt@domena.adr<b>[/email]</b><br /><br />co zamieni się na <a href=\"emailto:nikt@domena.adr\">nbikt@domena.adr</a> albo wpisać jedynie nikt@domena.adr w wiadomości i zostanie to automatycznie zamienione podczas wyświetlania wiadomości.</li></ul>Podobnie jak ze wszystkimi znacznikami BBCode możesz otaczać adresy URL jakimikolwiek innymi znacznikami, jak <b>[img][/img]</b> (zobacz kolejny punkt), <b>[b][/b]</b>, itp. Jeśli chodzi o znaczniki formatujące, do ciebie należy dbałość o poprawną kolejność otwietania i zamykania, na przykład:<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/url][/img]</b><br /><br />jest <u>nieprawidłowe</u> przez co twój post może zostać usunięty.");

$faq[] = array("--", "Wstawianie obrazków do postów");
$faq[] = array("Dodawanie obrazka do postu", "BBCode phpBB zawiera znacznik umożliwiający wstawianie obrazków do postów. Należy jednak pamiętać o dwóch istotnych rzeczach: wielu użytkowników nie lubi dużych ilości obrazków w postach oraz wstawiany obrazek musi być już dostępny w internecie (nie może na przykład istnieć tylko na twoim komputerze, chyba że masz u siebie serwer!). Nie ma obecnie możliwości przechowywania obrazków lokalnie wraz z phpBB (problemy te zostaną prawdopodobnie rozwiązane w następnej wersji phpBB). Aby wstawić obrazek musisz otoczyć jego adres URL znacznikami <b>[img][/img]</b>. Na przykład:<br /><br /><b>[img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img]</b><br /><br />Jak zaznaczono w sekcji URL powyżej możesz otoczyć obrazek znacznikami <b>[url][/url]</b> jeśli chcesz, np.<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img][/url]</b><br /><br />zmieni się w:<br /><br /><a href=\"http://www.phpbb.com/\" target=\"_blank\"><img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" /></a><br />");

$faq[] = array("--", "Inne sprawy");
$faq[] = array("Czy mogę dodać własne znaczniki?", "Nie, obawiam się że nie bezpośrednio w phpBB 2.0. Planujemy wprowadzenie modyfikowalnej listy znaczników BBCode w następnej wersji forum.");

//
// This ends the BBCode guide entries
//

?>