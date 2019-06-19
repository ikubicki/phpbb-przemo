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
$he = true;

$lang['Groups'] = 'Grupy';
$lang['Styles'] = 'Style';
$lang['General'] = 'Ogólne';
$lang['Users'] = 'Użytkownicy';
$lang['Forums'] = 'Fora';

$lang['Configuration'] = 'Konfiguracja';
$lang['Manage'] = 'Zarządzaj';
$lang['Disallow'] = 'Zabroń nazwy';
$lang['Prune'] = 'Czyszczenie';
$lang['Mass_Email'] = 'Mas. Korespondencja';
$lang['Ranks'] = 'Rangi';
$lang['Smilies'] = 'Uśmieszki';
$lang['Ban_Management'] = 'Banlista';
$lang['Word_Censor'] = 'Cenzura Słów';
$lang['Export'] = 'Eksport';
$lang['Create_new'] = 'Utwórz';
$lang['Add_new'] = 'Dodaj';
$lang['Backup_DB'] = 'Kopia Zapasowa';
$lang['Restore_DB'] = 'Odtwarzanie';

//
// Index
//

$lang['Admin'] = 'Administracja';
$lang['Welcome_phpBB'] = 'Witamy w phpBB';
$lang['Admin_intro'] = 'Dziękujemy, że wybrał' .  (($he) ? 'e' : 'a') . 'ś phpBB by Przemo do obsługi Twojego forum. Ten ekran przedstawia krótki przegląd różnorodnych danych statystycznych, dotyczących forum. Możesz wrócić do tej strony klikając odnośnik <u>Indeks Administracji</u> na lewym panelu. Aby powrócić do strony głównej forum kliknij <u>Str. Główna Forum</u> lewym panelu. Inne odnośniki po lewej stronie ekranu dają dostęp do narzędzi kontrolujących każdy aspekt zachowania forum. Każde z nich zawiera osobne instrukcje użycia.';
$lang['Main_index'] = 'Str. Główna Forum';
$lang['Forum_stats'] = 'Statystyki Forum';
$lang['Admin_Index'] = 'Indeks Administracji';
$lang['Preview_forum'] = 'Podgląd Forum';

$lang['Click_return_admin_index'] = 'Kliknij %sTutaj%s aby powrócić do Indeksu Administracji';

$lang['Statistic'] = 'Statystyki';
$lang['Value'] = 'Wartość';
$lang['Number_posts'] = 'Liczba postów';
$lang['Posts_per_day'] = 'Postów dziennie';
$lang['Number_topics'] = 'Liczba tematów';
$lang['Topics_per_day'] = 'Tematów dziennie';
$lang['Number_users'] = 'Liczba użytkowników';
$lang['Users_per_day'] = 'Użytkowników dziennie';
$lang['Board_started'] = 'Start Forum';
$lang['Avatar_dir_size'] = 'Użycie dysku';
$lang['Database_size'] = 'Baza Danych';
$lang['Gzip_compression'] = 'Kompresja Gzip';
$lang['Not_available'] = 'Niedostępne';
$lang['f_mail'] = 'Obsługa funkcji <b>mail</b> na serwerze';
$lang['search_keywords_max'] = 'Maksymalna liczba słów, jaką użytkownik może wykorzystać, używając wyszukiwarki.';
$lang['languages_list'] = 'Dostępne języki: %s';
$lang['files_list'] = 'Dostępne pliki: %s';


//
// DB Utils
//
$lang['Database_Utilities'] = 'Narzędzia Bazy Danych';
$lang['Restore'] = 'Przywracanie';
$lang['Backup'] = 'Kopia Zapasowa';
$lang['Backup_explain'] = 'W tym miejscu możesz włączyć automatyczne tworzenie kopii zapasowej bazy danych, która będzie tworzona co 24 godziny (podczas tworzenia kopii, forum jest wyłączone)<br />Masz możliwość wyboru ile kopii zapasowych ma być przechowywane na serwerze. Będą one przetrzymywane w katalogu /db/db_backup/ katalog <b>db_backup</b> powinien mieć prawa do zapisu ( chmod 777 ).<br />W tym miejscu masz też możliwość wykonania kopii zapasowej "na żądanie" po kliknięciu na link.<br />Plik kopii zapasowej ma nazwę np. db_backup_phpbb_psmdowhx_date-30-05-2005.sql.gz znaki psmdowhx są losowe a więc nie ma możliwości aby plik dostał sie w niepowołane ręce. Katalogu /db_backup/ nie można "wylistować" gdyż znajduje się tam plik index.html.<br />Masz możliwość ustawienia aby kopia nie obejmowała danych z tabel: search i read_history. Tabele search można odbudować narzędziem do odbudowywania search w panelu admina. Tabele search i read_history zajmują najwięcej miejsca w bazie danych, tabeli read_history nie można przywrócić tak jak tabel search.<br />Na celeronie 1,4 256 ram baza danych o wielkości 80MB jest kopiowana w około 40 sekund, bez tabel search i read_history, rozpakowany plik zajmuje 42MB. Przy dłuższym czasie tworzenia kopii mogą wystąpić nieprzewidziane problemy.<br />Jeżeli masz dostęp do Cpanel\'u lub innego narzędzia administracyjnego, sprawdź, czy nie tworzy on automatycznych kopii zapasowych bazy SQL, jeśli tworzy nie musisz włączać automatycznego tworzenia przez forum.';
$lang['db_backup_enable'] = 'Włącz automatyczne tworzenie kopii';
$lang['db_backup_copies'] = 'Ilość przetrzymywanych kopii';
$lang['db_backup_tables_search'] = 'Kopiuj zawartość tabel search';
$lang['db_backup_tables_rh'] = 'Kopiuj zawartość tabeli read_history';
$lang['db_backup_link'] = 'Wykonaj kopię teraz';
$lang['db_backup_done'] = 'Kopia została wykonana.';
$lang['db_backup_last'] = 'Ostatnia kopia: ';

//
// Auth pages
//
$lang['Select_a_User'] = 'Wybierz Użytkownika';
$lang['Select_a_Group'] = 'Wybierz Grupę';
$lang['Select_a_Forum'] = 'Wybierz Forum';
$lang['Auth_Control_User'] = 'Kontrola Zezwoleń Użytkowników';
$lang['Auth_Control_Group'] = 'Kontrola Zezwoleń Grup';
$lang['Auth_Control_Forum'] = 'Kontrola Zezwoleń Forów';
$lang['Look_up_User'] = 'Wybierz Użytkownika';
$lang['Look_up_Group'] = 'Wybierz Grupy';
$lang['Look_up_Forum'] = 'Wybierz Forum';

$lang['Group_auth_explain'] = 'Tutaj możesz zmieniać zezwolenia i status moderatora przydzielony każdej grupie użytkowników. Nie zapomnij zmieniając ustawienia, że indywidualne uprawnienia mogą nadal zezwalać użytkownikowi na dostęp do forów itp.';
$lang['User_auth_explain'] = 'Tutaj możesz zmieniać zezwolenia i status moderatora dla każdego użytkownika. Nie zapomnij zmieniając ustawienia, że uprawnienia grupowe mogą nadal zezwalać użytkownikowi na dostęp do forów itp.';
$lang['Forum_auth_explain'] = 'Tutaj możesz zmienić poziomy autoryzacji dla każdego forum. Masz do dyspozycji metodę prostą i zaawansowaną, z których druga oferuje większe możliwości kontroli ustawień. Pamiętaj, że zmiana ustawień dotyczących forów zadecyduje o tym, co użytkownicy będą mogli na nich robić.';

$lang['Simple_mode'] = 'Tryb Prosty';
$lang['Advanced_mode'] = 'Tryb Zaawansowany';
$lang['Moderator_status'] = 'Status Moderatora';

$lang['Allowed_Access'] = 'Dostęp Zezwolony';
$lang['Disallowed_Access'] = 'Dostęp Zabroniony';
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
$lang['Announce'] = 'Ogłoszenia';
$lang['Vote'] = 'Głosowanie';
$lang['Pollcreate'] = 'Tworzenie ankiet';

$lang['Simple_Permission'] = 'Proste Zezwolenia';

$lang['User_Level'] = 'Poziom użytkownika';
$lang['Auth_Admin'] = 'Administrator';
$lang['Group_memberships'] = 'Członkostwo w grupach (Wszystkich: %d )';
$lang['Usergroup_members'] = 'Tak grupa ma następujących członków (Wszystkich: %d )';

