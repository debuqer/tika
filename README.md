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

**Actions**

Also events can be defined in Form

```php
$model_config = new ConfigContainer([
    'instance' => [
        'text:first_name' => [],
        'text:last_name' => [],
        'text:full_name' => [],
    ],
    'actions' => [
        'set-value:setting-full-name' => [
            'event' => 'form.change',
            'item' => 'instance.text:full_name',
            'value' => 'form.get("instance.text:first_name.value") ~" " ~ form.get("instance.text:last_name.value")',
            'consitions' => 'form.get("instance.text:first_name.value") == "john" '
        ]
    ]   
]);
$form = new Form();
```

Using this scenario after any change of form this action will run, considering conditions in it and if condition satisfied the value of full_name input will be concat of first_name and last_name 

