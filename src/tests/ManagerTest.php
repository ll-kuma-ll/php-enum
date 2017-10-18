<?php

namespace LLkumaLL\Enum\Tests;

use PHPUnit\Framework\TestCase;
use LLkumaLL\Enum\Manager;
use LLkumaLL\Enum\Enum;

/**
 * Managerクラステスト
 *
 */
class ManagerTest extends TestCase
{
    protected function createEnumMock(string $value = 'CASE2'): Enum
    {
        return new class($value) extends Enum {
            const ENUM = [
                'CASE1' => 'test case 1',
                'CASE2' => 'test case 2',
            ];
        };
    }

    /**
     * コンストラクター引数に未定義クラス名が渡された場合のテスト
     *
     * @return void
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage is not exists
     */
    public function testFailConstructNoClassExixts()
    {
        new Manager('ClassIsNotExists');
    }

    /**
     * コンストラクター引数にEnumを継承していないクラス名が渡された場合のテスト
     *
     * @return void
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage is not subclass of
     */
    public function testFailConstructNotSublcassOfEnum()
    {
        new Manager(Manager::class);
    }

    /**
     * Enum定数取得テスト
     *
     * @return void
     */
    public function testGetConstants()
    {
        $class = get_class($this->createEnumMock());
        $manager = new Manager($class);
        $actual = $manager->getConstants();

        $this->assertTrue(is_array($actual), '->getConstants() 配列が返る');
        $this->assertArrayHasKey('CASE1', $actual, '->getConstants() 定数定義された配列が返る');
        $this->assertArrayHasKey('CASE2', $actual, '->getConstants() 定数定義された配列が返る');
    }

    /**
     * Enumインスタンス生成テスト
     *
     * @return void
     */
    public function testCreateAll()
    {
        $manager = new Manager(get_class($this->createEnumMock()));
        $actual = $manager->createAll();

        $this->assertTrue(is_array($actual), '->createAll() 配列が返る');
        $this->assertArrayHasKey('CASE1', $actual, '->createAll() Enum定数が配列キーに設定されている');
        $this->assertArrayHasKey('CASE2', $actual, '->createAll() Enum定数が配列キーに設定されている');
        
        foreach ($actual as $key => $enum) {
            $this->assertInstanceOf(Enum::class, $enum, '->createAll() 配列の値がEnumインスタンスである');
            $this->assertEquals($key, $enum->value(), '->crateAll() 配列キーとEnum設定値が同じ');
        }
    }
}