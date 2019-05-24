<?php require_once __DIR__ . '/../header.php' ?>

    <div id="logotype">
        <a id="logotype__link" href="/"><img id="logotype__image" src="/img/logotype.png"></a>
    </div>
    <form id="form" action="/login" method="POST">
        <input id="form__nickname" name="nickname" type="text" placeholder="Логин" value="<?= $_POST['nickname'] ?>">
        <div id="form__password">
            <input id="form__password__input" name="password" type="password" placeholder="Пароль">
            <div id="form__password__button"><i class="fas fa-eye-slash"></i></div>
        </div>
        <button id="form__submit">Войти</button>
        <p id="form__invite">Ещё нет аккаунта? <a id="form__invite__link" href="/register">Регистрация</a></p>
        <?php if ($error): ?>
        <p id="form__error"><?= $error ?></p>
        <?php endif ?>
    </form>

<?php require_once __DIR__ . '/../footer.php' ?>