$lang['Forum_auth_updated'] = 'Zezwolenia Forów zostały zaktualizowane';
$lang['Auth_updated'] = 'Zezwolenia zostały zmienione';
$lang['Click_return_userauth'] = 'Kliknij %sTutaj%s aby powrócić do Zezwoleń Użytkowników';
$lang['Click_return_groupauth'] = 'Kliknij %sTutaj%s aby powrócić do Zezwoleń Grup';
$lang['Click_return_forumauth'] = 'Kliknij %sTutaj%s aby powrócić do Zezwoleń Forów';


//
// Banning
//
$lang['Ban_explain'] = 'Tutaj możesz kontrolować banlistę użytkowników. Uzyskasz to przez banowanie danego użytkownika, zakresu numerów IP lub hostów. Dzięki tym metodom użytkownik nie dostanie się nawet na stronę główną. Aby zapobiec rejestracji pod innymi nazwami możesz także zbanować konkretny adres e-mail.';
$lang['Select_username'] = 'Wybierz Nazwę Użytkownika';
$lang['Ban_IP'] = 'Zbanuj jeden lub więcej adresów IP lub hostów';
$lang['IP_hostname'] = 'Adresy IP lub hosty';
$lang['Ban_IP_explain'] = 'Aby podać kilka adresów IP lub hostów oddziel je przecinkami. Kiedy podajesz adres IP znak <b>*</b> zastępuje dowolny ciąg cyfr. Aby określić zakres tylko kilku adresów IP oddziel początkowy i końcowy myślnikiem (-) Nie stosuj bardzo dużych zakresów IP, na przykład zakres 20-80 doda do bazy aż 60 wpisów. Jeżeli podajesz host, możesz użyć znaku <b>*</b> który zastąpi dowolny ciąg znaków, oraz znaku <b>?</b> który zastępuje dowolny jeden znak - przykłady: IP: <b>80.53.12.*</b> lub host: <b>*.neoplus.adsl.tpnet.pl</b> lub host: <b>host2?.firma.pl</b>';

$lang['Ban_email'] = 'Zbanuj jeden lub więcej adresów e-mail';
$lang['Ban_email_explain'] = 'Aby podać więcej niż jeden adres e-mail, oddziel je przecinkami. Znakiem zamiennym jest *, np. *@hotmail.com.';

$lang['Ban_update_sucessful'] = 'Banlista została zaktualizowana';
$lang['Click_return_banadmin'] = 'Kliknij %sTutaj%s aby powrócić do Kontroli banlisty';


//
// Configuration
//
$lang['General_Config'] = 'Ustawienia Główne';
$lang['Click_return_config'] = 'Kliknij %sTutaj%s aby powrócić do Ustawień Głównych';

$lang['Server_name'] = 'Nazwa Domeny';
$lang['Script_path'] = 'Ścieżka skryptu';
$lang['Server_port'] = 'Port Serwera';
$lang['Acct_activation'] = 'Włącz aktywację kont';
$lang['Acc_Admin'] = 'Admin';

$lang['Allow_BBCode'] = 'Zezwól na BBCode';
$lang['Allow_smilies'] = 'Zezwól na Uśmieszki';
$lang['Admin_email'] = 'Adres E-mail Administratora';

//
// Forum Management
//

$lang['Forum_admin'] = 'Administracja Forum';
$lang['Forum_admin_explain'] = 'W tym miejscu możesz dodawać, usuwać, modyfikować, zmieniać kolejność i ponownie synchronizować kategorie i fora.<br />Pamiętaj że aby utworzyć drzewo, czyli "forum w forum" musisz najpierw utworzyć kategorię w jakimś istniejącym forum i dopiero później w tej kategorii utworzyć forum.<br />Możesz również przesuwać istniejące fora do kategorii utworzonej w wybranym forum.';
$lang['Edit_forum'] = 'Edytuj forum';
$lang['Create_forum'] = 'Nowe Forum';
$lang['Create_category'] = 'Nowa Kategoria';
$lang['Config_updated'] = 'Konfiguracja Forum Została Zaktualizowana';
$lang['Move_up'] = 'W górę';
$lang['Move_down'] = 'W dół';
$lang['Resync'] = 'Synch.';
$lang['No_mode'] = 'Nie określono trybu';
$lang['Forum_edit_delete_explain'] = 'Poniższy formularz pozwoli zmienić wszystkie podstawowe opcje forum. Aby zmienić szczegółowe ustawienia Użytkowników i Forów skorzystaj z odnośników po lewej.';

$lang['Move_contents'] = 'Przenieś całą zawartość';
$lang['Forum_delete'] = 'Usuń Forum';
$lang['Forum_delete_explain'] = 'Poniższy formularz pozwoli na usunięcie forum (lub działów) i zdecydowanie co zrobić z tematami (lub forami), które były w nim zawarte.';

$lang['Forum_settings'] = 'Generalne Ustawienia Forum';
$lang['Forum_name'] = 'Nazwa Forum';
$lang['Forum_desc'] = 'Opis';
$lang['Forum_status'] = 'Status Forum';
$lang['Forum_pruning'] = 'Automatyczne Czyszczenie';

$lang['prune_freq'] = 'Sprawdź wiek tematu co';
$lang['prune_days'] = 'Usuń tematy, w których nie pisano nic przez';
$lang['Set_prune_data'] = 'Włączył' .  (($he) ? 'e' : 'a') . 'ś automatyczne czyszczenie dla tego forum ale nie określił' .  (($he) ? 'e' : 'a') . 'ś jego parametrów. Wróć i wpisz wszystkie dane.';

$lang['Move_and_Delete'] = 'Przenieś i Usuń';

$lang['Delete_all_posts'] = 'Usuń wszystkie posty';
$lang['Edit_Category'] = 'Edytuj Kategorię';
$lang['Edit_Category_explain'] = 'Użyj tego formularza do zmiany nazwy kategorii.';

$lang['Forums_updated'] = 'Dane dotyczące Forów i Kategorii zostały zaktualizowane';

$lang['Must_delete_forums'] = 'Musisz usunąć wszystkie fora przed usunięciem tej kategorii';

$lang['Click_return_forumadmin'] = 'Kliknij %sTutaj%s aby powrócić do Administracji Forum';


//
// Smiley Management
//
$lang['smiley_title'] = 'Edycja Uśmieszków';
$lang['smile_desc'] = 'Na tej stronie możesz dodawać, usuwać i zmieniać ikony emocji lub uśmieszki, które użytkownicy mogą używać w swoich postach i prywatnych wiadomościach.';

$lang['smiley_config'] = 'Dodaj Uśmieszki';
$lang['smiley_code'] = 'Kod Uśmieszku';
$lang['smiley_url'] = 'Plik Obrazka Uśmieszku';
$lang['smile_add'] = 'Nowy Uśmieszek';
$lang['Smile'] = 'Uśmiech';

$lang['Select_pak'] = 'Wybierz Plik Paczki (.pak)';
$lang['replace_existing'] = 'Zamień Istniejący Uśmiech';
$lang['keep_existing'] = 'Zachowaj Istniejący Uśmiech';
$lang['smiley_import_inst'] = 'Powin' .  (($he) ? 'ieneś' : 'naś') . ' rozpakować paczkę uśmieszków i wysłać pliki do odpowiedniego katalogu Uśmieszków. Potem ustaw odpowiednio poniższy formularz i importuj paczkę.';
$lang['smiley_import'] = 'Import Paczki Uśmieszków';
$lang['choose_smile_pak'] = 'Wybierz Plik .pak Paczki Uśmieszków';
$lang['import'] = 'Importuj Uśmieszki';
$lang['smile_conflicts'] = 'Co zrobić w przypadku konfliktów';
$lang['del_existing_smileys'] = 'Usuń istniejące uśmieszki przed importem';
$lang['import_smile_pack'] = 'Importuj Paczkę';
$lang['export_smile_pack'] = 'Utwórz Paczkę';
$lang['export_smiles'] = 'Aby utworzyć paczkę uśmieszków z obecnie zainstalowanych kliknij %sTutaj%s aby ściągnąć plik .pak uśmieszków. Nazwij go odpowiednio zachowując rozszerzenie .pak. Potem spakuj ten plik razem z obrazkami uśmieszków w archiwum zip.';

$lang['smiley_add_success'] = 'Uśmieszek został dodany';
$lang['smiley_edit_success'] = 'Uśmieszek został zaktualizowany';
$lang['smiley_import_success'] = 'Paczka Uśmieszków została zaimportowana!';
$lang['smiley_del_success'] = 'Uśmieszek został usunięty';
$lang['Click_return_smileadmin'] = 'Kliknij %sTutaj%s aby powrócić do Administracji Uśmieszkami';


//
// User Management
//
$lang['User_admin'] = 'Administracja Użytkownikami';
$lang['User_admin_explain'] = 'Tutaj możesz zmienić informacje o użytkowniku i ustawione przez niego opcje. Aby zmienić jego prawa dostępu skorzystaj z systemu zmiany zezwoleń.';

