<?php

/***************************************************************************
 *                      lang_admin.php [Polish]
 *                      -------------------
 * begin                : Sat Dec 16 2000
 * copyright            : (C) 2001 The phpBB Group
 * e-mail               : support@phpbb.com
 *
 * modification         : (C) 2005 Przemo http://www.przemo.org
 * date modification    : ver. 1.12.5 2005/11/10 19:34
 *
 ****************************************************************************/

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

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//

// Check for user gender
$he = ($userdata['user_gender'] != 2) ? true : false;

$lang['Groups'] = 'Grupy';
$lang['Styles'] = 'Style';
$lang['General'] = 'Og�lne';
$lang['Users'] = 'U�ytkownicy';
$lang['Forums'] = 'Fora';

$lang['Configuration'] = 'Konfiguracja';
$lang['Manage'] = 'Zarz�dzaj';
$lang['Disallow'] = 'Zabro� nazwy';
$lang['Prune'] = 'Czyszczenie';
$lang['Mass_Email'] = 'Mas. Korespondencja';
$lang['Ranks'] = 'Rangi';
$lang['Smilies'] = 'U�mieszki';
$lang['Ban_Management'] = 'Banlista';
$lang['Word_Censor'] = 'Cenzura S��w';
$lang['Export'] = 'Eksport';
$lang['Create_new'] = 'Utw�rz';
$lang['Add_new'] = 'Dodaj';
$lang['Backup_DB'] = 'Kopia Zapasowa';
$lang['Restore_DB'] = 'Odtwarzanie';

//
// Index
//

$lang['Admin'] = 'Administracja';
$lang['Welcome_phpBB'] = 'Witamy w phpBB';
$lang['Admin_intro'] = 'Dzi�kujemy, �e wybra�' .  (($he) ? 'e' : 'a') . '� phpBB by Przemo do obs�ugi Twojego forum. Ten ekran przedstawia kr�tki przegl�d r�norodnych danych statystycznych, dotycz�cych forum. Mo�esz wr�ci� do tej strony klikaj�c odno�nik <u>Indeks Administracji</u> na lewym panelu. Aby powr�ci� do strony g��wnej forum kliknij <u>Str. G��wna Forum</u> lewym panelu. Inne odno�niki po lewej stronie ekranu daj� dost�p do narz�dzi kontroluj�cych ka�dy aspekt zachowania forum. Ka�de z nich zawiera osobne instrukcje u�ycia.';
$lang['Main_index'] = 'Str. G��wna Forum';
$lang['Forum_stats'] = 'Statystyki Forum';
$lang['Admin_Index'] = 'Indeks Administracji';
$lang['Preview_forum'] = 'Podgl�d Forum';

$lang['Click_return_admin_index'] = 'Kliknij %sTutaj%s aby powr�ci� do Indeksu Administracji';

$lang['Statistic'] = 'Statystyki';
$lang['Value'] = 'Warto��';
$lang['Number_posts'] = 'Liczba post�w';
$lang['Posts_per_day'] = 'Post�w dziennie';
$lang['Number_topics'] = 'Liczba temat�w';
$lang['Topics_per_day'] = 'Temat�w dziennie';
$lang['Number_users'] = 'Liczba u�ytkownik�w';
$lang['Users_per_day'] = 'U�ytkownik�w dziennie';
$lang['Board_started'] = 'Start Forum';
$lang['Avatar_dir_size'] = 'U�ycie dysku';
$lang['Database_size'] = 'Baza Danych';
$lang['Gzip_compression'] = 'Kompresja Gzip';
$lang['Not_available'] = 'Niedost�pne';
$lang['f_mail'] = 'Obs�uga funkcji <b>mail</b> na serwerze';
$lang['search_keywords_max'] = 'Maksymalna liczba s��w, jak� u�ytkownik mo�e wykorzysta�, u�ywaj�c wyszukiwarki.';
$lang['languages_list'] = 'Dost�pne j�zyki: %s';
$lang['files_list'] = 'Dost�pne pliki: %s';


//
// DB Utils
//
$lang['Database_Utilities'] = 'Narz�dzia Bazy Danych';
$lang['Restore'] = 'Przywracanie';
$lang['Backup'] = 'Kopia Zapasowa';
$lang['Backup_explain'] = 'W tym miejscu mo�esz w��czy� automatyczne tworzenie kopii zapasowej bazy danych, kt�ra b�dzie tworzona co 24 godziny (podczas tworzenia kopii, forum jest wy��czone)<br />Masz mo�liwo�� wyboru ile kopii zapasowych ma by� przechowywane na serwerze. B�d� one przetrzymywane w katalogu /db/db_backup/ katalog <b>db_backup</b> powinien mie� prawa do zapisu ( chmod 777 ).<br />W tym miejscu masz te� mo�liwo�� wykonania kopii zapasowej "na ��danie" po klikni�ciu na link.<br />Plik kopii zapasowej ma nazw� np. db_backup_phpbb_psmdowhx_date-30-05-2005.sql.gz znaki psmdowhx s� losowe a wi�c nie ma mo�liwo�ci aby plik dosta� sie w niepowo�ane r�ce. Katalogu /db_backup/ nie mo�na "wylistowa�" gdy� znajduje si� tam plik index.html.<br />Masz mo�liwo�� ustawienia aby kopia nie obejmowa�a danych z tabel: search i read_history. Tabele search mo�na odbudowa� narz�dziem do odbudowywania search w panelu admina. Tabele search i read_history zajmuj� najwi�cej miejsca w bazie danych, tabeli read_history nie mo�na przywr�ci� tak jak tabel search.<br />Na celeronie 1,4 256 ram baza danych o wielko�ci 80MB jest kopiowana w oko�o 40 sekund, bez tabel search i read_history, rozpakowany plik zajmuje 42MB. Przy d�u�szym czasie tworzenia kopii mog� wyst�pi� nieprzewidziane problemy.<br />Je�eli masz dost�p do Cpanel\'u lub innego narz�dzia administracyjnego, sprawd�, czy nie tworzy on automatycznych kopii zapasowych bazy SQL, je�li tworzy nie musisz w��cza� automatycznego tworzenia przez forum.';
$lang['db_backup_enable'] = 'W��cz automatyczne tworzenie kopii';
$lang['db_backup_copies'] = 'Ilo�� przetrzymywanych kopii';
$lang['db_backup_tables_search'] = 'Kopiuj zawarto�� tabel search';
$lang['db_backup_tables_rh'] = 'Kopiuj zawarto�� tabeli read_history';
$lang['db_backup_link'] = 'Wykonaj kopi� teraz';
$lang['db_backup_done'] = 'Kopia zosta�a wykonana.';
$lang['db_backup_last'] = 'Ostatnia kopia: ';

//
// Auth pages
//
$lang['Select_a_User'] = 'Wybierz U�ytkownika';
$lang['Select_a_Group'] = 'Wybierz Grup�';
$lang['Select_a_Forum'] = 'Wybierz Forum';
$lang['Auth_Control_User'] = 'Kontrola Zezwole� U�ytkownik�w';
$lang['Auth_Control_Group'] = 'Kontrola Zezwole� Grup';
$lang['Auth_Control_Forum'] = 'Kontrola Zezwole� For�w';
$lang['Look_up_User'] = 'Wybierz U�ytkownika';
$lang['Look_up_Group'] = 'Wybierz Grupy';
$lang['Look_up_Forum'] = 'Wybierz Forum';

$lang['Group_auth_explain'] = 'Tutaj mo�esz zmienia� zezwolenia i status moderatora przydzielony ka�dej grupie u�ytkownik�w. Nie zapomnij zmieniaj�c ustawienia, �e indywidualne uprawnienia mog� nadal zezwala� u�ytkownikowi na dost�p do for�w itp.';
$lang['User_auth_explain'] = 'Tutaj mo�esz zmienia� zezwolenia i status moderatora dla ka�dego u�ytkownika. Nie zapomnij zmieniaj�c ustawienia, �e uprawnienia grupowe mog� nadal zezwala� u�ytkownikowi na dost�p do for�w itp.';
$lang['Forum_auth_explain'] = 'Tutaj mo�esz zmieni� poziomy autoryzacji dla ka�dego forum. Masz do dyspozycji metod� prost� i zaawansowan�, z kt�rych druga oferuje wi�ksze mo�liwo�ci kontroli ustawie�. Pami�taj, �e zmiana ustawie� dotycz�cych for�w zadecyduje o tym, co u�ytkownicy b�d� mogli na nich robi�.';

$lang['Simple_mode'] = 'Tryb Prosty';
$lang['Advanced_mode'] = 'Tryb Zaawansowany';
$lang['Moderator_status'] = 'Status Moderatora';

$lang['Allowed_Access'] = 'Dost�p Zezwolony';
$lang['Disallowed_Access'] = 'Dost�p Zabroniony';
$lang['Is_Moderator'] = 'Moderator';
$lang['Not_auth_Moderator'] = 'Nie Moderator';

$lang['Public'] = 'Publiczne';
$lang['Private'] = 'Prywatne';
$lang['Registered'] = 'Zarejestrowani';
$lang['Hidden'] = 'Ukryte';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = 'WSZYSCY';
$lang['Forum_REG'] = 'ZAREJESTR.';
$lang['Forum_PRIVATE'] = 'PRYWATNE';
$lang['Forum_MOD'] = 'MODERAT.';
$lang['Forum_ADMIN'] = 'ADMIN';

