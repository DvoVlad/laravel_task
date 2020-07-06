# laravel_task
Тестовое задание
<h1>Пример работы</h1>
<h2>Для отправки запросов я использовал postman.</h2>
<p align="center">
1. Клиент делает запрос на создание документа</p>
<pre>
Запрос:
POST /api/v1/document HTTP/1.1
accept: application/json
Ответ:
HTTP/1.1 200 OK
content-type: application/json
{
"document": {
"id": "718ce61b-a669-45a6-8f31-32ba41f94784",
"status": "draft",
"payload": {},
"created_at": "2018-09-01 20:00:00",
"updated_at": "2018-09-01 20:00:00"
}
}
</pre>
<p align="center">2. Клиент редактирует документ первый раз</p>
<pre>
Запрос:
PATCH /api/v1/document/718ce61b-a669-45a6-8f31-32ba41f94784 HTTP/1.1
accept: application/json
content-type: application/json
{
"document": {
"payload": {
"actor": "The fox",
"meta": {
"type": "quick",
"color": "brown"
},
"actions": [
{
"action": "jump over",
"actor": "lazy dog"
}
]}
}
}
Ответ:
HTTP/1.1 200 OK
content-type: application/json
{
"document": {
"id": "718ce61b-a669-45a6-8f31-32ba41f94784",
"status": "draft",
"payload": {
"actor": "The fox",
"meta": {
"type": "quick",
"color": "brown"
},
"actions": [
{
"action": "jump over",
"actor": "lazy dog"
}
]
},
"created_at": "2018-09-01 20:00:00",
"updated_at": "2018-09-01 20:01:00"
}
}
</pre>
<p align="center">3. Клиент редактирует документ</p>
<pre>
Запрос:
PATCH /api/v1/document/718ce61b-a669-45a6-8f31-32ba41f94784 HTTP/1.1
accept: application/json
content-type: application/json
{
"document": {
"payload": {
"meta": {
"type": "cunning",
"color": null
},
"actions": [
{
"action": "eat",
"actor": "blob"
},
{
"action": "run away"
}
]
}
}
}
Ответ:
HTTP/1.1 200 OK
content-type: application/json
{
"document": {
"id": "718ce61b-a669-45a6-8f31-32ba41f94784",
"status": "draft",
"payload": {
"actor": "The fox",
"meta": {
"type": "cunning",
},
"actions": [
{
"action": "eat",
"actor": "blob"
},
{
"action": "run away"
}
]
},
"created_at": "2018-09-01 20:00:00",
"updated_at": "2018-09-01 20:02:00"
}
}
</pre>
<p align="center">4. Клиент публикует документ</p>
<pre>
Запрос:
POST /api/v1/document/718ce61b-a669-45a6-8f31-32ba41f94784/publish HTTP/1.1
accept: application/json
Ответ:
HTTP/1.1 200 OK
content-type: application/json
{
"document": {
"id": "718ce61b-a669-45a6-8f31-32ba41f94784",
"status": "published",
"payload": {
"actor": "The fox",
"meta": {
"type": "cunning",
},
"actions": [
{
"action": "eat",
"actor": "blob"
},
{
"action": "run away"
}]
},
"created_at": "2018-09-01 20:00:00",
"updated_at": "2018-09-01 20:03:00"
}
}
</pre>
<p align="center">5. Клиент получает запись в списке</p>
<pre>
Запрос:
GET /api/v1/document/?page=1 HTTP/1.1
accept: application/json
Ответ:
HTTP/1.1 200 OK
content-type: application/json
{
"document": [
{
"id": "718ce61b-a669-45a6-8f31-32ba41f94784",
"status": "published",
"payload": {
"actor": "The fox",
"meta": {
"type": "cunning",
},
"actions": [
{
"action": "eat",
"actor": "blob"
},
{
"action": "run away"
}
]
},
"created_at": "2018-09-01 20:00:00",
"updated_at": "2018-09-01 20:03:00"
}
],
"pagination": {
"page": 1,
"perPage": 20,
"total": 1
}
}
</pre>
