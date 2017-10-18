<?php

namespace LLkumaLL\Enum;

/**
 * 列挙型(enum)
 *
 */
abstract class Enum
{
    /**
     * 設定定数値
     * @var mixed
     */
    private $value;

    /**
     * コンストラクター
     *
     * @param mixed $value 定数値
     */
    public function __construct($value)
    {
        if (!defined('static::ENUM') || !is_array(static::ENUM)) {
            // ENUMオブジェクト定数が定義されていなければ例外を投げる
            throw new \LogicException('Enum class is needed const "ENUM", type of array.');
        }

        if (!static::isValidValue($value)) {
            throw new \InvalidArgumentException;
        }

        $this->value = $value;
    }

    /**
     * バリデーション
     *
     * @param mixed $value バリデーション対象値
     * @return bool
     */
    public static function isValidValue($value): bool
    {
        return array_key_exists($value, static::ENUM);
    }

    /**
     * 値取得
     *
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * 指定された値に対するラベル取得
     *
     * @return string ラベル文字列
     */
    public function label(): string
    {
        return (string)static::ENUM[$this->value()];
    }

    /**
     * 文字列変換
     *
     * @return string 設定値
     */
    public function __toString()
    {
        return (string)$this->value();
    }

    /**
     * 未定義staticメソッド呼び出し
     *
     * @param string $method 呼び出しを試したメソッド名
     * @param array  $args   メソッド呼び出し時の引数
     * @return mixed         定数値
     * @throws BadMethodCallException
     */
    public static function __callStatic($method, $args)
    {
        try {
            return new static($method);
        } catch (\InvalidArgumentException $e) {
            // 定数定義がない場合は例外を投げる
            throw new \BadMethodCallException("[{$method}] is not exists.");
        } catch (\Exception $e) {
            // その他の例外はそのままスロー
            throw $e;
        }
    }

    /**
     * プロパティ定義処理
     *
     */
    public function __set($key, $value)
    {
        throw new \BadMethodCallException('All setter is forbbiden.');
    }
}