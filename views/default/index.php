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
            <hr>
            <label id="translator__form__contact-email">
                <span>Your email</span>: <input type="text">
            </label>
            <hr>
            <label id="translator__form__destination-language">
                <span>Destination language</span>: <input type="text">
            </label>
            <?php foreach ($arrayOfPhrases as $categoryName => $phraseSet) : ?>
                <hr>
                <h3>Category: <?= $categoryName ?></h3>
                <hr>
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
            <hr>
            <input type="submit">
        <?php Html::endForm() ?>
    </div>
</div>
