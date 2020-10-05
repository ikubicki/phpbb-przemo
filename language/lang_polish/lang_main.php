<?php
/***************************************************************************
 *                      lang_main.php [Polish]
 *                      -------------------
 * begin                : Sat Dec 16 2000
 * copyright            : (C) 2001 The phpBB Group
 * email                : support@phpbb.com
 * modification         : (C) 2003 Przemo http://www.przemo.org
 * date modification    : ver. 1.12.5 2005/12/10 1:14
 *
 ****************************************************************************/

/***************************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 ***************************************************************************/

//
// Translation by Mike Paluchowski and Radek Kmiecicki
// http://www.phpbb.pl/
//


//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//



// Check for user gender
$he = ($userdata['user_gender'] != 2) ? true : false;

setlocale(LC_ALL, 'pl');
@setlocale (LC_ALL, 'pl_PL.iso-8859-2', 'pl_PL.latin2', 'pl_PL', 'pl', 'polish');
$lang['ENCODING'] = 'iso-8859-2';
$lang['DIRECTION'] = 'ltr';
$lang['DATE_FORMAT'] = 'd M Y';

//
// Common, these terms are used
// extensively on several pages
//
$lang['Forum'] = 'Forum';
$lang['Category'] = 'Kategoria';
$lang['Topic'] = 'Temat';
$lang['Topics'] = 'Tematy';
$lang['Replies'] = 'Odpowiedzi';
$lang['Views'] = 'Wy�wietle�';
$lang['Post'] = 'Post';
$lang['Posts'] = 'Posty';
$lang['Posted'] = 'Wys�any';
$lang['Username'] = 'U�ytkownik';
$lang['Password'] = 'Has�o';
$lang['Email'] = 'E-mail';
$lang['Poster'] = 'Wys�a�';
$lang['Author'] = 'Autor';
$lang['Time'] = 'Czas';
$lang['Hours'] = 'Godzin';
$lang['Message'] = 'Wiadomo��';

$lang['1_Day'] = '1 Dzie�';
$lang['7_Days'] = '7 Dni';
$lang['2_Weeks'] = '2 Tygodnie';
$lang['1_Month'] = '1 Miesi�c';
$lang['3_Months'] = '3 Miesi�ce';
$lang['6_Months'] = '6 Miesi�cy';
$lang['1_Year'] = '1 Rok';

$lang['Jump_to'] = 'Skocz do';
$lang['Submit'] = 'Wy�lij';
$lang['Reset'] = 'Wyczy��';
$lang['Cancel'] = 'Anuluj';
$lang['Preview'] = 'Podgl�d';
$lang['Confirm'] = 'Zatwierd�';
$lang['Yes'] = 'Tak';
$lang['No'] = 'Nie';
$lang['Enabled'] = 'W��czony';
$lang['Disabled'] = 'Wy��czony';
$lang['Error'] = 'B��d';

$lang['Next'] = 'Dalej';
$lang['Previous'] = 'Wstecz';
$lang['Goto_page'] = 'Id� do strony';
$lang['Joined'] = 'Do��czy�';
$lang['IP_Address'] = 'Adres IP';

$lang['Select_forum'] = 'Wybierz forum';
$lang['View_newest_post'] = 'Zobacz najnowszy post';
$lang['Page_of'] = 'Strona <b>%d</b> z <b>%d</b>';

$lang['ICQ'] = 'Numer ICQ';
$lang['AIM'] = 'Numer Gadu-Gadu';
$lang['MSNM'] = 'MSN Messenger';
$lang['YIM'] = 'Yahoo Messenger';

$lang['Forum_Index'] = '%s Strona G��wna';

$lang['Post_new_topic'] = 'Napisz nowy temat';
$lang['Reply_to_topic'] = 'Odpowiedz do tematu';
$lang['Reply_with_quote'] = 'Odpowiedz z cytatem';

$lang['Click_return_topic'] = 'Kliknij %sTutaj%s aby powr�ci� do tematu';
$lang['Click_return_forum'] = 'Kliknij %sTutaj%s aby powr�ci� na forum';
$lang['Click_view_message'] = 'Kliknij %sTutaj%s aby zobaczy� swoj� wiadomo��';
$lang['Click_return_group'] = 'Kliknij %sTutaj%s aby powr�ci� do informacji o grupach';

$lang['Admin_panel'] = 'Panel Administracyjny';

$lang['Board_disable'] = 'To forum jest teraz wy��czone.';

//
// Global Header strings
//
$lang['Registered_users'] = 'Zarejestrowani U�ytkownicy:';
$lang['Browsing_forum'] = 'U�ytkownicy przegl�daj�cy to forum:';
$lang['Online_users_zero_total'] = 'Na Forum jest <b>0</b> u�ytkownik�w :: ';
$lang['Online_users_total'] = 'Na Forum jest <b>%d</b> u�ytkownik�w :: ';
$lang['Online_user_total'] = 'Na Forum jest <b>%d</b> u�ytkownik :: ';
$lang['Reg_users_zero_total'] = '0 Zarejestrowanych, ';
$lang['Reg_users_total'] = '%d Zarejestrowanych, ';
$lang['Reg_user_total'] = '%d Zarejestrowany, ';
$lang['Hidden_users_zero_total'] = '0 Ukrytych i ';
$lang['Hidden_users_total'] = '%d Ukrytych i ';
$lang['Hidden_user_total'] = '%d Ukryty i ';
$lang['Guest_users_zero_total'] = '0 Go�ci';
$lang['Guest_users_total'] = '%d Go�ci';
$lang['Guest_user_total'] = '%d Go��';
$lang['Record_online_users'] = 'Najwi�cej u�ytkownik�w <b>%s</b> by�o obecnych %s';

$lang['Admin_online_color'] = 'Administrator';
$lang['Mod_online_color'] = 'Moderator';

$lang['You_last_visit'] = 'Ostatnio odwiedzi�' .  (($he) ? 'e' : 'a') . '� nas %s';
$lang['Current_time'] = 'Obecny czas to %s';

$lang['Flood_Search'] = 'Nie mo�esz wyszukiwa� tak szybko. Odczekaj kilka sekund i spr�buj ponownie lub od�wie� stron�.';
$lang['Search_your_posts'] = 'Zobacz swoje posty';
$lang['Search_unanswered'] = 'Zobacz posty bez odpowiedzi';

$lang['Register'] = 'Rejestracja';
$lang['Profile'] = 'Profil';
$lang['Edit_profile'] = 'Zmie� sw�j profil';
$lang['Search'] = 'Szukaj';
$lang['Memberlist'] = 'U�ytkownicy';
$lang['FAQ'] = 'FAQ';
$lang['BBCode_guide'] = 'Przewodnik BBCode';
$lang['Usergroups'] = 'Grupy';
$lang['Last_Post'] = 'Ostatni post';
$lang['Moderator'] = 'Moderator';
$lang['Moderators'] = 'Moderatorzy';


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = 'Nasi u�ytkownicy napisali <b>0</b> post�w';
$lang['Posted_articles_total'] = 'Nasi u�ytkownicy napisali <b>%d</b> post�w';
$lang['Posted_article_total'] = 'Nasi u�ytkownicy napisali <b>%d</b> wiadomo��';
$lang['Registered_users_zero_total'] = 'Mamy <b>0</b> zarejestrowanych u�ytkownik�w';
$lang['Registered_users_total'] = 'Mamy <b>%d</b> zarejestrowanych u�ytkownik�w';
$lang['Registered_user_total'] = 'Mamy <b>%d</b> zarejestrowanego u�ytkownika';
$lang['Newest_user'] = 'Ostatnio zarejestrowana osoba: <b>%s%s%s</b>';

$lang['No_new_posts'] = 'Brak nowych post�w';
$lang['New_posts'] = 'Nowe posty';
$lang['New_post'] = 'Nowy post';
$lang['No_new_posts_hot'] = 'Brak nowych post�w [ Popularny ]';
$lang['New_posts_hot'] = 'Nowe posty [ Popularny ]';
$lang['No_new_posts_locked'] = 'Brak nowych post�w [ Zablokowany ]';
$lang['New_posts_locked'] = 'Nowe posty [ Zablokowany ]';
$lang['Forum_is_locked'] = 'Forum Zablokowane';


//
// Login
//
$lang['Login'] = 'Zaloguj';
$lang['Logout'] = 'Wyloguj';

$lang['Forgotten_password'] = 'Zapomnia�em has�a';

$lang['Log_me_in'] = 'Zaloguj mnie automatycznie przy ka�dej wizycie';


//
// Index page
//
$lang['No_Posts'] = 'Brak Post�w';
$lang['No_forums'] = 'Brak For�w';

$lang['Private_Message'] = 'Prywatna Wiadomo��';
$lang['Private_Messages'] = 'Prywatne Wiadomo�ci';
$lang['Who_is_Online'] = 'Kto jest na Forum';

$lang['Mark_all_forums'] = 'Oznacz wszystkie fora jako przeczytane';
$lang['Forums_marked_read'] = 'Wszystkie fora oznaczono jako przeczytane';


//
// Viewforum
//
$lang['View_forum'] = 'Zobacz Forum';

$lang['Forum_not_exist'] = 'Wybrane przez Ciebie forum nie istnieje';

$lang['Display_topics'] = 'Wy�wietl tematy z ostatnich';