$lang['Look_up_user'] = 'Pokaż użytkownika';

$lang['Admin_user_fail'] = 'Nie można było zaktualizować profilu użytkownika.';
$lang['Admin_user_updated'] = 'Profil użytkownika został zaktualizowany.';
$lang['Click_return_useradmin'] = 'Kliknij %sTutaj%s aby powrócić do Administracji Użytkownikami';

$lang['User_delete'] = 'Usuń tego użytkownika';
$lang['User_delete_explain'] = 'Zaznacz aby usunąć użytkownika, nie można tego cofnąć !';
$lang['User_deleted'] = 'Użytkownik został usunięty.';

$lang['User_status'] = 'Użytkownik jest aktywny';
$lang['User_allowpm'] = 'Może wysyłać Prywatne Wiadomości';
$lang['User_allowavatar'] = 'Może pokazywać Avatar';

$lang['Admin_avatar_explain'] = 'Tutaj możesz zobaczyć i usunąć obecny Avatar użytkownika.';

$lang['User_special'] = 'Specjalne pola administratora';
$lang['User_special_explain'] = 'Tych pól nie mogą zmieniać sami użytkownicy. Możesz tutaj zmodyfikować ich status i inne opcje dotyczące ich możliwości działania.';


//
// Group Management
//
$lang['Group_administration'] = 'Administracja Grupami';
$lang['Group_admin_explain'] = 'Z tego panelu możesz administrować wszystkimi grupami użytkowników; możesz je usuwać, tworzyć i zmieniać ustawienia. Możesz wybierać moderatorów, zmieniać na otwarte lub zamknięte i modyfikować nazwę oraz opis.';
$lang['Updated_group'] = 'Grupa została zaktualizowana';
$lang['Added_new_group'] = 'Nowa grupa została utworzona';
$lang['Deleted_group'] = 'Grupa została usunięta';
$lang['New_group'] = 'Utwórz nową grupę';
$lang['Edit_group'] = 'Edytuj grupę';
$lang['group_name'] = 'Nazwa Grupy';
$lang['group_description'] = 'Opis Grupy';
$lang['group_moderator'] = 'Moderator Grupy';
$lang['group_status'] = 'Status Grupy';
$lang['group_open'] = 'Otwarta';
$lang['group_closed'] = 'Zamknięta';
$lang['group_hidden'] = 'Ukryta';
$lang['group_delete'] = 'Usuń Grupę';
$lang['group_delete_check'] = 'Usuń tę grupę';
$lang['No_group_name'] = 'Musisz wpisać nazwę dla tej grupy';
$lang['No_group_moderator'] = 'Musisz podać moderatora tej grupy';
$lang['delete_group_moderator'] = 'Usunąć poprzedniego moderatora grupy?';
$lang['delete_moderator_explain'] = 'Jeżeli zmieniasz moderatora zaznacz to pole aby usunąć starego moderatora. Jeżeli tego nie zrobisz stanie się on zwykłym członkiem grupy.';
$lang['Click_return_groupsadmin'] = 'Kliknij %sTutaj%s aby powrócić do Administracji Grupami.';
$lang['Select_group'] = 'Wybierz grupę';
$lang['Look_up_group'] = 'Pokaż grupę';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'Czyszczenie Forum';
$lang['Forum_Prune_explain'] = 'Usunięte zostaną tematy, w których nie napisano nic nowego przez określoną liczbę dni. Jeżeli nie wpiszesz żadnej liczby usunięte zostaną wszystkie tematy. Nietknięte pozostaną tematy z aktywnymi ankietami oraz ogłoszenia. Będziesz musiał usunąć je ręcznie.';
$lang['Do_Prune'] = 'Wykonaj';
$lang['Prune_topics_not_posted'] = 'Wyczyść tematy bez nowych odpowiedzi przez dni';
$lang['Topics_pruned'] = 'Usunięto tematów';
$lang['Prune_success'] = 'Czyszczenie zostało wykonane';


//
// Word censor
//
$lang['Words_title'] = 'Cenzura Słów';
$lang['Words_explain'] = 'Z tego miejsca możesz dodawać, zmieniać i usuwać słowa, które zostaną automatycznie ocenzurowane na Twoim forach. Dodatkowo ludzie nie będą mogli się rejestrować z nazwami zawierającymi te słowa. Znaki uniwersalne (*) są dozwolone, np. *test* obejmie przetestowanie, test* obejmie testowanie, *test obejmie przedtest.';
$lang['Word'] = 'Słowo';
$lang['Edit_word_censor'] = 'Zmień Cenzurę';
$lang['Replacement'] = 'Zamiennik';
$lang['Add_new_word'] = 'Dodaj nowe słowo';

$lang['Must_enter_word'] = 'Musisz wpisać słowo i jego zamiennik';
$lang['No_word_selected'] = 'Nie wybrano słowa do edycji';

$lang['Word_updated'] = 'Wybrana cenzura została zaktualizowana';
$lang['Word_added'] = 'Nowa cenzura została dodana';
$lang['Word_removed'] = 'Wybrana cenzura została usunięta';

$lang['Click_return_wordadmin'] = 'Kliknij %sTutaj%s aby powrócić do Administracji Cenzurą';

//
// Ranks admin
//

$lang['Ranks_title'] = 'Administracja Rangami';
$lang['Ranks_explain'] = 'Używając tego formularza możesz dodawać, zmieniać, przeglądać i usuwać rangi. Możesz też tworzyć specjalne rangi i przydzielać je poprzez system zarządzania użytkowników.';

$lang['Add_new_rank'] = 'Dodaj nową rangę';

$lang['Rank_title'] = 'Nazwa Rangi';
$lang['Rank_title_e'] = 'Jeśli chcesz użyć obrazka rangi w którym jest już nazwa rangi i chcesz żeby nie powtarzała się ona w nazwie rangi to przed nazwą rangi daj: <b>-#</b> wówczas nie będzie ona wyświetlana';
$lang['Rank_special'] = 'Jest Rangą personalną';
$lang['Rank_minimum'] = 'Minimum Postów';
$lang['Rank_image'] = 'Obraz Rangi';
$lang['Rank_image_explain'] = 'Możesz tutaj określić obrazek związany z daną rangą<br />Obrazki rang powinny się znajdować we wszystkich katalogach stylów w: /templates/Nazwa_stylu/images/ranks/';

$lang['Must_select_rank'] = 'Musisz wybrać rangę';
$lang['No_assigned_rank'] = 'Nie określono rang specjalnych';

$lang['Rank_updated'] = 'Ranga została zaktualizowana';
$lang['Rank_added'] = 'Ranga została dodana';
$lang['Rank_removed'] = 'Ranga została usunięta';
$lang['No_update_ranks'] = 'Ranga została usunięta, jednakże konta użytkowników, którym została przydzielona nie zostały zmienione. Będziesz musiał ręcznie usunąć rangę z tych kont';

$lang['Click_return_rankadmin'] = 'Kliknij %sTutaj%s aby powrócić do Administracji Rangami';


//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'Kontrola Zabronionych Nazw';
$lang['Disallow_explain'] = 'Tutaj możesz kontrolować nazwy użytkowników, których nie wolno używać. Zabronione nazwy mogą zawierać znak zamienny *. Pamiętaj, że nie możesz zabronić nazwy, która już została zarejestrowana. Najpierw usuń tego użytkownika a potem dopisz tutaj nazwę.';

$lang['Delete_disallow_title'] = 'Usuń Zabronioną Nazwę';
$lang['Delete_disallow_explain'] = 'Możesz usunąć zabronioną nazwę wybierając ją z tej listy i klikając Wyślij.';

$lang['Add_disallow_title'] = 'Dodaj Zabronioną Nazwę';
$lang['Add_disallow_explain'] = 'Możesz zabronić korzystania z jakiejś nazwy wykorzystując znak * równoważny dowolnemu ciągowi znaków';
$lang['Disallowed_deleted'] = 'Zabroniona nazwa została usunięta';
$lang['Disallow_successful'] = 'Zabroniona nazwa została dodana';
$lang['Disallowed_already'] = 'Nazwa, którą wpisał' .  (($he) ? 'e' : 'a') . 'ś, nie może być zakazana. Albo jest już na liście albo istnieje już taki użytkownik.';

$lang['Click_return_disallowadmin'] = 'Kliknij %sTutaj%s aby powrócić do Administracji Zabronionymi Nazwami';


