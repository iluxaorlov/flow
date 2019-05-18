<?php require_once __DIR__ . '/../header.php' ?>

    <div id="logotype">
        <a id="logotype__link" href="/"><img id="logotype__image" src="/img/logotype.png"></a>
    </div>
    <form id="form" action="/login" method="POST">
        <input id="form__login" name="login" type="text" placeholder="Логин" value="<?= $_POST['login'] ?>">
        <div id="form__password">
            <input id="form__password__input" name="password" type="password" placeholder="Пароль" value="<?= $_POST['password'] ?>">
            <div id="form__password__button"><i class="fas fa-eye-slash"></i></div>
        </div>
        <button id="form__submit">Войти</button>
        <p id="form__invite">Ещё нет аккаунта? <a id="form__invite__link" href="/register">Регистрация</a></p>
        <?php if ($error): ?>
        <p id="form__error"><?= $error ?></p>
        <?php endif ?>
    </form>
    
    <script src="js/form.js"></script>

<?php require_once __DIR__ . '/../footer.php' ?>