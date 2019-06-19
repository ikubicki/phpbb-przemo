<?php

/***************************************************************************
 *                                lang_xs.php
 *                                -----------
 *   copyright            : (C) 2003 - 2005 CyberAlien
 *   support              : http://www.phpbbstyles.com
 *
 *   version              : 2.2.0
 *
 *   file revision        : 55
 *   project revision     : 66
 *   last modified        : 09 Mar 2005  14:49:49
 *
 *   polish version       : Przemo ( http://www.przemo.org/phpBB2/ )
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

$lang['ENCODING'] = 'iso-8859-2';

$lang['Extreme_Styles'] = 'eXtreme Styles';
$lang['xs_title'] = 'eXtreme Styles';

$lang['xs_file'] = 'Plik';
$lang['xs_template'] = 'Schemat';
$lang['xs_id'] = 'ID';
$lang['xs_style'] = 'Styl';
$lang['xs_styles'] = 'Style';
$lang['xs_users'] = 'U�ytkownicy';
$lang['xs_options'] = 'Opcje';
$lang['xs_comment'] = 'Komentarz';
$lang['xs_upload_time'] = 'Czas wysy�ania';
$lang['xs_select'] = 'Wyb�r';

$lang['xs_continue'] = 'Kontynuuj';	// button

$lang['xs_click_here_lc'] = 'kliknij tutaj';
$lang['xs_edit_lc'] = 'edycja';

/*
* navigation
*/
$lang['xs_config_shownav'] = array(
	'Konfiguracja',
	'Instaluj Style',
	'Odinstaluj style',
	'Domy�lny Styl',
	'Zarz�dzaj Cache\'m',
	'Importuj Styl',
	'Eksportuj Styl',
	'Klonuj Styl',
	'Pobierz Styl',
	'Edytuj Schemat',
	'Edytuj Styl',
	'Eksportuj Dane',
	'Sprawd� Uaktualnienia',
	);

/*
* frame_top.tpl
*/
$lang['xs_menu_lc'] = 'Menu';
$lang['xs_support_forum_lc'] = 'forum supportu';
$lang['xs_download_styles_lc'] = 'pobierz style';
$lang['xs_install_styles_lc'] = 'instaluj style';

/*
* index.tpl
*/

$lang['xs_main_comment1'] = 'To jest g�owne menu eXtreme Styles.<br />Ten modu� zast�puje oryginalne zarz�dzanie stylami. S� tu tak�e oryginalne funkcje phpBB2, jednak zosta�y zoptymalizowane i posiadaj� dodatkowe mo�liwo�ci.';
$lang['xs_main_comment2'] = 'eXtreme Styles pozwala na zapisanie danych stylu do pliku w formie skompresowanej.';
$lang['xs_main_comment3'] = 'Wszystkie funkcje zarz�dzania stylami phpBB2 zosta�y zast�pione przez eXtreme Styles<br /><br /><a href="{URL}">Kliknij tutaj</a> aby zobaczy� Menu.';
$lang['xs_main_title'] = 'eXtreme Styles Menu Nawigacji';
$lang['xs_menu'] = 'eXtreme Styles Menu';

$lang['xs_manage_styles'] = 'Zarz�dzanie Stylami';
$lang['xs_import_export_styles'] = 'Import/Eksport Styl�w';
$lang['xs_install_uninstall_styles'] = 'Instalacja/Deinstalacja Styl�w';
$lang['xs_edit_templates'] = 'Edycja Styl�w';
$lang['xs_other_functions'] = 'Inne funkcje';

$lang['xs_configuration'] = 'Konfiguracja';
$lang['xs_configuration_explain'] = 'Konfiguracja eXtreme Styles';
$lang['xs_default_style'] = 'Domy�lny styl';
$lang['xs_default_style_explain'] = 'Ta opcja pozwala na ustawienie domy�lnego stylu forum, oraz prze��czenie styl�w u�ytkownik�w.';
$lang['xs_manage_cache'] = 'Zarz�dzanie Cach\'em';
$lang['xs_manage_cache_explain'] = 'Zarz�dzanie plikami cache.';
$lang['xs_import_styles'] = 'Import Stylu';
$lang['xs_import_styles_explain'] = 'Tutaj mo�esz pobra� i instalowa� pliki .style';
$lang['xs_export_styles'] = 'Eksport Stylu';
$lang['xs_export_styles_explain'] = 'W tym miejscu mo�esz zapisa� styl swojego forum do pliku .style co umo�liwia mi�dzy innymi �atwy transfer na inne forum';
$lang['xs_clone_styles'] = 'Klonuj Styl';
$lang['xs_clone_styles_explain'] = 'W tym miejscu mo�esz sklonowa� wybrany styl.';
$lang['xs_download_styles'] = 'Pobierz Style';
$lang['xs_download_styles_explain'] = 'Ta funkcja pozwala na szybkie pobranie i zainstalowanie styl�w ze strony www. Mo�esz zarz�dza� list� dost�pnych stron.';
$lang['xs_install_styles'] = 'Instaluj Style';
$lang['xs_install_styles_explain'] = 'W tym miejscu mo�esz zainstalowa� style kt�re znajduj� si� w katalogu /templates/';
$lang['xs_uninstall_styles'] = 'Deinstalacja Styl�w';
$lang['xs_uninstall_styles_explain'] = 'W tym miejscu mo�esz odinstalowa� style z forum.';
$lang['xs_edit_templates_explain'] = 'W tym miejscu mo�esz edytowa� pliki .tpl poprzez formularz.';
$lang['xs_edit_styles_data'] = 'Edycja Danych Styl�w';
$lang['xs_edit_styles_data_explain'] = 'W tym miejscu mo�esz edytowa� kolory styl�w';
$lang['xs_export_styles_data'] = 'Eksport Danych Stylu';
$lang['xs_export_styles_data_explain'] = 'W tym miejscu mo�esz zapisa� ustawienia danych stylu, znajduj�cych si� w pliku theme_info.cfg.';
$lang['xs_check_for_updates'] = 'Sprawd� Altualizacje';
$lang['xs_check_for_updates_explain'] = 'W tym miejscu mo�esz sprawdzi�, czy jest dost�pna nowa wersja modu�u';

