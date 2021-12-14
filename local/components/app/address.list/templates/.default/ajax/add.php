<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER;

?>
<div class="row">
    <div class="col-4">
        <form action="" method="post" id="myForm">
            <input type="hidden" id="userID" value="<?= $USER->GetID() ?>">
            <label for="address" class="form-label">Ваш адрес</label><br>
            <input type="text" id="address" name="address" class="form-control">
        </form>
    </div>
</div>