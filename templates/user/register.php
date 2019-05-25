<?php require_once __DIR__ . '/../header.php' ?>

    <header id="logotype">
        <a id="logotype__link" href="/"><img id="logotype__image" src="/img/logotype.png"></a>
    </header>
    <form id="form" action="/register" method="POST">
        <input id="nickname" name="nickname" type="text" placeholder="Имя пользователя" value="<?= $_POST['nickname'] ?>">
        <input id="password" name="password" type="password" placeholder="Пароль">
        <input id="repeat" name="repeat" type="password" placeholder="Повторите пароль">
        <button id="submit" type="submit">Регистрация</button>
        <p id="form__invite">Уже есть аккаунт? <a id="form__invite__link" href="/login">Войти</a></p>
        <?php if ($error): ?>
            <p id="form__error"><?= $error ?></p>
        <?php endif ?>
    </form>

<?php require_once __DIR__ . '/../footer.php' ?>