//
// Styles Admin
//
$lang['Styles_admin'] = 'Administracja Stylami';
$lang['Styles_explain'] = 'Korzystając z tego narzędzia możesz dodawać, usuwać i zarządzać stylami (oraz szablonami) dostępnymi dla użytkowników';
$lang['Styles_addnew_explain'] = 'Poniższa lista zawiera wszystkie style, które są dostępne dla posiadanych przez ciebie szablonów. Elementy na tej liście nie zostały jeszcze zainstalowane w bazie danych phpBB. Aby zainstalować styl po prostu kliknij odnośnik Instaluj obok wpisu';

$lang['Select_template'] = 'Wybierz Szablon';

$lang['Style'] = 'Styl';
$lang['Template'] = 'Szablon';
$lang['Install'] = 'Instaluj';
$lang['Download'] = 'Ściągnij';

$lang['Edit_theme'] = 'Edytuj Styl';
$lang['Edit_theme_explain'] = 'W formularzu poniżej możesz zmienić ustawienia dla wybranego stylu';

$lang['Create_theme'] = 'Utwórz Styl';
$lang['Create_theme_explain'] = 'Użyj formularza poniżej aby utworzyć nowy styl dla wybranego szablonu. Wpisując kolory (do których możesz używać jedynie wartości szesnastkowych) nie dodawaj początkowego #, np. CCCCCC jest poprawne ale #CCCCCC już nie.';

$lang['Export_themes'] = 'Eksportuj Styl';
$lang['Export_explain'] = 'Z tego panelu możesz eksportować dane stylu dla wybranego szablonu. Wybierz styl z poniższej listy, a skrypt utworzy plik jego konfiguracji i spróbuje zapisać go w wybranym katalogu stylów. Jeżeli nie będzie możliwe zapisanie pliku otrzymasz możliwość ściągnięcia go. Aby plik został zapisany serwer musi mieć uprawnienia zapisu w danym katalogu. Więcej informacji znajdziesz w podręczniku phpBB 2.';

$lang['Theme_installed'] = 'Wybrany styl został zainstalowany';
$lang['Style_removed'] = 'Wybrany styl został usunięty z bazy danych. Aby całkowicie usunąć styl z systemu musisz usunąć go ręcznie z katalogu szablonów.';
$lang['Theme_info_saved'] = 'Informacje o stylu dla wybranego szablonu zostały zapisane. Powin' .  (($he) ? 'ieneś' : 'naś') . ' teraz przywrócić uprawnienia dostępu pliku theme_info.cfg (i jeśli to potrzebne także dla katalogu szablonów) na \'tylko do odczytu\'.';
$lang['Theme_updated'] = 'Wybrany styl został zaktualizowany. Powin' .  (($he) ? 'ieneś' : 'naś') . ' wyeksportować nowe ustawienia.';
$lang['Theme_created'] = 'Styl utworzony. Powin' .  (($he) ? 'ieneś' : 'naś') . ' teraz wyeksportować go do pliku konfiguracyjnego aby go zabezpieczyć lub użyć gdzie indziej.';

$lang['Confirm_delete_style'] = 'Czy na pewno chcesz usunąć ten styl';

$lang['Download_theme_cfg'] = 'Eksporter nie mógł zapisać pliku z informacjami o stylu. Kliknij przycisk poniżej aby ściągnąć ten plik przez przeglądarkę. Kiedy już go ściągniesz wyślij go ręcznie do katalogu z plikami szablonu. Możesz wtedy spakować pliki dla dystrybucji lub użycia gdzie indziej.';
$lang['No_themes'] = 'Wybrany szablon nie ma żadnych dołączonych stylów. Aby utworzyć nowy styl kliknij odnośnik Utwórz Nowy na lewym panelu.';
$lang['No_template_dir'] = 'Otwarcie katalogu szablonów było niemożliwe. Być może nie istnieje lub serwer nie ma do niego praw dostępu.';
$lang['Cannot_remove_style'] = 'Nie możesz usunąć wybranego stylu, ponieważ jest obecnie domyślnym dla forum. Zmień ustawienia domyślne i spróbuj ponownie.';
$lang['Style_exists'] = 'Nazwa stylu, którą wybrał' .  (($he) ? 'e' : 'a') . 'ś już istnieje, wróć i spróbuj z inną nazwą.';

$lang['Click_return_styleadmin'] = 'Kliknij %sTutaj%s aby powrócić do Administracji Stylami';

$lang['Theme_settings'] = 'Ustawienia Tematu';
$lang['Theme_element'] = 'Element Tematu';
$lang['Simple_name'] = 'Prosta Nazwa';
$lang['Save_Settings'] = 'Zapisz Ustawienia';

$lang['Stylesheet'] = 'Arkusz CSS';
$lang['Background_image'] = 'Obrazek Tła';
$lang['Background_color'] = 'Kolor Tła';
$lang['Theme_name'] = 'Nazwa Tematu';
$lang['Link_color'] = 'Kolor Odnośnika';
$lang['Text_color'] = 'Kolor Tekstu';
$lang['VLink_color'] = 'Kolor Odwiedzonego Odnośnika';
$lang['ALink_color'] = 'Kolor Aktywnego Odnośnika';
$lang['HLink_color'] = 'Kolor Odnośnika pod Kursorem';
$lang['Tr_color1'] = 'Kolor Rzędu Tabeli 1';
$lang['Tr_color2'] = 'Kolor Rzędu Tabeli 2';
$lang['Tr_color3'] = 'Kolor Rzędu Tabeli 3';
$lang['Tr_class1'] = 'Klasa Rzędu Tabeli 1';
$lang['Tr_class2'] = 'Klasa Rzędu Tabeli 2';
$lang['Tr_class3'] = 'Klasa Rzędu Tabeli 3';
$lang['Th_color1'] = 'Kolor Nagłówka Tabeli 1';
$lang['Th_color2'] = 'Kolor Nagłówka Tabeli 2';
$lang['Th_color3'] = 'Kolor Nagłówka Tabeli 3';
$lang['Th_class1'] = 'Klasa Nagłówka Tabeli 1';
$lang['Th_class2'] = 'Klasa Nagłówka Tabeli 2';
$lang['Th_class3'] = 'Klasa Nagłówka Tabeli 3';
$lang['Td_color1'] = 'Kolor Komórki Tabeli 1';
$lang['Td_color2'] = 'Kolor Komórki Tabeli 2';
$lang['Td_color3'] = 'Kolor Komórki Tabeli 3';
$lang['Td_class1'] = 'Klasa Komórki Tabeli 1';
$lang['Td_class2'] = 'Klasa Komórki Tabeli 2';
$lang['Td_class3'] = 'Klasa Komórki Tabeli 3';
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

$lang['Default_lang'] = 'Domyślny Język Forum';
$lang['ftp_info'] = 'Wpisz informację o twoim FTP';
$lang['ftp_username'] = 'Użytkownik FTP';
$lang['Install'] = 'Instalacja';

//
// Modified addons
//

$lang['Poll Admin'] = 'Sondy';
$lang['Poll Results'] = 'Wyniki glosowań';
$lang['Prune_User_Posts'] = 'Masowe kasowanie postów użytkowników';
$lang['logs'] = 'Logi połączeń';
$lang['Categories'] = 'Kategorie';
$lang['Clear_Cache'] = 'Wyczyść Cache';

$lang['Status_locked'] = 'Zablokowane';
$lang['Status_unlocked'] = 'Odblokowane';
$lang['Sort_alpha'] = 'Tytułu tematu';
$lang['Sort_fpdate'] = 'Czasu ostatniego postu';
$lang['Sort_ttime'] = 'Czasu napisania tematu';
$lang['Sort_author'] = 'Autora tematu';
$lang['User_allowsig'] = 'Może dodawać podpis';
$lang['No_group_action'] = 'Nie wybrano czynności';
$lang['Download2'] = 'Download';

