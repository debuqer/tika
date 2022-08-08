**Quick form generation**

Using tika, making forms is so fast and elegant. Form builder expects to get a well-decribed schema and will return a Form object instead.


```php
$schema = new ConfigContainer([
    'instance' => [
        'text:name' => [], 
        'text:email' => [],
        'numeric:age' => [],
        'select:gender' => [
            'options' => [
                'male' => 'male',
                'female' => 'female',
                'rather-not-to-say' => 'rather not to say'
            ]   
        ],
    ],
]);
$form = new Form( $schema );
```

This is all requirement to describe how a registeration form looks.

All configs must be wrapped by ConfigContainer class. This will help Tika core to be more strict on form schema.

Describing the form structure is in instance section. In this case 4 different type of input have requested to be present in the form.