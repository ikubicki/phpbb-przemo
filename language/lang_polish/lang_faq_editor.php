<?php

// Check for user gender
$he = ($userdata['user_gender'] != 2) ? true : false;

$lang['faq_editor'] = 'Edytor FAQ';
$lang['faq_editor_explain'] = 'Ten modu³ pozwala na edycje i uporz±dkowanie pytañ z FAQ Staraj siê <u>nie kasowaæ</u> Oryginalnych wpisów.';

$lang['faq_select_language'] = 'Wybierz jêzyk w jakim chcesz edytowaæ FAQ';
$lang['faq_retrieve'] = 'Edytuj FAQ';

$lang['faq_block_delete'] = 'Jeste¶ pew' .  (($he) ? 'ien' : 'na') . ' ¿e chcesz skasowaæ ten blok?';
$lang['faq_quest_delete'] = 'Jeste¶ pew' .  (($he) ? 'ien' : 'na') . ' ¿e chcesz skasowaæ to pytanie z odpowied¼±?';

$lang['faq_quest_edit'] = 'Edytuj pytanie i odpowied¼';
$lang['faq_quest_create'] = 'Utwórz nowe pytanie i odpowied¼';

$lang['faq_quest_edit_explain'] = 'Edytuj pytanie i odpowied¼, mo¿esz te¿ zmieniæ blok';
$lang['faq_quest_create_explain'] = 'Podaj pytanie i odpowied¼';

$lang['faq_block'] = 'Blok';
$lang['faq_quest'] = 'Pytanie';
$lang['faq_answer'] = 'Odpowied¼';

$lang['faq_block_name'] = 'Nazwa bloku';
$lang['faq_block_rename'] = 'Zmieñ nazwê bloku';
$lang['faq_block_rename_explain'] = 'Zmieñ nazwê bloku w FAQ';

$lang['faq_block_add'] = 'Dodaj blok';
$lang['faq_quest_add'] = 'Dodaj pytanie';

$lang['faq_no_quests'] = 'W bloku nie ma pytañ. To zablokuje wszystkie bloki wystêpuj±ce po tym przed wy¶wietleniem. Skasuj ten blok lub dodaj jedno lub wiêcej pytañ.';
$lang['faq_no_blocks'] = 'Brak zdefiniowanych bloków';

$lang['faq_write_file'] = 'B³±d zapisu do pliku jêzykowego! (sprawd¼ uprawnienia pliku (chmod 666)';
$lang['faq_write_file_explain'] = 'Musisz nadaæ prawa do zapisu dla plików w language/lang_******/lang_bbcode.php i lang_faq.php W systemach unixowych wykonuje siê to poleceniem: <b>chmod 666 plik</b> Niektóre klienty posiadaj±ce liniê poleceñ równie¿ na to pozwalaj± na przyk³ad TotalCommander.';

?>