$lang['xs_set_configuration_lc'] = 'konfiguracja';
$lang['xs_set_default_style_lc'] = 'domy�lny styl';
$lang['xs_manage_cache_lc'] = 'zarz�dzaj cache\'m';
$lang['xs_import_styles_lc'] = 'importuj styl';
$lang['xs_export_styles_lc'] = 'eksportuj styl';
$lang['xs_clone_styles_lc'] = 'klonuj styl';
$lang['xs_uninstall_styles_lc'] = 'odinstaluj style';
$lang['xs_edit_templates_lc'] = 'edytuj styl';
$lang['xs_edit_styles_data_lc'] = 'edytuj dane stylu';
$lang['xs_export_styles_data_lc'] = 'eksportuj dane stylu';
$lang['xs_check_for_updates_lc'] = 'sprawd� aktualizacje';

/*
* ftp.tpl, ftp functions
*/

$lang['xs_ftp_comment1'] = 'Przy u�yciu tej funkcji, musisz wybra� metod� wysy�ania pliku. Je�eli wybierzesz FTP, has�o nie zostanie zapisane, b�dziesz o nie proszony podczas ka�dego po��czenia. Je�eli wybierzesz lokalne przechowywanie pliku, upewnij si�, czy wybrane katalogi maj� prawa do zapisu (chmod 777)';
$lang['xs_ftp_comment2'] = 'Przy u�yciu tej funkcji musisz poda� ustawienia FTP. Has�o nie zostanie zapisane, b�dziesz o nie proszony podczas ka�dego po��czenia.';
$lang['xs_ftp_comment3'] = 'Uwaga: funkcja FTP jest wy��czona na tym serwerze. Nie mo�esz u�ywa� ustawie� wymagaj�cych dost�pu poprzez FTP.';

$lang['xs_ftp_title'] = 'Konfiguracja FTP';

$lang['xs_ftp_explain'] = 'FTP jest u�ywane do wysy�ania nowych styl�w. Je�eli chcesz importowa� style, musisz odpowiednio skonfigurowa� parametry FTP. B�d� one wykryte automatycznie je�eli b�dzie taka mo�liwo��.';

$lang['xs_ftp_error_fatal'] = 'Funkcja FTP jest wy��czona na tym serwerze, nie mo�na kontynuowa�.';
$lang['xs_ftp_error_connect'] = 'B��d FTP: nie mo�na po��czy� do {HOST}';
$lang['xs_ftp_error_login'] = 'B��d FTP: nie mo�na zalogowa�';
$lang['xs_ftp_error_chdir'] = 'B��d FTP: nie mo�na wej�c do katalogu {DIR}';
$lang['xs_ftp_error_nonphpbbdir'] = 'B��d FTP: ustawiony niew�a�ciwy katalog. Brak plik�w phpBB w katalogu.';
$lang['xs_ftp_error_noconnect'] = 'B��d po��czenia do serwera';
$lang['xs_ftp_error_login2'] = 'Z�y login lub has�o';

$lang['xs_ftp_log_disabled'] = 'funkcja FTP jest wy��czona na tym serwerze, nie mo�na kontynuowa�';
$lang['xs_ftp_log_connecting'] = '��czenie do {HOST}';
$lang['xs_ftp_log_noconnect'] = 'b��d ��czenia do {HOST}';
$lang['xs_ftp_log_connected'] = 'po��czony, logowanie ...';
$lang['xs_ftp_log_nologin'] = 'nie mo�na zalogowa� jako {USER}';
$lang['xs_ftp_log_loggedin'] = 'zalogowany';
$lang['xs_ftp_log_end'] = 'koniec wykonywania skryptu';
$lang['xs_ftp_log_nopwd'] = 'b��d: nie mo�na odczyta� bie��cego katalogu';
$lang['xs_ftp_log_nomkdir'] = 'b��d: nie mo�na utworzy� katalogu {DIR}';
$lang['xs_ftp_log_mkdir'] = 'tworzenie katalogu {DIR}';
$lang['xs_ftp_log_nochdir'] = 'b��d: nie mo�na zmieni� katalogu na {DIR}';
$lang['xs_ftp_log_normdir'] = 'b��d: nie mo�na usun�� katalogu {DIR}';
$lang['xs_ftp_log_rmdir'] = 'usuwanie katalogu {DIR}';
$lang['xs_ftp_log_chdir'] = 'zmiana katalogu na {DIR}';
$lang['xs_ftp_log_noupload'] = 'b��d: nie mo�na wys�a� pliku {FILE}';
$lang['xs_ftp_log_upload'] = 'wysy�anie pliku {FILE}';
$lang['xs_ftp_log_nochmod'] = 'uwaga: nie mo�na ustawi� odpowiednich praw dla pliku {FILE}';
$lang['xs_ftp_log_chmod'] = 'prawa pliku {FILE} na {MODE}';
$lang['xs_ftp_log_invalidcommand'] = 'b��d: nieznane polecenie: {COMMAND}';
$lang['xs_ftp_log_chdir2'] = 'zmiana bie��cego katalogu spowrotem na {DIR}';
$lang['xs_ftp_log_nochdir2'] = 'nie mo�na zmieni� katalogu na {DIR}';

$lang['xs_ftp_config'] = 'Konfiguracja FTP';
$lang['xs_ftp_select_method'] = 'Wybierz metod� wysy�ania';
$lang['xs_ftp_select_local'] = 'U�yj lokalnego systemu plik�w (nie wymaga konfiguracji lecz wymaga praw do zapisu w katalogu styl�w chmod 777)';
$lang['xs_ftp_select_ftp'] = 'U�yj FTP (ustaw parametry poni�ej)';

$lang['xs_ftp_settings'] = 'Ustawienia FTP';
$lang['xs_ftp_host'] = 'Host FTP';
$lang['xs_ftp_login'] = 'Login FTP';
$lang['xs_ftp_path'] = '�cie�ka do phpBB';
$lang['xs_ftp_pass'] = 'Has�o FTP';
$lang['xs_ftp_remotedir'] = 'Zdalny Katalog';

$lang['xs_ftp_host_guess'] = ' (prawdopodobnie "{HOST}" [<a href="javascript: void(0)" onclick="{CLICK}">ustaw host</a>])';
$lang['xs_ftp_login_guess'] = ' (prawdopodobnie "{LOGIN}" [<a href="javascript: void(0)" onclick="{CLICK}">ustaw host</a>])';
$lang['xs_ftp_path_guess'] = ' (prawdopodobnie "{PATH}" [<a href="javascript: void(0)" onclick="{CLICK}">ustaw �cie�k�</a>])';


