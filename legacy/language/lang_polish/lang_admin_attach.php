<?php
/***************************************************************************
 *                      lang_admin_attach.php [Polish]
 *                      -------------------
 *     begin            : Thu Feb 07 2002
 *     copyright        : (C) 2002 Meik Sievertsen
 *     email            : acyd.burn@gmx.de
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
// Attachment Mod Admin Language Variables
//

// Modules, this replaces the keys used
$lang['Control_Panel'] = 'Panel kontrolny';
$lang['Shadow_attachments'] = 'Przegl�danie nieaktywnych za��cznik�w';
$lang['Forbidden_extensions'] = 'Usu� lub dodaj rozszerzenie za��cznik�w';
$lang['Extension_control'] = 'Kontrola rozszerze� za��cznik�w';
$lang['Extension_group_manage'] = 'Kontrola rozszerze� za��cznik�w dla grup';
$lang['Special_categories'] = 'Dodatkowe kategorie';
$lang['Sync_attachments'] = 'Synchronizuj za��czniki';
$lang['Quota_limits'] = 'Limity Quoty';

// Attachments -> Management
$lang['Attach_settings'] = 'Ustawienia za��cznik�w';
$lang['Manage_attachments_explain'] = 'Tutaj mo�esz ustawi� g��wne ustawienia modu�u za��cznik�w. Gdy naci�niesz przycisk Testuj Ustawienia, modu� przez chwile b�dzie sprawdza� czy wszystko dzia�a poprawnie. Je�li masz problem z wys�aniem pliku, uruchom Test, �eby zobaczy� dok�adne informacje o b��dach.';
$lang['Attach_filesize_settings'] = 'Ustawienia rozmiar�w za��cznik�w';
$lang['Attach_number_settings'] = 'Ustawienia numer�w za��cznik�w';
$lang['Attach_options_settings'] = 'Ustawienia za��cznik�w';

$lang['Upload_directory'] = 'Katalog za��cznik�w';
$lang['Upload_directory_explain'] = 'Podaj �cie�k� od katalogu w kt�rym masz forum. Na przyk�ad \'files\' Przyk�ad: adres forum: http://www.yourdomain.com/phpBB2 a katalog za��cznik�w: http://www.yourdomain.com/phpBB2/files.';
$lang['Attach_img_path'] = 'Ikony link�w za��cznik�w';
$lang['Attach_img_path_explain'] = 'Ta ikona jest wy�wietlana za linkiem do za��cznika w postach u�ytkownik�w. Pozostaw to pole puste gdy nie chcesz �eby by�a wy�wietlana. B�dzie zast�pione przez Extension Groups Management.';
$lang['Attach_topic_icon'] = 'Ikony za��cznik�w w tematach';
$lang['Attach_topic_icon_explain'] = 'Ta ikona b�dzie wy�wietlana przed tematem postu je�li b�dzie w nim za��cznik. Pozostaw to pole puste gdy nie chcesz �eby by�a wy�wietlana.';
$lang['Attach_display_order'] = 'Kolejno�� wy�wietlania za��cznik�w';
$lang['Attach_display_order_explain'] = 'Tutaj mo�esz ustali� w jakiej kolejno�ci b�d� segregowane za��czniki w postach lub prywatnych wiadomo�ciach. Mo�esz ustawi� (Najnowsze za��czniki pierwsze) lub (Najstarsze za��czniki pierwsze).';
$lang['Show_apcp'] = '"Zwini�ty" spos�b pokazywania p�l dla za��cznik�w';
$lang['Show_apcp_explain'] = 'Przy zwini�tym, podczas pisania postu, trzeba klikn�� na link, po czym otworzy si� pole do za��czania plik�w. Przy rozwini�tym te pola b�d� widoczne zawsze.';

$lang['Max_filesize_attach'] = 'Rozmiar za��cznik�w';
$lang['Max_filesize_attach_explain'] = 'Maksymalny rozmiar za��cznika w bajtach (bytes). Gdy ustawisz 0 rozmiar b�dzie nieograniczony.';
$lang['Attach_quota'] = 'Quota dyskowa';
$lang['Attach_quota_explain'] = 'Maksymalny rozmiar dla wszystkich za��cznik�w, uwarunkowany twoja quot� na koncie lub twoim dysku na serwerze.';
$lang['Max_filesize_pm'] = 'Maksymalny rozmiar za��cznik�w w skrzynce prywatnej';
$lang['Max_filesize_pm_explain'] = 'Maksymalny rozmiar za��cznik�w jaki mo�e mie� u�ytkownik w swojej skrzynce na prywatne wiadomo�ci.'; 
$lang['Default_quota_limit'] = 'Limity Quoty';
$lang['Default_quota_limit_explain'] = 'W tym miejscu mo�esz ustali� automatyczn� ilo�� Quoty dyskowej dla nowych u�ytkownik�w oraz dla u�ytkownik�w bez przypisanej Quoty indywidualnej';

$lang['Max_attachments'] = 'Maksymalna ilo�� za��cznik�w - posty';
$lang['Max_attachments_explain'] = 'Maksymalna ilo�� za��cznik�w w jednym po�cie.';
$lang['Max_attachments_pm'] = 'Maksymalna ilo�� za��cznik�w - PM';
$lang['Max_attachments_pm_explain'] = 'Maksymalna ilo�� za��cznik�w w jednej prywatnej wiadomo�ci.';

$lang['Disable_mod'] = 'Wy��cz modu� za��cznik�w';
$lang['Disable_mod_explain'] = 'Ta opcja wy��cza modu� za��cznik�w.';
$lang['PM_Attachments'] = 'W��cz za��czniki w PM';
$lang['PM_Attachments_explain'] = 'W��cza lub wy��cza mo�liwo�� dodawania za��cznik�w w prywatnych wiadomo�ciach';
$lang['Ftp_upload'] = 'W��cz upload FTP';
$lang['Ftp_upload_explain'] = 'W��cz lub wy��cz upload FTP. Je�li w��czysz musisz poda� parametry FTP i katalogu do uploadu plik�w.';
$lang['Attachment_topic_review'] = 'W��czy� pokazywanie za��cznik�w podczas przegl�dania temat�w?';
$lang['Attachment_topic_review_explain'] = 'Je�li w��czysz ikona za��cznik�w b�dzie pokazywana kiedy odpowiesz na post.';

$lang['Ftp_server'] = 'FTP Upload Server';
$lang['Ftp_server_explain'] = 'Tutaj mo�esz poda� IP adres lub Host name dla serwera gdzie b�d� kopiowane za��czniki. Je�li pozostawisz to pole puste, b�dzie w tym celu wykorzystany serwer gdzie masz zainstalowane forum. UWAGA nie mo�na podawa� adresu FTP w ten spos�b: ftp:// lub podobny. Poprawny adres to na przyk�ad: ftp.adres.serwera.pl lub adres IP co zmniejszy czas dost�pu.';

$lang['Attach_ftp_path'] = 'Katalog uploadu plik�w';
$lang['Attach_ftp_path_explain'] = 'Podaj �cie�k� dost�pu do katalogu gdzie b�d� umieszczane pliki. Nie podawaj tutaj adresu FTP, tylko �cie�k� dost�pu do katalogu, adres podajesz wy�ej.<br /> Na przyk�ad, gdy tw�j adres do jakiego� pliku na FTP wygl�da tak: ftp://adres.serwera.pl/ogolne/pliki/jakis_plik.zip to w tym miejscu wpisujesz: /ogolne/pliki';
$lang['Ftp_download_path'] = 'Katalog downloadu plik�w';
$lang['Ftp_download_path_explain'] = 'To samo co wy�ej tylko tutaj podajemy pe�n� �cie�k� np: ftp://adres.serwera.pl/ogolne/pliki';
$lang['Ftp_passive_mode'] = 'Tryb pasywny';
$lang['Ftp_passive_mode_explain'] = 'Tryb pasywny wymaga aby zdalny serwer mia� otwarty port dla po��czenia i zwraca� adres dla tego portu i nas�uchiwa� na tym porcie';

$lang['No_ftp_extensions_installed'] = 'Niestety nie mo�esz u�y� uploadu FTP gdy� serwer PHP nie obs�uguje uploadu FTP';

// Attachments -> Shadow Attachments
$lang['Shadow_attachments_explain'] = 'Tutaj mo�esz skasowa� stare lub "nie dzia�aj�ce" za��czniki, mo�esz to sprawdzi� klikaj�c na nie';
$lang['Shadow_attachments_file_explain'] = 'Za��czniki kt�re znajduj� si� w katalogu za��cznik�w a nie ma ich w bazie za��cznik�w, w �adnym po�cie ani prywatnej wiadomo�ci.';
$lang['Shadow_attachments_row_explain'] = 'Za��czniki kt�re znajduj� si� w katalogu za��cznik�w a nie ma ich w �adnym po�cie ani prywatnej wiadomo�ci.';
$lang['Empty_file_entry'] = 'Pusty plik';

// Attachments -> Sync
$lang['Sync_thumbnail_resetted'] = 'Miniatura zresetowana dla za��cznika: %s'; // replace %s with physical Filename
$lang['Attach_sync_finished'] = 'Synchronizacja za��cznik�w zako�czona.';

// Extensions -> Extension Control
$lang['Manage_extensions'] = 'Ustawienia zezwole� rozszerze� za��cznik�w';
$lang['Manage_extensions_explain'] = 'Tutaj mo�esz ustali� jakie rozszerzenia za��cznik�w b�d� akceptowane.';
$lang['Explanation'] = 'Opis';
$lang['Extension_group'] = 'Rozszerze� za��cznik�w dla grup';
$lang['Extension_exist'] = 'Rozszerzenie %s ju� istnieje'; // replace %s with the Extension
$lang['Unable_add_forbidden_extension'] = 'Rozszerzenie %s nie znalezione, nie mo�esz ustawi� takiego rozszerzenia'; // replace %s with Extension

// Extensions -> Extension Groups Management
$lang['Manage_extension_groups'] = 'Ustawienia rozszerze� za��cznik�w grup';
$lang['Manage_extension_groups_explain'] = 'Tutaj mo�esz dodawa�, kasowa� i zmienia� rozszerzenia grup, mo�esz wy��czy� Rozszerzenia Grup, przypisa� specjaln� kategori�, zmieni� ustawienia downloadu, ustawi� ikon� uploadu kt�ra jest wy�wietlana przed Grupami Rozszerze�.';
$lang['Special_category'] = 'Kategoria specjalna';
$lang['Category_images'] = 'Ikony za��cznik�w';
$lang['Category_stream_files'] = 'Pliki Stream';
$lang['Category_swf_files'] = 'Pliki Flash';
$lang['Allowed'] = 'Zezw�l';
$lang['Allowed_forums'] = 'Zezw�l na forum';
$lang['Ext_group_permissions'] = 'Prawa grup';
$lang['Download_mode'] = 'Spos�b �ci�gania';
$lang['Upload_icon'] = 'Prze�lij ikon�';
$lang['Max_groups_filesize'] = 'Maksymalny rozmiar pliku';
$lang['Extension_group_exist'] = 'Rozszerzenie %s dla grupy ju� istnieje'; // replace %s with the group name
$lang['Collapse'] = '+';
$lang['Decollapse'] = '-';

// Extensions -> Special Categories
$lang['Manage_categories'] = 'Ustawienia specjalnych kategorii';
$lang['Manage_categories_explain'] = 'Tutaj mo�esz ustawi� specjalne kategorie.';
$lang['Settings_cat_images'] = 'Ustawienia Specjalnych Kategorii: Ikony';
$lang['Settings_cat_streams'] = 'Ustawienia Specjalnych Kategorii: Pliki Stream';
$lang['Settings_cat_flash'] = 'Ustawienia Specjalnych Kategorii: Pliki Flash';
$lang['Display_inlined'] = 'Obrazek jako link';
$lang['Display_inlined_explain'] = 'Ustaw czy obrazek ma by� pokazywany w po�cie (Tak) czy ma by� linkiem do obrazka';
$lang['Max_image_size'] = 'Maksymalny rozmiar obrazka';
$lang['Max_image_size_explain'] = 'Tutaj ustawiasz maksymalny dozwolony rozmiar obrazka (Wysoko�� i szeroko�� w pikselach).<br />Je�li podasz warto�� 0 nie b�dzie ograniczenia, lecz zbyt du�y obrazek mo�e nie pracowa� poprawnie z PHP.';
$lang['Image_link_size'] = 'Zamiana na link zbyt du�ego obrazka';
$lang['Image_link_size_explain'] = 'Je�li za��czony obrazek przekroczy podane warto�ci, system wy�wietli tylko link do niego. Je�li podasz warto�ci 0 nie b�dzie ograniczenia, lecz zbyt du�e zdj�cia mog� nie pracowa� poprawnie w PHP.';
$lang['Assigned_group'] = 'Wyznaczona grupa';

$lang['Image_create_thumbnail'] = 'Tworzenie minigalerii';
$lang['Image_create_thumbnail_explain'] = 'Ta opcja tworzy i wy�wietla tylko miniaturki za��czonych zdj�� (je�li s� wi�ksze ni� maksymalny podany poni�ej rozmiar zdj�� galerii), kt�re s� linkami do zdj�� w oryginalnych rozmiarach. Opcja ta wymaga zainstalowanego programu: Imagick, je�li nie wiesz czy na serwerze jest on zainstalowany, u�yj poni�ej przycisku "Znajd� Imagick" Je�li jest on zainstalowany na serwerze, �cie�ka do aplikacji zostanie automatycznie wpisana w pole "Imagick (Pe�na �cie�ka)" je�li skrypt nie odnajdzie �cie�ki, zapytaj administratora i wpisz �cie�k� r�cznie.';
$lang['Image_min_thumb_filesize'] = 'Maksymalny rozmiar zdj�� minigalerii';
$lang['Image_min_thumb_filesize_explain'] = 'Je�li za��czane zdj�cia b�d� przekracza�y podan� wielko�� i jest zainstalowany Imagick na serwerze, oraz �cie�ka jest podana prawid�owo, galeria zostanie utworzona.';
$lang['Image_imagick_path'] = 'Imagick (Pe�na �cie�ka)';
$lang['Image_imagick_path_explain'] = 'Podaj pe�n� �cie�k� do programu: Imagick, przyk�ad pod systemami Unixowymi: /usr/bin/convert lub windowsowymi: c:/imagemagick/convert.exe Je�li jej nie znasz, u�yj przycisku "Znajd� Imagick" lub zapytaj administratora.';
$lang['Image_search_imagick'] = 'Znajd� Imagick';

$lang['Use_gd2'] = 'U�yj kompresji GD2';
$lang['Use_gd2_explain'] = 'PHP posiada mo�liwo�� wsp�pracy z mechanizmami GD1 oraz GD2 przy przetwarzaniu obraz�w, nale�y je wybra� indywidualnie wed�ug jako�ci uzyskiwanych obraz�w';
$lang['Attachment_version'] = 'Wersja modu�u za��cznik�w: %s'; // %s is the version number

// Extensions -> Forbidden Extensions
$lang['Manage_forbidden_extensions'] = 'Ustawianie niedozwolonych rozszerze� plik�w';
$lang['Manage_forbidden_extensions_explain'] = 'Tutaj mo�esz doda� lub usun�� niedozwolone rozszerzenia plik�w. Rozszerzenia php, php3 i php4 s� zabronione z powod�w bezpiecze�stwa, je�li mo�esz nie kasuj.';
$lang['Forbidden_extension_exist'] = 'Rozszerzenie %s ju� istnieje'; // replace %s with the extension
$lang['Extension_exist_forbidden'] = 'Rozszerzenie %s jest w tej chwili ustawione jako zezwolone, najpierw usu� je z listy rozszerze� zezwolonych';  // replace %s with the extension

// Extensions -> Extension Groups Control -> Group Permissions
$lang['Group_permissions_title'] = 'Prawa rozszerze� dla grupy -> \'%s\''; // Replace %s with the Groups Name
$lang['Group_permissions_explain'] = 'Tutaj mo�esz ustawi� w�a�ciwo�ci rozszerze� grup dla danego forum (podanych w polu zezwole� for). Standardowym ustawieniem jest zezwolenie userom na zamieszczanie plik�w w dowolnym forum.';
$lang['Note_admin_empty_group_permissions'] = 'NOTE:<br />Within the below listed Forums your Users are normally allowed to attach files, but since no Extension Group is allowed to be attached there, your Users are unable to attach anything. If they try, they will receive Error Messages. Maybe you want to set the Permission \'Post Files\' to ADMIN at these Forums.<br /><br />';
$lang['Add_forums'] = 'Dodaj fora';
$lang['Add_selected'] = 'Dodaj wybrane';
$lang['Perm_all_forums'] = 'WSZYSTKIE FORA';

// Attachments -> Quota Limits
$lang['Manage_quotas'] = 'Zarz�dzanie limitami Quoty dyskowej';
$lang['Manage_quotas_explain'] = 'W tym miejscu mo�esz doda�/usun��/zmieni� limity quoty. Mo�esz przypisa� quot� do u�ytkownik�w i grup. Aby przypisa� limit quoty dla u�ytkownika przejd� do edycji jego danych. Aby przypisa� quot� dla grup, przejd� do edycji danych grupy.';
$lang['Assigned_users'] = 'Przypisani u�ytkownicy';
$lang['Assigned_groups'] = 'Przypisane grupy';
$lang['Quota_limit_exist'] = 'Limit quoty %s istnieje.'; // Replace %s with the Quota Description

// Attachments -> Control Panel
$lang['Control_panel_title'] = 'Panel kontrolny za��cznik�w';
$lang['Control_panel_explain'] = 'Tutaj mo�esz przegl�da� i ustawia� wszystkie za��czniki wys�ane przez u�ytkownik�w';
$lang['File_comment_cp'] = 'Komentarz za��cznika';

// Control Panel -> Search
$lang['Search_wildcard_explain'] = 'U�yj * by zast�pi� jaki� ci�g znak�w';
$lang['Size_smaller_than'] = 'Rozmiar (w bajtach) za��cznika jest mniejsza ni�';
$lang['Size_greater_than'] = 'Rozmiar (w bajtach) za��cznika jest wi�ksza ni�';
$lang['Count_smaller_than'] = 'Liczba �ci�gni�� jest mniejsza ni�';
$lang['Count_greater_than'] = 'Liczba �ci�gni�� jest wi�ksza ni�';
$lang['More_days_old'] = 'Za��czone X dni wstecz.';
$lang['No_attach_search_match'] = 'Nie znaleziono za��cznik�w spe�niaj�ce te kryteria';

// Control Panel -> Statistics
$lang['Number_of_attachments'] = 'Ilo�� za��cznik�w';
$lang['Total_filesize'] = '��czny rozmiar wszystkich za��cznik�w';
$lang['Number_posts_attach'] = 'Ilo�� post�w z za��cznikami';
$lang['Number_topics_attach'] = 'Ilo�� temat�w z za��cznikami';
$lang['Number_users_attach'] = 'Ilo�� u�ytkownik�w kt�rzy za��czyli pliki';
$lang['Number_pms_attach'] = 'Ca�kowita ilo�� za��cznik�w w prywatnych wiadomo�ciach';

// Control Panel -> Attachments
$lang['Statistics_for_user'] = 'Statystyki za��cznik�w dla u�ytkownika %s'; // replace %s with username
$lang['Size_in_kb'] = 'Rozmiar (KB)';
$lang['Downloads'] = '�ci�gni�to';
$lang['Post_time'] = 'Data postu';
$lang['Posted_in_topic'] = 'Post w temacie';
$lang['Submit_changes'] = 'Zachowaj zmiany';

// Sort Types
$lang['Sort_Attachments'] = 'Za��czniki';
$lang['Sort_Size'] = 'Rozmiar';
$lang['Sort_Filename'] = 'Nazwa pliku';
$lang['Sort_Comment'] = 'Komentarz do za��cznika';
$lang['Sort_Extension'] = 'Rozszerzenie';
$lang['Sort_Downloads'] = '�ci�gni�to';
$lang['Sort_Posttime'] = 'Data postu';

// View Types
$lang['View_Statistic'] = 'Statystyki';
$lang['View_Search'] = 'Szukaj';
$lang['View_Username'] = 'U�ytkownik';
$lang['View_Attachments'] = 'Za��czniki';

// Successfully updated
$lang['Attach_config_updated'] = 'Konfiguracja za��cznik�w uaktualniona pomy�lnie';
$lang['Click_return_attach_config'] = 'Kliknij %stutaj%s �eby powr�ci� do konfiguracji za��cznik�w';
$lang['Test_settings_successful'] = 'Test konfiguracji zako�czony, wszystko wygl�da dobrze.';

// Some basic definitions
$lang['Attachments'] = 'Za��czniki';
$lang['Attachment'] = 'Za��cznik';
$lang['Extension'] = 'Rozszerzenie';

// Auth pages
$lang['Auth_attach'] = 'Post za��cznika';
$lang['Auth_download'] = '�ci�gnij za��czniki';

?>