$lang['View'] = 'Widoczny';
$lang['Read'] = 'Czytanie';
$lang['Post'] = 'Pisanie';
$lang['Reply'] = 'Odpowiedzi';
$lang['Edit'] = 'Edycja';
$lang['Sticky'] = 'Przyklejone';
$lang['Announce'] = 'Og�oszenia';
$lang['Vote'] = 'G�osowanie';
$lang['Pollcreate'] = 'Tworzenie ankiet';

$lang['Simple_Permission'] = 'Proste Zezwolenia';

$lang['User_Level'] = 'Poziom u�ytkownika';
$lang['Auth_Admin'] = 'Administrator';
$lang['Group_memberships'] = 'Cz�onkostwo w grupach (Wszystkich: %d )';
$lang['Usergroup_members'] = 'Tak grupa ma nast�puj�cych cz�onk�w (Wszystkich: %d )';

$lang['Forum_auth_updated'] = 'Zezwolenia For�w zosta�y zaktualizowane';
$lang['Auth_updated'] = 'Zezwolenia zosta�y zmienione';
$lang['Click_return_userauth'] = 'Kliknij %sTutaj%s aby powr�ci� do Zezwole� U�ytkownik�w';
$lang['Click_return_groupauth'] = 'Kliknij %sTutaj%s aby powr�ci� do Zezwole� Grup';
$lang['Click_return_forumauth'] = 'Kliknij %sTutaj%s aby powr�ci� do Zezwole� For�w';


//
// Banning
//
$lang['Ban_explain'] = 'Tutaj mo�esz kontrolowa� banlist� u�ytkownik�w. Uzyskasz to przez banowanie danego u�ytkownika, zakresu numer�w IP lub host�w. Dzi�ki tym metodom u�ytkownik nie dostanie si� nawet na stron� g��wn�. Aby zapobiec rejestracji pod innymi nazwami mo�esz tak�e zbanowa� konkretny adres e-mail.';
$lang['Select_username'] = 'Wybierz Nazw� U�ytkownika';
$lang['Ban_IP'] = 'Zbanuj jeden lub wi�cej adres�w IP lub host�w';
$lang['IP_hostname'] = 'Adresy IP lub hosty';
$lang['Ban_IP_explain'] = 'Aby poda� kilka adres�w IP lub host�w oddziel je przecinkami. Kiedy podajesz adres IP znak <b>*</b> zast�puje dowolny ci�g cyfr. Aby okre�li� zakres tylko kilku adres�w IP oddziel pocz�tkowy i ko�cowy my�lnikiem (-) Nie stosuj bardzo du�ych zakres�w IP, na przyk�ad zakres 20-80 doda do bazy a� 60 wpis�w. Je�eli podajesz host, mo�esz u�y� znaku <b>*</b> kt�ry zast�pi dowolny ci�g znak�w, oraz znaku <b>?</b> kt�ry zast�puje dowolny jeden znak - przyk�ady: IP: <b>80.53.12.*</b> lub host: <b>*.neoplus.adsl.tpnet.pl</b> lub host: <b>host2?.firma.pl</b>';

$lang['Ban_email'] = 'Zbanuj jeden lub wi�cej adres�w e-mail';
$lang['Ban_email_explain'] = 'Aby poda� wi�cej ni� jeden adres e-mail, oddziel je przecinkami. Znakiem zamiennym jest *, np. *@hotmail.com.';

$lang['Ban_update_sucessful'] = 'Banlista zosta�a zaktualizowana';
$lang['Click_return_banadmin'] = 'Kliknij %sTutaj%s aby powr�ci� do Kontroli banlisty';


//
// Configuration
//
$lang['General_Config'] = 'Ustawienia G��wne';
$lang['Click_return_config'] = 'Kliknij %sTutaj%s aby powr�ci� do Ustawie� G��wnych';

$lang['Server_name'] = 'Nazwa Domeny';
$lang['Script_path'] = '�cie�ka skryptu';
$lang['Server_port'] = 'Port Serwera';
$lang['Acct_activation'] = 'W��cz aktywacj� kont';
$lang['Acc_Admin'] = 'Admin';

$lang['Allow_BBCode'] = 'Zezw�l na BBCode';
$lang['Allow_smilies'] = 'Zezw�l na U�mieszki';
$lang['Admin_email'] = 'Adres E-mail Administratora';

//
// Forum Management
//

$lang['Forum_admin'] = 'Administracja Forum';
$lang['Forum_admin_explain'] = 'W tym miejscu mo�esz dodawa�, usuwa�, modyfikowa�, zmienia� kolejno�� i ponownie synchronizowa� kategorie i fora.<br />Pami�taj �e aby utworzy� drzewo, czyli "forum w forum" musisz najpierw utworzy� kategori� w jakim� istniej�cym forum i dopiero p�niej w tej kategorii utworzy� forum.<br />Mo�esz r�wnie� przesuwa� istniej�ce fora do kategorii utworzonej w wybranym forum.';
$lang['Edit_forum'] = 'Edytuj forum';
$lang['Create_forum'] = 'Nowe Forum';
$lang['Create_category'] = 'Nowa Kategoria';
$lang['Config_updated'] = 'Konfiguracja Forum Zosta�a Zaktualizowana';
$lang['Move_up'] = 'W g�r�';
$lang['Move_down'] = 'W d�';
$lang['Resync'] = 'Synch.';
$lang['No_mode'] = 'Nie okre�lono trybu';
$lang['Forum_edit_delete_explain'] = 'Poni�szy formularz pozwoli zmieni� wszystkie podstawowe opcje forum. Aby zmieni� szczeg�owe ustawienia U�ytkownik�w i For�w skorzystaj z odno�nik�w po lewej.';

$lang['Move_contents'] = 'Przenie� ca�� zawarto��';
$lang['Forum_delete'] = 'Usu� Forum';
$lang['Forum_delete_explain'] = 'Poni�szy formularz pozwoli na usuni�cie forum (lub dzia��w) i zdecydowanie co zrobi� z tematami (lub forami), kt�re by�y w nim zawarte.';

$lang['Forum_settings'] = 'Generalne Ustawienia Forum';
$lang['Forum_name'] = 'Nazwa Forum';
$lang['Forum_desc'] = 'Opis';
$lang['Forum_status'] = 'Status Forum';
$lang['Forum_pruning'] = 'Automatyczne Czyszczenie';

$lang['prune_freq'] = 'Sprawd� wiek tematu co';
$lang['prune_days'] = 'Usu� tematy, w kt�rych nie pisano nic przez';
$lang['Set_prune_data'] = 'W��czy�' .  (($he) ? 'e' : 'a') . '� automatyczne czyszczenie dla tego forum ale nie okre�li�' .  (($he) ? 'e' : 'a') . '� jego parametr�w. Wr�� i wpisz wszystkie dane.';

$lang['Move_and_Delete'] = 'Przenie� i Usu�';

$lang['Delete_all_posts'] = 'Usu� wszystkie posty';
$lang['Edit_Category'] = 'Edytuj Kategori�';
$lang['Edit_Category_explain'] = 'U�yj tego formularza do zmiany nazwy kategorii.';

$lang['Forums_updated'] = 'Dane dotycz�ce For�w i Kategorii zosta�y zaktualizowane';

$lang['Must_delete_forums'] = 'Musisz usun�� wszystkie fora przed usuni�ciem tej kategorii';

$lang['Click_return_forumadmin'] = 'Kliknij %sTutaj%s aby powr�ci� do Administracji Forum';


//
// Smiley Management
//
$lang['smiley_title'] = 'Edycja U�mieszk�w';
$lang['smile_desc'] = 'Na tej stronie mo�esz dodawa�, usuwa� i zmienia� ikony emocji lub u�mieszki, kt�re u�ytkownicy mog� u�ywa� w swoich postach i prywatnych wiadomo�ciach.';

$lang['smiley_config'] = 'Dodaj U�mieszki';
$lang['smiley_code'] = 'Kod U�mieszku';
$lang['smiley_url'] = 'Plik Obrazka U�mieszku';
$lang['smile_add'] = 'Nowy U�mieszek';
$lang['Smile'] = 'U�miech';

$lang['Select_pak'] = 'Wybierz Plik Paczki (.pak)';
$lang['replace_existing'] = 'Zamie� Istniej�cy U�miech';
$lang['keep_existing'] = 'Zachowaj Istniej�cy U�miech';
$lang['smiley_import_inst'] = 'Powin' .  (($he) ? 'iene�' : 'na�') . ' rozpakowa� paczk� u�mieszk�w i wys�a� pliki do odpowiedniego katalogu U�mieszk�w. Potem ustaw odpowiednio poni�szy formularz i importuj paczk�.';
$lang['smiley_import'] = 'Import Paczki U�mieszk�w';
$lang['choose_smile_pak'] = 'Wybierz Plik .pak Paczki U�mieszk�w';
$lang['import'] = 'Importuj U�mieszki';
$lang['smile_conflicts'] = 'Co zrobi� w przypadku konflikt�w';
$lang['del_existing_smileys'] = 'Usu� istniej�ce u�mieszki przed importem';
$lang['import_smile_pack'] = 'Importuj Paczk�';
$lang['export_smile_pack'] = 'Utw�rz Paczk�';
$lang['export_smiles'] = 'Aby utworzy� paczk� u�mieszk�w z obecnie zainstalowanych kliknij %sTutaj%s aby �ci�gn�� plik .pak u�mieszk�w. Nazwij go odpowiednio zachowuj�c rozszerzenie .pak. Potem spakuj ten plik razem z obrazkami u�mieszk�w w archiwum zip.';

