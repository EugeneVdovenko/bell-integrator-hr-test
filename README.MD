# Тестовое задание для middle/senior PHP/Symfony разработчика для Bell Integrations

Используя PHP 7 и фреймворк Symfony 5 (последние версии PHP 7.4 и Symfony 5.2), а также Doctrine ORM и с использованием 
Docker контейнера, написать REST API для создания и получения книг и авторов из базы данных в формате JSON. 

## Требования к заданию

- [x] Написать миграцию, засеивающую тестовые таблицы ~10 000 книгами и ~10 000 авторами
- [x] Реализовать запросы на создание книги и автора в базе /book/create, /author/create
- [x] Реализовать запрос на получение списка книг с автором из базы /book/search c поиском по названию книги
- [x] Написать Unit-тест
- [x] Используя возможности Symfony по локализации контента, сделать мультиязычный метод получения информации о книге /{lang}/book/{Id}, где {lang} = en|ru и {Id} = Id книги. Формат ответа: {Id: 1, 'Name':'War and Peace|Война и мир'} - поле Name выводить на языке локализации запроса.

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
DATABASE_URL="postgresql://homestead:secret@db:5432/homestead?currentSchema=books&serverVersion=13&charset=utf8"
```

```
php bin/console doctrine:database:create
```

````
`php bin/console doctrine:mgrate
````

```
php bin/console doctrine:fixtures:load  
```

## Маршруты

### Создать автора
```
POST http://development.local:8000/author/create

{
    "name": "API Автор"
}
```
### Список авторов
```
GET http://development.local:8000/author?limit=10
```
### Создать книгу
```
POST http://development.local:8000/book/create

{
    "name": "New API book",
    "author": [1015, 1099]
}
```
### Список книг
```
GET http://development.local:8000/book?limit=5
```
### Одна книга
```
GET http://development.local:8000/ru/book/99
```
### Поиск по названию
```
GET http://127.0.0.1/book/search?filter[title]=книга 999
```