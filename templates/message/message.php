<?php foreach ($messages as $message): ?>
<?php if ($authorizedUser && $authorizedUser->getId() === $message->getUser()->getId()): ?>
<p class="tx"><?= $message->getText() ?></p>
<?php else: ?>
<p class="rx"><?= $message->getText() ?></p>
<?php endif ?>
<?php endforeach ?>