<?php foreach ($messages as $message): ?>
<?php if ($authorizedUser && $authorizedUser->getId() === $message->getUser()->getId()): ?>
<div class="tx"><?= $message->getText() ?></div>
<?php else: ?>
<div class="rx"><?= $message->getText() ?></div>
<?php endif ?>
<?php endforeach ?>