$lang['Active'] = 'Aktywny';
$lang['modules'] = 'Rozmieszczenie modułów';
$lang['clock'] = 'Zegar';
$lang['l_search_a'] = 'Wyrównanie Menu Szukaj';
$lang['Deactivate'] = 'Wyłącz';
$lang['none'] = 'wyłącz';
$lang['Logs'] = 'Logi';
$lang['LogsActions'] = 'Logi czynności';
$lang['Log_action_title'] = 'Logi administracyjne';
$lang['Log_action_explain'] = 'Poniżej znajdują się logi czynności wykonywanych przez administratorów i moderatorów';
$lang['Choose_sort_method'] = 'Wybierz metodę sortowania';
$lang['Id_log'] = 'Log Id';
$lang['Delete_log'] = 'Skasuj Log';
$lang['Action'] = 'Czynność';
$lang['Done_by'] = 'Wykonane przez';
$lang['User_ip'] = 'IP użytkownika';
$lang['Log_delete'] = 'Log skasowany.';
$lang['Click_return_admin_log'] = 'Kliknij %sTutaj%s żeby przejść do logów';
$lang['OverallPermissions'] = 'Zezwolenia ogólne';
$lang['OverallPermissions_all'] = 'Ustaw poniższe zezwolenia dla wszystkich forów';
$lang['l_logsip_e'] = 'Logi domyślnie wyłączone, możesz je włączyć w menu Konfiguracja. Do poprawnej pracy logowania plik /admin/admin_logs.php musi mieć prawa do zapisu: chmod 777 admin_logs.php<br />Jeżeli chcesz wyczyścić logi, usuń zawartość danych w pliku /admin/admin_logs.php';
$lang['l_logsip'] = 'Logi połączeń';
$lang['Files'] = 'Pliki';
$lang['Globalannounce'] = 'Ważne ogłoszenie';
$lang['Group_rank'] = 'Rangi dla grup';
$lang['Group_rank_explain'] = 'Tutaj możesz wybrać rangi dla całych grup. Będzie ignorowane jeśli ustawisz rangę specjalną.';
$lang['Group_Rank_special'] = 'Personalna- / Ranga grupy';
$lang['Group_rank_order'] = 'Pierwszeństwo Grup';
$lang['Group_rank_order_moved'] = 'Grupa przeniesiona.';
$lang['Group_rank_order_alreay_moved'] = 'Grupa już jest przeniesiona.';
$lang['Group_rank_order_could_not_moved'] = 'Grupa nie może być przeniesiona ponieważ już jest na górze lub na dole.';
$lang['Group_rank_resynced'] = 'Grupowanie zsynchronizowane';
$lang['Group_rank_order_explain'] = 'Jeśli użytkownik jest w więcej niż jednej grupie, będzie pokazywana ta ranga która jest wyżej na liście.';

$lang['Inactive_title'] = 'Nieaktywni użytkownicy';
$lang['Deleted_user'] = 'Użytkownik z ID #%d usunięty';
$lang['Activate_title'] = 'Czynność konta użytkownika';
$lang['Activate'] = 'Aktywuj';
$lang['Waiting_1'] = '(Oczekuje na aktywację %d dzień)';
$lang['Waiting_2'] = '(Oczekuje na aktywację od %d dni)';
$lang['No_users'] = 'Nie ma użytkowników oczekujących na aktywację';
$lang['Total_member'] = '<b>%d</b> użytkownik oczekuje na aktywację.';
$lang['Total_members'] = '<b>%d</b> użytkowników oczekuje na aktywację.';

$lang['Account_block'] = 'Konto zablokowane';
$lang['Account_block_explain'] = 'Tutaj znajdują się informacje dot. blokady konta, prób błędnego logowania, daty, adresu.';
$lang['Block_until'] = 'Zablokowane do: %s';
$lang['Block_by'] = 'Próby logowań z IP: %s';
$lang['Last_block_by'] = 'Ostatnio z IP: %s';
$lang['Unblock_user'] = 'Odblokuj konto';
$lang['Block_user'] = 'Zablokuj konto na %s minut';
$lang['Badlogin_count'] = 'Ilość błędnych logowań';

$lang['BM_Show_bans_by'] = 'Pokaż bany na';
$lang['BM_All'] = 'Wszystkie';
$lang['BM_Show'] = 'Pokaż';
$lang['BM_Banned'] = 'Założony';
$lang['BM_Expires'] = 'Wygaśnie';
$lang['BM_By'] = 'Przez';
$lang['BM_Add_a_new_ban'] = 'Dodaj bana';
$lang['BM_Edit_ban'] = 'Edytuj bana';
$lang['BM_Delete_selected_bans'] = 'Usuń wybrane bany';
$lang['BM_Private_reason'] = 'Prywatny powód';
$lang['BM_Private_reason_explain'] = 'Ten powód będzie widoczny tylko dla administratorów';
$lang['BM_Public_reason'] = 'Publiczny powód';
$lang['BM_Public_reason_explain'] = 'Ten powód będzie wyświetlany tylko zbanowanemu użytkownikowi, jeśli będzie próbował wejść na forum';
$lang['BM_Generic_reason'] = 'Powód standardowy';
$lang['BM_Mirror_private_reason'] = 'Powód taki sam jak Prywatny Powód';
$lang['BM_Other'] = 'Inny/wpisz niżej';
$lang['BM_Expire_time'] = 'Czas wygaśnięcia';
$lang['BM_Expire_time_explain'] = 'Możesz ustalić kiedy ban ma zniknąć/wygasnąć.';
$lang['BM_Never'] = 'Nigdy';
$lang['BM_After_specified_length_of_time'] = 'Po upływie:';
$lang['BM_Minutes'] = 'Minut';
$lang['BM_Weeks'] = 'Tygodni';
$lang['BM_Months'] = 'Miesięcy';
$lang['BM_Years'] = 'Lat';

$lang['Custom_fields'] = 'Pola w profilu';
$lang['shoutbox_on'] = 'ShoutBox włączony';
$lang['date_on'] = 'Wyświetlanie daty';
$lang['sb_make_links'] = 'Włącz automatyczne tworzenie linków';
$lang['sb_links_names'] = 'Nazwa linkiem do profilu';
$lang['sb_allow_edit'] = 'Zezwól na edycje wiadomości przez Administratorów';
$lang['sb_allow_edit_m'] = 'Zezwól na edycje wiadomości przez Moderatorów';
$lang['sb_allow_edit_all'] = 'Zezwól na edycje własnych wiadomości';
$lang['sb_allow_delete'] = 'Zezwól na usuwanie wiadomości przez Administratorów';
$lang['sb_allow_delete_m'] = 'Zezwól na usuwanie wiadomości przez Moderatorów';
$lang['sb_allow_delete_all'] = 'Zezwól na usuwanie własnych wiadomości';
$lang['sb_allow_guest'] = 'Goście mogą pisać w ShoutBox\'ie ?';
$lang['sb_allow_guest_view'] = 'Shoutbox tylko widoczny dla gości, bez możliwości pisania';
$lang['sb_allow_users'] = 'Zarejestrowani użytkownicy mogą pisać w ShoutBox\'ie ?';
$lang['sb_allow_users_view'] = 'Shoutbox tylko widoczny dla zarejestrowanych użytkowników, bez możliwości pisania';
$lang['delete_days'] = 'Po ilu dniach kasować wiadomości';
$lang['sb_shout_refresh'] = 'Częstotliwość odświeżania shoutboxa.<br>Po jakim czasie shoutbox ma pobrać nowe wiadomości czekające w kolejce? Wartości w sekundach, czyli 5 = 5 sekund';
$lang['sb_shout_group'] = 'Wybierz grupy, które będą mogły pisać w shoutboxie. Przytrzymaj klawisz CTRL i myszką wybieraj grupy.';
$lang['l_usercall'] = 'Po kliknięciu w nick przenosi jego nazwę do pola pisania wiadomości. User Call.';
$lang['sb_smilies'] = 'Włącz wysuwany panel emotikon.';
$lang['sb_count_msg'] = 'Ilość wyświetlanych wiadomości';
$lang['sb_text_lenght'] = 'Maksymalna ilość znaków w wiadomości';
$lang['sb_word_lenght'] = 'Maksymalna ilość znaków w jednym wyrazie';
$lang['setup_shoutbox'] = 'Ustawienia Shoutboxa';
$lang['shout_size'] = 'Rozmiary ShoutBox\'a';
$lang['sb_banned_send'] = 'Zabroń wysyłać wiadomości użytkownikowi';
$lang['sb_banned_send_e'] = 'Wpisz ID użytkownika, któremu chcesz odebrać możliwość wysyłania wiadomości do ShoutBox\'a, możesz podać kilka, oddziel je przecinkami. Przykład: <b>18, 124</b>';
$lang['sb_banned_view'] = 'Wyłącz ShoutBox dla użytkownika';
$lang['sb_banned_view_e'] = 'Wpisz ID użytkownika, któremu chcesz odebrać możliwość używania ShoutBox\'a, możesz podać kilka, oddziel je przecinkami. Przykład: <b>18, 124</b>';

$lang['disallow_forums'] = 'Zablokuj pisanie w forach';
$lang['disallow_forums_e'] = 'Zablokuj temu użytkownikowi możliwość pisania w określonych forach.<br />Dla wyboru kilku, przytrzymaj klawisz Ctrl';
$lang['can_custom_ranks'] = 'Może ustawiać swój tytuł';
$lang['can_custom_color'] = 'Może ustawiać kolor nazwy';

$lang['group_count'] = 'Ilość wymaganych postów';
$lang['group_count_explain'] = 'Jeśli użytkownik będzie miał tyle postów lub więcej niż ta wartość zostanie automatycznie dołączony do tej grupy';
$lang['Group_count_enable'] = 'Automatyczne dodawanie użytkowników';
$lang['Group_count_update'] = 'Dodaj teraz użytkowników z podaną lub większą ilością postów';
$lang['Group_count_delete'] = 'Usuń teraz wszystkich użytkowników tej grupy';