$lang['smiley_add_success'] = 'U�mieszek zosta� dodany';
$lang['smiley_edit_success'] = 'U�mieszek zosta� zaktualizowany';
$lang['smiley_import_success'] = 'Paczka U�mieszk�w zosta�a zaimportowana!';
$lang['smiley_del_success'] = 'U�mieszek zosta� usuni�ty';
$lang['Click_return_smileadmin'] = 'Kliknij %sTutaj%s aby powr�ci� do Administracji U�mieszkami';


//
// User Management
//
$lang['User_admin'] = 'Administracja U�ytkownikami';
$lang['User_admin_explain'] = 'Tutaj mo�esz zmieni� informacje o u�ytkowniku i ustawione przez niego opcje. Aby zmieni� jego prawa dost�pu skorzystaj z systemu zmiany zezwole�.';

$lang['Look_up_user'] = 'Poka� u�ytkownika';

$lang['Admin_user_fail'] = 'Nie mo�na by�o zaktualizowa� profilu u�ytkownika.';
$lang['Admin_user_updated'] = 'Profil u�ytkownika zosta� zaktualizowany.';
$lang['Click_return_useradmin'] = 'Kliknij %sTutaj%s aby powr�ci� do Administracji U�ytkownikami';

$lang['User_delete'] = 'Usu� tego u�ytkownika';
$lang['User_delete_explain'] = 'Zaznacz aby usun�� u�ytkownika, nie mo�na tego cofn�� !';
$lang['User_deleted'] = 'U�ytkownik zosta� usuni�ty.';

$lang['User_status'] = 'U�ytkownik jest aktywny';
$lang['User_allowpm'] = 'Mo�e wysy�a� Prywatne Wiadomo�ci';
$lang['User_allowavatar'] = 'Mo�e pokazywa� Avatar';

$lang['Admin_avatar_explain'] = 'Tutaj mo�esz zobaczy� i usun�� obecny Avatar u�ytkownika.';

$lang['User_special'] = 'Specjalne pola administratora';
$lang['User_special_explain'] = 'Tych p�l nie mog� zmienia� sami u�ytkownicy. Mo�esz tutaj zmodyfikowa� ich status i inne opcje dotycz�ce ich mo�liwo�ci dzia�ania.';


//
// Group Management
//
$lang['Group_administration'] = 'Administracja Grupami';
$lang['Group_admin_explain'] = 'Z tego panelu mo�esz administrowa� wszystkimi grupami u�ytkownik�w; mo�esz je usuwa�, tworzy� i zmienia� ustawienia. Mo�esz wybiera� moderator�w, zmienia� na otwarte lub zamkni�te i modyfikowa� nazw� oraz opis.';
$lang['Updated_group'] = 'Grupa zosta�a zaktualizowana';
$lang['Added_new_group'] = 'Nowa grupa zosta�a utworzona';
$lang['Deleted_group'] = 'Grupa zosta�a usuni�ta';
$lang['New_group'] = 'Utw�rz now� grup�';
$lang['Edit_group'] = 'Edytuj grup�';
$lang['group_name'] = 'Nazwa Grupy';
$lang['group_description'] = 'Opis Grupy';
$lang['group_moderator'] = 'Moderator Grupy';
$lang['group_status'] = 'Status Grupy';
$lang['group_open'] = 'Otwarta';
$lang['group_closed'] = 'Zamkni�ta';
$lang['group_hidden'] = 'Ukryta';
$lang['group_delete'] = 'Usu� Grup�';
$lang['group_delete_check'] = 'Usu� t� grup�';
$lang['No_group_name'] = 'Musisz wpisa� nazw� dla tej grupy';
$lang['No_group_moderator'] = 'Musisz poda� moderatora tej grupy';
$lang['delete_group_moderator'] = 'Usun�� poprzedniego moderatora grupy?';
$lang['delete_moderator_explain'] = 'Je�eli zmieniasz moderatora zaznacz to pole aby usun�� starego moderatora. Je�eli tego nie zrobisz stanie si� on zwyk�ym cz�onkiem grupy.';
$lang['Click_return_groupsadmin'] = 'Kliknij %sTutaj%s aby powr�ci� do Administracji Grupami.';
$lang['Select_group'] = 'Wybierz grup�';
$lang['Look_up_group'] = 'Poka� grup�';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'Czyszczenie Forum';
$lang['Forum_Prune_explain'] = 'Usuni�te zostan� tematy, w kt�rych nie napisano nic nowego przez okre�lon� liczb� dni. Je�eli nie wpiszesz �adnej liczby usuni�te zostan� wszystkie tematy. Nietkni�te pozostan� tematy z aktywnymi ankietami oraz og�oszenia. B�dziesz musia� usun�� je r�cznie.';
$lang['Do_Prune'] = 'Wykonaj';
$lang['Prune_topics_not_posted'] = 'Wyczy�� tematy bez nowych odpowiedzi przez dni';
$lang['Topics_pruned'] = 'Usuni�to temat�w';
$lang['Prune_success'] = 'Czyszczenie zosta�o wykonane';


//
// Word censor
//
$lang['Words_title'] = 'Cenzura S��w';
$lang['Words_explain'] = 'Z tego miejsca mo�esz dodawa�, zmienia� i usuwa� s�owa, kt�re zostan� automatycznie ocenzurowane na Twoim forach. Dodatkowo ludzie nie b�d� mogli si� rejestrowa� z nazwami zawieraj�cymi te s�owa. Znaki uniwersalne (*) s� dozwolone, np. *test* obejmie przetestowanie, test* obejmie testowanie, *test obejmie przedtest.';
$lang['Word'] = 'S�owo';
$lang['Edit_word_censor'] = 'Zmie� Cenzur�';
$lang['Replacement'] = 'Zamiennik';
$lang['Add_new_word'] = 'Dodaj nowe s�owo';

$lang['Must_enter_word'] = 'Musisz wpisa� s�owo i jego zamiennik';
$lang['No_word_selected'] = 'Nie wybrano s�owa do edycji';

$lang['Word_updated'] = 'Wybrana cenzura zosta�a zaktualizowana';
$lang['Word_added'] = 'Nowa cenzura zosta�a dodana';
$lang['Word_removed'] = 'Wybrana cenzura zosta�a usuni�ta';

$lang['Click_return_wordadmin'] = 'Kliknij %sTutaj%s aby powr�ci� do Administracji Cenzur�';

//
// Ranks admin
//

$lang['Ranks_title'] = 'Administracja Rangami';
$lang['Ranks_explain'] = 'U�ywaj�c tego formularza mo�esz dodawa�, zmienia�, przegl�da� i usuwa� rangi. Mo�esz te� tworzy� specjalne rangi i przydziela� je poprzez system zarz�dzania u�ytkownik�w.';

$lang['Add_new_rank'] = 'Dodaj now� rang�';

$lang['Rank_title'] = 'Nazwa Rangi';
$lang['Rank_title_e'] = 'Je�li chcesz u�y� obrazka rangi w kt�rym jest ju� nazwa rangi i chcesz �eby nie powtarza�a si� ona w nazwie rangi to przed nazw� rangi daj: <b>-#</b> w�wczas nie b�dzie ona wy�wietlana';
$lang['Rank_special'] = 'Jest Rang� personaln�';
$lang['Rank_minimum'] = 'Minimum Post�w';
$lang['Rank_image'] = 'Obraz Rangi';
$lang['Rank_image_explain'] = 'Mo�esz tutaj okre�li� obrazek zwi�zany z dan� rang�<br />Obrazki rang powinny si� znajdowa� we wszystkich katalogach styl�w w: /templates/Nazwa_stylu/images/ranks/';

$lang['Must_select_rank'] = 'Musisz wybra� rang�';
$lang['No_assigned_rank'] = 'Nie okre�lono rang specjalnych';

$lang['Rank_updated'] = 'Ranga zosta�a zaktualizowana';
$lang['Rank_added'] = 'Ranga zosta�a dodana';
$lang['Rank_removed'] = 'Ranga zosta�a usuni�ta';
$lang['No_update_ranks'] = 'Ranga zosta�a usuni�ta, jednak�e konta u�ytkownik�w, kt�rym zosta�a przydzielona nie zosta�y zmienione. B�dziesz musia� r�cznie usun�� rang� z tych kont';

$lang['Click_return_rankadmin'] = 'Kliknij %sTutaj%s aby powr�ci� do Administracji Rangami';


//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'Kontrola Zabronionych Nazw';
$lang['Disallow_explain'] = 'Tutaj mo�esz kontrolowa� nazwy u�ytkownik�w, kt�rych nie wolno u�ywa�. Zabronione nazwy mog� zawiera� znak zamienny *. Pami�taj, �e nie mo�esz zabroni� nazwy, kt�ra ju� zosta�a zarejestrowana. Najpierw usu� tego u�ytkownika a potem dopisz tutaj nazw�.';

$lang['Delete_disallow_title'] = 'Usu� Zabronion� Nazw�';
$lang['Delete_disallow_explain'] = 'Mo�esz usun�� zabronion� nazw� wybieraj�c j� z tej listy i klikaj�c Wy�lij.';

$lang['Add_disallow_title'] = 'Dodaj Zabronion� Nazw�';
$lang['Add_disallow_explain'] = 'Mo�esz zabroni� korzystania z jakiej� nazwy wykorzystuj�c znak * r�wnowa�ny dowolnemu ci�gowi znak�w';
$lang['Disallowed_deleted'] = 'Zabroniona nazwa zosta�a usuni�ta';
$lang['Disallow_successful'] = 'Zabroniona nazwa zosta�a dodana';
$lang['Disallowed_already'] = 'Nazwa, kt�r� wpisa�' .  (($he) ? 'e' : 'a') . '�, nie mo�e by� zakazana. Albo jest ju� na li�cie albo istnieje ju� taki u�ytkownik.';

