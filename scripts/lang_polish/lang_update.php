<?php
$lang['no_admin'] = 'Nie jeste� administratorem.';
$lang['No_query_info'] = 'Wa�ne jest aby sprawdzi� pow�d niewykonania instrukcji. Prawid�owym objawem niewykonania instrukcji jest istnienie ju� w bazie lub brak takiej tabeli lub kolumny w tabeli. Nieprawid�owym objawem jest jedynie informacja o braku dost�pu do komendy lub b��d w sk�adni instrukcji SQL (syntax). W razie w�tpliwo�ci mo�na poszuka� odpowiedzi lub zada� pytanie na forum: <a href="http://www.przemo.org/phpBB2/" tatger="_blank">http://www.przemo.org/phpBB2/</a> wklejaj�c lini� kt�ra nie zosta�a wykonana. Uwaga nie nale�y korzysta� z pliku update.sql do wykonania aktualizacji "r�cznie" gdy� nie zawiera on wszystkich koniecznych instrukcji !';
$lang['update_body'] = '<b>Modyfikacja forum do wersji phpBB modified v1.12.13 by Przemo</b></span><br /><span class="gensmall">U�yj aby uaktualni� z wersji phpBB modified by Przemo 1.12.8</span></td></tr>
	<tr><td class="row2"><span class="gensmall">
	<b>Instrukcja:</b><br />
	Przed przyst�pieniem do aktualizacji, na wszelki wypadek zr�b kopi� swojego forum. Skopiuj wszystkie pliki, oraz zr�b kopi� bazy danych,
	w Panelu Admina, lub w PhpMyAdminie.<br />
	Gdy masz ju� kopi� forum, nie nadpisujesz jeszcze plik�w forum, plikami aktualizacji, tylko najpierw uruchamiasz aktualizacj� (przycisk ni�ej)
	<br />Teraz naci�nij przycisk <b>"Zacznij aktualizacj�"</b> 
	Zostan� wy�wietlone instrukcje kt�re nie zosta�y wykonane, zar�wno w aktualizacji z oryginalnego phpBB jak i aktualizacji z ni�szej wersji phpBB by Przemo wiele z tych instrukcji nie zostanie wykonanych gdy� jest to uniwersalny aktualizator. ' . $lang['No_query_info'] . '<br />
	Je�eli operacja b�dzie trwa� za d�ugo i serwer zatrzyma skrypt, mo�esz wykona� aktualizacj� ponownie (od�wie�y� stron�) kolejne czynno�ci b�d� wykonywane.<br />
	Po zako�czeniu nadpisz pliki swojego forum, plikami mojej wersji. Musi by� taka kolejno��, najpierw w��czenie aktualizacji potem nadpisanie plik�w. W odwrotnej kolejno�ci, trzeba by� ca�y czas zalogowanym jako admin przy kopiowaniu plik�w, co mo�e sie nie uda� i w�wczas trzeba skorzysta� z kopii swojego forum :)
	<br /><br />�ycz� powodzenia.';
$lang['start_update'] = 'Zacznij aktualizacj�';
$lang['checksum_error'] = 'Nieprawid�owa suma kontrolna pliku <b>%s</b> ! (%s)<br />Spr�buj jeszcze raz skopiowa� plik na serwer.';
$lang['result'] = '<b>Wynik aktualizacji bazy do wersji phpBB modified v1.12.13 by Przemo</b><br />Instrukcji wykonanych: <b>%s</b>, niewykonanych: <b>%s</b><br /><br />&bull;Sprawd� poni�sze instrukcje SQL<br /><span class="gensmall">' . $lang['No_query_info'] . '</span><br /><br />&bull; Nadpisz wszystkie pliki  opr�cz <i><b>config.php</b></i><br />&bull; Sprawd� w Panelu Admina: Kontrol� Systemu, zwr�� uwag� na prawa katalog�w do zapisu<br />&bull; Je�eli aktualizujesz z oryginalnego phpBB popraw w Panelu Admina i przenie� do katalogu stylu obrazki rang<br />&bull; <span class="gensmall">U�yj pliku <a href="update_useragent.php" target="_blank">/scripts/update_useragent.php</a> aby dostosowa� ikony przegl�darek dla "starych" post�w (u�yj po wys�aniu nowych plik�w) </span><br />&bull; Dopasuj nowe kolory Admina, JR Admina, Moderator�w, kolor�w OnMouseOver w Panelu Admina w edycji danych stylu';
$lang['failed'] = 'Niewykonane';
$lang['query_ok'] = 'Wykonane';
$lang['No_available_db'] = 'phpBB by Przemo obs�uguje tylko baz� danych MySQL. Aktualne forum korzysta z innej bazy danych.';

$lang['UA_time_exc'] = 'Czas generowania strony zosta� przekroczony. <br />Zosta�o przetworzonych post�w: <b>%s</b> z <b>%s</b> <br />Kontynuuj konwersj�: %sDalej%s.';
$lang['UA_title'] = 'Aktualizacja identyfikatora przegl�darki';
$lang['UA_finished'] = 'Aktualizacja zosta�a zako�czona. <br />Zaktualizowano post�w: <b>%s</b>';
$lang['UA_no_useragent'] = 'Nie mo�na odnale�� katalogu z ikonami system�w i przegl�darek. <br />Sprawd�, czy katalog <i>templates/subSilver/images/user_agent</i> istnieje. Je�li nie, skopiuj go ze �ci�gni�tej paczki. <br />Je�li istnieje, a pojawia si� ten komunikat, zg�o� to nam na forum <a href="http://www.przemo.org/phpBB2/forum/">http://www.przemo.org/phpBB2/forum/</a>.';
$lang['Generate_file'] = 'Zaznacz aby tylko wygenerowa� plik z zapytaniami do bazy<br />UWAGA nie wszystkie zapytania zostaj� wykonane, tak wi�c "r�czne" wykonanie zapyta� mo�e by� k�opotliwe';
$lang['dangerous_files'] = 'UWAGA: skrypt wykry� na serwerze pliki, kt�re mog� by� niebezpieczne. Poniewa� poni�sze pliki nie powinny si� znajdowa� w tych miejscach, zalecane jest aby szczeg�owo przejrze� ka�dy z nich i upewni� si�, �e nie zawiera on exploita lub innego niebezpiecznego kodu. W przypadku w�tpliwo�ci, zg�o� to nam na forum <a href="http://www.przemo.org/phpBB2/forum/">http://www.przemo.org/phpBB2/forum/</a>. Je�li masz pe�n� �wiadomo��, �e poni�sze pliki nale�� do Ciebie i nie s� niebezpieczne, kontynuuj aktualizacj�';
?>