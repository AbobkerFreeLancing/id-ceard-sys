## UHS System

## نظام إدارة جامعة العلوم الصحية
القبول، التسجيل، المدفوعات، النتائج، والكثير من الأنظمة الفرعية الأخرى

## Project Tech Stack

| Tech              | version | Description                                                 |
| ----------------- | ------- | ----------------------------------------------------------- |
| Laravel           | 13.x      | PHP Framework                                               |
| Livewire          | 4.x     | build dynamic, reactive interfaces using only PHP           |
| Filament          | 5.x     | Filament is a Server-Driven UI (SDUI) framework for Laravel |
| Spatie Permission | 8.x     | Associate users with roles and permissions                  |
| Tailwind          | 4.x     | A utility-first CSS framework packed with classes           |


## Installation - تثبيت المشروع وتشغيله

1. Install Laragon and place the project in `Laragon-server\www\uhs-sys`.
2. Make sure PHP 8.4 is installed and configured.
3. Start Apache and MySQL from Laragon.
4. Create a MySQL database `uhs-sys`.
5. Copy `.env.example` to `.env` and configure the database credentials.
6. Run `composer install` from the project folder. then Run `npm install`.
7. Run `php artisan migrate` then `php artisan seed`.
8. Open `http://localhost/uhs-sys` or `http://uhs-sys.test` in a browser.

Check the project's configuration or setup files for any additional requirements.
