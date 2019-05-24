<?php require_once __DIR__ . '/../header.php' ?>

    <div id="chat"></div>
    <div id="panel">
        <?php if ($authorizedUser): ?>
        <div id="panel__input">
            <div id="panel__input__container">
                <textarea id="panel__input__field" name="text" placeholder="Ваше сообщение" maxlength="512"></textarea>
                <button id="panel__input__button"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
        <?php else: ?>
        <div id="panel__button">
            <a id="panel__button__link" href="/login">Присоединиться</a>
        </div>
        <?php endif ?>     
    </div>
    <button id="scroll"><i class="fas fa-arrow-down"></i></button>
    <div id="notification"></div>

<?php require_once __DIR__ . '/../footer.php' ?>