# Bookshop [![Build Status](https://travis-ci.org/poymanov/bookshop.svg?branch=master)](https://travis-ci.org/poymanov/bookshop)

Приложение для отображения каталога книг.

Позволяет создавать/редактировать/удалять книги через административную панель.

# Установка

Требуются [Docker](https://store.docker.com/search?type=edition&offering=community) и [Docker Compose](https://docs.docker.com/compose/install/).

- Поместить файлы проекта любую директорию
- Перейти в директорию проекта и выполнить:
```
make init 

# или установка с демо-данными
make init-demo
```
Инициализация проекта может занять некоторое время

# Использование

Для запуска проекта использовать:
```
make start
```

Проект доступен по адресу **http://localhost**


# Административная панель

Доступна всем пользователям-администраторам по адресу **http://localhost/admin**

Управление авторами книг - **http://localhost/admin/authors**

Управление книгами - **http://localhost/admin/books**

# Окружение приложения

Все зависимости приложения устанавливаются внутри docker-контейнера.

Доступ в окружение приложения после запуска:

```
make app
```

В окружении приложения доступны **php**, **phpunit**, **composer**, **npm**, **node**, а также [алиасы](docker/php/aliases) для более удобной работы с компонентами приложения.

Запуск сборки ресурсов (assets):
```
npm run dev
```

# Тесты

```
make test
```

В окружении приложения:

```
phpunit
```
