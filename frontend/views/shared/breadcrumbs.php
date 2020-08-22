<?php

use yii\bootstrap4\Breadcrumbs;

$breadcrumbs = isset($params['breadcrumbs']) ? $params['breadcrumbs'] : [];
?>

<?php if (!empty($breadcrumbs)): ?>
    <br>
    <div class="container">
        <?= Breadcrumbs::widget(['links' => $breadcrumbs]); ?>
    </div>
<?php endif; ?>