$lang['Click_return_disallowadmin'] = 'Kliknij %sTutaj%s aby powr�ci� do Administracji Zabronionymi Nazwami';


//
// Styles Admin
//
$lang['Styles_admin'] = 'Administracja Stylami';
$lang['Styles_explain'] = 'Korzystaj�c z tego narz�dzia mo�esz dodawa�, usuwa� i zarz�dza� stylami (oraz szablonami) dost�pnymi dla u�ytkownik�w';
$lang['Styles_addnew_explain'] = 'Poni�sza lista zawiera wszystkie style, kt�re s� dost�pne dla posiadanych przez ciebie szablon�w. Elementy na tej li�cie nie zosta�y jeszcze zainstalowane w bazie danych phpBB. Aby zainstalowa� styl po prostu kliknij odno�nik Instaluj obok wpisu';

$lang['Select_template'] = 'Wybierz Szablon';

$lang['Style'] = 'Styl';
$lang['Template'] = 'Szablon';
$lang['Install'] = 'Instaluj';
$lang['Download'] = '�ci�gnij';

$lang['Edit_theme'] = 'Edytuj Styl';
$lang['Edit_theme_explain'] = 'W formularzu poni�ej mo�esz zmieni� ustawienia dla wybranego stylu';

$lang['Create_theme'] = 'Utw�rz Styl';
$lang['Create_theme_explain'] = 'U�yj formularza poni�ej aby utworzy� nowy styl dla wybranego szablonu. Wpisuj�c kolory (do kt�rych mo�esz u�ywa� jedynie warto�ci szesnastkowych) nie dodawaj pocz�tkowego #, np. CCCCCC jest poprawne ale #CCCCCC ju� nie.';

$lang['Export_themes'] = 'Eksportuj Styl';
$lang['Export_explain'] = 'Z tego panelu mo�esz eksportowa� dane stylu dla wybranego szablonu. Wybierz styl z poni�szej listy, a skrypt utworzy plik jego konfiguracji i spr�buje zapisa� go w wybranym katalogu styl�w. Je�eli nie b�dzie mo�liwe zapisanie pliku otrzymasz mo�liwo�� �ci�gni�cia go. Aby plik zosta� zapisany serwer musi mie� uprawnienia zapisu w danym katalogu. Wi�cej informacji znajdziesz w podr�czniku phpBB 2.';

$lang['Theme_installed'] = 'Wybrany styl zosta� zainstalowany';
$lang['Style_removed'] = 'Wybrany styl zosta� usuni�ty z bazy danych. Aby ca�kowicie usun�� styl z systemu musisz usun�� go r�cznie z katalogu szablon�w.';
$lang['Theme_info_saved'] = 'Informacje o stylu dla wybranego szablonu zosta�y zapisane. Powin' .  (($he) ? 'iene�' : 'na�') . ' teraz przywr�ci� uprawnienia dost�pu pliku theme_info.cfg (i je�li to potrzebne tak�e dla katalogu szablon�w) na \'tylko do odczytu\'.';
$lang['Theme_updated'] = 'Wybrany styl zosta� zaktualizowany. Powin' .  (($he) ? 'iene�' : 'na�') . ' wyeksportowa� nowe ustawienia.';
$lang['Theme_created'] = 'Styl utworzony. Powin' .  (($he) ? 'iene�' : 'na�') . ' teraz wyeksportowa� go do pliku konfiguracyjnego aby go zabezpieczy� lub u�y� gdzie indziej.';

$lang['Confirm_delete_style'] = 'Czy na pewno chcesz usun�� ten styl';

$lang['Download_theme_cfg'] = 'Eksporter nie m�g� zapisa� pliku z informacjami o stylu. Kliknij przycisk poni�ej aby �ci�gn�� ten plik przez przegl�dark�. Kiedy ju� go �ci�gniesz wy�lij go r�cznie do katalogu z plikami szablonu. Mo�esz wtedy spakowa� pliki dla dystrybucji lub u�ycia gdzie indziej.';
$lang['No_themes'] = 'Wybrany szablon nie ma �adnych do��czonych styl�w. Aby utworzy� nowy styl kliknij odno�nik Utw�rz Nowy na lewym panelu.';
$lang['No_template_dir'] = 'Otwarcie katalogu szablon�w by�o niemo�liwe. By� mo�e nie istnieje lub serwer nie ma do niego praw dost�pu.';
$lang['Cannot_remove_style'] = 'Nie mo�esz usun�� wybranego stylu, poniewa� jest obecnie domy�lnym dla forum. Zmie� ustawienia domy�lne i spr�buj ponownie.';
$lang['Style_exists'] = 'Nazwa stylu, kt�r� wybra�' .  (($he) ? 'e' : 'a') . '� ju� istnieje, wr�� i spr�buj z inn� nazw�.';

$lang['Click_return_styleadmin'] = 'Kliknij %sTutaj%s aby powr�ci� do Administracji Stylami';

$lang['Theme_settings'] = 'Ustawienia Tematu';
$lang['Theme_element'] = 'Element Tematu';
$lang['Simple_name'] = 'Prosta Nazwa';
$lang['Save_Settings'] = 'Zapisz Ustawienia';

$lang['Stylesheet'] = 'Arkusz CSS';
$lang['Background_image'] = 'Obrazek T�a';
$lang['Background_color'] = 'Kolor T�a';
$lang['Theme_name'] = 'Nazwa Tematu';
$lang['Link_color'] = 'Kolor Odno�nika';
$lang['Text_color'] = 'Kolor Tekstu';
$lang['VLink_color'] = 'Kolor Odwiedzonego Odno�nika';
$lang['ALink_color'] = 'Kolor Aktywnego Odno�nika';
$lang['HLink_color'] = 'Kolor Odno�nika pod Kursorem';
$lang['Tr_color1'] = 'Kolor Rz�du Tabeli 1';
$lang['Tr_color2'] = 'Kolor Rz�du Tabeli 2';
$lang['Tr_color3'] = 'Kolor Rz�du Tabeli 3';
$lang['Tr_class1'] = 'Klasa Rz�du Tabeli 1';
$lang['Tr_class2'] = 'Klasa Rz�du Tabeli 2';
$lang['Tr_class3'] = 'Klasa Rz�du Tabeli 3';
$lang['Th_color1'] = 'Kolor Nag��wka Tabeli 1';
$lang['Th_color2'] = 'Kolor Nag��wka Tabeli 2';
$lang['Th_color3'] = 'Kolor Nag��wka Tabeli 3';
$lang['Th_class1'] = 'Klasa Nag��wka Tabeli 1';
$lang['Th_class2'] = 'Klasa Nag��wka Tabeli 2';
$lang['Th_class3'] = 'Klasa Nag��wka Tabeli 3';
$lang['Td_color1'] = 'Kolor Kom�rki Tabeli 1';
$lang['Td_color2'] = 'Kolor Kom�rki Tabeli 2';
$lang['Td_color3'] = 'Kolor Kom�rki Tabeli 3';
$lang['Td_class1'] = 'Klasa Kom�rki Tabeli 1';
$lang['Td_class2'] = 'Klasa Kom�rki Tabeli 2';
$lang['Td_class3'] = 'Klasa Kom�rki Tabeli 3';
$lang['fontface1'] = 'Czcionka 1';
$lang['fontface2'] = 'Czcionka 2';
$lang['fontface3'] = 'Czcionka 3';
$lang['fontsize1'] = 'Rozmiar Czcionki 1';
$lang['fontsize2'] = 'Rozmiar Czcionki 2';
$lang['fontsize3'] = 'Rozmiar Czcionki 3';
$lang['fontcolor1'] = 'Kolor Czcionki 1';
$lang['fontcolor2'] = 'Kolor Czcionki 2';
$lang['fontcolor3'] = 'Kolor Czcionki 3';
$lang['span_class1'] = 'Klasa Span 1';
$lang['span_class2'] = 'Klasa Span 2';
$lang['span_class3'] = 'Klasa Span 3';

//
// Install Process
//

$lang['Default_lang'] = 'Domy�lny J�zyk Forum';
$lang['ftp_info'] = 'Wpisz informacj� o twoim FTP';
$lang['ftp_username'] = 'U�ytkownik FTP';
$lang['Install'] = 'Instalacja';

//
// Modified addons
//

$lang['Poll Admin'] = 'Sondy';
$lang['Poll Results'] = 'Wyniki glosowa�';
$lang['Prune_User_Posts'] = 'Masowe kasowanie post�w u�ytkownik�w';
$lang['logs'] = 'Logi po��cze�';
$lang['Categories'] = 'Kategorie';
$lang['Clear_Cache'] = 'Wyczy�� Cache';

$lang['Status_locked'] = 'Zablokowane';
$lang['Status_unlocked'] = 'Odblokowane';
$lang['Sort_alpha'] = 'Tytu�u tematu';
$lang['Sort_fpdate'] = 'Czasu ostatniego postu';
$lang['Sort_ttime'] = 'Czasu napisania tematu';
$lang['Sort_author'] = 'Autora tematu';
$lang['User_allowsig'] = 'Mo�e dodawa� podpis';
$lang['No_group_action'] = 'Nie wybrano czynno�ci';
$lang['Download2'] = 'Download';

