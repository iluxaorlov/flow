<?php require_once __DIR__ . '/../header.php' ?>

    <div id="chat"></div>
    <button id="scroll"><i class="fas fa-arrow-down"></i></button>
    <div id="notification"></div>
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

    <script src="/public/js/app.js"></script>
    <script src="/public/js/pull.js"></script>
    <script src="/public/js/load.js"></script>
    <script src="/public/js/scroll.js"></script>

    <?php if ($authorizedUser): ?>
    <script src="/public/js/send.js"></script>
    <?php endif ?>

<?php require_once __DIR__ . '/../footer.php' ?>