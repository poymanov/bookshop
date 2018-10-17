# Bookshop [![Build Status](https://travis-ci.org/poymanov/bookshop.svg?branch=master)](https://travis-ci.org/poymanov/bookshop)

Приложение для отображения каталога книг.

Позволяет создавать/редактировать/удалять книги через административную панель.

#### Содержание

- [Установка](#install)
- [Использование](#usage)
- [Административная панель](#admin)
- [Окружение приложения](#env)
- [Тесты](#tests)

<a name="install"><h2>Установка</h2></a>

Требуются [Docker](https://store.docker.com/search?type=edition&offering=community) и [Docker Compose](https://docs.docker.com/compose/install/).

- Поместить файлы проекта любую директорию
- Перейти в директорию проекта и выполнить:
```
make init 

# или установка с демо-данными
make init-demo
```
Инициализация проекта может занять некоторое время


<a name="usage"><h2>Использование</h2></a>

Для запуска проекта использовать:
```
make start
```

Проект доступен по адресу **http://localhost**


<a name="admin"><h2>Административная панель</h2></a>

Доступна всем пользователям-администраторам по адресу **http://localhost/admin**

Управление авторами книг - **http://localhost/admin/authors**

Управление книгами - **http://localhost/admin/books**


<a name="env"><h2>Окружение приложения</h2></a>

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

<a name="tests"><h2>Тесты</h2></a>

```
make test
```

В окружении приложения:

```
phpunit
```
