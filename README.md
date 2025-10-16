![Weave](https://github.com/user-attachments/assets/6a7d7f71-3921-48b3-bf25-afb03e0fa430)


# Weave

An easy and elegant way to interpolate and stub strings.


## Installation
```php
composer require princejohnsantillan/weave
```

## Usage
```php
weave("Hi {{name}}!", ["Prince"]); // Hi Prince!

weave("Today is {{:now,Y-m-d}}!"); // Today is 2025-10-14!

weave("{{title:headline}}", ["this is a breaking news"]) //This Is A Breaking News
```

Any string manipulation you can see in Laravel's string docs is pretty much supported. https://laravel.com/docs/12.x/strings 
