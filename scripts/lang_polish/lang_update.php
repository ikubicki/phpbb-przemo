<?php
$lang['no_admin'] = 'Nie jeste¶ administratorem.';
$lang['No_query_info'] = 'Wa¿ne jest aby sprawdziæ powód niewykonania instrukcji. Prawid³owym objawem niewykonania instrukcji jest istnienie ju¿ w bazie lub brak takiej tabeli lub kolumny w tabeli. Nieprawid³owym objawem jest jedynie informacja o braku dostêpu do komendy lub b³±d w sk³adni instrukcji SQL (syntax). W razie w±tpliwo¶ci mo¿na poszukaæ odpowiedzi lub zadaæ pytanie na forum: <a href="http://www.przemo.org/phpBB2/" tatger="_blank">http://www.przemo.org/phpBB2/</a> wklejaj±c liniê która nie zosta³a wykonana. Uwaga nie nale¿y korzystaæ z pliku update.sql do wykonania aktualizacji "rêcznie" gdy¿ nie zawiera on wszystkich koniecznych instrukcji !';
$lang['update_body'] = '<b>Modyfikacja forum do wersji phpBB modified v1.12.9 by Przemo</b></span><br /><span class="gensmall">U¿yj aby uaktualniæ z wersji phpBB modified by Przemo 1.12.8</span></td></tr>
	<tr><td class="row2"><span class="gensmall">
	<b>Instrukcja:</b><br />
	Przed przyst±pieniem do aktualizacji, na wszelki wypadek zrób kopiê swojego forum. Skopiuj wszystkie pliki, oraz zrób kopiê bazy danych,
	w Panelu Admina, lub w PhpMyAdminie.<br />
	Gdy masz ju¿ kopiê forum, nie nadpisujesz jeszcze plików forum, plikami aktualizacji, tylko najpierw uruchamiasz aktualizacjê (przycisk ni¿ej)
	<br />Teraz naci¶nij przycisk <b>"Zacznij aktualizacjê"</b> 
	Zostan± wy¶wietlone instrukcje które nie zosta³y wykonane, zarówno w aktualizacji z oryginalnego phpBB jak i aktualizacji z ni¿szej wersji phpBB by Przemo wiele z tych instrukcji nie zostanie wykonanych gdy¿ jest to uniwersalny aktualizator. ' . $lang['No_query_info'] . '<br />
	Je¿eli operacja bêdzie trwaæ za d³ugo i serwer zatrzyma skrypt, mo¿esz wykonaæ aktualizacjê ponownie (od¶wie¿yæ stronê) kolejne czynno¶ci bêd± wykonywane.<br />
	Po zakoñczeniu nadpisz pliki swojego forum, plikami mojej wersji. Musi byæ taka kolejno¶æ, najpierw w³±czenie aktualizacji potem nadpisanie plików. W odwrotnej kolejno¶ci, trzeba byæ ca³y czas zalogowanym jako admin przy kopiowaniu plików, co mo¿e sie nie udaæ i wówczas trzeba skorzystaæ z kopii swojego forum :)
	<br /><br />¯yczê powodzenia.';
$lang['start_update'] = 'Zacznij aktualizacjê';
$lang['checksum_error'] = 'Nieprawid³owa suma kontrolna pliku <b>%s</b> ! (%s)<br />Spróbuj jeszcze raz skopiowaæ plik na serwer.';
$lang['result'] = '<b>Wynik aktualizacji bazy do wersji phpBB modified v1.12.9 by Przemo</b><br />Instrukcji wykonanych: <b>%s</b>, niewykonanych: <b>%s</b><br /><br />&bull;Sprawd¼ poni¿sze instrukcje SQL<br /><span class="gensmall">' . $lang['No_query_info'] . '</span><br /><br />&bull; Nadpisz wszystkie pliki  oprócz <i><b>config.php</b></i><br />&bull; Sprawd¼ w Panelu Admina: Kontrolê Systemu, zwróæ uwagê na prawa katalogów do zapisu<br />&bull; Je¿eli aktualizujesz z oryginalnego phpBB popraw w Panelu Admina i przenie¶ do katalogu stylu obrazki rang<br />&bull; <span class="gensmall">U¿yj pliku <a href="update_useragent.php" target="_blank">/scripts/update_useragent.php</a> aby dostosowaæ ikony przegl±darek dla "starych" postów (u¿yj po wys³aniu nowych plików) </span><br />&bull; Dopasuj nowe kolory Admina, JR Admina, Moderatorów, kolorów OnMouseOver w Panelu Admina w edycji danych stylu';
$lang['failed'] = 'Niewykonane';
$lang['query_ok'] = 'Wykonane';
$lang['No_available_db'] = 'phpBB by Przemo obs³uguje tylko bazê danych MySQL. Aktualne forum korzysta z innej bazy danych.';

$lang['UA_time_exc'] = 'Czas generowania strony zosta³ przekroczony. <br />Zosta³o przetworzonych postów: <b>%s</b> z <b>%s</b> <br />Kontynuuj konwersjê: %sDalej%s.';
$lang['UA_title'] = 'Aktualizacja identyfikatora przegl±darki';
$lang['UA_finished'] = 'Aktualizacja zosta³a zakoñczona. <br />Zaktualizowano postów: <b>%s</b>';
$lang['UA_no_useragent'] = 'Nie mo¿na odnale¼æ katalogu z ikonami systemów i przegl±darek. <br />Sprawd¼, czy katalog <i>templates/subSilver/images/user_agent</i> istnieje. Je¶li nie, skopiuj go ze ¶ci±gniêtej paczki. <br />Je¶li istnieje, a pojawia siê ten komunikat, zg³o¶ to nam na forum <a href="http://www.przemo.org/phpBB2/forum/">http://www.przemo.org/phpBB2/forum/</a>.';
$lang['Generate_file'] = 'Zaznacz aby tylko wygenerowaæ plik z zapytaniami do bazy<br />UWAGA nie wszystkie zapytania zostaj± wykonane, tak wiêc "rêczne" wykonanie zapytañ mo¿e byæ k³opotliwe';
$lang['dangerous_files'] = 'UWAGA: skrypt wykry³ na serwerze pliki, które mog± byæ niebezpieczne. Poniewa¿ poni¿sze pliki nie powinny siê znajdowaæ w tych miejscach, zalecane jest aby szczegó³owo przejrzeæ ka¿dy z nich i upewniæ siê, ¿e nie zawiera on exploita lub innego niebezpiecznego kodu. W przypadku w±tpliwo¶ci, zg³o¶ to nam na forum <a href="http://www.przemo.org/phpBB2/forum/">http://www.przemo.org/phpBB2/forum/</a>. Je¶li masz pe³n± ¶wiadomo¶æ, ¿e poni¿sze pliki nale¿± do Ciebie i nie s± niebezpieczne, kontynuuj aktualizacjê';
?>