$lang['Optimize_DB'] = 'Optymalizacja SQL';
$lang['Optimize'] = 'Optymalizuj';
$lang['Optimize_explain'] = 'Optymalizacja bazy SQL polega na czyszczeniu pustych pól w bazie';
$lang['Optimize_Table'] = 'Tabela';
$lang['Optimize_Record'] = 'Wpisów';
$lang['Optimize_Type'] = 'Typ';
$lang['Optimize_Size'] = 'Rozmiar';
$lang['Optimize_Status'] = 'Status';
$lang['Optimize_InvertChecked'] = 'Odwróć zaznaczenia';
$lang['Optimize_success'] = 'Baza pomyślnie zoptymalizowana';
$lang['Optimize_NoTableChecked'] = 'Nie wybrano żadnej tabeli';

$lang['SQL_Admin_No_Access'] = 'Nie masz dostępu do tego menu.<br /><br />Kliknij %sTutaj%s żeby zobaczyć szczegóły.';
$lang['Category_attachment'] = 'Przypisane do';
$lang['Category_desc'] = 'Opis';
$lang['Attach_forum_wrong'] = 'Nie możesz przypisać forum do forum. Tylko kategorie.';
$lang['Attach_root_wrong'] = 'Nie możesz przypisać forum do głównego forum, utwórz kategorie';
$lang['Forum_name_missing'] = 'Nie można utworzyć forum bez nazwy';
$lang['Category_name_missing'] = 'Nie można utworzyć kategorii bez nazwy';
$lang['Only_forum_for_topics'] = 'Tematy mogą być tylko w forum';
$lang['Delete_forum_with_attachment_denied'] = 'Nie możesz usunąć forum zawierającego podkategorie';
$lang['Category_delete'] = 'Usuń kategorie';
$lang['Category_delete_explain'] = 'W tym miejscu możesz usunąć kategorie i przenieść fora oraz podkategorie które zawiera.';
$lang['Forum_link_url'] = 'Forum&nbsp;jako&nbsp;link';
$lang['Forum_link_url_explain'] = 'W tym miejscu możesz podać adres lokalny lub pełny adres do zewnętrznego miejsca.<br />Pamiętaj żeby podać http://';
$lang['Forum_link_internal'] = 'Adres lokalny';
$lang['Forum_link_internal_explain'] = 'Wybierz Tak jeśli adres jest lokalny (katalog forum)';
$lang['Forum_link_hit_count'] = 'Kliknięć';
$lang['Forum_link_hit_count_explain'] = 'Wybierz Tak, jeśli chcesz aby kliknięcia były zliczane i pokazywane.';
$lang['Forum_link_with_attachment_deny'] = 'Nie możesz ustawić forum jako link, jeżeli zawiera podkategorie.';
$lang['Forum_link_with_topics_deny'] = 'Nie możesz ustawić forum jako link, jeżeli zawiera tematy.';
$lang['Forum_attached_to_link_denied'] = 'Nie możesz przypisać forum ani kategorii do forum które jest linkiem.';

$lang['mass_smilies_add'] = 'Dodaj uśmieszki z katalogu';
$lang['Click_to_back_smilies'] = 'Uśmieszków dodanych: <b>%s</b><br /><br />Kliknij %sTutaj%s żeby wrócić do zarządzania uśmieszkami';
$lang['Resync_Stats'] = 'Synchronizacja';
$lang['Rebuild_search'] = 'Odbuduj Search';
$lang['Rebuild_search_explain'] = 'Ta funkcja pozwala na odbudowanie tabel phpbb_search_* pobiera ona dane z tabeli postów i kopiuje je do search\'u. Umożliwia to całkowite odzyskanie tabel search, przydatne jest to w sytuacji gdy mamy dużą bazę danych i potrzebujemy przenieść forum na inny serwer, wówczas możemy usunąć całkowicie tabele phpbb_search_* które zajmują około 40% całej bazy, skopiować bazę danych na drugi serwer i wówczas odbudować search.<br />Odbudowywanie search\'u przy dużej ilości postów może trwać kilka godzin, jest wyposażone w automat który pozwala na kontynuowanie odbudowywania po rozłączeniu.<br />Jeżeli mamy forum na wolnym serwerze, musimy wybrać większy czas oraz mniejszy limit postów, w przypadku "zacięcia" się funkcji w jakimś miejscu musimy chwilowo zmniejszyć jeszcze bardziej limit postów (dzieje się tak wtedy gdy skrypt natrafi na obszerny post)<br /><b>Pamiętaj</b> że podczas startu skryptu tabele phpbb_search_* zostają wyczyszczone.';
$lang['Time_limit'] = 'Limit czasu';
$lang['Post_limit'] = 'Limit postów';
$lang['Finished'] = 'Zakończono';
$lang['Refresh_rate'] = 'Odświeżanie';
$lang['Percentage_complete'] = 'Postęp';
$lang['Resync_page_desc_simple'] = 'W tym miejscu możesz zsynchronizować bazę danych forów, to narzędzie ustala prawdziwą wartość dla: ilości tematów, postów, ostatnich postów, odpowiedzi, możesz wybrać poszczególne fora do synchronizacji, lub zaznaczyć wszystkie.<br />Jeżeli masz duże forum, z dużą ilością tematów i postów, użyj trybu zaawansowanego aby synchronizować fora pojedynczo.<br /><b>Przed użyciem tego narzędzia powin' .  (($he) ? 'ieneś' : 'naś') . ' zrobić kopię bazy danych.</b><br />Zalecane jest dwukrotne wykonanie synchronizacji.'; 
$lang['Resync_all_ask'] = 'Synchronizacja wszystkich forów';
$lang['Resync_options'] = 'Opcje synchronizacji';
$lang['Resync_forum_topics'] = 'Ilość tematów w forum';
$lang['Resync_forum_posts'] = 'Ilość postów w forum';
$lang['Resync_forum_last_post'] = 'Ostatni post w forum';
$lang['Resync_topic_replies'] = 'Ilość odpowiedzi w tematach';
$lang['Resync_topic_last_post'] = 'Ostatni post w tematach';
$lang['Resync_question'] = 'Wybór';
$lang['Resync_do'] = 'Uruchom synchronizację';
$lang['Resync_redirect'] = '<br /><br />Wróć do <a href="%s">Synchronizacji</a><br /><br />Wróć do <a href="%s">Panelu admina</a>.';
$lang['Resync_completed'] = 'Fora oraz tematy zostały zsynchronizowane';
$lang['Resync_no_forums'] = 'Brak forów do synchronizacji';
$lang['resume_rebuild'] = '<b>Uwaga!</b> poprzednie odbudowywanie zostało przerwane przed ukończeniem zadania, kliknij %sTutaj%s aby je przywrócić, lub %sTutaj%s aby anulować. Jeżeli anulujesz, w tabelach phpbb_search_* pozostaną niepełne dane które zostały odtworzone do tej pory, zaleca sie wtedy rozpocząć przebudowywanie od początku.';
$lang['value_not'] = 'Wartość: <b>%s</b> nie ma odpowiednika, popraw zapytanie<br /><br />Kliknij %sTutaj%s żeby powrócić';
$lang['confirm_clear'] = 'Nie podał' .  (($he) ? 'e' : 'a') . 'ś warunków, czy na pewno chcesz wyczyścić tę tabelę ?';
$lang['cannot_execute'] = 'Nie mogę wykonać: <b>%s</b><br /><br />Kliknij %sTutaj%s żeby powrócić.';
$lang['execute_done'] = 'Ilość rekordów: <b>%s</b><br /><br /><b>%s</b><br /><br />Kliknij %sTutaj%s żeby powrócić.';
$lang['mysql_e'] = '<span style="color: red"><b>UWAGA !!!</b></span> To narzędzie jest dla zaawansowanych użytkowników! Znających działanie baz SQL, niewłaściwe użycie może spowodować trwałą utratę danych z bazy!<br />W tym miejscu możesz wykonać jedno lub kilka zapytań SQL. Aby wykonać kilka, oddziel je znakiem <b>;</b> jednak ten znak nie może występować w samym zapytaniu SQL.<br />Przed użyciem zalecane jest wykonanie kopii bazy SQL ! Prefix tabel: <b>%s</b>';
$lang['do_query'] = 'Wykonanie zapytania/zapytań SQL';
$lang['execute'] = 'wykonaj';
$lang['access_title'] = 'Zezwolenia dla SQL\'a';
$lang['access_explain'] = 'Z powodów bezpieczeństwa do menu SQL mogą mieć dostęp tylko wybrani administratorzy.<br />Jeżeli nie masz dostępu a uważasz że powin' .  (($he) ? 'ieneś' : 'naś') . ' mieć, zwróć się do głównego administratora.<br />Dopisywanie administratorów którzy mają mieć dostęp do SQL odbywa się za pomocą ID. Jeżeli nie wiesz co to znaczy to lepiej żebyś nie wiedział' .  (($he) ? '' : 'a') . ' i nie miał' .  (($he) ? '' : 'a') . ' dostępu do tej części menu, bo może się to skończyć uszkodzeniem forum :><br />Jeśli jesteś "dopisanym" adminem poniżej jest formularz służący do dodania kolejnych adminów którzy będą mieli dostęp do SQL. Jeżeli jesteś głównym administratorem i nie widzisz formularza, kliknij %s<b>Tutaj</b>%s będziesz miał' .  (($he) ? '' : 'a') . ' możliwość dodania swojego ID (domyślnie 2)<br /><span style="color: red"><b>Pamiętaj</b></span> żeby po zakończeniu koniecznie zmienić nazwę pliku <b>/admin/main_admin.php</b> lub go usunąć, w przeciwnym razie twoi administratorzy będą mogli zastąpić twoje ID swoim i będą mieć dostęp do SQL.<br />W celu jeszcze większego bezpieczeństwa wskazane jest po zakończeniu operacji na bazie danych, usunięcie z tej listy zezwoleń swojego numeru ID i zmianę nazwy pliku poprzez FTP';
$lang['change_main_admin'] = 'Wpisz swoje ID (dla kilku oddziel przecinkami)';
$lang['IPSearch_Search_by_IP'] = 'Szukaj adresu IP';
$lang['IPSearch_Enter_IP'] = 'Podaj adres IP';
$lang['IPSearch_Search_Results'] = 'Wyniki wyszukiwania IP';
$lang['IPSearch_Enter_an_IP'] = 'Cofnij sie i podaj adres IP';
$lang['IPSearch_Again'] = 'Szukaj jeszcze raz';
$lang['smiley_del_all_success'] = 'Wszystkie uśmieszki zostały usunięte';
$lang['dell_all_smilies'] = 'Usuń wszystkie uśmieszki !';
$lang['can_topic_color'] = 'Może używać koloru tematu';
$lang['Uninstall18'] = 'Deinstalator modyfikacji';
$lang['uninstall_explain'] = 'W tym miejscu możesz przywrócić forum do oryginalnej postaci, może się to okazać potrzebne gdy będziesz chciał' .  (($he) ? '' : 'a') . ' uaktualnić swoje forum np. do wersji phpBB 2.2.<br />Przywracanie składa się z dwóch etapów: 1. Odinstalowanie w tym miejscu modyfikacji z bazy danych. 2. Nadpisanie plików oryginalnymi plikami phpBB 2.0.x Lepszym sposobem jest usunięcie z katalogu forum wszystkich plików, z wyjątkiem katalogu \'images\' oraz pliku <b>config.php</b> i wgranie oryginalnych plików.<br /><br /><b>Odinstalowanie z bazy danych SQL</b><br />Pamiętaj, że gdy odinstalujesz modyfikację z bazy SQL nie będzie można tego cofnąć. Stracisz wszystkie dodatkowe informacje, te których nie ma w oryginalnym phpBB. Zalecane jest więc zrobienie kopii bazy SQL.<br />Możliwe jest oczywiście ponowne przywrócenie forum do postaci z przed odinstalowania, pod warunkiem posiadania kopii bazy SQL. Jeżeli chcemy przywrócić, czyścimy bazę danych, wgrywamy kopię bazy i nadpisujemy pliki forum plikami phpBB modified v1.12.5 by Przemo z wyjątkiem pliku <b>config.php</b>';
$lang['Uninstall'] = 'Odinstaluj';
$lang['confirm_uninstall'] = 'Czy jesteś pew' .  (($he) ? 'ien' : 'na') . ' że chcesz odinstalować modyfikacje?<br />Spowoduje to utratę niektórych danych, powin' .  (($he) ? 'ieneś' : 'naś') . ' posiadać kopię bazy danych.';
$lang['Set_new_version'] = 'Podaj wersję plików phpBB2 którymi nadpiszesz istniejące';
$lang['uninstall_end'] = '<span class="nav"><b>Wynik deinstalacji:</b></span><br /><span class="gensmall">Jeżeli wszystkie zapytania są w kolorze niebieskim, oznacza to że deinstalacja przebiegła pomyślnie. Usuń wszystkie dodatkowe pliki pakietu phpBB modified by Przemo, i nadpisz wszystkie istniejące plikami z oryginalnego pakietu phpBB 2.0.15 lub wyższego.</span>';
$lang['query_executed'] = 'Instrukcja wykonana';
$lang['query_not_executed'] = 'Instrukcja nie wykonana';
$lang['Updates'] = 'Uaktualnienia';

