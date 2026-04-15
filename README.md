# Tech Sales System

## Project Setup Guide

Follow the steps below to run the project locally.

---

## Prerequisites

Make sure you have the following installed:

- Composer
- PHP
- MySql
- Node
- Git

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/fredwen91/simple-blog-website.git
```

---

### 2. Setup Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate # generate app key
php artisan migrate
php artisan serve
```

---

### 3. Setup Frontend

```bash
cd frontend
npm install
npm run dev
```

---

## Access the Application

Open your browser and go to:

```
http://localhost:5173/
```

---

## Notes

- Ensure ports `5173` and `8000` are not in use.

---

## Author

- Wenfred Edradan

---
