<?php

namespace LLkumaLL\Enum;

/**
 * 列挙型管理クラス
 *
 */
class Manager
{
    /**
     * Enum継承クラス名
     * @var string
     */
    private $class_name;

    /**
     * コンストラクター
     *
     * @param string $class_name Enum継承クラス名
     */
    public function __construct(string $class_name)
    {
        if (!class_exists($class_name)) {
            // 未定義のクラス名が渡された場合は例外を投げる
            throw new \InvalidArgumentException("[$class_name] is not exists");
        }

        if (!is_subclass_of($class_name, Enum::class)) {
            // Enumクラスを継承していないクラス名が渡された場合は例外を投げる
            throw new \InvalidArgumentException("[$class_name] is not subclass of ".Enum::class);
        }

        $this->class_name = $class_name;
    }

    /**
     * 定数定義一覧
     *
     * @return array
     */
    public function getConstants(): array
    {
        return $this->class_name::ENUM ?? [];
    }

    /**
     * 列挙型全値インスタンス生成
     *
     * @return array 列挙型インスタンス配列
     */
    public function createAll(): array
    {
        $ins = [];
        $class = $this->class_name;

        foreach ($this->getConstants() as $key => $label) {
            $ins[$key] = $class::$key();
        }

        return $ins;
    }
}