$lang['Topic_Announcement'] = '<b>Og�oszenie:</b>';
$lang['Topic_Sticky'] = '<b>Przyklejony:</b>';
$lang['Topic_Moved'] = '<b>Przesuni�ty:</b>';
$lang['Topic_Poll'] = '<b>[ Ankieta ]</b>';

$lang['Mark_all_topics'] = 'Oznacz wszystkie tematy jako przeczytane';
$lang['Topics_marked_read'] = 'Tematy na tym forum zosta�y oznaczone jako przeczytane';

$lang['Rules_post_can'] = '<b>Mo�esz</b> pisa� nowe tematy';
$lang['Rules_post_cannot'] = '<b>Nie mo�esz</b> pisa� nowych temat�w';
$lang['Rules_reply_can'] = '<b>Mo�esz</b> odpowiada� w tematach';
$lang['Rules_reply_cannot'] = '<b>Nie mo�esz</b> odpowiada� w tematach';
$lang['Rules_edit_can'] = '<b>Mo�esz</b> zmienia� swoje posty';
$lang['Rules_edit_cannot'] = '<b>Nie mo�esz</b> zmienia� swoich post�w';
$lang['Rules_delete_can'] = '<b>Mo�esz</b> usuwa� swoje posty';
$lang['Rules_delete_cannot'] = '<b>Nie mo�esz</b> usuwa� swoich post�w';
$lang['Rules_vote_can'] = '<b>Mo�esz</b> g�osowa� w ankietach';
$lang['Rules_vote_cannot'] = '<b>Nie mo�esz</b> g�osowa� w ankietach';
$lang['Rules_moderate'] = '<b>Mo�esz</b> %smoderowa� to forum%s';

$lang['No_topics_post_one'] = 'Nie ma �adnych post�w na tym forum<br />Kliknij na przycisk <b>Nowy Temat</b> aby co� napisa�';
$lang['No_topics_post_one_ignore'] = 'Nie ma wi�cej temat�w kt�rych nie ignorujesz na tym forum, kliknij link "Poka� ignorowane tematy" aby zobaczy� wszystkie tematy';

//
// Viewtopic
//
$lang['View_topic'] = 'Zobacz temat';

$lang['Guest'] = 'Go��';
$lang['Post_subject'] = 'Temat postu';
$lang['View_next_topic'] = 'Nast�pny temat';
$lang['View_previous_topic'] = 'Poprzedni temat';
$lang['Submit_vote'] = 'Wy�lij G�os';
$lang['View_results'] = 'Zobacz Wyniki';

$lang['No_newer_topics'] = 'Nie ma nowszych temat�w na tym forum';
$lang['No_older_topics'] = 'Nie ma starszych temat�w na tym forum';
$lang['No_posts_topic'] = 'Nie istniej� �adne posty dla tego tematu';

$lang['Display_posts'] = 'Wy�wietl posty z ostatnich';
$lang['All_Posts'] = 'Wszystkie Posty';
$lang['Newest_First'] = 'Najpierw Nowsze';
$lang['Oldest_First'] = 'Najpierw Starsze';

$lang['Back_to_top'] = 'Powr�t do g�ry';

$lang['Read_profile'] = 'Zobacz profil autora';
$lang['Visit_website'] = 'Odwied� stron� autora';
$lang['Edit_delete_post'] = 'Zmie�/Usu� ten post';
$lang['View_IP'] = 'Zobacz IP autora';
$lang['Delete_post'] = 'Usu� ten post';

$lang['wrote'] = 'napisa�/a';
$lang['Quote'] = 'Cytat';
$lang['Code'] = 'Kod';

$lang['Edited_time_total'] = 'Ostatnio zmieniony przez %s %s, w ca�o�ci zmieniany %d raz';
$lang['Edited_times_total'] = 'Ostatnio zmieniony przez %s %s, w ca�o�ci zmieniany %d razy';

$lang['Lock_topic'] = 'Zablokuj ten temat';
$lang['Unlock_topic'] = 'Odblokuj ten temat';
$lang['Move_topic'] = 'Przesu� ten temat';
$lang['Delete_topic'] = 'Usu� ten temat';
$lang['Split_topic'] = 'Podziel ten temat';

$lang['Stop_watching_topic'] = 'Przesta� �ledzi� ten temat';
$lang['Start_watching_topic'] = '�led� odpowiedzi w tym temacie';
$lang['No_longer_watching'] = 'Przesta�' .  (($he) ? 'e' : 'a') . '� �ledzi� ten temat';
$lang['You_are_watching'] = 'Rozpocz' .  (($he) ? '��e' : '�a') . '� �ledzenie tego tematu';

$lang['Total_votes'] = 'Wszystkich G�os�w';

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = 'Tre�� wiadomo�ci';
$lang['Topic_review'] = 'Przegl�d tematu';

$lang['No_post_mode'] = 'Nie okre�lono typu postu';

$lang['Post_a_new_topic'] = 'Napisz nowy temat';
$lang['Post_a_reply'] = 'Napisz odpowied�';
$lang['Post_topic_as'] = 'Napisz temat jako';
$lang['Edit_Post'] = 'Zmie� post';
$lang['Options'] = 'Opcje';

$lang['Post_Announcement'] = 'Og�oszenie';
$lang['Post_Sticky'] = 'Przyklejony';
$lang['Post_Normal'] = 'Normalny';

$lang['Confirm_delete'] = 'Czy na pewno chcesz usun�� ten post?';
$lang['Confirm_delete_poll'] = 'Czy na pewno chcesz usun�� t� ankiet�?';

$lang['Flood_Error'] = 'Nie mo�esz wys�a� nowego postu tak szybko po poprzednim, zaczekaj chwil� i spr�buj ponownie';
$lang['Empty_subject'] = 'Musisz wpisa� temat je�li wysy�asz nowy w�tek';
$lang['Empty_message'] = 'Musisz wpisa� wiadomo�� przed wys�aniem';
$lang['Forum_locked'] = 'To forum jest zablokowane, nie mo�esz pisa� dodawa� ani zmienia� na nim czegokolwiek';
$lang['Topic_locked'] = 'Ten temat jest zablokowany bez mo�liwo�ci zmiany post�w lub pisania odpowiedzi';
$lang['No_topic_id'] = 'Musisz wybra� temat do wys�ania odpowiedzi';
$lang['No_valid_mode'] = 'Mo�esz jedynie pisa� nowe, odpowiada�, zmienia� lub cytowa� wiadomo�ci, wr�� i spr�buj ponownie';
$lang['No_such_post'] = 'Taki post lub temat nie istnieje, by� mo�e zosta� przed chwil� usuni�ty, wr�� i spr�buj ponownie';
$lang['Edit_own_posts'] = 'Mo�esz zmienia� jedynie swoje posty';
$lang['Delete_own_posts'] = 'Mo�esz usuwa� jedynie swoje posty';
$lang['Cannot_delete_replied'] = 'Nie mo�esz usuwa� post�w, na kt�re jest odpowied�';
$lang['Cannot_delete_poll'] = 'Nie mo�esz usun�� aktywnej ankiety';
$lang['Empty_poll_title'] = 'Musisz wpisa� tytu� dla ankiety';
$lang['To_few_poll_options'] = 'Musisz wpisa� przynajmniej dwie opcje ankiety';
$lang['To_many_poll_options'] = 'Poda�' .  (($he) ? 'e' : 'a') . '� zbyt wiele opcji dla ankiety';
$lang['Already_voted'] = 'Odda�' .  (($he) ? 'e' : 'a') . '� ju� g�os w tej ankiecie';
$lang['No_vote_option'] = 'Musisz wybra� opcj� podczas g�osowania';

$lang['Add_poll'] = 'Dodaj Ankiet�';
$lang['Add_poll_explain'] = 'Je�eli nie chcesz dodawa� ankiety do tego tematu, pozostaw pola puste';
$lang['Poll_question'] = 'Pytanie do ankiety';
$lang['Poll_option'] = 'Opcja ankiety';
$lang['Add_option'] = 'Dodaj opcj�';
$lang['Update'] = 'Aktualizuj';
$lang['Delete'] = 'Usu�';
$lang['Poll_for'] = 'Czas trwania';
$lang['Days'] = 'Dni';
$lang['Poll_for_explain'] = '[ Wpisz 0 lub pozostaw puste dla nieko�cz�cej si� ankiety ]';
$lang['Delete_poll'] = 'Usu� Ankiet�';

$lang['Disable_HTML_post'] = 'Wy��cz HTML w tym po�cie';
$lang['Disable_BBCode_post'] = 'Wy��cz BBCode w tym po�cie';
$lang['Disable_Smilies_post'] = 'Wy��cz U�mieszki w tym po�cie';

$lang['HTML_is_ON'] = 'HTML: <u>TAK</u>';
$lang['HTML_is_OFF'] = 'HTML: <u>NIE</u>';
$lang['BBCode_is_ON'] = '%sBBCode%s: <u>TAK</u>';
$lang['BBCode_is_OFF'] = '%sBBCode%s: <u>NIE</u>';
$lang['Smilies_are_ON'] = 'U�mieszki: <u>TAK</u>';
$lang['Smilies_are_OFF'] = 'U�mieszki: <u>NIE</u>';

$lang['Attach_signature'] = 'Dodaj podpis (mo�e by� zmieniony w profilu)';
$lang['Notify'] = 'Powiadom mnie gdy kto� odpowie';