$lang['Active'] = 'Aktywny';
$lang['modules'] = 'Rozmieszczenie modu��w';
$lang['clock'] = 'Zegar';
$lang['l_search_a'] = 'Wyr�wnanie Menu Szukaj';
$lang['Deactivate'] = 'Wy��cz';
$lang['none'] = 'wy��cz';
$lang['Logs'] = 'Logi';
$lang['LogsActions'] = 'Logi czynno�ci';
$lang['Log_action_title'] = 'Logi administracyjne';
$lang['Log_action_explain'] = 'Poni�ej znajduj� si� logi czynno�ci wykonywanych przez administrator�w i moderator�w';
$lang['Choose_sort_method'] = 'Wybierz metod� sortowania';
$lang['Id_log'] = 'Log Id';
$lang['Delete_log'] = 'Skasuj Log';
$lang['Action'] = 'Czynno��';
$lang['Done_by'] = 'Wykonane przez';
$lang['User_ip'] = 'IP u�ytkownika';
$lang['Log_delete'] = 'Log skasowany.';
$lang['Click_return_admin_log'] = 'Kliknij %sTutaj%s �eby przej�� do log�w';
$lang['OverallPermissions'] = 'Zezwolenia og�lne';
$lang['OverallPermissions_all'] = 'Ustaw poni�sze zezwolenia dla wszystkich for�w';
$lang['l_logsip_e'] = 'Logi domy�lnie wy��czone, mo�esz je w��czy� w menu Konfiguracja. Do poprawnej pracy logowania plik /admin/admin_logs.php musi mie� prawa do zapisu: chmod 777 admin_logs.php<br />Je�eli chcesz wyczy�ci� logi, usu� zawarto�� danych w pliku /admin/admin_logs.php';
$lang['l_logsip'] = 'Logi po��cze�';
$lang['Files'] = 'Pliki';
$lang['Globalannounce'] = 'Wa�ne og�oszenie';
$lang['Group_rank'] = 'Rangi dla grup';
$lang['Group_rank_explain'] = 'Tutaj mo�esz wybra� rangi dla ca�ych grup. B�dzie ignorowane je�li ustawisz rang� specjaln�.';
$lang['Group_Rank_special'] = 'Personalna- / Ranga grupy';
$lang['Group_rank_order'] = 'Pierwsze�stwo Grup';
$lang['Group_rank_order_moved'] = 'Grupa przeniesiona.';
$lang['Group_rank_order_alreay_moved'] = 'Grupa ju� jest przeniesiona.';
$lang['Group_rank_order_could_not_moved'] = 'Grupa nie mo�e by� przeniesiona poniewa� ju� jest na g�rze lub na dole.';
$lang['Group_rank_resynced'] = 'Grupowanie zsynchronizowane';
$lang['Group_rank_order_explain'] = 'Je�li u�ytkownik jest w wi�cej ni� jednej grupie, b�dzie pokazywana ta ranga kt�ra jest wy�ej na li�cie.';

$lang['Inactive_title'] = 'Nieaktywni u�ytkownicy';
$lang['Deleted_user'] = 'U�ytkownik z ID #%d usuni�ty';
$lang['Activate_title'] = 'Czynno�� konta u�ytkownika';
$lang['Activate'] = 'Aktywuj';
$lang['Waiting_1'] = '(Oczekuje na aktywacj� %d dzie�)';
$lang['Waiting_2'] = '(Oczekuje na aktywacj� od %d dni)';
$lang['No_users'] = 'Nie ma u�ytkownik�w oczekuj�cych na aktywacj�';
$lang['Total_member'] = '<b>%d</b> u�ytkownik oczekuje na aktywacj�.';
$lang['Total_members'] = '<b>%d</b> u�ytkownik�w oczekuje na aktywacj�.';

$lang['Account_block'] = 'Konto zablokowane';
$lang['Account_block_explain'] = 'Tutaj znajduj� si� informacje dot. blokady konta, pr�b b��dnego logowania, daty, adresu.';
$lang['Block_until'] = 'Zablokowane do: %s';
$lang['Block_by'] = 'Pr�by logowa� z IP: %s';
$lang['Last_block_by'] = 'Ostatnio z IP: %s';
$lang['Unblock_user'] = 'Odblokuj konto';
$lang['Block_user'] = 'Zablokuj konto na %s minut';
$lang['Badlogin_count'] = 'Ilo�� b��dnych logowa�';

$lang['BM_Show_bans_by'] = 'Poka� bany na';
$lang['BM_All'] = 'Wszystkie';
$lang['BM_Show'] = 'Poka�';
$lang['BM_Banned'] = 'Za�o�ony';
$lang['BM_Expires'] = 'Wyga�nie';
$lang['BM_By'] = 'Przez';
$lang['BM_Add_a_new_ban'] = 'Dodaj bana';
$lang['BM_Edit_ban'] = 'Edytuj bana';
$lang['BM_Delete_selected_bans'] = 'Usu� wybrane bany';
$lang['BM_Private_reason'] = 'Prywatny pow�d';
$lang['BM_Private_reason_explain'] = 'Ten pow�d b�dzie widoczny tylko dla administrator�w';
$lang['BM_Public_reason'] = 'Publiczny pow�d';
$lang['BM_Public_reason_explain'] = 'Ten pow�d b�dzie wy�wietlany tylko zbanowanemu u�ytkownikowi, je�li b�dzie pr�bowa� wej�� na forum';
$lang['BM_Generic_reason'] = 'Pow�d standardowy';
$lang['BM_Mirror_private_reason'] = 'Pow�d taki sam jak Prywatny Pow�d';
$lang['BM_Other'] = 'Inny/wpisz ni�ej';
$lang['BM_Expire_time'] = 'Czas wyga�ni�cia';
$lang['BM_Expire_time_explain'] = 'Mo�esz ustali� kiedy ban ma znikn��/wygasn��.';
$lang['BM_Never'] = 'Nigdy';
$lang['BM_After_specified_length_of_time'] = 'Po up�ywie:';
$lang['BM_Minutes'] = 'Minut';
$lang['BM_Weeks'] = 'Tygodni';
$lang['BM_Months'] = 'Miesi�cy';
$lang['BM_Years'] = 'Lat';

$lang['Custom_fields'] = 'Pola w profilu';
$lang['shoutbox_on'] = 'ShoutBox w��czony';
$lang['date_on'] = 'Wy�wietlanie daty';
$lang['sb_make_links'] = 'W��cz automatyczne tworzenie link�w';
$lang['sb_links_names'] = 'Nazwa linkiem do profilu';
$lang['sb_allow_edit'] = 'Zezw�l na edycje wiadomo�ci przez Administrator�w';
$lang['sb_allow_edit_m'] = 'Zezw�l na edycje wiadomo�ci przez Moderator�w';
$lang['sb_allow_edit_all'] = 'Zezw�l na edycje w�asnych wiadomo�ci';
$lang['sb_allow_delete'] = 'Zezw�l na usuwanie wiadomo�ci przez Administrator�w';
$lang['sb_allow_delete_m'] = 'Zezw�l na usuwanie wiadomo�ci przez Moderator�w';
$lang['sb_allow_delete_all'] = 'Zezw�l na usuwanie w�asnych wiadomo�ci';
$lang['sb_allow_guest'] = 'Go�cie mog� pisa� w ShoutBox\'ie ?';
$lang['sb_allow_guest_view'] = 'Shoutbox tylko widoczny dla go�ci, bez mo�liwo�ci pisania';
$lang['sb_allow_users'] = 'Zarejestrowani u�ytkownicy mog� pisa� w ShoutBox\'ie ?';
$lang['sb_allow_users_view'] = 'Shoutbox tylko widoczny dla zarejestrowanych u�ytkownik�w, bez mo�liwo�ci pisania';
$lang['delete_days'] = 'Po ilu dniach kasowa� wiadomo�ci';
$lang['sb_shout_refresh'] = 'Cz�stotliwo�� od�wie�ania shoutboxa.<br>Po jakim czasie shoutbox ma pobra� nowe wiadomo�ci czekaj�ce w kolejce? Warto�ci w sekundach, czyli 5 = 5 sekund';
$lang['sb_shout_group'] = 'Wybierz grupy, kt�re b�d� mog�y pisa� w shoutboxie. Przytrzymaj klawisz CTRL i myszk� wybieraj grupy.';
$lang['l_usercall'] = 'Po klikni�ciu w nick przenosi jego nazw� do pola pisania wiadomo�ci. User Call.';
$lang['sb_smilies'] = 'W��cz wysuwany panel emotikon.';
$lang['sb_count_msg'] = 'Ilo�� wy�wietlanych wiadomo�ci';
$lang['sb_text_lenght'] = 'Maksymalna ilo�� znak�w w wiadomo�ci';
$lang['sb_word_lenght'] = 'Maksymalna ilo�� znak�w w jednym wyrazie';
$lang['setup_shoutbox'] = 'Ustawienia Shoutboxa';
$lang['shout_size'] = 'Rozmiary ShoutBox\'a';
$lang['sb_banned_send'] = 'Zabro� wysy�a� wiadomo�ci u�ytkownikowi';
$lang['sb_banned_send_e'] = 'Wpisz ID u�ytkownika, kt�remu chcesz odebra� mo�liwo�� wysy�ania wiadomo�ci do ShoutBox\'a, mo�esz poda� kilka, oddziel je przecinkami. Przyk�ad: <b>18, 124</b>';
$lang['sb_banned_view'] = 'Wy��cz ShoutBox dla u�ytkownika';
$lang['sb_banned_view_e'] = 'Wpisz ID u�ytkownika, kt�remu chcesz odebra� mo�liwo�� u�ywania ShoutBox\'a, mo�esz poda� kilka, oddziel je przecinkami. Przyk�ad: <b>18, 124</b>';

