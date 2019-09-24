<?php

/**
 * @var View $this
 * @var MessageInterface $message
 * @var string $content
 */

use yii\mail\MessageInterface;
use yii\web\View;

?>
<?php $this->beginPage() ?>
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
<?php $this->endPage() ?>