$lang['Stored'] = 'Wiadomo�� zosta�a zapisana';
$lang['Deleted'] = 'Wiadomo�� zosta�a usuni�ta';
$lang['Poll_delete'] = 'Ankieta zosta�a usuni�ta';
$lang['Vote_cast'] = 'Tw�j g�os zosta� zapisany';

$lang['Topic_reply_notification'] = 'Powiadomienie o Odpowiedzi';

$lang['bbcode_b_help'] = 'Tekst pogrubiony: [b]tekst[/b] Rada: zaznacz tekst i kliknij';
$lang['bbcode_i_help'] = 'Tekst kursyw�: [i]tekst[/i] Rada: zaznacz tekst i kliknij';
$lang['bbcode_u_help'] = 'Tekst podkre�lony: [u]tekst[/u] Rada: zaznacz tekst i kliknij';
$lang['bbcode_q_help'] = 'Cytat: [quote]tekst[/quote] Rada: zaznacz tekst i kliknij';
$lang['bbcode_c_help'] = 'Poka� kod: [code]kod[/code] Rada: zaznacz tekst i kliknij';
$lang['bbcode_l_help'] = 'Lista: [list]tekst[/list] Rada: zaznacz tekst i kliknij';
$lang['bbcode_o_help'] = 'Lista uporz�dkowana: [list=]tekst[/list] Rada: zaznacz tekst i kliknij';
$lang['bbcode_p_help'] = 'Wstaw obrazek: [img]http://adres_obrazka[/img] Rada: Kliknij i wpisz adres';
$lang['bbcode_w_help'] = '[url]http://adres[/url] Rada: Kliknij wpisz nazw� i adres';
$lang['bbcode_a_help'] = 'Zamknij wszystkie otwarte tagi bbCode';
$lang['bbcode_s_help'] = 'Kolor czcionki: [color=red]tekst[/color] Rada: zaznacz tekst i wybierz kolor';
$lang['bbcode_f_help'] = 'Rozmiar czcionki: [size=x-small]ma�y tekst[/size] Rada: zaznacz tekst i wybierz rozmiar';

$lang['Emoticons'] = 'Ikony Emocji';
$lang['More_emoticons'] = 'Wi�cej Ikon';

$lang['Font_color'] = 'Kolor';
$lang['color_default'] = 'Domy�lny';
$lang['color_dark_red'] = 'Ciemnoczerwony';
$lang['color_red'] = 'Czerwony';
$lang['color_orange'] = 'Pomara�czowy';
$lang['color_brown'] = 'Br�zowy';
$lang['color_yellow'] = '��ty';
$lang['color_green'] = 'Zielony';
$lang['color_olive'] = 'Oliwkowy';
$lang['color_cyan'] = 'B��kitny';
$lang['color_blue'] = 'Niebieski';
$lang['color_dark_blue'] = 'Ciemnoniebieski';
$lang['color_indigo'] = 'Purpurowy';
$lang['color_violet'] = 'Fioletowy';
$lang['color_white'] = 'Bia�y';
$lang['color_black'] = 'Czarny';

$lang['Font_size'] = 'Rozmiar';
$lang['font_tiny'] = 'Minimalny';
$lang['font_small'] = 'Ma�y';
$lang['font_normal'] = 'Normalny';
$lang['font_large'] = 'Du�y';
$lang['font_huge'] = 'Ogromny';

$lang['Close_Tags'] = 'Zamknij Tagi';
$lang['Styles_tip'] = 'Rada: Style mog� by� stosowane szybko do zaznaczonego tekstu';


//
// Private Messaging
//
$lang['Private_Messaging'] = 'Prywatne Wiadomo�ci';

$lang['Login_check_pm'] = 'Zaloguj&nbsp;si�,&nbsp;by&nbsp;sprawdzi�&nbsp;wiadomo�ci';
$lang['New_pms'] = 'Masz %d <span class=\'pm\'>*<b>nowe</b>*</span> wiadomo�ci';
$lang['New_pm'] = 'Masz %d <span class=\'pm\'>*<b>now�</b>*</span> wiadomo��';
$lang['No_new_pm'] = 'Nie&nbsp;masz&nbsp;wiadomo�ci';
$lang['Unread_pms'] = 'Masz %d nieprzeczytanych wiadomo�ci';
$lang['Unread_pm'] = 'Masz %d nieprzeczytan� wiadomo��';
$lang['No_unread_pm'] = 'Nie masz nieprzeczytanych wiadomo�ci';
$lang['You_new_pm'] = 'Nowa prywatna wiadomo�� czeka na Ciebie w Skrzynce';
$lang['You_new_pms'] = 'Nowe prywatne wiadomo�ci czekaj� na Ciebie w Skrzynce';
$lang['You_no_new_pm'] = 'Nie ma dla Ciebie �adnych nowych prywatnych wiadomo�ci';
$lang['Unread_message'] = 'Nowa wiadomo��';
$lang['Read_message'] = 'Przeczytana wiadomo��';

$lang['Read_pm'] = 'Odczytaj wiadomo��';
$lang['Post_new_pm'] = 'Napisz wiadomo��';
$lang['Post_reply_pm'] = 'Odpowiedz na post';
$lang['Post_quote_pm'] = 'Cytuj wiadomo��';
$lang['Edit_pm'] = 'Zmie� wiadomo��';

$lang['Inbox'] = 'Skrzynka';
$lang['Outbox'] = 'Do Wys�ania';
$lang['Savebox'] = 'Zapisane';
$lang['Sentbox'] = 'Wys�ane';
$lang['Flag'] = 'Flaga';
$lang['Subject'] = 'Temat';
$lang['From'] = 'Od';
$lang['To'] = 'Do';
$lang['Date'] = 'Data';
$lang['Mark'] = 'Zaznacz';
$lang['Sent'] = 'Wys�ana';
$lang['Saved'] = 'Zapisana';
$lang['Delete_marked'] = 'Usu� Zaznaczone';
$lang['Delete_all'] = 'Usu� Wszystkie';
$lang['Save_marked'] = 'Zapisz Zaznaczone';
$lang['Save_message'] = 'Zapisz Wiadomo��';
$lang['Delete_message'] = 'Usu� Wiadomo��';

$lang['Display_messages'] = 'Wy�wietl wiadomo�ci z ostatnich';
$lang['All_Messages'] = 'Wszystkie Wiadomo�ci';

$lang['No_messages_folder'] = 'Nie masz wiadomo�ci w tym folderze';

$lang['PM_disabled'] = 'Prywatne Wiadomo�ci zosta�y wy��czone na tym forum';
$lang['Cannot_send_privmsg'] = 'Administrator zabroni� Ci wysy�a� prywatnych wiadomo�ci';
$lang['No_to_user'] = 'Musisz wpisa� nazw� u�ytkownika aby wys�a� t� wiadomo��';

$lang['Disable_HTML_pm'] = 'Wy��cz HTML w tej wiadomo�ci';
$lang['Disable_BBCode_pm'] = 'Wy��cz BBCode w tej wiadomo�ci';
$lang['Disable_Smilies_pm'] = 'Wy��cz U�mieszki w tej wiadomo�ci';

$lang['Message_sent'] = 'Wiadomo�� zosta�a wys�ana';

$lang['Click_return_inbox'] = 'Kliknij %sTutaj%s aby powr�ci� do Skrzynki';
$lang['Click_return_index'] = 'Kliknij %sTutaj%s aby powr�ci� do Strony G��wnej';

$lang['Send_a_new_message'] = 'Wy�lij now� prywatn� wiadomo��';
$lang['Send_a_reply'] = 'Odpowiedz na prywatn� wiadomo��';
$lang['Edit_message'] = 'Zmie� prywatn� wiadomo��';

$lang['Notification_subject'] = 'Nadesz�a nowa Prywatna Wiadomo��';

$lang['Find_username'] = 'Znajd� u�ytkownika';
$lang['Find'] = 'Znajd�';
$lang['No_match'] = 'Nie znaleziono pasuj�cych';

$lang['No_post_id'] = 'Nie wybrano post�w';
$lang['No_such_folder'] = 'Nie istnieje taki folder';

$lang['Mark_all'] = 'Zaznacz wszystkie';
$lang['Unmark_all'] = 'Odznacz wszystkie';

$lang['Confirm_delete_pm'] = 'Czy na pewno chcesz usun�� t� wiadomo��?';
$lang['Confirm_delete_pms'] = 'Czy na pewno chcesz usun�� te wiadomo�ci?';

$lang['Inbox_size'] = 'Wiadomo�ci w Skrzynce zajmuj� %d%%';
$lang['Sentbox_size'] = 'Wys�ane wiadomo�ci zajmuj� %d%%';
$lang['Savebox_size'] = 'Zapisane wiadomo�ci zajmuj� %d%%';

$lang['Click_view_privmsg'] = 'Kliknij %sTutaj%s aby odwiedzi� twoj� Skrzynk�';


//
// Profiles/Registration
//

$lang['Preferences'] = 'Preferencje';

$lang['Website'] = 'Strona WWW';
$lang['Location'] = 'Sk�d';
$lang['Email_address'] = 'Adres email';
$lang['Send_private_message'] = 'Wy�lij prywatn� wiadomo��';
$lang['Interests'] = 'Zainteresowania';
$lang['Poster_rank'] = 'Ranga';

