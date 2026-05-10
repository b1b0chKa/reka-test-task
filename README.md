# Todo App (Laravel + Vanilla JS + Vite)

## Описание
Простое Todo-приложение с авторизацией, задачами и тегами.  
Backend: Laravel API  
Frontend: Blade + Vanilla JavaScript (Vite)

---

## Стек
- Laravel 11
- MySQL
- Docker
- Nginx
- Vite
- Vanilla JS
- Blade templates

---

## Запуск проекта

### 1. Поднятие окружения (Docker)

Проект полностью работает через Docker:

docker compose up -d --build

### 2. Установка зависимостей

docker exec -it reka-app composer install
docker exec -it reka-app npm install

---

### 3. Настройка окружения

cp .env.example .env
docker exec -it reka-app php artisan key:generate

Настроить БД в `.env`:
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

---

### 4. Миграции

docker exec -it reka-app php artisan migrate

---

### 5. Запуск проекта

Frontend (Vite):
npm run dev

---

## API

### Auth
POST /api/register  
POST /api/login  

### Tasks
GET /api/tasks  
POST /api/tasks  
GET /api/tasks/{id}  
PUT /api/tasks/{id}  
DELETE /api/tasks/{id}  
PATCH /api/tasks/sort  

### Tags
GET /api/tags  
POST /api/tags  

---

## Авторизация
Используется Bearer Token (Sanctum)

Authorization: Bearer <token>

Токен хранится в localStorage.

---

## Функционал
- Регистрация / логин
- JWT-like auth через Sanctum
- CRUD задач
- Drag & drop сортировка
- Создание тегов
- Привязка тегов к задачам
