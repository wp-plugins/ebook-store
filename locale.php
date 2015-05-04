<?php

$l['default']['buy'] = 'Buy';
$l['default']['preview'] = 'Preview';
$l['default']['details'] = 'Details';
$l['default']['download'] = 'Download';

$l['en']['buy'] = 'Buy';
$l['en']['preview'] = 'Preview';
$l['en']['details'] = 'Details';
$l['en']['download'] = 'Download';

$l['de']['buy'] = 'Kaufen';
$l['de']['preview'] = 'Vorschau';
$l['de']['details'] = 'Details';
$l['de']['download'] = 'Datei';

$l['fr']['buy'] = 'Acheter';
$l['fr']['preview'] = 'Aperçu';
$l['fr']['details'] = 'Détails';
$l['fr']['download'] = 'Télécharger';

$l['es']['buy'] = 'Comprar';
$l['es']['preview'] = 'Prevista';
$l['es']['details'] = 'Detalles';
$l['es']['download'] = 'Descargar';

$l['zh']['buy'] = '购买';
$l['zh']['preview'] = '预览';
$l['zh']['details'] = '的详细信息';
$l['zh']['download'] = '下载';

$l['hi']['buy'] = 'खरीदें';
$l['hi']['preview'] = 'पूर्वावलोकन';
$l['hi']['details'] = 'विवरण';
$l['hi']['download'] = 'डाउनलोड';

$l['ru']['buy'] = 'Купить';
$l['ru']['preview'] = 'Превью';
$l['ru']['details'] = 'Детали';
$l['ru']['download'] = 'Скачать';

$l['jp']['buy'] = '購入'; 
$l['jp']['preview'] = 'プレビュー';
$l['jp']['details'] = '詳細';
$l['jp']['download'] = 'ダウンロード';


$get_locale = get_locale();
$get_locale = $get_locale{0} . $get_locale{1};

$locale = $l[$get_locale];
if (!@$locale) {
	$locale = $l['default'];
}
?>