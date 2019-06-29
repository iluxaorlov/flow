<?php require_once __DIR__ . '/../header.php' ?>

    <main id="chat"></main>
    <section id="panel">
        <?php if ($authorizedUser): ?>
            <footer id="panel__input">
                <section id="panel__input__container">
                    <textarea id="panel__input__field" name="text" placeholder="Ваше сообщение" maxlength="512"></textarea>
                    <button id="panel__input__button"><i class="fas fa-paper-plane"></i></button>
                </section>
            </footer>
        <?php else: ?>
            <footer id="panel__button">
                <a id="panel__button__link" href="/login">Присоединиться</a>
            </footer>
        <?php endif ?>     
    </section>
    <button id="scroll"><i class="fas fa-arrow-down"></i></button>
    <div id="notification"></div>

<?php require_once __DIR__ . '/../footer.php' ?>