/*
* config.tpl
*/

$lang['xs_config_updated'] = 'Konfiguracja zaktualizowana.';
$lang['xs_config_updated_explain'] = 'Musisz od�wie�y� stron� aby nowa konfiguracja odnios�a skutek. <a href="{URL}">Kliknij tutaj</a> aby od�wie�y�.';
$lang['xs_config_warning'] = 'Uwaga: cache nie mo�e zosta� zapisany.';
$lang['xs_config_warning_explain'] = 'Katalog Cache nie ma praw do zapisu. eXtreme Styles mo�e spr�bowa� ustawi� odpowiednie prawa.<br /><a href="{URL}">Kliknij tutaj</a> aby ustawi�.<br /><br />Je�eli nie b�dzie mo�liwo�ci korzystania z cach\'u nie przejmuj si�, eXtreme Styles pomimo tego przyspieszy dzia�anie styl�w.';

$lang['xs_config_maintitle'] = 'Konfiguracja eXtreme Styles';
$lang['xs_config_subtitle'] = 'Je�eli nie rozumiesz tych parametr�w, nic nie zmieniaj !';
$lang['xs_config_title'] = 'Ustawienia eXtreme Styles v{VERSION}';
$lang['xs_config_cache'] = 'Ustawienia Cache';

$lang['xs_config_navbar'] = 'Poka� w lewej ramce:';
$lang['xs_config_navbar_explain'] = 'Mo�esz wybra� jakie pozycje b�d� wy�wietlane w lewej ramce panelu administracyjnego w sekcji styl�w.';

$lang['xs_config_def_template'] = 'Domy�lny katalog styl�w';
$lang['xs_config_def_template_explain'] = 'Je�eli wymagane pliki stylu (*.tpl) nie zostan� odnalezione w odpowiednim katalogu (mo�e to nast�pi� na skutek b��dnego wys�ania plik�w stylu lub z�ej instalacji mod�w) system podmieni brakuj�cy plik z powi�zanym stylem np. subSilver. Pozostaw puste aby wy��czy� t� funkcj�.';

$lang['xs_config_check_switches'] = 'Sprawdzaj b��dy podczas kompilacji';
$lang['xs_config_check_switches_explain'] = 'Ta opcja sprawdza b��dy w stylach. Wy��czenie spowoduje szybsz� kompilacj� plik�w, lecz kompilator mo�e omin�� wa�ne b��dy kt�re mog� si� pojawi� w plikach.';
$lang['xs_config_check_switches_0'] = 'Wy��czone';
$lang['xs_config_check_switches_1'] = 'Szybkie sprawdzanie';
$lang['xs_config_check_switches_2'] = 'Pojedyncze sprawdzanie';

$lang['xs_config_show_errors'] = 'Poka� b��dy je�eli pliki s� niepoprawnie dodawane do plik�w.tpl';
$lang['xs_config_show_error_explain'] = 'Ta funkcja sprawdza b��dy gdy u�ytkownik niew�a�ciwie wykorzysta funkcj�: &lt;!-- INCLUDE filename --&gt;';

$lang['xs_config_tpl_comments'] = 'Dodaj nazwy plik�w .tpl do kodu HTML';
$lang['xs_config_tpl_comments_explain'] = 'Dodaje nazwy plik�w jako komentarze do kodu HTML. Pozwala wykry�, kt�re pliki .tpl s� aktualnie wykorzystywane.';

$lang['xs_config_use_cache'] = 'U�yj Cach\'u';
$lang['xs_config_use_cache_explain'] = 'Cache s� to odpowiednio spreparowane (skompilowane) pliki styl�w do postaci PHP (serwer nie musi za ka�dym razem ��czy� (kompilowa�) plik�w stylu przy ka�dym wy�wietleniu strony.';

$lang['xs_config_auto_compile'] = 'Automatyczny zapis do Cache';
$lang['xs_config_auto_compile_explain'] = 'Automatycznie kompiluj style, kt�re nie s� z\'cach\'owane.';

$lang['xs_config_auto_recompile'] = 'Automatycznie rekompiluj Cache';
$lang['xs_config_auto_recompile_explain'] = 'Rekompiluje automatycznie pliki styl�w, gdy zostan� zmienione.';

$lang['xs_config_php'] = 'Rozszerzenie dla nazw plik�w cach\'u';
$lang['xs_config_php_explain'] = 'Rozszerzenie dla plik�w cach\'u. Pliki PHP kt�re s� zapisywane do cach\' maj� automatycznie dodawane rozszerzenie php. Nie podawaj kropek.';

