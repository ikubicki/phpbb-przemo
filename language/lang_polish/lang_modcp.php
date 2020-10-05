<?php

$he = ($userdata['user_gender'] != 2) ? true : false;

// Poni¿ej mo¿esz w analogiczny sposób dodaæ inne powody
$lang['del_notify_reasons'] = [];
$lang['del_notify_reasons'][] = 'Bez powodu';
$lang['del_notify_reasons'][] = 'Post nie na temat';
$lang['del_notify_reasons'][] = 'Post sprzeczny z regulaminem';
$lang['del_notify_reasons'][] = 'Post nie wnosz±cy nic do tematu';
$lang['del_notify_reasons'][] = 'Niski poziom intelektualny postu';
//

$lang['confirm_expire_topic'] = 'Czy na pewno chcesz nadaæ tematowi wybrany czas wyga¶niêcia?';
$lang['Click_return_modcp'] = 'Kliknij %sTutaj%s aby powróciæ do Panelu Kontrolnego Moderacji';
$lang['Confirm_delete_topic'] = 'Czy na pewno chcesz usun±æ wybrane tematy?';
$lang['Confirm_move_topic'] = 'Czy na pewno chcesz przenie¶æ wybrane tematy?';
$lang['Confirm_merge_topic'] = 'Czy jeste¶ pew' .  (($he) ? 'ien' : 'na') . ', ¿e chcesz scaliæ wybrany temat/tematy?<br /><span class=genmed>(Nastêpnie wybierzesz docelowy post do scalenia postów ju¿ wybranych)</span>'; 
$lang['Delete_to_trash'] = 'Usuñ do ¦mietnika';
$lang['del_notify_reason'] = 'Wybierz powód usuniêcia postu lub tematu.';
$lang['del_notify_choice'] = 'Nie wysy³aj powiadomienia';
$lang['del_notify'] = 'Powiadomienie u¿ytkownika %s o usuniêciu jego postu lub tematu.';
$lang['del_notify_reason_e'] = 'Wybieraj±c "Bez powodu", u¿ytkownik otrzyma tylko powiadomienie o usuniêciu postu lub tematu.';
$lang['del_notify_reason2'] = 'Wpisz w³asny powód';
$lang['del_notify_reason2_e'] = 'W tym miejscu mo¿esz wpisaæ w³asny powód, powy¿sza lista wyboru bêdzie ignorowana.';
$lang['IP_info'] = 'Informacja o IP';
$lang['Leave_shadow_topic'] = 'Pozostaw odno¶nik na starym forum.';
$lang['Lookup_IP'] = 'IP <-> Host';
$lang['Mod_CP_explain'] = 'Korzystaj±c z poni¿szego formularza mo¿esz przeprowadziæ zbiorow± moderacjê na tym forum. Mo¿esz blokowaæ, odblokowywaæ, przenosiæ i usuwaæ dowoln± ilo¶æ tematów. Je¿eli to forum jest ustawione jako prywatne mo¿esz tak¿e czê¶ciowo decydowaæ, którzy u¿ytkownicy mog± mieæ do niego dostêp.';
$lang['Merge_after'] = 'Scalaj wszystkie od wybranego postu';
$lang['Merge_Topic'] = 'Scalaj temat';
$lang['Merge_Topic_explain'] = 'U¿ywaj±c poni¿szego formularza mo¿esz scaliæ posty w tematy, wybieraæ posty pojedynczo lub scalaæ od wybranego postu';
$lang['Merge_to_forum'] = 'Scalaj do forum';
$lang['Merge_post_topic'] = 'Scalaj posty w temat';
$lang['Move_to_forum'] = 'Przenie¶ do forum';
$lang['Mod_CP'] = 'Panel Kontrolny Moderacji';
$lang['Mod_CP_merge_explain'] = 'Wybierz temat, do którego chcesz scaliæ inne tematy lub posty';
$lang['Merge'] = 'Scalaj';
$lang['No_Topics_Merged'] = '¿aden z tematów nie zosta³ scalony';
$lang['None_selected'] = 'Nie wybra³' .  (($he) ? 'e' : 'a') . '¶ ¿adnych tematów do wykonania tej operacji. Proszê wróæ i wybierz przynajmniej jeden.';
$lang['Not_Moderator'] = 'Nie jeste¶ moderatorem tego forum';
$lang['No_Topics_Moved'] = 'Nie przeniesiono ¿adnego tematu';
$lang['Not_auth_edit_delete_admin'] = 'Nie mo¿esz usuwaæ/edytowaæ postów administratora!.';
$lang['Other_IP_this_user'] = 'Inne IP, z których pisa³ ten u¿ytkownik';
$lang['Posts_Merged'] = 'Wybrane posty zosta³y scalone';
$lang['Resync_page_title'] = 'Synchronizacja forów';
$lang['Split_Topic_explain'] = 'U¿ywaj±c poni¿szego formularza mo¿esz podzieliæ temat na dwa, wybieraj±c posty, które maj± zostaæ wydzielone lub dziel±c od jednego zaznaczonego postu';
$lang['Split_title'] = 'Tytu³ nowego tematu';
$lang['Split_forum'] = 'Forum dla nowego tematu';
$lang['Split_posts'] = 'Wydziel wybrane posty';
$lang['Split_after'] = 'Wydziel od wybranego postu';
$lang['Topic_split'] = 'Wybrany temat zosta³ podzielony';
$lang['Topics_Removed'] = 'Wybrane tematy zosta³y usuniête z bazy danych.';
$lang['Topics_Merged'] = 'Wybrane tematy zosta³y scalone';
$lang['Topic_started'] = 'Temat rozpoczêty';
$lang['Topics_Locked'] = 'Wybrane tematy zosta³y zablokowane';
$lang['Topics_Expired'] = 'Tematowi zosta³ przypisany wybrany czas wyga¶niêcia';
$lang['Topics_Unlocked'] = 'Wybrane tematy zosta³y odblokowane';
$lang['Topics_Stickyd'] = 'Wybrane tematy zosta³y przyklejone';
$lang['Topics_Announced'] = 'Wybrane tematy zosta³y oznaczone jako og³oszenie';
$lang['Topics_Normalised'] = 'Wybrane tematy zosta³y zamienione na normalne';
$lang['This_posts_IP'] = 'IP dla tego postu';
$lang['Users_this_IP'] = 'U¿ytkownicy pisz±cy z tego IP';
$lang['Split_Topic'] = 'Panel Kontrolny Dzielenia Tematów';
$lang['Move_reason'] = 'Powód przesuniêcia tematu';
$lang['Move_reason_e'] = 'Autor tematu zostanie powiadomiony o przesuniêciu jego tematu. Mo¿esz wpisaæ powód który zobaczy w emailu lub prywatnej wiadomo¶ci.';


define('LANG_MODCP', true);
?>
