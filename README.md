

ВВОДНОЕ ЗАДАНИЕ
------------

Реализация вывода листинга заказов стандартными средствами фреймворка.


УСТАНОВКА
------------

Возможно, перед установкой нужно будет удалить 27-ю строку из `docker-compose.yml` (нужна для процессоров apple m1)

    platform: 'linux/amd64'

### Установка из Docker

Обновите пакеты поставщиков

    docker-compose run --rm php composer update --prefer-dist

Запустите триггеры установки (создание кода проверки файлов cookie)

    docker-compose run --rm php composer install    
    
Запустите контейнер

    docker-compose up -d
    
Модуль будет доступен по следующему URL:

    http://127.0.0.1/test/default

РАЗВЕРТЫВАНИЕ
-------------

### База данных

Все все таблицы и тестовые данные уже внесены в базу данных.

Для удобства установлен phpMyAdmin, доступен по адресу:

    http://127.0.0.1:8888/

для подключения:

    сервер - `db`
    пользователь - `root`
    пароль - `my_root_pwd`

**ЗАМЕТКИ:**
- Для тестирования переводов, создана локаль 'ru'. Для переключения на 'ru' локаль нужно раскоментировать 37-ю строку в контроллере модуля `DefaultController`:

      Yii::$app->language = 'ru';
