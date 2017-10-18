# php-enum
列挙型をPHPで利用するためにクラスで実装。  
毎度作成するのが面倒なので、composerライブラリとして読み込める様に作成。

## Composer設定

```bash
php composer.phar require ll-kuma-ll/php-enum
```

## 定義サンプル

```php
namespace Foo;

use LLkumaLL\Enum\Enum;

class Sample extends Enum
{
    const ENUM = [
        'VALUE_1' => 'label 1',
        'VALUE_2' => 'label 2',
    ];
}
```

## 利用サンプル

```php
use LLkumaLL\Enum\Manager;
use Foo\Sample;

// 単独で使いたい場合
$enum = Sample::VALUE_1();
// 'label 1' が出力される
echo $enum->label();
// 'VALUE_1' が出力される
echo $enum->value();

// まとめて取り扱いたい場合
$manager = new Manager(Sample::class);

// ENUM定数配列の定義分全部をループ処理
foreach ($manager->createAll() as $const => $enum) {
    // '同じ'が出力される
    echo $const == $enum->value() ? '同じ' : '違う';
}
```