$lang['Report_post'] = 'Zgłaszanie postów';
$lang['Report_config_updated'] = 'Ustawienia zgłaszanych postów zaktualizowane.';
$lang['Click_return_report_config'] = 'Kliknij %sTutaj%s aby przejść do ustawień zgłaszania postów';
$lang['Click_return_report_auth'] = 'Kliknij %sTutaj%s aby przejść do ustawień zezwoleń zgłaszania postów';
$lang['Click_return_report_auth_select'] = 'Kliknij %sTutaj%s aby przejść do wyboru zezwoleń zgłaszania postów';
$lang['Report_config'] = 'Zgłaszanie postów - Konfiguracja';
$lang['Report_config_explain'] = '';
$lang['Report_popup_size'] = 'Rozmiary popup\'a';
$lang['Report_popup_size_explain'] = 'W tym miejscu możesz ustawić szerokość i wysokość popup\'a (w pikselach)';
$lang['Report_popup_links_target'] = 'Okno popup\'a';
$lang['Report_popup_links_target_explain'] = 'W tym miejscu możesz ustalić w jakim oknie ma być otwierany popup';
$lang['Report_popup_links_target_0'] = 'Jako popup';
$lang['Report_popup_links_target_1'] = 'W nowym oknie';
$lang['Report_popup_links_target_2'] = 'W tym samym oknie';
$lang['Report_only_admin'] = 'Tylko dla administratorów';
$lang['Report_only_admin_explain'] = 'Jeśli włączysz tą opcje, tylko administratorzy będą powiadamiani o zgłaszanych postach';
$lang['Report_no_guests'] = 'Tylko zarejestrowani';
$lang['Report_no_guests_explain'] = 'Tylko zarejestrowani użytkownicy mogą zgłaszać posty';
$lang['No_group_specified'] = 'Nie ma ustalonej grupy/grup';
$lang['Report_already_auth'] = 'Ten użytkownik/grupa już jest dodany';
$lang['Report_auth_field_explain'] = 'Możesz zaznaczyć kilka użytkowników';
$lang['Report_permissions_explain'] = 'W tym miejscu możesz zablokować zgłaszanie postów, lub wyłączyć powiadamianie o zgłoszonych postach dla wybranych użytkowników';
$lang['Report_no_auth'] = 'Zablokuj możliwość zgłaszania postów wybranym użytkownikom';
$lang['Report_disable'] = 'Wyłącz powiadamianie o zgłaszanych postach dla wybranych użytkowników';
$lang['Back'] = 'Cofnij';
$lang['Remove'] = 'Usuń';
$lang['Report_post_disable'] = 'Zgłaszanie postów wyłączone';
$lang['Prune_users'] = 'Masowe kasowanie użytkowników'; 
$lang['Ecat'] = 'Kategoria: Edytuj';
$lang['Dcat'] = 'Kategoria: Usuń';
$lang['Rcat'] = 'Kategoria: Przemianuj';
$lang['Efile'] = 'Pliki: Edytuj';
$lang['Dfile'] = 'Pliki: Usuń';
$lang['Efield'] = 'Dodatki: Edytuj';
$lang['Dfield'] = 'Dodatki: Usuń';
$lang['wrong_config_parametr'] = $lang['Server_name'] . ' nie może zawierać <b>%s</b> !';
$lang['Forum_link'] = 'Link zewnętrzny';
$lang['User_allow_helped'] = 'Może używać punktów "Pomógł"';
$lang['User_allow_helped_e'] = 'Włącza lub wyłącza zarówno używanie przycisku "Pomógł" jak i ukrywa ilość punktów "Pomógł" uzyskanych przez tego użytkownika';
$lang['Admin_notepad'] = 'Notatnik Administratorów';
$lang['confirm_deluser'] = 'Czy jesteś pew' .  (($he) ? 'ien' : 'na') . ' że chcesz usunąć tego użytkownika ?';
$lang['Forum_moderate'] = 'Forum moderowane';
$lang['Forum_moderate_e'] = 'Tematy i posty będą oczekiwały na akceptację przez Moderatora lub Administratora';
$lang['Tree_req'] = 'Tematy tylko w formie drzewa';
$lang['Tree_req_grade'] = 'Po ilu stopniach drzewa zmniejszenie odległości stopni drzewa<br />0 - Wyłącza całkowicie drzewa w forum';
$lang['Prune_explain'] = 'Nie zostaną usunięte tematy zawierające sondy lub będące ogłoszeniami lub tematami przyklejonymi.';
$lang['No_count'] = 'Niezliczanie postów';
$lang['Forums_shadow'] = 'Fora nieskojarzone z żadną kategorią';
$lang['Wrong_category'] = 'Nie możesz przypisać forum samego do siebie.';
$lang['All_forums'] = 'Wszystkie fora i kategorie';
$lang['log_file_limit_info'] = 'Plik logów <b>/admin/admin_logs.php</b> jest zbyt duży (%sMb) aby go otworzyć w oknie przeglądarki.<br /><br />Plik został skompresowany i znajduje się w: <b>%s</b><br /><br />Kliknij %sTutaj%s aby go pobrać.<br /><br />Po ściągnięciu KONIECZNIE usuń go z katalogu /files/ możesz też wyczyścić stary plik /admin/admin_logs.php';
$lang['log_file_limit_error1'] = 'Błąd odczytu pliku: <b>%s</b>';
$lang['log_file_limit_error2'] = 'Błąd zapisu skompresowanego pliku: <b>%s</b>';

