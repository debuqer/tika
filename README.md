# Tika Form Builder
This package will generate a form using well structed schema inspired by XForm, various form types, actions and events and capability of building custom one's are provided.

**Installation**

This package is in developing state and not available to use 

**Quick start**

```php
$model_config = new ConfigContainer([
    'instance' => [
        'text:first_name' => [],
        'text:last_name' => [],
    ]   
]);
$form = new Form();
```

This simple start will generate a form with 2 fields, first_name and last_name.