$lang['disallow_forums'] = 'Zablokuj pisanie w forach';
$lang['disallow_forums_e'] = 'Zablokuj temu u�ytkownikowi mo�liwo�� pisania w okre�lonych forach.<br />Dla wyboru kilku, przytrzymaj klawisz Ctrl';
$lang['can_custom_ranks'] = 'Mo�e ustawia� sw�j tytu�';
$lang['can_custom_color'] = 'Mo�e ustawia� kolor nazwy';

$lang['group_count'] = 'Ilo�� wymaganych post�w';
$lang['group_count_explain'] = 'Je�li u�ytkownik b�dzie mia� tyle post�w lub wi�cej ni� ta warto�� zostanie automatycznie do��czony do tej grupy';
$lang['Group_count_enable'] = 'Automatyczne dodawanie u�ytkownik�w';
$lang['Group_count_update'] = 'Dodaj teraz u�ytkownik�w z podan� lub wi�ksz� ilo�ci� post�w';
$lang['Group_count_delete'] = 'Usu� teraz wszystkich u�ytkownik�w tej grupy';

$lang['Optimize_DB'] = 'Optymalizacja SQL';
$lang['Optimize'] = 'Optymalizuj';
$lang['Optimize_explain'] = 'Optymalizacja bazy SQL polega na czyszczeniu pustych p�l w bazie';
$lang['Optimize_Table'] = 'Tabela';
$lang['Optimize_Record'] = 'Wpis�w';
$lang['Optimize_Type'] = 'Typ';
$lang['Optimize_Size'] = 'Rozmiar';
$lang['Optimize_Status'] = 'Status';
$lang['Optimize_InvertChecked'] = 'Odwr�� zaznaczenia';
$lang['Optimize_success'] = 'Baza pomy�lnie zoptymalizowana';
$lang['Optimize_NoTableChecked'] = 'Nie wybrano �adnej tabeli';

$lang['SQL_Admin_No_Access'] = 'Nie masz dost�pu do tego menu.<br /><br />Kliknij %sTutaj%s �eby zobaczy� szczeg�y.';
$lang['Category_attachment'] = 'Przypisane do';
$lang['Category_desc'] = 'Opis';
$lang['Attach_forum_wrong'] = 'Nie mo�esz przypisa� forum do forum. Tylko kategorie.';
$lang['Attach_root_wrong'] = 'Nie mo�esz przypisa� forum do g��wnego forum, utw�rz kategorie';
$lang['Forum_name_missing'] = 'Nie mo�na utworzy� forum bez nazwy';
$lang['Category_name_missing'] = 'Nie mo�na utworzy� kategorii bez nazwy';
$lang['Only_forum_for_topics'] = 'Tematy mog� by� tylko w forum';
$lang['Delete_forum_with_attachment_denied'] = 'Nie mo�esz usun�� forum zawieraj�cego podkategorie';
$lang['Category_delete'] = 'Usu� kategorie';
$lang['Category_delete_explain'] = 'W tym miejscu mo�esz usun�� kategorie i przenie�� fora oraz podkategorie kt�re zawiera.';
$lang['Forum_link_url'] = 'Forum&nbsp;jako&nbsp;link';
$lang['Forum_link_url_explain'] = 'W tym miejscu mo�esz poda� adres lokalny lub pe�ny adres do zewn�trznego miejsca.<br />Pami�taj �eby poda� http://';
$lang['Forum_link_internal'] = 'Adres lokalny';
$lang['Forum_link_internal_explain'] = 'Wybierz Tak je�li adres jest lokalny (katalog forum)';
$lang['Forum_link_hit_count'] = 'Klikni��';
$lang['Forum_link_hit_count_explain'] = 'Wybierz Tak, je�li chcesz aby klikni�cia by�y zliczane i pokazywane.';
$lang['Forum_link_with_attachment_deny'] = 'Nie mo�esz ustawi� forum jako link, je�eli zawiera podkategorie.';
$lang['Forum_link_with_topics_deny'] = 'Nie mo�esz ustawi� forum jako link, je�eli zawiera tematy.';
$lang['Forum_attached_to_link_denied'] = 'Nie mo�esz przypisa� forum ani kategorii do forum kt�re jest linkiem.';

