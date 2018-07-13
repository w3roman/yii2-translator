# yii2-translator

- [Installation](#installation)
- [Usage](#usage)

## Installation

``` sh
composer require w3lifer/yii2-translator
```

1. Add this to your application configuration:

``` php
<?php

return [
    // ...
    'modules' => [
        // ...
        'translator' => [
            'class' => 'w3lifer\yii2\translator\Module',
            'email' => 'john.doe@example.com',
        ],
        // ...
    ],
    // ...
];
```

2. Follow this link: `https://example.com/translator`.