$lang['Confirm_delete_all'] = 'Czy na pewno chcesz usunąć wszystkie: <b>%s</b> ?';
$lang['Split'] = 'Łączenie';
$lang['Expire'] = 'Wygasanie';
$lang['Warning_delete'] = 'Usunięcie ostrzeżenia';
$lang['Warning_edit'] = 'Edycja ostrzeżenia';
$lang['Object'] = 'Obiekt';
$lang['Group_mail_enable'] = 'Moderator grupy może wysyłać masową korespondencję do członków grupy ?';
$lang['Forum_trash'] = 'Forum jako śmietnik';
$lang['Forum_trash_e'] = 'Gdy ustawisz forum jako śmietnik, podczas kasowania tematów pojawi się dodatkowy przycisk służący przenoszeniu tematu do śmietnika';
$lang['Resync_page_posts'] = 'Synchronizacja użytkowników';
$lang['No_themes'] = 'Brak Szablonów w bazie danych';
$lang['Group_prefix'] = 'Prefix, pojawi się przed nazwą użytkowników';
$lang['Group_no_unsub'] = 'Zakaz opuszczania';
$lang['Groups_color_explain'] = 'Możesz wyróżnić grupy, ustawiając im kolor prefix oraz styl. Jeżeli w edycji danych stylu, usuniesz kolor dla Admina, Moda lub Junior Admina nie będą oni oznaczani kolorem i będziesz ' .  (($he) ? 'mógł' : 'mogła') . ' ich przypisać do wyróżnionej grupy, zniknie też opis kolorów m.in. na stronie głównej.<br />Wiele stylów oddziel średnikiem, przykłady: <b>font-weight: bold; font-size: 16px; text-decoration: line-through; font-style: italic; filter: glow(color=#FF0000);height:10</b> i wiele innych (max. 255 znaków)';
$lang['Group_style'] = 'Styl';
$lang['Separate_topics'] = 'Oddzielone ważne tematy';
$lang['Separate_total'] = 'osobne tabele';
$lang['Separate_med'] = 'belka';
$lang['Show_global_announce'] = 'Pokazuj ważne ogłoszenia z innych działów';
$lang['Advert_title'] = 'Reklama';
$lang['Show_hosts'] = 'Pokaż hosty';
$lang['Forum_no_split'] = 'Nie łącz postów';
$lang['Forum_no_helped'] = 'Wyłącz "Pomógł"';
$lang['topic_tags'] = 'Tagi tematów, oddzielaj przecinkami, nie używaj znaków <b>[]</b>';
$lang['sort_methods'] = 'Zablokowane na dół';

$lang['Statistics_management'] = 'Moduły statystyk';
$lang['Statistics_config'] = 'Konfiguracja statystyk';
$lang['Acces_menu_denied'] = 'Nie masz dostępu do tego menu';
$lang['Check-files'] = 'Kontrola Systemu';
$lang['New_info'] = 'Proszę czekać, trwa pobieranie informacji o aktualizacjach ...';
$lang['forum_compress'] = 'przez skrypt';
$lang['server_compress'] = 'przez serwer';
$lang['Name'] = 'Nazwa';
$lang['Files_count'] = 'Ilość plików';
$lang['Rows_count'] = 'Ilość wpisów';
$lang['Config_setup'] = 'Zapis konfiguracji';
$lang['Config_setup_e'] = 'W tym miejscu możesz zapisać bieżącą konfigurację forum, odtworzyć zapisaną konfigurację, ustawić minimalną i maksymalną konfigurację. Dotyczy to ogólnej konfiguracji forum, ostrzeżeń, shoutbox\'a, załączników, oraz zgłaszania postów. Dotyczy to tylko konfiguracji, nie dotyczy informacji które są dodawane jak np. zezwolenia, uśmieszki, cenzura słów, zainstalowane style, banlista, pola w profilu, zabronione nazwy, grupy, fora, kategorie, rozszerzenia załączników.';
$lang['Default_config'] = 'Ustaw domyślną konfigurację';
$lang['Max_config'] = 'Ustaw maksymalną konfigurację';
$lang['Min_config'] = 'Ustaw minimalną konfigurację';
$lang['Save_config'] = 'Zapisz bieżącą konfigurację';
$lang['Saved_config'] = 'Ustaw konfigurację zapisaną: %s';
$lang['Permissions_List'] = 'Lista zezwoleń';                  
$lang['Forum_auth_list_explain'] = 'Lista zezwoleń dla wszystkich forów. Możesz je edytować klikając na button "Edycja zezwoleń" na dole forum.';                                                                  
$lang['Forum_auth_list_explain_ALL'] = 'Wszyscy użytkownicy';                                                          
$lang['Forum_auth_list_explain_REG'] = 'Wszyscy zarejestrowani użytkownicy';                                               
$lang['Forum_auth_list_explain_PRIVATE'] = 'Tylko użytkownicy ze specjalnymi zezwoleniami';                          
$lang['Forum_auth_list_explain_MOD'] = 'Tylko moderatorzy tego forum';                                      
$lang['Forum_auth_list_explain_ADMIN'] = 'Tylko administratorzy';                                              
$lang['Forum_auth_list_explain_auth_view'] = '%s mogą oglądać to forum';                                       
$lang['Forum_auth_list_explain_auth_read'] = '%s mogą czytać posty w tym forum';                              
$lang['Forum_auth_list_explain_auth_post'] = '%s mogą pisać nowe posty w tym forum';                                    
$lang['Forum_auth_list_explain_auth_reply'] = '%s mogą opowiadać na posty w tym forum';                            
$lang['Forum_auth_list_explain_auth_edit'] = '%s mogą edytować posty w tym forum';                              
$lang['Forum_auth_list_explain_auth_delete'] = '%s mogą usuwać posty w tym forum';                          
$lang['Forum_auth_list_explain_auth_sticky'] = '%s mogą ustawiać przyklejone tematy w tym forum';                    
$lang['Forum_auth_list_explain_auth_announce'] = '%s mogą pisać ogłoszenia w tym forum';                  
$lang['Forum_auth_list_explain_auth_vote'] = '%s mogą brać udział w głosowaniu w sondach w tym forum';                           
$lang['Forum_auth_list_explain_auth_pollcreate'] = '%s mogą tworzyć ankiety w tym forum';                      
$lang['Cancel'] = 'Anuluj';
$lang['Edit_permissions'] = 'Edycja zezwoleń';

$lang['Forum_out_of_date'] = 'Twoje forum jest NIEAKTUALNE! <a href="http://przemo.org/phpBB2/index.php?cid=0">Pobierz</a> najnowszą wersję!';
$lang['Forum_up_to_date'] = 'Twoje forum jest aktualne.';
$lang['Forum_search_for_updates'] = 'Sprawdź teraz';
$lang['Forum_last_update_check'] = 'Ostatnio sprawdzano %s';
$lang['Forum_last_update_check_minutes_ago'] = '%d minut temu';
$lang['Forum_last_update_check_hours_ago'] = '%d godzin temu';
$lang['Forum_last_update_check_days_ago'] = '%d dni temu';
//
// That's all Folks!
// -------------------------------------------------

?>