<?php

$l['default']['buy'] = 'Buy';
$l['default']['preview'] = 'Preview';
$l['default']['details'] = 'Details';
$l['default']['download'] = 'Download';
$l['default']['pages'] = 'pages';

$l['en']['buy'] = 'Buy';
$l['en']['preview'] = 'Preview';
$l['en']['details'] = 'Details';
$l['en']['download'] = 'Download';
$l['en']['pages'] = 'pages';

$l['de']['buy'] = 'Kaufen';
$l['de']['preview'] = 'Vorschau';
$l['de']['details'] = 'Details';
$l['de']['download'] = 'Datei';
$l['de']['pages'] = 'buchseiten';

$l['fr']['buy'] = 'Acheter';
$l['fr']['preview'] = 'Aperçu';
$l['fr']['details'] = 'Détails';
$l['fr']['download'] = 'Télécharger';
$l['fr']['pages'] = 'pages';

$l['es']['buy'] = 'Comprar';
$l['es']['preview'] = 'Prevista';
$l['es']['details'] = 'Detalles';
$l['es']['download'] = 'Descargar';
$l['es']['pages'] = 'páginas';

$l['zh']['buy'] = '购买';
$l['zh']['preview'] = '预览';
$l['zh']['details'] = '的详细信息';
$l['zh']['download'] = '下载';
$l['zh']['pages'] = '网页';

$l['hi']['buy'] = 'खरीदें';
$l['hi']['preview'] = 'पूर्वावलोकन';
$l['hi']['details'] = 'विवरण';
$l['hi']['download'] = 'डाउनलोड';
$l['hi']['pages'] = 'पृष्ठों';

$l['ru']['buy'] = 'Купить';
$l['ru']['preview'] = 'Превью';
$l['ru']['details'] = 'Детали';
$l['ru']['download'] = 'Скачать';
$l['ru']['pages'] = 'страницы';

$l['jp']['buy'] = '購入'; 
$l['jp']['preview'] = 'プレビュー';
$l['jp']['details'] = '詳細';
$l['jp']['download'] = 'ダウンロード';
$l['jp']['pages'] = 'ページ';

$l['tr']['buy'] = 'Satın Al!'; 
$l['tr']['preview'] = 'Örneğe Bak';
$l['tr']['details'] = 'Detaylar';
$l['tr']['download'] = 'Indir';
$l['tr']['pages'] = 'sayfa';


$get_locale = get_locale();
$get_locale = $get_locale{0} . $get_locale{1};

$locale = $l[$get_locale];
if (!@$locale) {
	$locale = $l['default'];
}
?>