$lang['Total_posts'] = 'Post�w';
$lang['User_post_pct_stats'] = '%d%% z ca�o�ci';
$lang['User_post_day_stats'] = '%.2f post�w dziennie';
$lang['Search_user_posts'] = 'Znajd� wszystkie posty %s';

$lang['No_user_id_specified'] = 'Wybrany u�ytkownik nie istnieje';

$lang['Date_format'] = 'Format Daty';

$lang['Confirm_password'] = 'Potwierd� Has�o';

$lang['Avatar'] = 'Avatar';

$lang['No_user_specified'] = 'Nie okre�lono �adnego u�ytkownika';
$lang['Flood_email_limit'] = 'Nie mo�esz teraz wys�a� kolejnego email\'a. Spr�buj ponownie za jaki� czas.';
$lang['Email_sent'] = 'Email zosta� wys�any';
$lang['Send_email'] = 'Wy�lij email';
$lang['Empty_subject_email'] = 'Musisz okre�li� temat dla email\'a';
$lang['Empty_message_email'] = 'Musisz wpisa� wiadomo�� do wys�ania';

//
// Memberslist
//
$lang['Select_sort_method'] = 'Metoda sortowania';
$lang['Sort'] = 'Sortuj';
$lang['Sort_Top_Ten'] = '10 najaktywniejszych';
$lang['Sort_Joined'] = 'Data przy��czenia';
$lang['Sort_Username'] = 'Nazwa u�ytkownika';
$lang['Sort_Ascending'] = 'Rosn�co';
$lang['Sort_Descending'] = 'Malej�co';

//
// Group control panel
//
$lang['Group_Control_Panel'] = 'Panel Kontrolny Grupy';
$lang['Group_member_details'] = 'Cz�onkostwo w Grupach';

$lang['Group_Information'] = 'Informacje o Grupie';
$lang['Group_name'] = 'Nazwa Grupy';
$lang['Group_description'] = 'Opis Grupy';
$lang['Group_membership'] = 'Twoje cz�onkostwo';
$lang['Group_Members'] = 'Cz�onkowie Grupy';
$lang['Group_Moderator'] = 'Moderator Grupy';
$lang['Pending_members'] = 'Cz�onkowie Oczekuj�cy';

$lang['Group_type'] = 'Typ grupy';
$lang['Group_open'] = 'Grupa otwarta';
$lang['Group_closed'] = 'Grupa zamkni�ta';
$lang['Group_hidden'] = 'Grupa ukryta';

$lang['Memberships_pending'] = 'Oczekujesz na przyj�cie';

$lang['No_groups_exist'] = '�adna Grupa nie Istnieje';
$lang['Group_not_exist'] = 'Taka grupa nie istnieje';

$lang['Join_group'] = 'Do��cz';
$lang['No_group_members'] = 'Ta grupa nie ma cz�onk�w';
$lang['Group_hidden_members'] = 'Ta grupa jest ukryta, nie mo�esz zobaczy� listy jej cz�onk�w';
$lang['Group_joined'] = 'Zosta�' .  (($he) ? 'e' : 'a') . '� do��czony do tej grupy<br />Zostaniesz powiadomionu kiedy Twoje cz�onkostwo zostanie zaakceptowane przez moderatora';
$lang['Group_request'] = 'Pro�ba o przy��czenie do grupy %s';
$lang['Group_added'] = 'Zosta�' .  (($he) ? 'e' : 'a') . '� dodany do grupy %s';
$lang['Already_member_group'] = 'Jeste� ju� cz�onkiem tej grupy';
$lang['User_is_member_group'] = 'U�ytkownik jest ju� cz�onkiem tej grupy';
$lang['Group_type_updated'] = 'Zaktualizowano typ grupy';

$lang['Could_not_anon_user'] = 'Anonimowy nie mo�e by� cz�onkiem grupy';

$lang['Confirm_unsub'] = 'Czy na pewno chcesz opu�ci� t� grup�?';
$lang['Confirm_unsub_pending'] = 'Twoje cz�onkostwo w tej grupie nie zosta�o jeszcze zaakceptowane, czy na pewno chcesz je zako�czy�?';

$lang['Unsub_success'] = 'Przesta�' .  (($he) ? 'e' : 'a') . '� by� cz�onkiem tej grupy.';

$lang['Approve_selected'] = 'Zaakceptuj Wybrane';
$lang['Deny_selected'] = 'Odrzu� Wybrane';
$lang['Remove_selected'] = 'Usu� Wybrane';
$lang['Add_member'] = 'Dodaj Cz�onka';
$lang['Not_group_moderator'] = 'Nie jeste� moderatorem tej grupy i nie mo�esz wykona� tego dzia�ania.';

$lang['Login_to_join'] = 'Zaloguj si� aby do��czy� do grupy lub zarz�dza� jej cz�onkostwem';
$lang['This_open_group'] = 'To jest grupa otwarta, kliknij aby poprosi� o cz�onkostwo';
$lang['Member_this_group'] = 'Jeste� cz�onkiem tej grupy';
$lang['Pending_this_group'] = 'Twoje cz�onkowstwo w tej grupie czeka na akceptacj�';
$lang['Are_group_moderator'] = 'Jeste� moderatorem tej grupy';
$lang['None'] = 'Brak';
$lang['Unsubscribe'] = 'Opu��';
$lang['View_Information'] = 'Zobacz Informacje';


//
// Search
//
$lang['Search_query'] = 'Poszukiwane Zapytanie';
$lang['Search_options'] = 'Opcje Wyszukiwania';

$lang['Search_keywords'] = 'Szukaj S��w Kluczowych';
$lang['Search_keywords_explain'] = 'Mo�esz u�ywa� <u>AND</u> aby okre�la�, kt�re s�owa musz� znale�� si� w wynikach, <u>OR</u> dla tych, kt�re mog� si� tam znale�� i <u>NOT</u> dla tych, kt�re nie mog� wyst�pi�. Znak * zast�puje dowolny ci�g znak�w.<br />�eby wyszuka� wyra�enie, wpisz je pomi�dzy <b>"</b>cudzys�owami<b>"</b><br />Nie b�d� znalezione znaki specjalne, za wyj�tkiem: <b>@ . - _</b>';
$lang['Search_author'] = 'Szukaj Autora';
$lang['Search_author_explain'] = 'U�yj * jako zamiennika dowolnego ci�gu znak�w';

$lang['Search_for_any'] = 'Szukaj kt�regokolwiek s�owa lub wyra�enia';
$lang['Search_for_all'] = 'Szukaj wszystkich s��w';
$lang['Search_title_msg'] = 'Przeszukaj tytu�, opis i tekst wiadomo�ci';
$lang['Search_msg_only'] = 'Przeszukaj tylko tekst wiadomo�ci';
$lang['Search_title_only'] = 'Przeszukaj tylko tytu� wiadomo�ci';
$lang['Search_title_e_only'] = 'Przeszukaj tylko opis tematu';

$lang['Return_first'] = 'Poka� pierwsze';
$lang['characters_posts'] = 'znak�w z postu';

$lang['Search_previous'] = 'Przeszukaj ostanie';

$lang['Sort_by'] = 'Sortuj wed�ug';
$lang['Sort_Time'] = 'Czas wys�ania';
$lang['Sort_Topic_Title'] = 'Tytu� tematu';

$lang['Display_results'] = 'Poka� wyniki jako';
$lang['All_available'] = 'Wszystkie dost�pne';
$lang['No_searchable_forums'] = 'Nie masz uprawnie� do przeszukiwania kt�regokolwiek forum na tej stronie';

$lang['No_search_match'] = 'Nie znaleziono temat�w ani post�w pasuj�cych do Twoich kryteri�w';
$lang['Found_search_match'] = 'Znaleziono %d wynik';
$lang['Found_search_matches'] = 'Znalezionych wynik�w: %d';

$lang['Close_window'] = 'Zamknij Okno';


//
// Auth related entries
//
// Note the %s will be replaced with one of the following \'user\' arrays
$lang['Sorry_auth_announce'] = 'Tylko %s mog� pisa� og�oszenia na tym forum.';
$lang['Sorry_auth_sticky'] = 'Tylko %s mog� pisa� tematy przyklejone na tym forum.';
$lang['Sorry_auth_read'] = 'Tylko %s mog� czyta� tematy na tym forum.';
$lang['Sorry_auth_delete'] = 'Tylko %s mog� usuwa� posty na tym forum.';
$lang['Sorry_auth_post'] = 'Tylko %s mog� pisa� nowe tematy na tym forum.'; 
$lang['Sorry_auth_reply'] = 'Tylko %s mog� odpowiada� w tematach na tym forum.';
$lang['Sorry_auth_edit'] = 'Tylko %s mog� edytowa� posty na tym forum.'; 
$lang['Sorry_auth_vote'] = 'Tylko %s mog� g�osowa� w ankietach na tym forum.';

// These replace the %s in the above strings
$lang['Auth_Anonymous_users']  = '<b>niezalogowani u�ytkownicy</b>';
$lang['Auth_Registered_Users'] = '<b>zarejestrowani u�ytkownicy</b>';
$lang['Auth_Users_granted_access'] = '<b>u�ytkownicy z uprawnieniami dost�pu</b>';
$lang['Auth_Moderators'] = '<b>moderatorzy</b>';
$lang['Auth_Administrators'] = '<b>administratorzy</b>';

$lang['Not_Authorised'] = 'Nie posiadasz uprawnie�';

