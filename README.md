

ВВОДНОЕ ЗАДАНИЕ
------------

Реализация вывода листинга заказов стандартными средствами фреймворка.


УСТАНОВКА
------------

### Подготовка

Возможно, перед установкой нужно будет удалить 27-ю строку из `docker-compose.yml` (нужна для процессоров apple m1)

    platform: 'linux/amd64'

В `.env` настроить переменные, например:

    MYSQL_DATABASE=orders_db
    MYSQL_ROOT_PASSWORD=my_root_pwd
    PORTS='8080:80'
    PORTS_DB='3306:3306'
    PORTS_DB_EXPOSE='3306'

В `/config/db.php` настроить подключение к БД, например:

    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=db;dbname=orders_db',
        'username' => 'root',
        'password' => 'my_root_pwd',
        'charset' => 'utf8',
    ];

### Установка из Docker

Обновите пакеты поставщиков

    docker-compose run --rm php composer update --prefer-dist

Запустите триггеры установки (создание кода проверки файлов cookie)

    docker-compose run --rm php composer install    
    
Запустите контейнер

    docker-compose up -d
    
Модуль будет доступен по следующему URL:

    http://127.0.0.1:8080/orders

где `8080` - порт, указанный в `.env`

РАЗВЕРТЫВАНИЕ
-------------

### Миграции

Следующим этапом нужно применить миграции, для этого заходим в `yiisoftware/yii2-php` контейнер:

    docker exec -i -t {id-контейнера} bash

и запускаем миграции:

    php yii migrate

и подтверждаем выполнение операции

### Тестовые данные

После применения миграций можно загрузить резервную копию БД из файла. Для этого копируем файл БД (например `test_db_data.sql`) в папку `/docker/mysql` и подключаемся к контейнеру mySql:

    docker exec -i -t {id-контейнера} bash

Проходим авторизацию:

    mysql -u root -p

Подключаемся к БД: 

    use orders_db

где `orders_db` имя БД заданное в `.env`

Загружаем файл в БД:

    source /var/lib/mysql/test_db_data.sql

Для удобства установлен phpMyAdmin, доступен по адресу:

    http://127.0.0.1:8888/

