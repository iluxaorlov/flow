# Настройка проекта Flux
1. Скопировать проект на локальный компьютер командой ```$ git clone https://github.com/iluxaorlov/project-flux.git```
2. Перейти в папку проекта
3. Выполнить команду ```$ composer install```
4. Выполнить команду ```$ npm install```
5. Выполнить команду ```$ npm run build```
6. Создать базу данных с таблицами ***users (id PRIMARY_KEY VARCHAR(255), nickname VARCHAR(255), password VARCHAR(255), token VARCHAR(255))*** и ***messages (id PRIMARY_KEY VARCHAR(255), user VARCHAR(255), text TEXT, date DATETIME)***
7. Настроить подключение к базе данных в файле ***app/Settings/Database.php***