$lang['You_been_banned'] = 'Zosta�' .  (($he) ? 'e' : 'a') . '� wyrzucon' .  (($he) ? 'y' : 'a') . ' z tego forum<br />Skontaktuj si� z webmasterem lub administratorem forum je�eli chcesz wyja�ni� t� sytuacj�.';


//
// Viewonline
//
$lang['Reg_users_zero_online'] = 'Na Forum jest 0 Zarejestrowanych i ';
$lang['Reg_users_online'] = 'Na forum jest %d Zarejestrowanych i ';
$lang['Reg_user_online'] = 'Na forum jest %d Zarejestrowany u�ytkownik i ';
$lang['Hidden_users_zero_online'] = '0 Ukrytych u�ytkownik�w';
$lang['Hidden_users_online'] = '%d Ukrytych u�ytkownik�w';
$lang['Hidden_user_online'] = '%d Ukryty u�ytkownik';
$lang['Guest_users_zero_online'] = 'Na Forum jest 0 Go�ci';
$lang['Guest_users_online'] = 'Na Forum jest %d Go�ci';
$lang['Guest_user_online'] = 'Na Forum jest %d Go��';
$lang['No_users_browsing'] = 'Obecnie nie ma �adnych u�ytkownik�w na tym forum';

$lang['Online_explain'] = '';

$lang['Forum_Location'] = 'Lokalizacja';
$lang['Last_updated'] = 'Na forum';

$lang['Forum_index'] = 'Strona G��wna';
$lang['Logging_on'] = 'Loguje si�';
$lang['Posting_message'] = 'Pisze wiadomo��';
$lang['Searching_forums'] = 'Przeszukuje fora';
$lang['Viewing_profile'] = 'Ogl�da profil';
$lang['Viewing_online'] = 'Przegl�da list� obecnych na forum';
$lang['Viewing_member_list'] = 'Ogl�da list� u�ytkownik�w';
$lang['Viewing_priv_msgs'] = 'Ogl�da Prywatne Wiadomo�ci';
$lang['Viewing_FAQ'] = 'Ogl�da FAQ';


//
// Moderator Control Panel
//

$lang['Select'] = 'Wybierz';
$lang['Move'] = 'Przenie�';
$lang['Lock'] = 'Zablokuj';
$lang['Unlock'] = 'Odblokuj';
$lang['Topics_Moved'] = 'Wybrane tematy zosta�y przeniesione';

//
// Timezones ... for display on each page
//

$lang['datetime']['Sunday'] = 'Niedziela';
$lang['datetime']['Monday'] = 'Poniedzia�ek';
$lang['datetime']['Tuesday'] = 'Wtorek';
$lang['datetime']['Wednesday'] = '�roda';
$lang['datetime']['Thursday'] = 'Czwartek';
$lang['datetime']['Friday'] = 'Pi�tek';
$lang['datetime']['Saturday'] = 'Sobota';
$lang['datetime']['Sun'] = 'Nie';
$lang['datetime']['Mon'] = 'Pon';
$lang['datetime']['Tue'] = 'Wto';
$lang['datetime']['Wed'] = '�ro';
$lang['datetime']['Thu'] = 'Czw';
$lang['datetime']['Fri'] = 'Pi�';
$lang['datetime']['Sat'] = 'Sob';
$lang['datetime']['January'] = 'Stycze�';
$lang['datetime']['February'] = 'Luty';
$lang['datetime']['March'] = 'Marzec';
$lang['datetime']['April'] = 'Kwiecie�';
$lang['datetime']['May'] = 'Maj';
$lang['datetime']['June'] = 'Czerwiec';
$lang['datetime']['July'] = 'Lipiec';
$lang['datetime']['August'] = 'Sierpie�';
$lang['datetime']['September'] = 'Wrzesie�';
$lang['datetime']['October'] = 'Pa�dziernik';
$lang['datetime']['November'] = 'Listopad';
$lang['datetime']['December'] = 'Grudzie�';
$lang['datetime']['Jan'] = 'Sty';
$lang['datetime']['Feb'] = 'Lut';
$lang['datetime']['Mar'] = 'Mar';
$lang['datetime']['Apr'] = 'Kwi';
$lang['datetime']['May'] = 'Maj';
$lang['datetime']['Jun'] = 'Cze';
$lang['datetime']['Jul'] = 'Lip';
$lang['datetime']['Aug'] = 'Sie';
$lang['datetime']['Sep'] = 'Wrz';
$lang['datetime']['Oct'] = 'Pa�';
$lang['datetime']['Nov'] = 'Lis';
$lang['datetime']['Dec'] = 'Gru';

//
// Errors (not related to a
// specific failure on a page)
//
$lang['Information'] = 'Informacja';
$lang['Critical_Information'] = 'Istotna Informacja';

$lang['General_Error'] = 'B��d Og�lny';
$lang['Critical_Error'] = 'B��d Krytyczny';
$lang['An_error_occured'] = 'Wyst�pi� B��d';
$lang['A_critical_error'] = 'Wyst�pi� Krytyczny B��d';

//
// Modified addons
//

$lang['2_Days'] = '2 Dni';
$lang['3_Days'] = '3 Dni';
$lang['4_Days'] = '4 Dni';
$lang['5_Days'] = '5 Dni';
$lang['6_Days'] = '6 Dni';
$lang['left'] = 'z lewej';
$lang['center'] = 'na �rodku';
$lang['right'] = 'z prawej';
$lang['registered_users'] = 'zarejestrowanych u�ytkownik�w';
$lang['posts'] = 'post�w';
$lang['topics'] = 'temat�w';
$lang['Search_new_unread'] = 'Zobacz posty nieprzeczytane';
$lang['Search_new'] = 'Zobacz posty od ostatniej wizyty';
$lang['visitors_txt'] = 'To forum odwiedzono ju�';
$lang['visitors_txt2'] = 'razy';
$lang['Sticky_topic'] = 'Przyklej ten temat';
$lang['Announce_topic'] = 'Oznacz jako og�oszenie';
$lang['Normal_topic'] = 'Oznacz jako normalny';
$lang['Sticky'] = 'Przyklejony';
$lang['Announce'] = 'Og�oszenie';
$lang['Normalise'] = 'Normalny';
$lang['Mark_topic_unread'] = 'Oznacz temat jako nieczytany';
$lang['Mark_topic_read'] = 'Oznacz temat jako przeczytany';
$lang['Statistics'] = 'Statystyki';
$lang['Comments'] = 'Komentarze';
$lang['Welcome'] = 'Witamy';
$lang['Poll'] = 'Ankieta';
$lang['Vote'] = 'G�osuj';
$lang['bbcode_y_help'] = 'Wy�rodkowanie: [center]tekst[/center] Rada: zaznacz tekst i kliknij';
$lang['bbcode_e_help'] = 'Zanikaj�cy tekst: [fade]text[/fade] Rada: zaznacz tekst i kliknij';
$lang['bbcode_k_help'] = 'Przewijany tekst: [scroll]tekst[/scroll] Rada: zaznacz tekst i kliknij';
$lang['bbcode_s2_help'] = 'Cie�: [shadow=red]text[/shadow] Rada: zaznacz tekst i wybierz kolor';
$lang['bbcode_g_help'] = 'Ogie�: [glow=red]text[/glow] Rada: zaznacz tekst i wybierz kolor';
$lang['bbcode_h_help'] = 'Ukryj: [hide]tekst[/hide] Rada: zaznacz tekst i kliknij';
$lang['Shadow_color'] = 'Cie�';
$lang['Glow_color'] = 'Ogie�';
$lang['write_link_text'] = 'Wpisz tekst kt�ry b�dzie pokazywany jako nazwa linku';
$lang['write_address'] = 'Podaj adres';
$lang['img_address'] = 'Podaj adres do obrazka';
$lang['stream_address'] = 'Podaj adres pliku';
$lang['GG'] = 'Gadu-Gadu u�ytkownika :: %s';
$lang['STAT_GG'] = 'Status Gadu-Gadu u�ytkownika';
$lang['GG_wait'] = 'Wiadomo�� oczekuje w kolejce na odebranie.<br />Zostanie dostarczona gdy adresat w��czy gadu-gadu<br /> lub adresat ma w tej chwili status <b>"niewidoczny"</b> b�d� "tylko dla znajomych".';
$lang['GG_full'] = 'Skrzynka odbiorcza adresata jest pe�na, wiadomo�� nie zosta�a dostarczona.';
$lang['GG_send'] = 'Wiadomo�� zosta�a dostarczona do adresata';
$lang['GG_not_send'] = 'Wiadomo�� nie zosta�a dostarczona, spr�buj jeszcze raz (od�wie� strone).';
$lang['Last_visit'] = 'Ostatnia wizyta';
$lang['Never'] = 'Nigdy';
$lang['Sort_Last_visit'] = 'Data ostatniej aktywno�ci';
$lang['Page_loading_wait'] = '�adowanie strony... prosz� czeka�!';
$lang['Page_loading_stop'] = 'Je�li strona nie chce si� za�adowa� kliknij <span onclick="hideLoadingPage()" style="cursor: pointer">Tutaj<\/span>';
$lang['Quick_Reply'] = 'Szybka odpowied�';
$lang['QuoteSelelected'] = 'Cytowanie selektywne';
$lang['QuoteSelelectedEmpty'] = 'Zaznacz najpierw tekst';
$lang['Quick_Reply_smilies'] = 'Wszystkie emotikony';
$lang['Age'] = 'Wiek';
$lang['Year'] = 'Rok';
$lang['Month'] = 'Miesi�c';
$lang['Day'] = 'Dzie�';
$lang['l_whoisonline'] = 'zobacz szczeg�owo';
$lang['new_topicsss'] = 'Nowych temat�w:';
$lang['new_postsss'] = 'Nowych post�w:';
$lang['unread_topicsss'] = 'Nieczytanych temat�w';
$lang['unread_postsss'] = 'Nieczytanych post�w';
$lang['Board_style'] = 'Styl forum';
$lang['l_level'] = 'Poziom';
$lang['Ignore_list'] = 'Lista ignorowanych';
$lang['Ignore_users'] = 'Ten u�ytkownik jest na twojej li�cie ignorowanych';
$lang['Ignore_add'] = 'Dodaj u�ytkownika do listy ignorowanych';
$lang['Ignore_delete'] = 'Usu� u�ytkownika z listy ignorowanych';
$lang['Ignore_added'] = 'U�ytkownik dodany do listy ignorowanych';
$lang['Ignore_deleted'] = 'U�ytkownik usuni�ty z listy ignorowanych';
$lang['Ignore_submit'] = 'Dodaj do listy ignorowanych';
$lang['Ignore_exists'] = 'U�ytkownik jest ju� na twojej li�cie ignorowanych';
$lang['Click_return_ignore'] = 'Kliknij %sTutaj%s �eby przej�� do swojej listy ignorowanych';
$lang['Ignore_user_warn'] = 'Nie mo�esz si� samemu ignorowa�!';
$lang['Post_user_ignored'] = 'U�ytkownik zosta� dodany do twojej listy <b>ignorowanych</b>.';
$lang['Click_view_ignore'] = 'Kliknij %sTutaj%s �eby zobaczy� jego post.<br />';
$lang['Search_for'] = 'Szukaj w tym dziale';
$lang['cicq'] = 'ICQ';

