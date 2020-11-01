<?php
/***************************************************************************
 *                      lang_pcount_resync.php [Polish]
 *                      -------------------
 *     begin            : Fri Sep 06 2002
 *     copyright        : (C) 2002 Adam Alkins
 *     email            : phpbb@rasadam.com
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

$lang['Resync_page_desc_simple'] = 'W wielu przypadkach licznik postów użytkowników nie odzwierciedla prawdziwej ilości postów którą użytkownik ma na forum. Podczas kasowania tematu, postu licznik postów użytkowników jest zmniejszany. Jednak w przypadku gdy kasujemy całe forum, lub forum ma ustawione czyszczenie, licznik postów użytkowników celowo nie jest zmniejszany.<br />To narzędzie umożliwia synchronizacje licznika postów wszystkich użytkowników do rzeczywistej wartości.<br />Synchronizację można wykonać w trybie prostym, dla wszystkich forów i wszystkich użytkowników, oraz w trybie zaawansowanym, wybierając forum (dla for z dużą ilością postów i użytkowników), lub użytkownika.<br /><b>Uwaga</b> Funkcja ta synchronizuje również (tylko w trybie prostym) niektóre tabele w których istnieje użytkownik, którego nie ma w tabeli użytkowników, oraz przywraca moderatorom usuniętych grup poziom zwykłego użytkownika, jeżeli w danej chwili nie są moderatorami.';
$lang['Resync_page_desc_adv'] = '';

$lang['Resync_batch_mode'] = 'Batch mode';
$lang['Resync_batch_number'] = 'Batch Number';
$lang['Resync_batch_amount'] = 'Resyncs per Batch';
$lang['Resync_finished'] = 'Zakończone';

$lang['Resync_completed'] = 'Synchronizacja zakończona pomyślnie';

$lang['Resync_question'] = 'Synchronizacja?';

$lang['Resync_check_all'] = 'Zaznacz aby zsynchronizować liczniki wszystkich użytkowników:';

$lang['Resync_do'] = 'Synchronizacja';

$lang['Resync_redirect'] = '<br /><br />Wróć do <a href="%s">Synchronizacji użytkowników</a><br /><br />Wróć do <a href="%s">Panelu Administracyjnego</a>.';
$lang['Resync_invalid'] = 'Błędne ustawienia - Brak użytkowników do synchronizacji';
