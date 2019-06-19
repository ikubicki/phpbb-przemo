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

$lang['Resync_page_desc_simple'] = 'W wielu przypadkach licznik postów u¿ytkowników nie odzwierciedla prawdziwej ilo¶ci postów któr± u¿ytkownik ma na forum. Podczas kasowania tematu, postu licznik postów u¿ytkowników jest zmniejszany. Jednak w przypadku gdy kasujemy ca³e forum, lub forum ma ustawione czyszczenie, licznik postów u¿ytkowników celowo nie jest zmniejszany.<br />To narzêdzie umo¿liwia synchronizacje licznika postów wszystkich u¿ytkowników do rzeczywistej warto¶ci.<br />Synchronizacjê mo¿na wykonaæ w trybie prostym, dla wszystkich forów i wszystkich u¿ytkowników, oraz w trybie zaawansowanym, wybieraj±c forum (dla for z du¿± ilo¶ci± postów i u¿ytkowników), lub u¿ytkownika.<br /><b>Uwaga</b> Funkcja ta synchronizuje równie¿ (tylko w trybie prostym) niektóre tabele w których istnieje u¿ytkownik, którego nie ma w tabeli u¿ytkowników, oraz przywraca moderatorom usuniêtych grup poziom zwyk³ego u¿ytkownika, je¿eli w danej chwili nie s± moderatorami.';
$lang['Resync_page_desc_adv'] = '';

$lang['Resync_batch_mode'] = 'Batch mode';
$lang['Resync_batch_number'] = 'Batch Number';
$lang['Resync_batch_amount'] = 'Resyncs per Batch';
$lang['Resync_finished'] = 'Zakoñczone';

$lang['Resync_completed'] = 'Synchronizacja zakoñczona pomy¶lnie';

$lang['Resync_question'] = 'Synchronizacja?';

$lang['Resync_check_all'] = 'Zaznacz aby zsynchronizowaæ liczniki wszystkich u¿ytkowników:';

$lang['Resync_do'] = 'Synchronizacja';

$lang['Resync_redirect'] = '<br /><br />Wróæ do <a href="%s">Synchronizacji u¿ytkowników</a><br /><br />Wróæ do <a href="%s">Panelu Administracyjnego</a>.';
$lang['Resync_invalid'] = 'B³êdne ustawienia - Brak u¿ytkowników do synchronizacji';

?>