$lang['Print_View'] = 'Wersja do druku';
$lang['Wrong_reg_key'] = 'Nieprawid�owy kod!';
$lang['Validation'] = 'Uwierzytelnianie';
$lang['Msg_Icon_No_Icon'] = 'Bez';
$lang['messageicon'] = 'Ikona tematu';
$lang['postmsgicon'] = 'Ikona Tematu/Postu';
$lang['Topic_view_users'] = 'Kto przegl�da� temat';
$lang['Topic_time'] = 'Ostatnio ogl�dany';
$lang['Topic_count'] = 'Ogl�dany';
$lang['Topic_global_announcement'] = '<b>Wa�ne og�oszenie:</b>';
$lang['Post_global_announcement'] = 'Wa�ne og�oszenie';
$lang['Forum_not_exist'] = 'Nie znaleziono forum';
$lang['Enter_forum_password'] = 'Podaj has�o dzia�u';
$lang['Incorrect_forum_password'] = 'B��dne has�o';
$lang['Only_alpha_num_chars'] = 'Has�o mo�e zawiera� od 3 do 20 znak�w z zakresu: (A-Z, a-z, 0-9)';
$lang['l_whois'] = 'Whois';
$lang['Staff'] = 'Osoby odpowiedzialne za Forum';
$lang['Admin'] = 'Administrator';
$lang['Junior'] = 'Junior Admin';
$lang['Period'] = 'Na forum od <b>%d</b> dni';
$lang['Topic_bookmark'] = 'Dodaj temat do Ulubionych';
$lang['Day_users'] = 'Przez ostatnie %s godziny byli na forum:';
$lang['last_visitors_more'] = 'Pe�na lista';
$lang['search_keywords_error'] = 'U�y�e� za du�o s��w przy pr�bie szukania. <br>Mo�esz ich wykorzysta� (maksymalnie): <b>%s</b>.';
$lang['hidden_user'] = 'Ukryte';
$lang['post_expire'] = 'Post wyga�nie:';
$lang['topic_expire'] = 'Wyga�nie';
$lang['expire_unlimit'] = 'Bez limitu';
$lang['l_expire_p'] = 'Czas wa�no�ci postu/tematu';
$lang['Tree_width_topic'] = 'Skok drzewa tematu w pixelach';
$lang['l_expire_p_e'] = 'Wybierz, po ilu dniach post ma by� automatycznie usuni�ty. Je�li jest to nowy temat, zostanie usuni�ty w ca�o�ci.';
$lang['expire_e'] = 'Ustaw, po ilu dniach temat ma by� skasowany';
$lang['announce-stick'] = 'Przyklejanie temat�w, oznaczanie jako og�oszenie lub jako globalne og�oszenie';
$lang['Merge_post'] = 'Scalaj posty w tym temacie';
$lang['Merge_posts'] = 'Scalaj wybrane posty';
$lang['post_expire_q'] = 'Wyga�nie za';
$lang['Password_not_complex'] = 'Has�o ';
$lang['Ignore_mini'] = 'Ignoruj';
$lang['pm_mini'] = 'PM';
$lang['aim_mini'] = 'GG';
$lang['quote_mini'] = 'Cytuj';
$lang['edit_mini'] = 'Edytuj';
$lang['mini_reply'] = 'ODPOWIEDZ';
$lang['mini_newtopic'] = 'NOWY TEMAT';
$lang['mini_locked'] = 'ZAMKNI�TY';

$lang['too_long_word'] = 'Za d�ugie s�owo';
$lang['login_to_shoutcast'] = 'Musisz si� zalogowa� �eby wys�a� wiadomo�� lub wysy�anie wiadomo�ci jest mo�liwe tylko dla Administrator�w i Moderator�w';
$lang['sb_banned_send'] = 'Nie mo�esz wysy�a� wiadomo�ci';
$lang['l_alert_sb'] = 'Czy na pewno chcesz usun�� wiadomo��?';
$lang['l_refresh_sb'] = 'Shoutbox otrzyma� 100 pustych odpowiedzi od serwera, aby kontynuowa� naci�nij ten przycisk.';
$lang['sb_restriction'] = 'Shoutbox zosta� wy��czony lub otrzyma�e� bana.';
$lang['l_cancel_sb'] = 'Anuluj';
$lang['l_edit_sb'] = 'Zapisz';
$lang['emotki'] = 'Bu�ki';
$lang['Email_explain'] = 'Je�eli tw�j mail to np. janek@jan.pl to w pierwsze pole wpisz janek, a w drugie jan.pl';

$lang['banned_forum'] = 'Administrator zablokowa� Tobie mo�liwo�� pisania w tym forum';

$lang['edit_time_past'] = 'Nie mo�esz juz zmieni� swojego postu. Post mo�na zmienia� przez <b>%d</b> minut, Od momentu jego wys�ania';
$lang['This_closed_group'] = 'To jest zamkni�ta grupa, %s';
$lang['This_hidden_group'] = 'To jest ukryta grupa, %s';
$lang['No_more'] = 'nowi u�ytkownicy nie b�d� przyjmowani';
$lang['No_add_allowed'] = 'automatyczne przyjmowanie u�ytkownik�w nie jest dozwolone';
$lang['Join_auto'] = 'Mo�esz do��czy� do grupy je�li ilo�� twoich post�w osi�gnie wystarczaj�c� warto��';
$lang['Permissions'] = 'Zezwolenia';
$lang['quote_image'] = 'Obrazek';
$lang['Gender'] = 'P�e�';
$lang['Male'] = 'M�czyzna';
$lang['Female'] = 'Kobieta';
$lang['No_gender_specify'] = 'Nie wiadomo :)';
$lang['not_gg_account'] = 'Brak numeru lub has�a bramki GG. Poinformuj administratora';
$lang['not_gg_addresat'] = 'Brak adresata';
$lang['wrong_gg_addresat'] = 'Z�y format numeru adresata';
$lang['not_gg_msg'] = 'Brak tre�ci wiadomo�ci';
$lang['gg_too_long'] = 'D�ugo�� wiadomo�ci nie mo�e przekracza� 1800 znak�w';
$lang['topic_expire_mod'] = 'Wyga�nie za: ';
$lang['Forum_link_visited'] = 'Odwiedzono %d razy';
$lang['Redirect'] = 'Przeniesienie';
$lang['Never'] = 'Nigdy';
$lang['login_require'] = 'Dost�p do tej cz�ci forum wymaga zalogowania si�.';
$lang['login_require_register'] = 'Je�eli nie jeste� jeszcze zarejestrowany, kliknij %sTutaj%s �eby przej�� do formularza rejestracyjnego.';

