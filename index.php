<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Адреса пользователя");
?>

<?php $APPLICATION->IncludeComponent(
	'app:address.list',
	'',
	[
		'SHOW_ELEMENTS' => 'N'
	],
	false
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>