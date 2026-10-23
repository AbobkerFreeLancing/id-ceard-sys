# 🏛️ دليل الهيكل المعماري والنموذج المرجعي للمشاريع (Project Architecture Blueprint)

هذا الدليل يمثل المرجع الشامل لهيكلية هذا المشروع ونموذج العمل القياسي (Blueprint) الذي تم استخلاصه، بحيث يمكن اعتماده كقالب أساسي (Boilerplate / Starter Kit) لإنشاء وتطوير مشاريع برمجية أخرى مهما كان نوعها أو مجال عملها (إدارة جامعات، تجارة إلكترونية، أنظمة محاسبية، عيادات طبية، أنظمة سحابية SaaS، إلخ).

---

## 📑 الفهرس
1. [نظرة عامة والتقنيات الأساسية (Tech Stack)](#1-نظرة-عامة-والتقنيات-الأساسية-tech-stack)
2. [تشريح وفلسفة ملفات جذر المشروع (Root Files Anatomy)](#2-تشريح-وفلسفة-ملفات-جذر-المشروع-root-files-anatomy)
3. [المعمارية الموديلية للمشروع (Modular Architecture - Packages)](#3-المعمارية-الموديلية-للمشروع-modular-architecture---packages)
4. [فلسفة العمل بـ Livewire (Livewire-First Architecture)](#4-فلسفة-العمل-بـ-livewire-livewire-first-architecture)
5. [التكامل مع Filament UI و Server-Driven UI](#5-التكامل-مع-filament-ui-و-server-driven-ui)
6. [بيئة الخادم، الطابور (Queues)، والبث الحي (WebSockets / Reverb)](#6-بيئة-الخادم-الطابور-queues-والبث-الحي-websockets--reverb)
7. [خطوات استنساخ وتطبيق هذا الهيكل في مشروع جديد](#7-خطوات-استنساخ-وتطبيق-هذا-الهيكل-في-مشروع-جديد)

---

## 1. نظرة عامة والتقنيات الأساسية (Tech Stack)

تم بناء المشروع على أحدث المعايير في بيئة عمل PHP و Laravel الحديثة مع استبعاد الواجهات التقليدية المعقدة (React/Vue SPAs) لصالح نهج **Server-Driven UI & Reactive Components**:

| التقنية / المكتبة | الإصدار المعتمد | الدور والوظيفة في المشروع |
| :--- | :--- | :--- |
| **Laravel Framework** | 13.x / 12.x / 11.x (PHP 8.3+) | النواة المركزية للباك إند، التوجيه (Routing)، ومحرك Eloquent ORM. |
| **Livewire** | 3.x / 4.x | بناء واجهات تفاعلية بالكامل عبر PHP و Blade دون الحاجة لكتابة كود JavaScript يدوي. |
| **Filament Admin** | 5.x / 3.x | نظام إدارة لوحات التحكم (Panels) والمكونات البرمجية للجداول (Tables) والنماذج (Schemas/Forms). |
| **Tailwind CSS** | v4.x (@tailwindcss/vite) | إطار عمل التنسيقات السريعة مع الجيل الرابع فائق السرعة عبر محرك Vite. |
| **Laravel Reverb & Echo** | Reverb 1.7+ & Echo 2.0 | سيرفر WebSockets مدمج عالي الأداء لتحديث الواجهات والرسائل والتنبيهات لحظياً. |
| **Alpine.js** | مدمج مع Livewire & Filament | إدارة الحالات التفاعلية الخفيفة على الواجهة (مثل القوائم المنسدلة، إظهار كلمة المرور). |
| **Spatie Suite** | Permission, ActivityLog, QueryBuilder | إدارة الصلاحيات والأدوار، تتبع سجل نشاطات المستخدمين، وبناء استعلامات البحث. |
| **Modular Architecture** | PSR-4 (`Packages/`) | فصل الأنظمة الفرعية في حزم داخلية مستقلة يمكن تفعيلها أو تعطيلها بسهولة. |

---

## 2. تشريح وفلسفة ملفات جذر المشروع (Root Files Anatomy)

تعتبر ملفات الجذر (Root Files) في هذا المشروع هي "حجر الأساس" الذي يضبط قواعد البناء، الأتمتة، بيئة الخوادم، وسلوك الفريق البرمجي:

### أ. ملفات إدارة الحزم والاعتماديات:
1. **`composer.json`**:
   - يقوم بتحميل مكاتب الـ PHP الأساسية.
   - **السر المعماري:** يحتوي في قسم `autoload` على:
     ```json
     "autoload": {
         "files": ["app/helpers.php"],
         "psr-4": {
             "App\\": "app/",
             "Packages\\": "Packages/",
             "Database\\Factories\\": "database/factories/",
             "Database\\Seeders\\": "database/seeders/"
         }
     }
     ```
     تحميل `Packages\` تحت مسار مجلد مخصص يجعل النظام قادراً على العمل كـ Multi-Module دون تعقيدات أدوات خارجية.
   - ينفذ أوامر ما بعد التثبيت تلقائياً مثل `@php artisan filament:upgrade`.
2. **`package.json`**:
   - يحتوي على مكتبات الواجهة: Tailwind CSS v4، Vite، Axios، Laravel Echo، Pusher-js، Flowbite.
   - يتضمن سكربتات مخصصة لترجمة ملفات CSS الأمامية:
     - `dev`: تشغيل خادم التطوير السريع Vite.
     - `build`: تجميع ملفات الإنتاج النهائية.
     - `front-watch`: مراقبة ملفات الواجهة الأمامية وإعادة بنائها.

### ب. ملفات التهيئة والأداء:
3. **`vite.config.js`**:
   - يستخدم الإضافة الثورية الجديدة `@tailwindcss/vite`.
   - يقوم بمراقبة وتفعيل التحديث اللحظي (Hot Reloading) للمسارات الحيوية الخاصة بـ Livewire و Filament:
     ```javascript
     refresh: [
         ...refreshPaths,
         "app/Filament/**",
         "app/Forms/Components/**",
         "app/Livewire/**",
         "app/Infolists/Components/**",
         "app/Providers/Filament/**",
         "app/Tables/Columns/**",
     ]
     ```
4. **`server.php`**:
   - ملف لمحاكاة خادم الويب (Apache mod_rewrite) عند التشغيل المحلي بواسطة `php -S` أو بيئات التطوير السريعة.
5. **`stubs/`**:
   - يحتوي على قوالب كود مخصصة (Custom Artisan Stubs) لتوليد النماذج والمتحكمات والمهاجرات متوافقة مع معايير المشروع عند تنفيذ أوامر `php artisan make:...`.

### ج. ملفات التشغيل والإنتاج (Deployment & Server Configs):
6. **`laravel-worker.conf` (Supervisor Configuration)**:
   - تكوين تشغيل خادم طوابير المهام و Reverb في بيئة الإنتاج:
     - `[program:laravel-worker]`: يشغل `php artisan queue:work` في الخلفية بـ 2 processes مع إعادة التشغيل التلقائي عند التوقف.
     - `[program:laravel-reverb]`: يشغل `php artisan reverb:start` للبث اللحظي للـ WebSockets.
7. **`Nginx.txt`**:
   - نموذج إعداد خادم Nginx يشمل توجيه منافذ HTTP إلى HTTPS، تفعيل دعم HTTP/2 و HTTP/3 (QUIC)، وتمرير البروكسي (Proxy Pass) لخدمة الويب و WebSockets.
8. **`_htaccess.txt`**:
   - إعداد خادم Apache لإعادة توجيه كافة الطلبات إلى المجلد العام `public/` وحماية المجلدات الحساسة.
9. **`.editorconfig` و `.prettierrc` و `.styleci.yml`**:
   - لتوحيد أسلوب كتابة الكود والتنسيقات، المسافات البادئة (Tabs/Spaces)، ومطابقة معايير PSR-12 بين جميع المطورين.

---

## 3. المعمارية الموديلية للمشروع (Modular Architecture - Packages)

بدلاً من تكديس جميع الموديلات والمهاجرات والخدمات داخل مجلد `app/` حتى يصبح المشروع متضخماً (Monolith غير منظم)، يعتمد هذا النظام معمارية **الموديولات المستقلة (Internal Modules / Packages)** داخل مجلد `Packages/`:

```text
Packages/
├── Common/          # النواة المشتركة (الفروع، الإعدادات العامة، الدول، العملاء)
├── Accounting/      # النظام المالي والمحاسبي الكامل (دليل الحسابات، القيود، السندات)
├── Support/         # نظام تذاكر الدعم الفني والمحادثات
├── DocsModule/      # نظام توثيق المشاريع والتعليمات مع واجهات Livewire
├── Chat/            # نظام الدردشة الفورية والتواصل
├── IdCard/          # النظام التخصصي الذكي (نظام هوية: البطاقات، القوالب، المنتسبين، الأقسام، الفحص الأمني)
├── Enum/            # التعدادات الموحدة لكافة أجزاء النظام
├── Helpers/         # أدوات مساعدة عامة (BedayaHelper لتوليد الأرقام المرجعية والرموز)
├── Traits/          # السمات المشتركة (BelongsToBranch, HasActiveScope, BelongsToCreator)
└── Providers/       # موفرو الخدمات الحزمية (BedayaServiceProvider)
```

### آلية عمل موفر الخدمة المركزي (`BedayaServiceProvider`):
يتحكم ملف `config/bedaya.php` في تشغيل وإيقاف الموديولات كـ Feature Flags:
```php
// config/bedaya.php
return [
    'accounting_enabled' => true,
    'support_tickets_enabled' => true,
    'idcard_enabled' => true,
    'docs_module_enabled' => false,
    'chat_enabled' => false,
];
```
ثم يقوم `BedayaServiceProvider` بتسجيل الموديولات الفعالة فقط:
```php
if (config('bedaya.idcard_enabled')) {
    $this->app->register(\Packages\IdCard\IdCardServiceProvider::class);
}
```

### تشريح الموديول الداخلي الواحد (مثال: `Packages/IdCard/`):
كل موديول يمثل تطبيقاً مصغراً متكاملاً يحتوي على:
- **`ServiceProvider.php`**: يقوم بتحميل المهاجرات تلقائياً (`loadMigrationsFrom`)، والمسارات (`routes/`)، والواجهات (`loadViewsFrom`)، والترجمات (`loadTranslationsFrom`).
- **`Models/`**: موديلات الـ Eloquent الخاصة بالموديول.
- **`Database/Migrations/`**: ملفات قواعد البيانات الخاصة به.
- **`Database/Seeders/`**: البيانات الأولية المستقلة للموديول.
- **`Livewire/`**: مكونات Livewire الخاصة بالموديول (مع تسجيل مساحات الأسماء بواسطة `Livewire::addNamespace(...)`).
- **`Services/`**: طبقة منطق العمل (Business Logic Layer).

---

## 4. فلسفة العمل بـ Livewire (Livewire-First Architecture)

يتبنى المشروع مبدأ **Livewire-First** لبناء الواجهات التفاعلية دون الحاجة للجوء إلى أطر عمل JavaScript خارجية. ينقسم العمل بـ Livewire في هذا الهيكل إلى 3 أنماط رئيسية:

### النمط 1: المكونات كصفحات كاملة (Full-Page Components)
تُستدعى هذه المكونات مباشرة عبر موجه المسارات `routes/web.php` وتحدد القالب الرئيسي الذي تحتويه:
```php
// routes/web.php
use App\Livewire\Pages\HomePage;
Route::get('/', HomePage::class)->name('home');

// Component
class HomePage extends Component
{
    public function render()
    {
        return view('livewire.pages.home-page')
            ->layout('layouts.frontend'); // تحديد القالب الرئيسي
    }
}
```

### النمط 2: نماذج Livewire المدمجة مع قدرات Filament Schemas (`HasSchemas`)
بدلاً من بناء النماذج وحقول الإدخال والتحقق يدوياً في Blade، يتم استخدام ميزة `Filament Forms/Schemas` داخل مكون الـ Livewire:
```php
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Livewire\Component;

class AppointmentCreate extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public ?string $name;
    public ?string $phone;
    public ?int $doctor_id;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->label(__('backend.name')),
            TextInput::make('phone')->tel()->required()->label(__('backend.phone')),
            Select::make('doctor_id')
                ->options(Doctor::pluck('name', 'id'))
                ->live() // تحديث فوري تفاعلي
                ->required(),
        ]);
    }
}
```
وفي ملف الـ Blade يتم عرض النموذج بسطر واحد:
```blade
<form wire:submit.prevent="create">
    {{ $this->form }}
    <button type="submit">حفظ</button>
</form>
```

### النمط 3: جداول Livewire المتقدمة مع Filament Tables (`HasTable`)
بناء جداول استعلام متقدمة مع البحث والفرز والصفحات والتصدير:
```php
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class AccountTransactionsTableView extends Component implements HasTable
{
    use InteractsWithTable;

    public $record;

    public function table(Table $table): Table
    {
        return $table
            ->query(Transaction::query()->where('account_id', $this->record->id))
            ->columns([
                TextColumn::make('statement')->label(__('backend.statement'))->searchable(),
                TextColumn::make('debit')->label(__('backend.debit'))->money(),
                TextColumn::make('credit')->label(__('backend.credit'))->money(),
                TextColumn::make('created_at')->date()->label(__('backend.date')),
            ]);
    }

    public function render()
    {
        return view('livewire.account-transactions-table-view');
    }
}
```
وفي الـ Blade ببساطة:
```blade
<div>
    {{ $this->table }}
</div>
```

### النمط 4: مكونات Livewire الموديلية داخل الـ Packages
لجعل مكونات Livewire قابلة لإعادة الاستخدام داخل حزم منفصلة، يتم تسجيل مساحة أسماء Livewire في موفر الخدمة الخاص بالحزمة:
```php
// Packages/DocsModule/DocsModuleProvider.php
use Livewire\Livewire;

Livewire::addNamespace(
    namespace: 'bedaya:docs',
    classNamespace: 'Packages\\DocsModule\\Livewire',
    classPath: __DIR__ . '/Livewire',
    classViewPath: __DIR__ . '/../resources/views/livewire',
);
```
ويتم استدعاء المكون في أي صفحة Blade بهذا الشكل:
```blade
<livewire:bedaya:docs::docs-projec-details :project="$project" />
```

---

## 5. التكامل مع Filament UI و Server-Driven UI

المشروع يحتوي على توليد مخصص لموارد Filament لتطبيق معايير العمل الصارمة (مثل التوطين العربي الإجباري، الهيكل القياسي للأعمدة، وتوحيد الصلاحيات):
- **`app/Filament/Commands/FileGenerators/Resources/`**:
  - `BedayaResourceClassGenerator`: يضمن توليد الموارد بمجموعات التصفح المناسبة وصلاحيات الوصول وأيقونات Heroicon الافتراضية.
  - `BedayaFormGenerator`: يولد تلقائياً النماذج بتوزيع شبكي مقسم إلى أعمدة رئيسية للبيانات وأعمدة جانبية لتسجيل تاريخ الإنشاء والتعديل (`created_at`, `updated_at`).
  - `BedayaTableGenerator`: يولد جداول تحتوي على أعمدة البحث والإجراءات القياسية (View, Edit, Delete داخل ActionGroup).

---

## 6. بيئة الخادم، الطابور (Queues)، والبث الحي (WebSockets / Reverb)

- **Laravel Reverb**: مفعّل عبر `config/reverb.php` و `laravel-worker.conf`. يتواصل المتصفح مع السيرفر عبر منفذ WebSocket محدد باستخدام `laravel-echo` و `pusher-js`.
- **معالجة العمليات الطويلة عبر Queues**:
  العمليات الثقيلة (إصدار الشهادات، كشوف الدرجات، رسائل البريد، ترحيل الدفعات) تُسند إلى مهام طابور `Jobs` يتم تنفيذها عبر Supervisor.
- **التعامل مع البذور الشرطية (Conditional Seeding via `VoidSeeder`)**:
  عندما تكون حزمة معينة مغلقة، لا يتم إلغاء الـ Seeder بل يُستبدل بـ `VoidSeeder::class` حتى لا تفشل عمليات `php artisan db:seed`.

---

## 7. خطوات استنساخ وتطبيق هذا الهيكل في مشروع جديد

عند البدء في إنشاء مشروع جديد باستخدام نفس الهيكلية بغض النظر عن تخصصه:
1. **استنساخ ملفات الجذر الأساسية**:
   - انسخ `composer.json` (مع تعديل اسم المشروع ومسارات `Packages\`).
   - انسخ `package.json` و `vite.config.js`.
   - انسخ ملفات السيرفر: `laravel-worker.conf` و `Nginx.txt` و `_htaccess.txt`.
2. **إنشاء مجلد الحزم `Packages/`**:
   - إنشاء حزم أساسية مشتركة: `Common`, `Enum`, `Helpers`, `Traits`, `Providers`.
   - إنشاء ملف الإعدادات الخاص بالنظام: `config/bedaya.php` (أو اسم مشروعك).
3. **تأسيس قوالب الواجهات Blade و Livewire**:
   - إنشاء `resources/views/layouts/frontend.blade.php` الذي يحوي `@filamentStyles` و `@filamentScripts` و `@vite`.
   - تأسيس مكونات Livewire للصفحات الرئيسية ولوحات تحكم المستخدمين.
4. **ربط لوحات التحكم المتعددة (Multi-Panel Filament)**:
   - لوحة الإدارة (`admin`)
   - لوحة المستخدمين/العملاء/الطلاب (`portal` أو `client`)
   - تخصيص شاشات تسجيل الدخول بمكونات Livewire مخصصة.
