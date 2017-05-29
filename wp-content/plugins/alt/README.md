# Інтсрукція встановлення ORM системи

## Інсталяція WordPress

Для встановлення вордпрес, потрібно його скачати з офіційного сайту https://wordpress.org/download/.

Процес інсталяції системи для запуску сервера описана тут https://codex.wordpress.org/Installing_WordPress. 
Або можна використовувати існуючий LAMP, MAMP або WAMP сервери.

Далі потрібно пройти стандартну покрокову процедуру налаштування, яка допоможе 
 налаштувати зв'язок до бази даних та користувача адміністратора.

## Інсталяція ORM системи

Для того щоб запустити систему потрібно скопіювати папку проекту alt в 
папку `~/wordpress-root/wp-content/plugins`.

## Включення плагіну
 
Для активації плагіну, потрібно перейти в панель адміністрації `/wp-admin`,
а далі перейти через головне меню `Plugins -> Installed plugins` на сторінку активації
та вибрати AltORM.

## Оновлення бібліотек (не обов'зкове)

Для того щоб всі бібліотеки працювали вірно, рекомендується 
їх оновлювати за допомогою composer.

Встановлення composer https://getcomposer.org/doc/00-intro.md. 

Потрібно перейти в папку `~/wordpress-root/wp-content/plugins/alt` 
та виконати команду `composer update`.

# Робота з ORM

## Ініціалізація конфігурацій

Щоб використовувати дану систему з власним модулем, вам потрібно створити файл конфігурацій.
Приклад:

``` yaml
db:
  prefix: alt # це префікс для таблиць

class:
  repos:
    - UserRepository
    - CommentRepository
  classes:
    - User
    - Comment
```
## Створення класів

Для роботи системи, потрібно створити папку `Models`, в якій треба буде створити 2
класи:

1. Клас з бізнес логікою
2. Клас Репозиторій (де описуватиметься зв'язок з базою даних та інше)

В конструкторах кожного класу обов'язково потрібно передавати унікальний ідентифікатор
цього класу, наприклад:

``` php
	/**
	 * User constructor.
	 */
	function __construct() {
		parent::__construct('messys/User');
	}
```

Де memsys - папка модуля, а User - назва класу.

## Опис класів 

Для того щоб почати зв'язок класу з таблицею у базі даних, потрібно напистаи для них 
анотації:

```php
class User extends AbstractDbModel
{
	/** @Column(name="int", primary=true, unique=true, nullable=false, length=11) */
	public $id;

	/** @Column(name="varchar", length=255, nullable=false, default="User") */
	protected $name;

	/** @Column(name="text", nullable=true) */
	protected $comment;

	/** @Column(name="float", nullable=false, default="10") */
	protected $age;

	/** @Column(name="float", nullable=false, default="10.1") */
	protected $points;

	/** @Column(name="datetime", nullable=false) */
	protected $created_at;

	/** @Column(name="int", nullable=false, default="0") */
	protected $posts;
}
```

Де:
1. name - назва типу колонки;
2. length - довжина значень колонок
3. nullable - чи значення може бути null
4. default - значення по замовчуванню


Система підтрмує такі типи даних:
1. int
2. float
3. varchar
4. text
5. datetime

## Обов'язково

Кожен клас має імплементувати getter і setters для всіх змінних класу, які мають
відповідні анотації.