$lang['generate_time'] = 'Strona wygenerowana w';
$lang['second'] = 'sekundy';
$lang['seconds'] = 'sekund';
$lang['Warnings'] = 'Ostrze�enia u�ytkownik�w';
$lang['Warnings_viewtopic'] = 'Ostrze�e�';
$lang['warnings_banned_info'] = '<b>Masz zakaz wst�pu na forum !</b><br /><br />Na swoim koncie masz ostrze�e�: <b>%s</b> o ��cznej warto�ci: <b>%s</b>. Warto�� po kt�rej u�ytkownik jest banowany to: <b>%s</b><br /><br />Ostatnie ostrze�enie dosta�' .  (($he) ? 'e' : 'a') . '�: <b>%s</b><br />Pow�d: <i>%s</i>';
$lang['disallow_posting'] = 'Przekroczy�' .  (($he) ? 'e' : 'a') . '� limit ostrze�e�. Nie mo�esz pisa� nowych post�w ani temat�w.<br /><br />Kliknij %sTutaj%s �eby przej�� do strony ostrze�e�.';
$lang['warnings_lastwar_info'] = '<b>Dosta�' .  (($he) ? 'e' : 'a') . '� ostrze�enie !</b><br /><br />Kliknij %sTutaj%s �eby je zobaczy�.<br /><br />Mo�e by� konieczne ponowne zalogowanie.';
$lang['support'] = '<br /><br />Je�li nie potrafisz znale�� rozwi�zania tego problemu,<br />mo�esz spr�bowa� poszuka�, lub zada� pytanie na forum: <a href="http://www.przemo.org/phpBB2/" target="_blank">http://www.przemo.org/phpBB2/</a>';
$lang['poster_posts'] = 'Bra�' .  (($he) ? 'e' : 'a') . '� udzia� w tej dyskusji';
$lang['Sort_per_letter'] = 'Poka� u�ytkownik�w na liter�';
$lang['Others'] = 'inna';
$lang['All'] = 'wszystkich';
$lang['ignore_topic_added'] = 'Wybrany temat/tematy zosta�y dodane do listy ignorowanych.<br />Nie b�dziesz ich widzia�' .  (($he) ? '' : 'a') . ' w li�cie temat�w, oraz w li�cie temat�w nieprzeczytanych (lub "od ostatniej wizyty" w zale�no�ci od ustawie� forum)<br /><br />Kliknij %sTutaj%s �eby zobaczy� swoj� liste ignorowanych temat�w.<br /><br />Kliknij %sTutaj%s �eby wr�ci� na stron� g��wn�.';
$lang['ignore_topic_unignored'] = 'Wybrany temat/tematy zosta�y usuni�te z twojej listy ignorowanych temat�w.<br /><br />Kliknij %sTutaj%s �eby zobaczy� swoj� liste ignorowanych temat�w.<br /><br />Kliknij %sTutaj%s �eby wr�ci� na stron� g��wn�.';
$lang['ignore_mark'] = 'Ignoruj zaznaczone tematy';
$lang['ignore_topics'] = 'Ignorowane tematy';
$lang['list_ignore'] = 'Lista temat�w kt�re ignorujesz';
$lang['list_ignore_e'] = 'Z listy automatycznie s� kasowane tematy w kt�rych nie pojawi�a si� odpowied� przez ostatnie 3 miesi�ce';
$lang['ignore_list_empty'] = 'Nie ignorujesz �adnego tematu.<br /><br />Kliknij %sTutaj%s �eby wr�ci� na stron� g��wn�.';
$lang['ignore_topic'] = 'Ignoruj ten temat';
$lang['current_topic_ignore'] = 'Ignorujesz ten temat';
$lang['bbcode_ct_help'] = 'Kolor tematu, widoczny w widoku temat�w';
$lang['topic_color'] = 'Kolor tematu';
$lang['15_min'] = '15 Minut';
$lang['30_min'] = '30 Minut';
$lang['1_Hour'] = '1 Godziny';
$lang['2_Hour'] = '2 Godzin';
$lang['6_Hour'] = '6 Godzin';
$lang['12_Hour'] = '12 Godzin';
$lang['icons'] = 'Wszystkie ikony postu/tematu';
$lang['your_posts'] = 'twoich post�w';
$lang['replys_last_post'] = 'odpowiedzi od czasu twojego ostatniego postu';
$lang['unread_posts'] = 'post�w nieprzeczytanych';
$lang['not_poster_post'] = 'Nie bra�' .  (($he) ? 'e' : 'a') . '� udzia�u w tej dyskusji';
$lang['lang_q_quote_e'] = 'Po zaznaczeniu cz�ci tekstu kt�ry chcesz cytowa� i klikni�ciu tutaj, tekst wraz ze znacznikami BBCode pojawi si� na dole w szybkiej odpowiedzi. Mo�esz u�y� kilkukrotnie.';
$lang['ignore_topic_submit_e'] = 'Dodaje zaznaczone wy�ej tematy do twojej listy ignorowanych temat�w. Nie b�d� one wy�wietlane w widoku forum, oraz w wynikach wyszukiwania.';
$lang['data'] = 'Administrator forum narusza zasady korzystania ze skryptu forum dyskusyjnego <a href="http://www.przemo.org/phpBB2/">phpBB modified by Przemo</a><br />Forum zosta�o zablokowane !<br /><br />Wi�cej informacji mo�na uzyska� pisz�c na e-mail: przemo@przemo.org';
$lang['more_topicicons'] = 'Masz do wyboru wi�ksz� ilo�� ikon, po klikni�ciu w to pole, otworzy si� okno z dodatkowymi ikonami.';
$lang['online_minutes'] = 'Jest na forum minut: <b>%s</b>';
$lang['online_hours'] = 'Jest na forum godzin: <b>%s</b>';
$lang['Viewing_topic'] = 'Czyta temat';
$lang['gg_header_info_pm'] = 'Otrzyma�' .  (($he) ? 'e' : 'a') . '� now� prywatn� wiadomo�� od: %s';
$lang['gg_notify_topic'] = 'W obserwowanym przez Ciebie temacie: "%s" u�ytkownik: %s napisa� odpowied�';
$lang['l_notify_gg_privmsg'] = 'Link do twojej skrzynki: %s';
$lang['l_notify_gg_topic'] = '�eby zobaczy� temat kliknij: %s';
$lang['generate_queries'] = 'Zapyta� do SQL';
$lang['unread_post'] = 'Nieczytany post';
$lang['refresh'] = 'Od�wie�';
$lang['new_board_topic'] = 'Na forum %s u�ytkownik %s napisa� nowy temat: %s';
$lang['new_board_post'] = 'Na forum %s u�ytkownik %s napisa� odpowied� w temacie: %s';
$lang['Search_post_time'] = 'Wy�wietl posty z ostatnich:</span><br /><span class="gensmall">Wy�wietla posty napisane w ci�gu ostatniego wybranego czasu. Mo�na wybra� metod� wy�wietlania: Posty i Tematy';
$lang['user_not_allowpm'] = 'Nie mo�esz wys�a� prywatnej wiadomo�ci do tego u�ytkownika. U�ytkownik wy��czy� prywatne wiadomo�ci.';
$lang['open_all_new_window'] = 'Otw�rz wszystkie w nowych oknach';

$lang['s_email_friend'] = 'Powiadom znajomego o tym temacie';
$lang['s_email_friend_f_name'] = 'Imi� znajomego:';
$lang['s_email_friend_f_email'] = 'Email znajomego:';
$lang['s_email_friend_title'] = '%s zobacz temat na: %s';
$lang['s_email_friend_message'] = 'Przeczyta�' .  (($he) ? 'e' : 'a') . 'm temat %s na %s i pomy�la�' .  (($he) ? 'e' : 'a') . 'm, �e musisz go zobaczy�! Naprawd� warto! Tutaj jest link: %s';

$lang['mstr'] = 'Automatyczna naprawa tabeli w bazie SQL';
$lang['rrtf'] = "Tabela %s uleg�a uszkodzeniu, pr�ba automatycznej naprawy nie powiod�a si�:\n%s\n%s\nSpr�buj naprawi� tabel� r�cznie wykonuj�c zapytanie: REPAIR TABLE %s";
$lang['rrts'] = "Tabela %s uleg�a uszkodzeniu, pr�ba automatycznej naprawy prawdopodobnie powiod�a si�:\n%s\n Je�li nie, spr�buj wykonac zapytanie r�cznie: REPAIR TABLE %s";
$lang['rrsum'] = 'Wyst�pi� drobny problem techniczny, skrypt dokona� pr�by naprawy i wys�a� powiadomienie do Administratora forum<br />Sprobuj od�wie�y� stron�';

$lang['Report_no_access'] = 'Nie masz mo�liwo�ci u�ywania tej opcji';
$lang['Report_disabled'] = 'Post tego u�ytkownika nie mo�e zosta� zg�oszony';
$lang['Report_post_already_reported'] = 'Ten post zosta� ju� zg�oszony wcze�niej';
$lang['Report_post_self'] = 'Nie mo�esz zg�asza� swoich post�w';
$lang['Report_already_removed'] = 'Ten post zosta� usuni�ty';
$lang['Report_no_posts'] = 'Nie ma zg�oszonych �adnych post�w';
$lang['Report_no_title'] = 'Brak tytu�u';
$lang['Reporter'] = 'Zg�aszaj�cy';
$lang['Report_posts'] = 'Zg�oszone posty';
$lang['Report_popup_text'] = 'Nast�puj�ce posty zosta�y zg�oszone:';
$lang['Report_deleted'] = 'Zg�oszenie usuni�te.';
$lang['Report_post_reported'] = 'Zg�oszenie zosta�o wys�ane. Dzi�kujemy.';
$lang['Report_post'] = 'Zg�o� ten post do Moderatora i Administratora';
$lang['Report_del'] = 'Usu� zg�oszenie';
$lang['Report_no_popup'] = 'Otw�rz popup o zg�oszonych postach';
$lang['Report_no_mail'] = 'Powiadom na e-mail o zg�oszonych postach';
$lang['Report_reload_window'] = 'Od�wie� okno';
$lang['Report_no_auth'] = 'Nie mo�esz zg�osi� post�w, ta funkcja zosta�a Ci odebrana, lub nie jestes zalogowany.';
$lang['Report_open_popup'] = 'Otw�rz popup zg�osze�';
$lang['Report_list'] = 'Lista zg�osze�';
$lang['added'] = 'Dodano';
$lang['Voted_show'] = 'G�osowa�: '; // it means :  users that voted  (the number of voters will follow)
$lang['Results_after'] = 'Wynik b�dzie pokazany po zako�czeniu trwania ankiety';
$lang['Poll_expires'] = 'Zako�czenie ankiety za: ';
$lang['Minutes'] = 'Minut';
$lang['Max_vote'] = 'Maksimum "zaznacze�"';
$lang['Max_vote_explain'] = '[ Wpisz 1 lub pozostaw puste dla jednego "zaznaczenia" ]';
$lang['Max_voting_1_explain'] = 'Wybierz tylko ';
$lang['Max_voting_2_explain'] = ' odpowiedzi';
$lang['Max_voting_3_explain'] = ' (wi�cej odpowiedzi b�dzie ignorowane)';
$lang['Vhide'] = 'Ukryj';
$lang['Hide_vote'] = 'Wynik';
$lang['Tothide_vote'] = 'Sum� g�os�w';
$lang['Hide_vote_explain'] = ' [ Ukrycie do czasu zako�czenia ankiety ]';
$lang['rname'] = 'Szybka rejestracja';

