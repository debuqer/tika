# Tika Form Builder
This package will generate a form using well structed schema inspired by XForm, various form types, actions and events and capability of building custom one's are provided.

**Note:** This package is under development staging. _PLEASE DO NOT USE IT IN PRODUCTION APP_

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

Also actions can be defined in Form

```php
$model_config = new ConfigContainer([
    'instance' => [
        'text:first_name' => [],
        'text:last_name' => [],
        'text:name_status' => [],
    ],
    'actions' => [
        'set-value:setting-full-name' => [
            'event' => 'form.change',
            'item' => 'instance.text:name_status',
            'value' => 'name updated!',
        ]
    ]   
]);
$form = new Form();
```
 
As it shows, this action (setting-full-name) will set name_status field to "name updated!" message whenever form have changed.


**Validation**

You may pass rules to your inputs in order to validate them
```php 
$model_config = new ConfigContainer([
    'instance' => [
        'text:first_name' => [
            'validations' => [
                'not-null' => [],
            ]
        ],
        'text:last_name' => [],
    ],
    'actions' => [
        'validate:submit-form' => [
            'event' => 'on-submit',
        ]
    ]   
]);
$form = new Form();
```
