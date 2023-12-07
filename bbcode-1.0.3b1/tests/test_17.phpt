--TEST--
BBCODE Parser Flag Set -> REMOVE_IF_EMPTY
--FILE--
<?php
if (!extension_loaded('bbcode')){
	if (!dl('bbcode.so')){
		die ('bbcode not loadable');
	}
}
$arrayBBCode=array(
    'b'=>        array('type'=>BBCODE_TYPE_NOARG, 'open_tag'=>'<b>', 'close_tag'=>'</b>', 'flags'=>BBCODE_FLAGS_REMOVE_IF_EMPTY),
    'u'=>        array('type'=>BBCODE_TYPE_NOARG, 'open_tag'=>'<u>', 'close_tag'=>'</u>', 'flags'=>BBCODE_FLAGS_SMILEYS_OFF | BBCODE_FLAGS_REMOVE_IF_EMPTY | BBCODE_FLAGS_SMILEYS_OFF),
    'i'=>        array('type'=>BBCODE_TYPE_NOARG, 'open_tag'=>'<i>', 'close_tag'=>'</i>', 'flags'=>BBCODE_FLAGS_REMOVE_IF_EMPTY),
);
$text=<<<EOF
[b]Test_[i]Testa :)[u]
Plouf :)[/b]Testb [b]
Blob:)[/b][/i][/u]
Testc Testd
EOF;
$BBHandler=bbcode_create($arrayBBCode);
bbcode_set_flags($BBHandler,BBCODE_CORRECT_REOPEN_TAGS|BBCODE_DEFAULT_SMILEYS_ON|BBCODE_ARG_DOUBLE_QUOTE|BBCODE_ARG_SINGLE_QUOTE|BBCODE_ARG_HTML_QUOTE,BBCODE_SET_FLAGS_SET);
bbcode_add_smiley($BBHandler, ":)", "<img src=\"smiley.gif\" alt=\":)\" />");
bbcode_add_smiley($BBHandler, ":(", "<img src=\"sad.gif\" alt=\":(\" />");
bbcode_add_smiley($BBHandler, ":D", "<img src=\"happy.gif\" alt=\":D\" />");
bbcode_add_smiley($BBHandler, ":p", "<img src=\"tong.gif\" alt=\":p\" />");
bbcode_add_smiley($BBHandler, ":|", "<img src=\"special.gif\" alt=\":|\" />");
bbcode_add_smiley($BBHandler, ":6:", "<img src=\"six.gif\" alt=\":6:\" />");
echo bbcode_parse($BBHandler,$text);
?>
--EXPECT--
<b>Test_<i>Testa <img src="smiley.gif" alt=":)" /><u>
Plouf :)</u></i></b><i><u>Testb <b>
Blob<img src="smiley.gif" alt=":)" /></b></u></i>
Testc Testd
