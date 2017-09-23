# php-enum
列挙型をPHPで利用するためにクラスで実装。  
毎度作成するのが面倒なので、composerライブラリとして読み込める様に作成。

```php
use LLkumaLL\Enum\Enum;

class Sample extends Enum
{
    const ENUM = [
        'VALUE_1' => 'label 1',
        'VALUE_2' => 'label 2',
    ];
}
```