$lang['mass_smilies_add'] = 'Dodaj u�mieszki z katalogu';
$lang['Click_to_back_smilies'] = 'U�mieszk�w dodanych: <b>%s</b><br /><br />Kliknij %sTutaj%s �eby wr�ci� do zarz�dzania u�mieszkami';
$lang['Resync_Stats'] = 'Synchronizacja';
$lang['Rebuild_search'] = 'Odbuduj Search';
$lang['Rebuild_search_explain'] = 'Ta funkcja pozwala na odbudowanie tabel phpbb_search_* pobiera ona dane z tabeli post�w i kopiuje je do search\'u. Umo�liwia to ca�kowite odzyskanie tabel search, przydatne jest to w sytuacji gdy mamy du�� baz� danych i potrzebujemy przenie�� forum na inny serwer, w�wczas mo�emy usun�� ca�kowicie tabele phpbb_search_* kt�re zajmuj� oko�o 40% ca�ej bazy, skopiowa� baz� danych na drugi serwer i w�wczas odbudowa� search.<br />Odbudowywanie search\'u przy du�ej ilo�ci post�w mo�e trwa� kilka godzin, jest wyposa�one w automat kt�ry pozwala na kontynuowanie odbudowywania po roz��czeniu.<br />Je�eli mamy forum na wolnym serwerze, musimy wybra� wi�kszy czas oraz mniejszy limit post�w, w przypadku "zaci�cia" si� funkcji w jakim� miejscu musimy chwilowo zmniejszy� jeszcze bardziej limit post�w (dzieje si� tak wtedy gdy skrypt natrafi na obszerny post)<br /><b>Pami�taj</b> �e podczas startu skryptu tabele phpbb_search_* zostaj� wyczyszczone.';
$lang['Time_limit'] = 'Limit czasu';
$lang['Post_limit'] = 'Limit post�w';
$lang['Finished'] = 'Zako�czono';
$lang['Refresh_rate'] = 'Od�wie�anie';
$lang['Percentage_complete'] = 'Post�p';
$lang['Resync_page_desc_simple'] = 'W tym miejscu mo�esz zsynchronizowa� baz� danych for�w, to narz�dzie ustala prawdziw� warto�� dla: ilo�ci temat�w, post�w, ostatnich post�w, odpowiedzi, mo�esz wybra� poszczeg�lne fora do synchronizacji, lub zaznaczy� wszystkie.<br />Je�eli masz du�e forum, z du�� ilo�ci� temat�w i post�w, u�yj trybu zaawansowanego aby synchronizowa� fora pojedynczo.<br /><b>Przed u�yciem tego narz�dzia powin' .  (($he) ? 'iene�' : 'na�') . ' zrobi� kopi� bazy danych.</b><br />Zalecane jest dwukrotne wykonanie synchronizacji.'; 
$lang['Resync_all_ask'] = 'Synchronizacja wszystkich for�w';
$lang['Resync_options'] = 'Opcje synchronizacji';
$lang['Resync_forum_topics'] = 'Ilo�� temat�w w forum';
$lang['Resync_forum_posts'] = 'Ilo�� post�w w forum';
$lang['Resync_forum_last_post'] = 'Ostatni post w forum';
$lang['Resync_topic_replies'] = 'Ilo�� odpowiedzi w tematach';
$lang['Resync_topic_last_post'] = 'Ostatni post w tematach';
$lang['Resync_question'] = 'Wyb�r';
$lang['Resync_do'] = 'Uruchom synchronizacj�';
$lang['Resync_redirect'] = '<br /><br />Wr�� do <a href="%s">Synchronizacji</a><br /><br />Wr�� do <a href="%s">Panelu admina</a>.';
$lang['Resync_completed'] = 'Fora oraz tematy zosta�y zsynchronizowane';
$lang['Resync_no_forums'] = 'Brak for�w do synchronizacji';
$lang['resume_rebuild'] = '<b>Uwaga!</b> poprzednie odbudowywanie zosta�o przerwane przed uko�czeniem zadania, kliknij %sTutaj%s aby je przywr�ci�, lub %sTutaj%s aby anulowa�. Je�eli anulujesz, w tabelach phpbb_search_* pozostan� niepe�ne dane kt�re zosta�y odtworzone do tej pory, zaleca sie wtedy rozpocz�� przebudowywanie od pocz�tku.';
$lang['value_not'] = 'Warto��: <b>%s</b> nie ma odpowiednika, popraw zapytanie<br /><br />Kliknij %sTutaj%s �eby powr�ci�';
$lang['confirm_clear'] = 'Nie poda�' .  (($he) ? 'e' : 'a') . '� warunk�w, czy na pewno chcesz wyczy�ci� t� tabel� ?';
$lang['cannot_execute'] = 'Nie mog� wykona�: <b>%s</b><br /><br />Kliknij %sTutaj%s �eby powr�ci�.';
$lang['execute_done'] = 'Ilo�� rekord�w: <b>%s</b><br /><br /><b>%s</b><br /><br />Kliknij %sTutaj%s �eby powr�ci�.';
$lang['mysql_e'] = '<span style="color: red"><b>UWAGA !!!</b></span> To narz�dzie jest dla zaawansowanych u�ytkownik�w! Znaj�cych dzia�anie baz SQL, niew�a�ciwe u�ycie mo�e spowodowa� trwa�� utrat� danych z bazy!<br />W tym miejscu mo�esz wykona� jedno lub kilka zapyta� SQL. Aby wykona� kilka, oddziel je znakiem <b>;</b> jednak ten znak nie mo�e wyst�powa� w samym zapytaniu SQL.<br />Przed u�yciem zalecane jest wykonanie kopii bazy SQL ! Prefix tabel: <b>%s</b>';
$lang['do_query'] = 'Wykonanie zapytania/zapyta� SQL';
$lang['execute'] = 'wykonaj';
$lang['access_title'] = 'Zezwolenia dla SQL\'a';
$lang['access_explain'] = 'Z powod�w bezpiecze�stwa do menu SQL mog� mie� dost�p tylko wybrani administratorzy.<br />Je�eli nie masz dost�pu a uwa�asz �e powin' .  (($he) ? 'iene�' : 'na�') . ' mie�, zwr�� si� do g��wnego administratora.<br />Dopisywanie administrator�w kt�rzy maj� mie� dost�p do SQL odbywa si� za pomoc� ID. Je�eli nie wiesz co to znaczy to lepiej �eby� nie wiedzia�' .  (($he) ? '' : 'a') . ' i nie mia�' .  (($he) ? '' : 'a') . ' dost�pu do tej cz�ci menu, bo mo�e si� to sko�czy� uszkodzeniem forum :><br />Je�li jeste� "dopisanym" adminem poni�ej jest formularz s�u��cy do dodania kolejnych admin�w kt�rzy b�d� mieli dost�p do SQL. Je�eli jeste� g��wnym administratorem i nie widzisz formularza, kliknij %s<b>Tutaj</b>%s b�dziesz mia�' .  (($he) ? '' : 'a') . ' mo�liwo�� dodania swojego ID (domy�lnie 2)<br /><span style="color: red"><b>Pami�taj</b></span> �eby po zako�czeniu koniecznie zmieni� nazw� pliku <b>/admin/main_admin.php</b> lub go usun��, w przeciwnym razie twoi administratorzy b�d� mogli zast�pi� twoje ID swoim i b�d� mie� dost�p do SQL.<br />W celu jeszcze wi�kszego bezpiecze�stwa wskazane jest po zako�czeniu operacji na bazie danych, usuni�cie z tej listy zezwole� swojego numeru ID i zmian� nazwy pliku poprzez FTP';
$lang['change_main_admin'] = 'Wpisz swoje ID (dla kilku oddziel przecinkami)';
$lang['IPSearch_Search_by_IP'] = 'Szukaj adresu IP';
$lang['IPSearch_Enter_IP'] = 'Podaj adres IP';
$lang['IPSearch_Search_Results'] = 'Wyniki wyszukiwania IP';
$lang['IPSearch_Enter_an_IP'] = 'Cofnij sie i podaj adres IP';
$lang['IPSearch_Again'] = 'Szukaj jeszcze raz';
$lang['smiley_del_all_success'] = 'Wszystkie u�mieszki zosta�y usuni�te';
$lang['dell_all_smilies'] = 'Usu� wszystkie u�mieszki !';
$lang['can_topic_color'] = 'Mo�e u�ywa� koloru tematu';
$lang['Uninstall18'] = 'Deinstalator modyfikacji';
$lang['uninstall_explain'] = 'W tym miejscu mo�esz przywr�ci� forum do oryginalnej postaci, mo�e si� to okaza� potrzebne gdy b�dziesz chcia�' .  (($he) ? '' : 'a') . ' uaktualni� swoje forum np. do wersji phpBB 2.2.<br />Przywracanie sk�ada si� z dw�ch etap�w: 1. Odinstalowanie w tym miejscu modyfikacji z bazy danych. 2. Nadpisanie plik�w oryginalnymi plikami phpBB 2.0.x Lepszym sposobem jest usuni�cie z katalogu forum wszystkich plik�w, z wyj�tkiem katalogu \'images\' oraz pliku <b>config.php</b> i wgranie oryginalnych plik�w.<br /><br /><b>Odinstalowanie z bazy danych SQL</b><br />Pami�taj, �e gdy odinstalujesz modyfikacj� z bazy SQL nie b�dzie mo�na tego cofn��. Stracisz wszystkie dodatkowe informacje, te kt�rych nie ma w oryginalnym phpBB. Zalecane jest wi�c zrobienie kopii bazy SQL.<br />Mo�liwe jest oczywi�cie ponowne przywr�cenie forum do postaci z przed odinstalowania, pod warunkiem posiadania kopii bazy SQL. Je�eli chcemy przywr�ci�, czy�cimy baz� danych, wgrywamy kopi� bazy i nadpisujemy pliki forum plikami phpBB modified v1.12.5 by Przemo z wyj�tkiem pliku <b>config.php</b>';
$lang['Uninstall'] = 'Odinstaluj';
$lang['confirm_uninstall'] = 'Czy jeste� pew' .  (($he) ? 'ien' : 'na') . ' �e chcesz odinstalowa� modyfikacje?<br />Spowoduje to utrat� niekt�rych danych, powin' .  (($he) ? 'iene�' : 'na�') . ' posiada� kopi� bazy danych.';
$lang['Set_new_version'] = 'Podaj wersj� plik�w phpBB2 kt�rymi nadpiszesz istniej�ce';
$lang['uninstall_end'] = '<span class="nav"><b>Wynik deinstalacji:</b></span><br /><span class="gensmall">Je�eli wszystkie zapytania s� w kolorze niebieskim, oznacza to �e deinstalacja przebieg�a pomy�lnie. Usu� wszystkie dodatkowe pliki pakietu phpBB modified by Przemo, i nadpisz wszystkie istniej�ce plikami z oryginalnego pakietu phpBB 2.0.15 lub wy�szego.</span>';
$lang['query_executed'] = 'Instrukcja wykonana';
$lang['query_not_executed'] = 'Instrukcja nie wykonana';
$lang['Updates'] = 'Uaktualnienia';

$lang['Report_post'] = 'Zg�aszanie post�w';
$lang['Report_config_updated'] = 'Ustawienia zg�aszanych post�w zaktualizowane.';
$lang['Click_return_report_config'] = 'Kliknij %sTutaj%s aby przej�� do ustawie� zg�aszania post�w';
$lang['Click_return_report_auth'] = 'Kliknij %sTutaj%s aby przej�� do ustawie� zezwole� zg�aszania post�w';
$lang['Click_return_report_auth_select'] = 'Kliknij %sTutaj%s aby przej�� do wyboru zezwole� zg�aszania post�w';
$lang['Report_config'] = 'Zg�aszanie post�w - Konfiguracja';
$lang['Report_config_explain'] = '';
$lang['Report_popup_size'] = 'Rozmiary popup\'a';
$lang['Report_popup_size_explain'] = 'W tym miejscu mo�esz ustawi� szeroko�� i wysoko�� popup\'a (w pikselach)';
$lang['Report_popup_links_target'] = 'Okno popup\'a';
$lang['Report_popup_links_target_explain'] = 'W tym miejscu mo�esz ustali� w jakim oknie ma by� otwierany popup';
$lang['Report_popup_links_target_0'] = 'Jako popup';
$lang['Report_popup_links_target_1'] = 'W nowym oknie';
$lang['Report_popup_links_target_2'] = 'W tym samym oknie';
$lang['Report_only_admin'] = 'Tylko dla administrator�w';
$lang['Report_only_admin_explain'] = 'Je�li w��czysz t� opcje, tylko administratorzy b�d� powiadamiani o zg�aszanych postach';
$lang['Report_no_guests'] = 'Tylko zarejestrowani';
$lang['Report_no_guests_explain'] = 'Tylko zarejestrowani u�ytkownicy mog� zg�asza� posty';
$lang['No_group_specified'] = 'Nie ma ustalonej grupy/grup';
$lang['Report_already_auth'] = 'Ten u�ytkownik/grupa ju� jest dodany';
$lang['Report_auth_field_explain'] = 'Mo�esz zaznaczy� kilka u�ytkownik�w';
$lang['Report_permissions_explain'] = 'W tym miejscu mo�esz zablokowa� zg�aszanie post�w, lub wy��czy� powiadamianie o zg�oszonych postach dla wybranych u�ytkownik�w';
$lang['Report_no_auth'] = 'Zablokuj mo�liwo�� zg�aszania post�w wybranym u�ytkownikom';
$lang['Report_disable'] = 'Wy��cz powiadamianie o zg�aszanych postach dla wybranych u�ytkownik�w';
$lang['Back'] = 'Cofnij';
$lang['Remove'] = 'Usu�';
$lang['Report_post_disable'] = 'Zg�aszanie post�w wy��czone';
$lang['Prune_users'] = 'Masowe kasowanie u�ytkownik�w'; 
$lang['Ecat'] = 'Kategoria: Edytuj';
$lang['Dcat'] = 'Kategoria: Usu�';
$lang['Rcat'] = 'Kategoria: Przemianuj';
$lang['Efile'] = 'Pliki: Edytuj';
$lang['Dfile'] = 'Pliki: Usu�';
$lang['Efield'] = 'Dodatki: Edytuj';
$lang['Dfield'] = 'Dodatki: Usu�';
$lang['wrong_config_parametr'] = $lang['Server_name'] . ' nie mo�e zawiera� <b>%s</b> !';
$lang['Forum_link'] = 'Link zewn�trzny';
$lang['User_allow_helped'] = 'Mo�e u�ywa� punkt�w "Pom�g�"';
$lang['User_allow_helped_e'] = 'W��cza lub wy��cza zar�wno u�ywanie przycisku "Pom�g�" jak i ukrywa ilo�� punkt�w "Pom�g�" uzyskanych przez tego u�ytkownika';
$lang['Admin_notepad'] = 'Notatnik Administrator�w';
$lang['confirm_deluser'] = 'Czy jeste� pew' .  (($he) ? 'ien' : 'na') . ' �e chcesz usun�� tego u�ytkownika ?';
$lang['Forum_moderate'] = 'Forum moderowane';
$lang['Forum_moderate_e'] = 'Tematy i posty b�d� oczekiwa�y na akceptacj� przez Moderatora lub Administratora';
$lang['Tree_req'] = 'Tematy tylko w formie drzewa';
$lang['Tree_req_grade'] = 'Po ilu stopniach drzewa zmniejszenie odleg�o�ci stopni drzewa<br />0 - Wy��cza ca�kowicie drzewa w forum';
$lang['Prune_explain'] = 'Nie zostan� usuni�te tematy zawieraj�ce sondy lub b�d�ce og�oszeniami lub tematami przyklejonymi.';
$lang['No_count'] = 'Niezliczanie post�w';
$lang['Forums_shadow'] = 'Fora nieskojarzone z �adn� kategori�';
$lang['Wrong_category'] = 'Nie mo�esz przypisa� forum samego do siebie.';
$lang['All_forums'] = 'Wszystkie fora i kategorie';
$lang['log_file_limit_info'] = 'Plik log�w <b>/admin/admin_logs.'.$phpEx.'</b> jest zbyt du�y (%sMb) aby go otworzy� w oknie przegl�darki.<br /><br />Plik zosta� skompresowany i znajduje si� w: <b>%s</b><br /><br />Kliknij %sTutaj%s aby go pobra�.<br /><br />Po �ci�gni�ciu KONIECZNIE usu� go z katalogu /files/ mo�esz te� wyczy�ci� stary plik /admin/admin_logs.'.$phpEx;
$lang['log_file_limit_error1'] = 'B��d odczytu pliku: <b>%s</b>';
$lang['log_file_limit_error2'] = 'B��d zapisu skompresowanego pliku: <b>%s</b>';

