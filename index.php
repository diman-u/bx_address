<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Адреса пользователя");
?>

<?php $APPLICATION->IncludeComponent(
	'app:address.list',
	'',
	[
		'SHOW_ELEMENTS' => 'N',
		'CACHE_TIME'  => ['DEFAULT' => 3600]
	],
	false
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>