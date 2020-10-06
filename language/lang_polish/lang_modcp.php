<?php

$he = ($userdata['user_gender'] != 2) ? true : false;

// Poniżej możesz w analogiczny sposób dodać inne powody
$lang['del_notify_reasons'] = [];
$lang['del_notify_reasons'][] = 'Bez powodu';
$lang['del_notify_reasons'][] = 'Post nie na temat';
$lang['del_notify_reasons'][] = 'Post sprzeczny z regulaminem';
$lang['del_notify_reasons'][] = 'Post nie wnoszący nic do tematu';
$lang['del_notify_reasons'][] = 'Niski poziom intelektualny postu';
//

$lang['confirm_expire_topic'] = 'Czy na pewno chcesz nadać tematowi wybrany czas wygaśnięcia?';
$lang['Click_return_modcp'] = 'Kliknij %sTutaj%s aby powrócić do Panelu Kontrolnego Moderacji';
$lang['Confirm_delete_topic'] = 'Czy na pewno chcesz usunąć wybrane tematy?';
$lang['Confirm_move_topic'] = 'Czy na pewno chcesz przenieść wybrane tematy?';
$lang['Confirm_merge_topic'] = 'Czy napewno chcesz scalić wybrany temat/tematy?<br /><span class=genmed>(Następnie wybierzesz docelowy post do scalenia postów już wybranych)</span>'; 
$lang['Delete_to_trash'] = 'Usuń do Śmietnika';
$lang['del_notify_reason'] = 'Wybierz powód usunięcia postu lub tematu.';
$lang['del_notify_choice'] = 'Nie wysyłaj powiadomienia';
$lang['del_notify'] = 'Powiadomienie użytkownika %s o usunięciu jego postu lub tematu.';
$lang['del_notify_reason_e'] = 'Wybierając "Bez powodu", użytkownik otrzyma tylko powiadomienie o usunięciu postu lub tematu.';
$lang['del_notify_reason2'] = 'Wpisz własny powód';
$lang['del_notify_reason2_e'] = 'W tym miejscu możesz wpisać własny powód, powyższa lista wyboru będzie ignorowana.';
$lang['IP_info'] = 'Informacja o IP';
$lang['Leave_shadow_topic'] = 'Pozostaw odnośnik na starym forum.';
$lang['Lookup_IP'] = 'IP <-> Host';
$lang['Mod_CP_explain'] = 'Korzystając z poniższego formularza możesz przeprowadzić zbiorową moderację na tym forum. Możesz blokować, odblokowywać, przenosić i usuwać dowolną ilość tematów. Jeżeli to forum jest ustawione jako prywatne możesz także częściowo decydować, którzy użytkownicy mogą mieć do niego dostęp.';
$lang['Merge_after'] = 'Scalaj wszystkie od wybranego postu';
$lang['Merge_Topic'] = 'Scalaj temat';
$lang['Merge_Topic_explain'] = 'Używając poniższego formularza możesz scalić posty w tematy, wybierać posty pojedynczo lub scalać od wybranego postu';
$lang['Merge_to_forum'] = 'Scalaj do forum';
$lang['Merge_post_topic'] = 'Scalaj posty w temat';
$lang['Move_to_forum'] = 'Przenieś do forum';
$lang['Mod_CP'] = 'Panel Kontrolny Moderacji';
$lang['Mod_CP_merge_explain'] = 'Wybierz temat, do którego chcesz scalić inne tematy lub posty';
$lang['Merge'] = 'Scalaj';
$lang['No_Topics_Merged'] = 'żaden z tematów nie został scalony';
$lang['None_selected'] = 'Nie wybrano żadnych tematów do wykonania tej operacji. Proszę wróć i wybierz przynajmniej jeden.';
$lang['Not_Moderator'] = 'Nie jesteś moderatorem tego forum';
$lang['No_Topics_Moved'] = 'Nie przeniesiono żadnego tematu';
$lang['Not_auth_edit_delete_admin'] = 'Nie możesz usuwać/edytować postów administratora!.';
$lang['Other_IP_this_user'] = 'Inne IP, z których pisał ten użytkownik';
$lang['Posts_Merged'] = 'Wybrane posty zostały scalone';
$lang['Resync_page_title'] = 'Synchronizacja forów';
$lang['Split_Topic_explain'] = 'Używając poniższego formularza możesz podzielić temat na dwa, wybierając posty, które mają zostać wydzielone lub dzieląc od jednego zaznaczonego postu';
$lang['Split_title'] = 'Tytuł nowego tematu';
$lang['Split_forum'] = 'Forum dla nowego tematu';
$lang['Split_posts'] = 'Wydziel wybrane posty';
$lang['Split_after'] = 'Wydziel od wybranego postu';
$lang['Topic_split'] = 'Wybrany temat został podzielony';
$lang['Topics_Removed'] = 'Wybrane tematy zostały usunięte z bazy danych.';
$lang['Topics_Merged'] = 'Wybrane tematy zostały scalone';
$lang['Topic_started'] = 'Temat rozpoczęty';
$lang['Topics_Locked'] = 'Wybrane tematy zostały zablokowane';
$lang['Topics_Expired'] = 'Tematowi został przypisany wybrany czas wygaśnięcia';
$lang['Topics_Unlocked'] = 'Wybrane tematy zostały odblokowane';
$lang['Topics_Stickyd'] = 'Wybrane tematy zostały przyklejone';
$lang['Topics_Announced'] = 'Wybrane tematy zostały oznaczone jako ogłoszenie';
$lang['Topics_Normalised'] = 'Wybrane tematy zostały zamienione na normalne';
$lang['This_posts_IP'] = 'IP dla tego postu';
$lang['Users_this_IP'] = 'Użytkownicy piszący z tego IP';
$lang['Split_Topic'] = 'Panel Kontrolny Dzielenia Tematów';
$lang['Move_reason'] = 'Powód przesunięcia tematu';
$lang['Move_reason_e'] = 'Autor tematu zostanie powiadomiony o przesunięciu jego tematu. Możesz wpisać powód który zobaczy w emailu lub prywatnej wiadomości.';

define('LANG_MODCP', true);