$lang['xs_config_back'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� do konfiguracji.';
$lang['xs_config_sql_error'] = 'B��d zapisu konfiguracji dla {VAR}';

// Debug info
$lang['xs_debug_header'] = 'Debug info';
$lang['xs_debug_explain'] = 'U�yj do odnalezienia, lub naprawy b��d�w z cache\'m.';
$lang['xs_debug_vars'] = 'Ustawienia Stylu';
$lang['xs_debug_tpl_name'] = 'Nazwa pliku stylu:';
$lang['xs_debug_cache_filename'] = 'Plik Cache:';
$lang['xs_debug_data'] = 'Dane debug:';

$lang['xs_check_hdr'] = 'Sprawdzanie cach\'u dla %s';
$lang['xs_check_filename'] = 'B��d: b��dna nazwa pliku';
$lang['xs_check_openfile1'] = 'B��d: nie mo�na otworzy� pliku "%s". Pr�ba utworzenia katalogu ...';
$lang['xs_check_openfile2'] = 'B��d: nie mo�na otworzy� pliku "%s" po raz drugi. Anulowanie ...';
$lang['xs_check_nodir'] = 'Sprawdzanie "%s" - nie odnaleziono katalogu.';
$lang['xs_check_nodir2'] = 'B��d: nie mo�na utworzy� katalogu "%s" - sprawd� zezwolenia.';
$lang['xs_check_createddir'] = 'Tworzenie katalogu "%s"';
$lang['xs_check_dir'] = 'Sprawdzanie "%s" - katalog istnieje.';
$lang['xs_check_ok'] = 'Otwieranie pliku "%s" do zapisu.';


/*
* chmod
*/

$lang['xs_chmod'] = 'CHMOD';
$lang['xs_chmod_return'] = '<br /><br /><a href="{URL}">Kliknij tutaj</a> aby powr�ci� do konfiguracji.';
$lang['xs_chmod_message1'] = 'Konfiguracja zapisana.';
$lang['xs_chmod_error1'] = 'Nie mo�na zmieni� praw dost�pu dla katalogu';


/*
* default style
*/

$lang['xs_def_title'] = 'Ustaw domy�lny styl';
$lang['xs_def_explain'] = 'W tym miejscu mo�esz szybko ustawi� domy�lny styl Forum oraz prze��cza� u�ytkownik�w z jednego stylu na drugi.<br />Pami�taj, �e je�eli ustawi�e� sobie jaki� styl gdy by�e� nie zalogowany, b�dzie on jako domy�lny styl. Aby to zmieni� wyloguj si� i zmie� styl.';

$lang['xs_styles_set_default'] = 'ustaw domy�lny';
$lang['xs_styles_no_override'] = 'nie zast�puj ustawie� u�ytkownik�w';
$lang['xs_styles_do_override'] = 'zast�p ustawienia u�ytkownik�w';
$lang['xs_styles_switch_all'] = 'ustaw wszystkim ten styl';
$lang['xs_styles_switch_all2'] = 'ustaw wszystkim:';
$lang['xs_styles_defstyle'] = 'domy�lny styl';
$lang['xs_styles_available'] = 'Dost�pne style';
$lang['xs_styles_make_public'] = 'ustaw jako styl publiczny';
$lang['xs_styles_make_admin'] = 'ustaw styl tylko dla Administrator�w';
$lang['xs_styles_users'] = 'Lista U�ytkownik�w';


/*
* cache management
*/

$lang['xs_manage_cache_explain2'] = 'W tym miejscu mo�esz skompilowa� lub usun�� pliki cach\'u. (usu� pliki cache np. w przypadku przenoszenia forum lub po dokonaniu r�cznych zmian w bazie SQL !)';
$lang['xs_clear_all_lc'] = 'usu� wszystkie';
$lang['xs_compile_all_lc'] = 'kompiluj wszystkie';
$lang['xs_clear_cache_lc'] = 'wyczy�� cache';
$lang['xs_compile_cache_lc'] = 'kompiluj cache';
$lang['xs_cache_confirm'] = 'Je�eli posiadasz wiele styl�w, ta czynno�� mo�e znacznie obci��y� serwer. Czy na pewno chcesz kontynuowa�?';

$lang['xs_cache_nowrite'] = 'B��d: nie mo�na uzyska� praw do katalogu cache';
$lang['xs_cache_log_deleted'] = 'Usuwanie {FILE}';
$lang['xs_cache_log_nodelete'] = 'B��d: nie mo�na usun�� pliku {FILE}';
$lang['xs_cache_log_nothing'] = 'Nie ma nic do usuni�cia dla stylu {TPL}';
$lang['xs_cache_log_nothing2'] = 'Nie ma nic do usuni�cia w katalogu cache';
$lang['xs_cache_log_count'] = 'Plik�w usuni�tych: {NUM}';
$lang['xs_cache_log_count2'] = 'B��d usuwania {NUM} plik�w';
$lang['xs_cache_log_compiled'] = 'Skompilowano: {NUM} plik�w';
$lang['xs_cache_log_errors'] = 'B��d�w: {NUM}';
$lang['xs_cache_log_noaccess'] = 'B��d: nie mo�na uzyska� praw do katalogu {DIR}';
$lang['xs_cache_log_compiled2'] = 'Skompilowano: {FILE}';
$lang['xs_cache_log_nocompile'] = 'B��d kompilacji: {FILE}';

/*
* export/import/download/clone
*/

$lang['xs_import_explain'] = 'W tym miejscu mo�esz importowa� style. Mo�esz tak�e automatycznie zainstalowa� i zaktualizowa� style.';

$lang['xs_import_lc'] = 'import';
$lang['xs_list_files_lc'] = 'lista plik�w';
$lang['xs_delete_file_lc'] = 'usu� plik';
$lang['xs_export_style_lc'] = 'eksportuj styl';

$lang['xs_import_no_cached'] = 'Nie ma plik�w cach\'u do importu';
$lang['xs_add_styles'] = 'Dodaj Style';
$lang['xs_add_styles_web'] = 'Pobierz z sieci';
$lang['xs_add_styles_web_get'] = 'Pobierz';
$lang['xs_add_styles_copy'] = 'Kopiuj z lokalnego pliku';
$lang['xs_add_styles_copy_get'] = 'Kopiuj';
$lang['xs_add_styles_upload'] = 'Wy�lij z komputera';
$lang['xs_add_styles_upload_get'] = 'Wy�lij';

$lang['xs_export_style'] = 'Eksport Styl�w';
$lang['xs_export_style_explain'] = 'W tym miejscu mo�esz eksportowa� style jako pojedynczy plik. Plik ten b�dzie bardzo ma�y, co umo�liwia szybszy transfer w inne miejsce.<br /><br />Mo�esz tak�e wys�a� style bezpo�rednio na inny serwer, przy u�yciu po��czenia FTP.';

$lang['xs_export_style_title'] = 'Eksportuj Styl "{TPL}"';
$lang['xs_export_tpl_name'] = 'Eksportuj jako (nazwa schematu)';
$lang['xs_export_style_names'] = 'Wybierz Style do eksportu';
$lang['xs_export_style_name'] = 'Style do eksportu (nazwa stylu)';
$lang['xs_export_style_comment'] = 'Komentarz';
$lang['xs_export_where'] = 'Gdzie eksportowa�';
$lang['xs_export_where_download'] = 'Pobierz jako plik';
$lang['xs_export_where_store'] = 'Zapisz jako plik na serwerze';
$lang['xs_export_where_store_dir'] = 'Katalog';
$lang['xs_export_where_ftp'] = 'Wy�lij poprzez FTP';
$lang['xs_export_filename'] = 'Nazwa eksportowanego pliku';

$lang['xs_download_explain2'] = 'W tym miejscu mo�esz szybko pobra� i zainstalowa� style bezpo�rednio ze strony www. Kliknij na link obok nazwy strony aby zosta� przekierowanym do strony z list� styl�w do pobrania.<br /><br />Mo�esz tak�e zarz�dza� list� dost�pnych stron.';

$lang['xs_download_locations'] = 'Lokalizacje';
$lang['xs_edit_link'] = 'Edytuj Link';
$lang['xs_add_link'] = 'Dodaj Link';
$lang['xs_link_title'] = 'Tytu� Linku';
$lang['xs_link_url'] = 'Adres Linku';
$lang['xs_delete'] = 'Usu�';

$lang['xs_style_header_error_file'] = 'Nie mo�na otworzy� lokalnego pliku';
$lang['xs_style_header_error_server'] = 'B��d serwera: ';
$lang['xs_style_header_error_invalid'] = 'B��dny nag��wek pliku';
$lang['xs_style_header_error_reason'] = 'B��d odczytu nag��wka pliku: ';
$lang['xs_style_header_error_incomplete'] = 'Plik jest niekompletny';
$lang['xs_style_header_error_incomplete2'] = 'B��dny rozmiar pliku. Prawdopodobnie plik jest niekompletny.';
$lang['xs_style_header_error_invalid2'] = 'B��dny plik. Prawdopodobnie plik nie jest plikiem kompatybilnym z eXtreme Styles lub jest z innej wersji.';
$lang['xs_error_cannot_open'] = 'Nie mo�na otworzy� pliku.';
$lang['xs_error_decompress_style'] = 'B��d dekompresji pliku. Prawdopodobnie plik jest uszkodzony.';
$lang['xs_error_cannot_create_file'] = 'Nie mo�na utworzy� pliku "{FILE}"';
$lang['xs_error_cannot_create_tmp'] = 'Nie mo�na utworzy� pliku tymczasowego "{FILE}"';
$lang['xs_import_invalid_file'] = 'B��dny plik';
$lang['xs_import_incomplete_file'] = 'Niekompletny plik';
$lang['xs_import_uploaded'] = 'Styl wys�any.';
$lang['xs_import_installed'] = 'Styl wys�any i zainstalowany.';
$lang['xs_import_notinstall'] = 'Styl wys�any, lecz wyst�pi� b��d podczas instalacji stylu (sql error).';
$lang['xs_import_notinstall2'] = 'Styl wys�any, lecz wyst�pi� b��d podczas instalacji stylu: nie odnaleziono styl�w w pliku theme_info.cfg';
$lang['xs_import_notinstall3'] = 'Styl wys�any, lecz wyst�pi� b��d podczas instalacji stylu: nie odnaleziono wpis�w dla "{STYLE}" w pliku theme_info.cfg';
$lang['xs_import_notinstall4'] = 'Styl wys�any, lecz wyst�pi� b��d podczas instalacji stylu: nie mo�na uzyska� nast�pnego numeru themes_id';
$lang['xs_import_notinstall5'] = 'Styl wys�any, lecz wyst�pi� b��d podczas instalacji stylu: nie mo�na zaktualizowa� tabeli styl�w';
$lang['xs_import_nodownload'] = 'Nie mo�na pobra� stylu z {URL}';
$lang['xs_import_nodownload2'] = 'Nie mo�na skopiowac stylu z {URL}';
$lang['xs_import_nodownload3'] = 'Plik nie zosta� wys�any.';
$lang['xs_import_uploaded2'] = 'Styl pobrany. Mo�esz go teraz importowa�.<br /><br /><a href="{URL}">Kliknij tutaj</a> aby importowa� styl.';
$lang['xs_import_uploaded3'] = 'Styl skopiowany. Mo�esz go teraz importowa�.<br /><br /><a href="{URL}">Kliknij tutaj</a> aby importowa� styl.';
$lang['xs_import_uploaded4'] = 'Styl wys�any. Mo�esz go teraz importowa�.<br /><br /><a href="{URL}">Kliknij tutaj</a> aby importowa� styl.';
$lang['xs_export_no_open_dir'] = 'Nie mo�na otworzy� katalogu {DIR}';
$lang['xs_export_no_open_file'] = 'Nie mo�na otworzy� pliku {FILE}';
$lang['xs_export_no_read_file'] = 'B��d odczytu pliku {FILE}';
$lang['xs_no_theme_data'] = 'Nie mo�na pobra� informacji o stylu dla wybranego schematu';
$lang['xs_no_style_info'] = 'Nie mo�na pobra� informacji o stylu';
$lang['xs_export_noselect_themes'] = 'Powiniene� wybra� jako najmniejszy styl';
$lang['xs_export_error'] = 'Nie mo�na eksportowa� schematu "{TPL}": ';
$lang['xs_export_error2'] = 'Nie mo�na eksportowa� schematu "{TPL}": styl jest pusty';
$lang['xs_export_saved'] = 'Styl zapisany jako "{FILE}"';
$lang['xs_export_error_uploading'] = 'B��d wysy�ania pliku';
$lang['xs_export_uploaded'] = 'Plik wys�any.';
$lang['xs_clone_taken'] = 'Nazwa stylu jest ju� u�ywana.';
$lang['xs_error_new_row'] = 'Nie mo�na doda� wpisu do tabeli.';
$lang['xs_theme_cloned'] = 'Styl sklonowany.';
$lang['xs_invalid_style_name'] = 'B��dna nazwa stylu.';
$lang['xs_clone_style_exists'] = 'Schemat ju� istnieje';
$lang['xs_clone_no_select'] = 'Powiniene� wybra� najmniejszy styl do sklonowania.';
$lang['xs_no_themes'] = 'Styl nie odnaleziony w bazie.';

$lang['xs_import_back'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� do importu styl�w.';
$lang['xs_import_back_download'] = '<a href="{URL}" target="main">Kliknij tutaj</a> aby powr�ci� do pobierania styl�w.';
$lang['xs_export_back'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� eksportu styl�w.';
$lang['xs_clone_back'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� do klonowania styl�w.';
$lang['xs_download_back'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� do pobierania styl�w.';

$lang['xs_import_tpl'] = 'Importuj Schemat "{TPL}"';
$lang['xs_import_tpl_comment'] = 'W tym miejscu mo�esz wys�a� schemat dla twojego forum. Je�eli schemat pod t� nazw� ju� istnieje, stare pliki zostan� automatycznie zast�pione. Styl mo�e by� automatycznie zainstalowany. Je�eli chcesz zainstalowa� styl po imporcie, wybierz poni�ej jeden styl lub wi�cej.';
$lang['xs_import_tpl_filename'] = 'Nazwa pliku:';
$lang['xs_import_tpl_tplname'] = 'Nazwa schematu:';
$lang['xs_import_tpl_comment2'] = 'Komentarz:';
$lang['xs_import_select_styles'] = 'Wybierz styl(e) do instalacji:';
$lang['xs_import_install_def_lc'] = 'ustaw jako domy�lny styl forum';
$lang['xs_import_install_style'] = 'Instaluj styl:';
$lang['xs_import'] = 'Importuj';

$lang['xs_import_list_contents'] = 'Zawarto�� pliku: ';
$lang['xs_import_list_filename'] = 'Nazwa pliku: ';
$lang['xs_import_list_template'] = 'Schemat: ';
$lang['xs_import_list_comment'] = 'Komentarz: ';
$lang['xs_import_list_styles'] = 'Styl(e): ';
$lang['xs_import_list_files'] = 'Plik�w ({NUM}):';
$lang['xs_import_download_lc'] = 'pobierz plik';
$lang['xs_import_view_lc'] = 'podgl�d pliku';
$lang['xs_import_file_size'] = '({NUM} bajt�w)';

$lang['xs_import_nogzip'] = 'Ta funkcja wymaga kompresji gzip, kt�ra prawdopodobnie nie jest zainstalowana na serwerze.';
$lang['xs_import_nowrite_cache'] = 'Nie mo�na zapisa� do cach\'u. Ta funkcja wymaga, aby katalog cache mia� prawa do zapisu. Sprawd� ustawienia konfiguracji.<br /><br /><a href="{URL1}">Kliknij tutaj</a> aby spr�bowa� ustawi� prawa do zapisu.<br /><br /><a href="{URL2}">Kliknij tutaj</a> aby powr�ci� do importu styl�w.';

$lang['xs_import_download_warning'] = 'Zostaniesz przeniesiony do zewn�trznej strony, gdzie mo�esz szybko pobra� i zaimportowa� style.';

$lang['xs_clone_style'] = 'Klonuj Styl';
$lang['xs_clone_style_explain'] = 'W tym miejscu mo�esz szybko sklonowa� styl lub schemat.<br /><br />Uwaga: Podczas kopiowania schematu, upewnij si�, czy autor wybranego stylu na to zezwoli�.';
$lang['xs_clone_style_explain2'] = 'W tym miejscu mo�esz stworzy� nowy styl dla schematu. Funkcja ta nie kopiuje �adnych plik�w, dodaje tylko odpowiednie wpisy w bazie danych';
$lang['xs_clone_style_explain3'] = 'Podaj nazw� dla nowego schematu i kliknij przycisk "Klonuj.';
$lang['xs_clone_style_explain4'] = 'W tym miejscu mo�esz sklonowac schemat. Mo�esz tak�e skopiowa� wszystkie style przypisane do tego schematu. W p�niejszym czasie mo�esz bezpiecznie edytowa� pliki .tpl stary i nowy schemat nie zostanie zmieniony.';

$lang['xs_clone_style_lc'] = 'klonuj styl';
$lang['xs_clone_style2'] = 'Klonuj styl "{STYLE}":';
$lang['xs_clone_style3'] = 'Klonuj Schemat "{STYLE}"';
$lang['xs_clone_newdir_name'] = 'Nazwa katalogu nowego schematu (directory) :';
$lang['xs_clone_select'] = 'Wybierz styl(e) do klonowania:';
$lang['xs_clone_select_explain'] = 'Powiniene� wybra� najmniejszy styl.';
$lang['xs_clone_newname'] = 'Nazwa nowego stylu:';


/*
* install/uninstall
*/
$lang['xs_install_styles_explain2'] = 'To jest lista styl�w wys�anych do katalogu styl�w, lecz jeszcze niezainstalowanych. Kliknij na link "Instaluj" aby zainstalowa� wybrany styl lub wybierz kilka styl�w i zainstaluj wszystkie u�ywaj�c przycisku.';
$lang['xs_uninstall_styles_explain2'] = 'To jest lista zainstalowanych styl�w na twoim forum. Kliknij na link "Odinstaluj" aby odinstalowa�. U�ytkownicy u�ywaj�cy odinstalowywanego stylu zostan� prze��czeni na domy�lny styl. Deinstalacja usunie r�wnie� pliki cach\'u dla stylu .';

$lang['xs_install'] = 'Instaluj';
$lang['xs_install_lc'] = 'instaluj';
$lang['xs_uninstall'] = 'Odinstaluj';
$lang['xs_remove_files'] = 'Usu� Pliki';
$lang['xs_style_removed'] = 'Styl usuni�ty.';
$lang['xs_uninstall_lc'] = 'odinstaluj';
$lang['xs_uninstall2_lc'] = 'odinstaluj i usu� pliki';

$lang['xs_install_back'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� do instalacji styl�w.';
$lang['xs_uninstall_back'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� do deinstalacji styl�w.';
$lang['xs_goto_default'] = '<a href="{URL}">Kliknij tutaj</a> aby zmieni� domy�lny styl.';

$lang['xs_install_installed'] = 'Styl(e) zainstalowan(y/e).';
$lang['xs_install_error'] = 'B��d instalacji stylu.';
$lang['xs_install_none'] = 'Nie ma nowych styl�w do instalacji. Wszystkie dost�pne style s� ju� zainstalowane.';

$lang['xs_uninstall_default'] = 'Nie mo�esz usun�� domy�lnego stylu. Aby zmieni� domy�lny styl <a href="{URL}">kliknij tutaj</a>.';

/*
* export theme_info.cfg
*/
$lang['xs_export_styles_data_explain2'] = 'Ta funkcja zapisuje dane stylu do pliku theme_info.cfg. Mo�e zosta� u�yta do zapisu danych w bazie, przed przenoszeniem styl�w z jednego foeum na drugie.';
$lang['xs_export_styles_data_explain3'] = 'Wybierz style kt�re chcesz eksportowa�.';

$lang['xs_export_data_back'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� do eksportu danych stylu.';
$lang['xs_export_style_data_lc'] = 'eksportuj dane stylu';

$lang['xs_export_data_saved'] = 'Dane wyeksportowane.';

/*
* edit templates (file manager)
*/
$lang['xs_edit_template_comment1'] = 'Ta funkcja pozwala na edycj� schemat�w. Zostan� pokazane tylko pliki mo�liwe do edycji.';
$lang['xs_edit_template_comment2'] = 'Ta funkcja pozwala na edycj� schemat�w.';
$lang['xs_edit_file_saved'] = 'Plik zapisany.';
$lang['xs_edit_not_found'] = 'Nie odnaleziono pliku.';
$lang['xs_edittpl_back_dir'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� do zarz�dzania plikami.';

$lang['xs_fileman_browser'] = 'Przegl�darka plik�w';
$lang['xs_fileman_directory'] = 'Katalog:';
$lang['xs_fileman_dircount'] = 'Katalog�w ({COUNT}):';
$lang['xs_fileman_filter'] = 'Filtr';
$lang['xs_fileman_filter_ext'] = 'Poka� tylko pliki z rozszerzeniem:';
$lang['xs_fileman_filter_content'] = 'Poka� tylko pliki zawieraj�ce:';
$lang['xs_fileman_filter_clear'] = 'Wyczy�� filtr';
$lang['xs_fileman_filename'] = 'Nazwa pliku';
$lang['xs_fileman_filesize'] = 'Rozmiar';
$lang['xs_fileman_filetime'] = 'Modyfikowany';
$lang['xs_fileman_options'] = 'Opcje';
$lang['xs_fileman_time_today'] = '(dzisiaj)';
$lang['xs_fileman_edit_lc'] = 'edytuj';

$lang['xs_fileedit_search_nomatch'] = 'Zakres nie odnaleziony';
$lang['xs_fileedit_search_match1'] = 'Zast�piono 1 zakres';
$lang['xs_fileedit_search_matches'] = "Zastapionych zakres�w: ' + count + '";
$lang['xs_fileedit_noundo'] = 'Brak czynno�ci do cofni�cia';
$lang['xs_fileedit_undo_complete'] = 'Przywr�cono poprzedni� zawarto��';
$lang['xs_fileedit_edit_name'] = 'Edytuj plik:';
$lang['xs_fileedit_location'] = 'Lokalizacja:';
$lang['xs_fileedit_reload_lc'] = 'prze�aduj plik';
$lang['xs_fileedit_download_lc'] = 'pobierz plik';
$lang['xs_fileedit_trim'] = 'Automatycznie usuwaj odst�py na pocz�tku i ko�cu pliku.';
$lang['xs_fileedit_functions'] = 'Edycja funkcji';
$lang['xs_fileedit_replace1'] = 'Zast�p ';
$lang['xs_fileedit_replace2'] = ' na ';
$lang['xs_fileedit_replace_first_lc'] = 'zast�p pierwszy zakres';
$lang['xs_fileedit_replace_all_lc'] = 'zast�p wszystkie zakresy';
$lang['xs_fileedit_replace_undo_lc'] = 'cofnij zast�pienie';
$lang['xs_fileedit_backups'] = 'Kopie bezpiecze�stwa';
$lang['xs_fileedit_backups_save_lc'] = 'zapisz kopi�';
$lang['xs_fileedit_backups_show_lc'] = 'poka� zawarto��';
$lang['xs_fileedit_backups_restore_lc'] = 'przywr��';
$lang['xs_fileedit_backups_download_lc'] = 'pobierz';
$lang['xs_fileedit_backups_delete_lc'] = 'usu�';
$lang['xs_fileedit_upload'] = 'Wy�lij';
$lang['xs_fileedit_upload_file'] = 'Wy�lij plik:';

/*
* edit styles data (theme_info)
*/
$lang['xs_data_head_stylesheet'] = 'Tablica CSS';
$lang['xs_data_body_background'] = 'Obraz t�a (�ciezka lub adres do pliku)';
$lang['xs_data_body_bgcolor'] = 'Kolor t�a';
$lang['xs_data_style_name'] = 'Nazwa stylu';
$lang['xs_data_body_link'] = 'Kolor link�w';
$lang['xs_data_body_text'] = 'Kolor tekstu';
$lang['xs_data_body_vlink'] = 'Kolor odwiedzonych link�w';
$lang['xs_data_body_alink'] = 'Kolor aktywnych link�w';
$lang['xs_data_body_hlink'] = 'Kolor Hover link�w';
$lang['xs_data_tr_color'] = 'Kolor rz�du tabeli %s';
$lang['xs_data_tr_color_helped'] = 'Kolor kom�rki "pom�g�"';
$lang['xs_data_tr_class'] = 'Klasa rz�du tabeli %s';
$lang['xs_data_th_color'] = 'Kolor nag��wka tabeli %s';
$lang['xs_data_th_class'] = 'Klasa nag��wka tabeli %s';
$lang['xs_data_td_color'] = 'Kolor kolumny tabeli %s';
$lang['xs_data_td_class'] = 'Klasa kolumny tabeli %s';
$lang['xs_data_fontface'] = 'Kr�j tekstu %s';
$lang['xs_data_fontsize'] = 'Wielko�� tekstu %s';
$lang['xs_data_fontcolor'] = 'Kolor tekstu %s';
$lang['xs_data_fontcolor_admin'] = 'Kolor admina';
$lang['xs_data_fontcolor_jradmin'] = 'Kolor junior admina';
$lang['xs_data_fontcolor_mod'] = 'Kolor moda';
$lang['xs_data_factive_color'] = 'Kolor aktywnego pola formularza';
$lang['xs_data_faonmouse_color'] = 'Kolor kom�rki 1 po najechaniu mysz�';
$lang['xs_data_faonmouse2_color'] = 'Kolor kom�rki 2 po najechaniu mysz� oraz kolor drugiego pola formularza';

$lang['xs_data_span_class'] = 'Klasa span %s';
$lang['xs_data_img_size_poll'] = 'Rozmiar obrazk�w ankiet [px]';
$lang['xs_data_img_size_privmsg'] = 'Rozmiar statusu prywatnych wiadomo�ci [px]';
$lang['xs_data_theme_public'] = 'Styl publiczny (1 lub 0)';
$lang['xs_data_unknown'] = 'Opis nie jest dost�pny (%s)';

$lang['xs_edittpl_error_updating'] = 'B��d aktualizacji stylu.';
$lang['xs_edittpl_style_updated'] = 'Styl zaktualizowany.';
$lang['xs_edittpl_failed_open_file'] = 'Nie mo�na odczyta� pliku <b>%s</b>';
$lang['xs_edittpl_failed_open_file_css'] = 'Nie mo�na zapisa� do pliku <b>%s</b><br />Prawdopodobnie plik nie posiada praw do zapisu, wpisz u�ywaj�c klienta FTP z lini� polece�: <b> chmod 777 nazwa_pliku.css</b> b�d�c w katalogu w kt�rym znajduje sie plik.';
$lang['xs_invalid_style_id'] = 'B��dny numer ID stylu.';

$lang['xs_edittpl_back_edit'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� do edycji.';
$lang['xs_edittpl_back_list'] = '<a href="{URL}">Kliknij tutaj</a> aby powr�ci� do listy styl�w.';

$lang['xs_editdata_explain'] = 'W tym miejscu mo�esz edytowa� dane zainstalowanych styl�w w bazie danych.<br /> W tej modyfikacji w celu zmniejszenia ilo�ci transferu, forum korzysta tylko z pliku <b>nazwastylu.css</b> i nie �aduje informacji parametr�w stylu do kodu html. Parametry, kt�re widzisz poni�ej s� pobierane z bazy SQL, przy zapisie s� w niej zapisywane i r�wnolegle s� zapisywane do pliku .css w katalogu stylu <b>(plik ten powinien mie� prawa do zapisu chmod 777 nazwastylu.css)</b>. Struktura pliku <b>nazwastylu.css</b> oraz pozosta�e kolory kt�rych nie mo�na zmieni� w tym miejscu, s� pobierane z pliku <b>nazwastylu.tps</b><br />Zmieni� pozosta�e parametry mo�na na dwa sposoby: 1. Po zapisaniu zmian w tym miejscu, r�cznie edytowa� plik <b>nazwastylu.css</b> jednak gdy ponownie zapiszemy zmiany tutaj, plik <b>nazwastylu.css</b> zostanie spowrotem nadpisany przez szablon <b>nazwastylu.tps</b> tak wi�c lepszym rozwi�zaniem jest: 2. Edytowa� r�cznie plik <b>nazwastylu.tps</b> :)';
$lang['xs_editdata_var'] = 'Parametr';
$lang['xs_editdata_value'] = 'Warto��';
$lang['xs_editdata_comment'] = 'Komentarz';

/*
* updates
*/

$lang['xs_updates'] = 'Aktualizacje';
$lang['xs_updates_comment'] = 'W tym miejscu mo�esz sprawdzi� aktualizacje dla niekt�rych mod�w i styl�w';
$lang['xs_updates_comment2'] = 'Rezultat sprawdzania wersji.';
$lang['xs_update_total1'] = 'Wszystkich pozycji: {NUM}';
$lang['xs_update_info1'] = 'Ta funkcja sprawdza dost�pno�� aktualizacji do phpBB2, kilku mod�w i styl�w na twoim forum. Je�eli odnajdzie dost�pne aktualizacje, zostanie wy�wietlony link, kt�ry pozwoli je �ci�gn��. Funkcja ta wymaga mo�liwo�ci wykonywania zdalnych po��cze� przez PHP. Wiele darmowych serwer�w ma zablokowan� tak� mo�liwo��<br /><br />Po klikni�ciu "Kontynuuj", skrypt sprawdzi zainstalowan� zawarto�� forum. Je�eli tw�j serwer jest powolny, mo�e to zaj�� sporo czasu. B�d� cierpliwy i nie zatrzymuj procesu. W przypadku niepowodzenia mo�esz zwi�kszy� czas bezczynno�ci.';
$lang['xs_update_name'] = 'Nazwa';
$lang['xs_update_type'] = 'Rodzaj';
$lang['xs_update_current_version'] = 'Twoja wersja';
$lang['xs_update_latest_version'] = 'Ostatnia wersja';
$lang['xs_update_downloadinfo'] = 'Adres pobierania';
$lang['xs_update_timeout'] = 'Czas bezczynno�ci skryptu (sekundy):';
$lang['xs_update_continue'] = 'Kontynuuj';


$lang['xs_update_total2'] = 'B��d�w: {NUM}';
$lang['xs_update_total3'] = 'Dost�pnych aktualizacji: {NUM}';
$lang['xs_update_select1'] = 'Wybierz pozycje do aktualizacji';
$lang['xs_update_types'] = array(
		0 => 'Nieznane',
		1 => 'Styl',
		2 => 'Mod',
		3 => 'phpBB'
		);
$lang['xs_update_fileinfo'] = 'Wi�cej informacji';
$lang['xs_update_nothing'] = 'Nie ma nic do zaktualizowania.';
$lang['xs_update_noupdate'] = 'U�ywasz ostatniej dost�pnej wersji.';

$lang['xs_update_error_url'] = 'B��d: nie mo�na odczyta� adresu url %s';
$lang['xs_update_error_noitem'] = 'B��d: Nie ma dost�pnej informacji o aktualizacji';
$lang['xs_update_error_noconnect'] = 'B��d: Nie mo�na po��czy� do serwera aktualizacji';

$lang['xs_update_download'] = 'pobierz';
$lang['xs_update_downloadinfo2'] = 'pobierz/informacje';
$lang['xs_update_info'] = 'strona';

$lang['xs_permission_denied'] = 'Dost�p zabroniony';

$lang['xs_download_lc'] = 'pobierz';
$lang['xs_info_lc'] = 'informacja';

/*
* style configuration
*/
$lang['Template_Config'] = 'Konfiguracja Schemat�w';
$lang['xs_style_configuration'] = 'Konfiguracja Schemat�w';

$lang['xs_confirm_users'] = 'Czy na pewno chcesz ustawi� wszystkim u�ytkownikom ten styl?<br />Nie mo�na tego cofn��.';

$lang['xs_edit_permission'] = 'Funkcje edycji styl�w poprzez formularz oraz importu styl�w s� wy��czone ze wzgl�d�w bezpiecze�stwa.<br />Je�eli chcesz je w��czy�, ustaw w pliku /admin/admin_config.php zmienn�: $xs_edit na 1';
?>