$lang['helped_confirm'] = 'Jeste� ' .  (($he) ? 'autorem' : 'autork�') . ' tego tematu, je�eli ta odpowied� Ci pomog�a, mo�esz doda� jeden punkt "POM�G�" temu u�ytkownikowi<br /><br />Kliknij %sTUTAJ%s aby doda� punkt, lub kliknij %sTUTAJ%s aby anulowa� i powr�ci� do tematu';
$lang['helped_delete_confirm'] = 'Jeste� ' .  (($he) ? 'pewien' : 'pewna') . ' �e chcesz usun�� punkt "POM�G�" dla tego postu ?<br /><br />Kliknij %sTUTAJ%s je�eli chcesz usun�� punkt, lub %sTUTAJ%s aby powr�ci� do tematu';
$lang['helped_added'] = 'Punkt zosta� dodany<br /><br />Kliknij %sTUTAJ%s aby powr�cic do tematu.';
$lang['He_helped'] = 'Je�eli ten post pom�g� Ci, kliknij aby doda� punkt temu u�ytkownikowi';
$lang['He_helped_delete'] = 'Usu� punkt \'pom�g�\' dla tego postu';
$lang['help_1'] = ' raz';
$lang['help_more'] = ' razy';
$lang['postrow_help'] = '<b>Pom�g�:</b> ';
$lang['postrow_help_she'] = '<b>Pomog�a:</b> ';
$lang['helped'] = 'Pom�g�';
$lang['Joined_she'] = 'Do��czy�a';
$lang['that_same_msg'] = 'Nie mo�esz wys�a� dw�ch takich samych wiadomo�ci !';
$lang['Seeker'] = 'Szukaj u�ytkownik�w';
$lang['No_split_post'] = 'Nie ��cz tego postu';
$lang['too_many_voting'] = 'W tej sondzie maksymaln� warto�ci� oddanych g�os�w jest: <b>%s</b>, Ty zaznaczy�' .  (($he) ? 'e' : 'a') . '� <b> %s</b>.<br />G�os nie zosta� oddany, wr�� i zag�osuj jeszcze raz.';
$lang['failed_sending_email'] = 'B�ad wysy�ania email\'a<br />Mo�e zosta� podany z�y adres e-mail, w przeciwnym razie Administrator pownien sprawdzi� przyczyn� lub wy�aczy� wysy�anie email\'i przez forum.';

$lang['Print_topic'] = 'To jest tylko wersja do druku, aby zobaczy� pe�n� wersj� tematu, kliknij TUTAJ';

$lang['notify_message'] = 'Tw�j %s napisany przez Ciebie na: %s, zosta� usuni�ty przez Administratora lub Moderatora%s';
$lang['your_post'] = ' Tw�j post:';
$lang['Reason'] = 'Pow�d';
$lang['subject_notify_delete'] = 'Tw�j %s zosta� usuni�ty';
$lang['topic_link'] = "\n\rLink do tematu: %s";
$lang['forum_service'] = 'Obs�uga forum';
$lang['confirm_report_post'] = 'Czy na pewno chcesz zg�osi� ten post do Moderatora i Administratora?';
$lang['Accept'] = 'Zaakceptuj';
$lang['Reject'] = 'Odrzu�';
$lang['Accept-reject'] = 'Zaakceptuj/Odrzu� wybrane';
$lang['Post_no_approved'] = 'Oczekuje na akceptacj�';
$lang['Loser_protect'] = 'UWAGA! Pr�bujesz odpowiedziec w temacie na <b>%s</b> stronie tematu, temat zawiera stron <b>%s</b>.<br />Przeczytaj ca�y temat aby w nim odpowiedzie�!<br /><br />Kliknij %sTutaj%s aby przej�� do nast�pnej strony tematu.<br />Kliknij %sTutaj%s je�li jeste� przekonanan' .  (($he) ? 'y' : 'a') . ', �e chcesz odpowiedzie� nie czytaj�c ca�ego tematu.';
$lang['User_deleted'] = 'Usuni�ty';
$lang['Account_delete'] = 'Usuni�cie konta na %s';
$lang['User_report_post'] = 'U�ytkownik zg�osi� post';
$lang['Subject_e'] = 'Opis tematu';
$lang['Subject_e_info'] = 'nieobowi�zkowy';
$lang['show_ignore_topics'] = 'Poka� ignorowane tematy';
$lang['footer'] = 'Stopka forum zosta�a zmodyfikowana, forum nie b�dzie dzia�a� prawid�owo!<br />Ustaw prawid�owo stopk� w pliku overall_footer.tpl, musi by� ona widoczna w przegladarce, nie mo�e zawiera� "sztuczek" maskujacych.<br /><br />Wz�r: <b>Powered by &lt;a href=&quot;http://www.phpbb.com&quot; target=&quot;_blank&quot; class=&quot;copyright&quot;&gt;phpBB&lt;/a&gt; modified by &lt;a href=&quot;http://www.przemo.org/phpBB2/&quot; class=&quot;copyright&quot; target=&quot;_blank&quot;&gt;Przemo&lt;/a&gt; &amp;copy; 2003 phpBB Group</b>';
$lang['db_backup_done'] = 'W tym momencie forum rozpocz�o tworzenie kopii zapasowej bazy danych.<br />Prosz� wr�ci� na forum za minut�.';
$lang['Freak_undo'] = 'Ctrl+Z aby cofn��';
$lang['Today'] = 'Dzisiaj';
$lang['Yesterday'] = 'Wczoraj';
$lang['TA_Locked'] = 'Zamkni�ty';
$lang['TA_Unocked'] = 'Otwarty';
$lang['TA_Moved'] = 'Przesuni�ty';
$lang['TA_Expired'] = 'Wygaszony';
$lang['TA_Who'] = 'przez';
$lang['TA_Delete'] = 'Usu� t� informacj�';
$lang['Comment_post'] = 'Dopisz komentarz do postu';
$lang['Comment_added'] = 'Komentarz dodany przez: %s';
$lang['Topic_important'] = 'Warto�� merytoryczna';
$lang['First_post'] = 'Pierwszy post';
$lang['Post_history'] = 'Historia edycji postu';
$lang['Custom_Rank'] = 'Tytu� u�ytkownika';
$lang['Your_topic_moved'] = 'Tw�j temat na %s zosta� przesuni�ty';
$lang['Your_topic_moved_message'] = 'Napisany przez Ciebie temat: "%s" w forum: "%s" zosta� przesuni�ty do forum: "%s" Link do tematu: %s %s';
$lang['Important_topics'] = 'Wa�ne tematy';
$lang['View_next_unread_posts'] = 'Zobacz kolejne nieczytane posty';
$lang['Go'] = 'Id�';
$lang['adv_person'] = 'Zaproszone osoby';
$lang['adv_person_link'] = 'Aby zaprosi� znajomego na to forum, skopiuj ten link: %s';
$lang['Invalid_session'] = 'Sesja po��czenia wygas�a lub numer ID sesji jest nieprawid�owy.<br />Spr�buj ponownie.';
$lang['Not_admin'] = 'Nie posiadasz uprawnie� administratora.';
$lang['Posting_disabled'] = 'Pisanie post�w i temat�w zosta�o wy��czone.';
$lang['Registering_disabled'] = 'Rejestracja zosta�a wy��czona.';
$lang['Pruning_unread_posts'] = 'Twoje konto przekroczy�o maksymaln� ilo�� nieprzeczytanych post�w: <b>%s</b> Zosta�y usuni�te informacje o nieczytanych postach z wyj�tkiem post�w napisanych przez ostatnie: <b>%s</b> dni<br />Ilo�� usuni�tych nieczytanych post�w: <b>%s</b><br /><br />Aby nie otrzymywa� tego komunikatu, przeczytaj oznaczone tematy, lub oznacz wszystkie jako przeczytane.<br />W ka�dej chwili mo�esz skorzysta� z wyszukiwarki post�w aby odszuka� posty napisane w ci�gu ostatniego wybranego czasu.';
//
// That's all Folks!
// -------------------------------------------------

?>