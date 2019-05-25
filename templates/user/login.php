<?php require_once __DIR__ . '/../header.php' ?>

    <header id="logotype">
        <a id="logotype__link" href="/"><img id="logotype__image" src="/img/logotype.png"></a>
    </header>
    <form id="form" action="/login" method="POST">
        <input id="nickname" name="nickname" type="text" placeholder="Имя пользователя" value="<?= $_POST['nickname'] ?>">
        <section id="password__section">
            <input id="password__section__input" name="password" type="password" placeholder="Пароль">
            <button id="password__section__show" type="button"><i class="fas fa-eye-slash"></i></button>
        </section>
        <button id="submit" type="submit">Войти</button>
        <p id="form__invite">Ещё нет аккаунта? <a id="form__invite__link" href="/register">Регистрация</a></p>
        <?php if ($error): ?>
            <p id="form__error"><?= $error ?></p>
        <?php endif ?>
    </form>

<?php require_once __DIR__ . '/../footer.php' ?>