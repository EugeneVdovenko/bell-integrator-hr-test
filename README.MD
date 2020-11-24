# Тестовое задание для middle/senior PHP/Symfony разработчика для Bell Integrations

Используя PHP 7 и фреймворк Symfony 5 (последние версии PHP 7.4 и Symfony 5.2), а также Doctrine ORM и с использованием 
Docker контейнера, написать REST API для создания и получения книг и авторов из базы данных в формате JSON. 

## Требования к заданию

- [x] Написать миграцию, засеивающую тестовые таблицы ~10 000 книгами и ~10 000 авторами
- [ ] Реализовать запросы на создание книги и автора в базе /book/create, /author/create
- [ ] Реализовать запрос на получение списка книг с автором из базы /book/search c поиском по названию книги
- [ ] Написать Unit-тест
- [ ] Используя возможности Symfony по локализации контента, сделать мультиязычный метод получения информации о книге /{lang}/book/{Id}, где {lang} = en|ru и {Id} = Id книги. Формат ответа: {Id: 1, 'Name':'War and Peace|Война и мир'} - поле Name выводить на языке локализации запроса.

## Пример формата сущностей

```
Автор: { 
    'Id': 1, 
    'Name': 'Лев Толстой' 
}
```
```
Книга: { 
    'Id': 1, 
    'Name': ' War and peace|Война и мир', 
    'Author': [ { 
        'Id': 1, 
        'Name': 'Лев Толстой' 
        } 
    ] 
}
```

Результат нужно опубликовать на Github с мини-инструкцией по сборке приложения, включая docker-compose.yml, и прислать 
нам ссылку.

## Установка

```dotenv
DATABASE_URL="postgresql://homestead:secret@127.0.0.1:5432/homestead?currentSchema=books&serverVersion=13&charset=utf8"
```

```
php bin/console doctrine:database:create
```

```
php bin/console doctrine:fixtures:load  
```