$lang['Confirm_delete_all'] = 'Czy na pewno chcesz usun�� wszystkie: <b>%s</b> ?';
$lang['Split'] = '��czenie';
$lang['Expire'] = 'Wygasanie';
$lang['Warning_delete'] = 'Usuni�cie ostrze�enia';
$lang['Warning_edit'] = 'Edycja ostrze�enia';
$lang['Object'] = 'Obiekt';
$lang['Group_mail_enable'] = 'Moderator grupy mo�e wysy�a� masow� korespondencj� do cz�onk�w grupy ?';
$lang['Forum_trash'] = 'Forum jako �mietnik';
$lang['Forum_trash_e'] = 'Gdy ustawisz forum jako �mietnik, podczas kasowania temat�w pojawi si� dodatkowy przycisk s�u��cy przenoszeniu tematu do �mietnika';
$lang['Resync_page_posts'] = 'Synchronizacja u�ytkownik�w';
$lang['No_themes'] = 'Brak Szablon�w w bazie danych';
$lang['Group_prefix'] = 'Prefix, pojawi si� przed nazw� u�ytkownik�w';
$lang['Group_no_unsub'] = 'Zakaz opuszczania';
$lang['Groups_color_explain'] = 'Mo�esz wyr�ni� grupy, ustawiaj�c im kolor prefix oraz styl. Je�eli w edycji danych stylu, usuniesz kolor dla Admina, Moda lub Junior Admina nie b�d� oni oznaczani kolorem i b�dziesz ' .  (($he) ? 'm�g�' : 'mog�a') . ' ich przypisa� do wyr�nionej grupy, zniknie te� opis kolor�w m.in. na stronie g��wnej.<br />Wiele styl�w oddziel �rednikiem, przyk�ady: <b>font-weight: bold; font-size: 16px; text-decoration: line-through; font-style: italic; filter: glow(color=#FF0000);height:10</b> i wiele innych (max. 255 znak�w)';
$lang['Group_style'] = 'Styl';
$lang['Separate_topics'] = 'Oddzielone wa�ne tematy';
$lang['Separate_total'] = 'osobne tabele';
$lang['Separate_med'] = 'belka';
$lang['Show_global_announce'] = 'Pokazuj wa�ne og�oszenia z innych dzia��w';
$lang['Advert_title'] = 'Reklama';
$lang['Show_hosts'] = 'Poka� hosty';
$lang['Forum_no_split'] = 'Nie ��cz post�w';
$lang['Forum_no_helped'] = 'Wy��cz "Pom�g�"';
$lang['topic_tags'] = 'Tagi temat�w, oddzielaj przecinkami, nie u�ywaj znak�w <b>[]</b>';
$lang['sort_methods'] = 'Zablokowane na d�';

$lang['Statistics_management'] = 'Modu�y statystyk';
$lang['Statistics_config'] = 'Konfiguracja statystyk';
$lang['Acces_menu_denied'] = 'Nie masz dost�pu do tego menu';
$lang['Check-files'] = 'Kontrola Systemu';
$lang['New_info'] = 'Prosz� czeka�, trwa pobieranie informacji o aktualizacjach ...';
$lang['forum_compress'] = 'przez skrypt';
$lang['server_compress'] = 'przez serwer';
$lang['Name'] = 'Nazwa';
$lang['Files_count'] = 'Ilo�� plik�w';
$lang['Rows_count'] = 'Ilo�� wpis�w';
$lang['Config_setup'] = 'Zapis konfiguracji';
$lang['Config_setup_e'] = 'W tym miejscu mo�esz zapisa� bie��c� konfiguracj� forum, odtworzy� zapisan� konfiguracj�, ustawi� minimaln� i maksymaln� konfiguracj�. Dotyczy to og�lnej konfiguracji forum, ostrze�e�, shoutbox\'a, za��cznik�w, oraz zg�aszania post�w. Dotyczy to tylko konfiguracji, nie dotyczy informacji kt�re s� dodawane jak np. zezwolenia, u�mieszki, cenzura s��w, zainstalowane style, banlista, pola w profilu, zabronione nazwy, grupy, fora, kategorie, rozszerzenia za��cznik�w.';
$lang['Default_config'] = 'Ustaw domy�ln� konfiguracj�';
$lang['Max_config'] = 'Ustaw maksymaln� konfiguracj�';
$lang['Min_config'] = 'Ustaw minimaln� konfiguracj�';
$lang['Save_config'] = 'Zapisz bie��c� konfiguracj�';
$lang['Saved_config'] = 'Ustaw konfiguracj� zapisan�: %s';
$lang['Permissions_List'] = 'Lista zezwole�';                  
$lang['Forum_auth_list_explain'] = 'Lista zezwole� dla wszystkich for�w. Mo�esz je edytowa� klikaj�c na button "Edycja zezwole�" na dole forum.';                                                                  
$lang['Forum_auth_list_explain_ALL'] = 'Wszyscy u�ytkownicy';                                                          
$lang['Forum_auth_list_explain_REG'] = 'Wszyscy zarejestrowani u�ytkownicy';                                               
$lang['Forum_auth_list_explain_PRIVATE'] = 'Tylko u�ytkownicy ze specjalnymi zezwoleniami';                          
$lang['Forum_auth_list_explain_MOD'] = 'Tylko moderatorzy tego forum';                                      
$lang['Forum_auth_list_explain_ADMIN'] = 'Tylko administratorzy';                                              
$lang['Forum_auth_list_explain_auth_view'] = '%s mog� ogl�da� to forum';                                       
$lang['Forum_auth_list_explain_auth_read'] = '%s mog� czyta� posty w tym forum';                              
$lang['Forum_auth_list_explain_auth_post'] = '%s mog� pisa� nowe posty w tym forum';                                    
$lang['Forum_auth_list_explain_auth_reply'] = '%s mog� opowiada� na posty w tym forum';                            
$lang['Forum_auth_list_explain_auth_edit'] = '%s mog� edytowa� posty w tym forum';                              
$lang['Forum_auth_list_explain_auth_delete'] = '%s mog� usuwa� posty w tym forum';                          
$lang['Forum_auth_list_explain_auth_sticky'] = '%s mog� ustawia� przyklejone tematy w tym forum';                    
$lang['Forum_auth_list_explain_auth_announce'] = '%s mog� pisa� og�oszenia w tym forum';                  
$lang['Forum_auth_list_explain_auth_vote'] = '%s mog� bra� udzia� w g�osowaniu w sondach w tym forum';                           
$lang['Forum_auth_list_explain_auth_pollcreate'] = '%s mog� tworzy� ankiety w tym forum';                      
$lang['Cancel'] = 'Anuluj';
$lang['Edit_permissions'] = 'Edycja zezwole�';

$lang['Forum_out_of_date'] = 'Twoje forum jest NIEAKTUALNE! <a href="http://przemo.org/phpBB2/index.php?cid=0">Pobierz</a> najnowsz� wersj�!';
$lang['Forum_up_to_date'] = 'Twoje forum jest aktualne.';
$lang['Forum_search_for_updates'] = 'Sprawd� teraz';
$lang['Forum_last_update_check'] = 'Ostatnio sprawdzano %s';
$lang['Forum_last_update_check_minutes_ago'] = '%d minut temu';
$lang['Forum_last_update_check_hours_ago'] = '%d godzin temu';
$lang['Forum_last_update_check_days_ago'] = '%d dni temu';
//
// That's all Folks!
// -------------------------------------------------

?>