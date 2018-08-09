<?php

/**
 * @see \w3lifer\yii2\translator\controllers\DefaultController::actionIndex()
 *
 * @var $this           \yii\web\View
 * @var $arrayOfPhrases array
 */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Translator');

?>

<div id="translator__header__wrapper">
    <div id="translator__header__box">
        <h1 id="translator__header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>

<div id="translator__form__wrapper">
    <div id="translator__form__box">
        <?= Html::beginForm('', 'post', ['id' => 'translator__form']) ?>
            <table class="translator__form__table">
                <tr>
                    <th><?= Yii::t('app', 'Your email') ?></th>
                    <td id="translator__form__contact-email">
                        <input type="text">
                    </td>
                </tr>
                <tr>
                    <th><?= Yii::t('app', 'Destination language') ?></th>
                    <td id="translator__form__destination-language">
                        <input type="text">
                    </td>
                </tr>
            </table>
            <?php foreach ($arrayOfPhrases as $categoryName => $phraseSet) : ?>
                <h3><?= Yii::t('app', 'Category') ?>: <?= $categoryName ?></h3>
                <table class="translator__form__table" data-category-name="<?= $categoryName ?>">
                    <?php foreach ($phraseSet as $phrase) : ?>
                        <tr>
                            <th><?= $phrase ?></th>
                            <td>
                                <input type="text" name="phrases[]">
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            <?php endforeach ?>
            <input type="submit">
        <?= Html::endForm() ?>
    </div>
</div>
