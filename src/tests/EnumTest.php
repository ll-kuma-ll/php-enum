<?php

namespace LLkumaLL\Enum\Tests;

use PHPUnit\Framework\TestCase;
use LLkumaLL\Enum\Enum;

/**
 * Enumクラステスト
 *
 */
class EnumTest extends TestCase
{
    /**
     * モック生成
     *
     * @param  string $value コンストラクター引数
     * @return Enum
     */
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
     * コンストラクターテスト
     *
     * @return Enum
     */
    public function testConstructor(): Enum
    {
        $mock = $this->createEnumMock();
        $this->assertTrue(true, '->__constructor(param) 定数定義されている値が引数に渡されていれば成功');

        return $mock;
    }

    /**
     * オブジェクト定数未定義テスト
     *
     * @return void
     * @expectedException        LogicException
     * @expectedExceptionMessage needed const "ENUM"
     */
    public function testFailNoConstantENUM()
    {
        $mock = $this->getMockBuilder(Enum::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflection = new \ReflectionClass(Enum::class);
        $constructor = $reflection->getConstructor();
        $constructor->invokeArgs($mock, ['const test']);
    }

    /**
     * バリデーションテスト
     *
     * @return void
     */
     public function testValidValue()
     {
         $class = get_class($this->createEnumMock());

         $this->assertTrue($class::isValidValue('CASE1'), '::isValidValue(param) 引数で渡された値が定数定義されていればtrueを返す');
         $this->assertFalse($class::isValidValue('not exists const'), '::isValidValue(param) 引数で渡された値が定数定義されていなければfalseを返す');
     }
 
    /**
     * 定数定義外をパラメータに渡されたテスト
     *
     * @return void
     * @expectedException       InvalidArgumentException
     * @depends                 testValidValue
     */
    public function testFailParamNotInENUM()
    {
        $mock = $this->createEnumMock('not exists const');
    }

    /**
     * 設定値を返すテスト
     *
     * @return void
     */
    public function testValue()
    {
        $mock = $this->createEnumMock('CASE1');
        $this->assertEquals('CASE1', $mock->value(), '->value() 設定されている定数値が返る');
    }

    /**
     * ラベルテスト
     *
     * @return void
     */
    public function testLabel()
    {
        $mock = $this->createEnumMock('CASE1');
        $this->assertEquals('test case 1', $mock->label(), '->label() 設定されている定数のラベル文字列が返る');
    }

    /**
     * static定数値同名メソッドテスト
     *
     * @return void
     */
    public function testCallStatic()
    {
        $class = get_class($this->createEnumMock());
        $ins = $class::CASE1();

        $this->assertInstanceOf(Enum::class, $ins, '::__callStatic() 定数定義と同じメソッド名がコールされたらインスタンスを返す');
        $this->assertEquals('CASE1', $ins->value(), '::__callStatic() 定数設定がメソッド名と同一である');
    }

    /**
     * 未定義staticメソッド呼び出し
     *
     * @return void
     * @expectedException        BadMethodCallException
     * @expectedExceptionMessage is not exists
     */
    public function testFailCallStatic()
    {
        $class = get_class($this->createEnumMock());
        $class::NotExistsConstant();
    }

    /**
     * プロパティ定義禁止テスト
     *
     * @return void
     * @expectedException        BadMethodCallException
     * @expectedExceptionMessage All setter is forbbiden
     */
    public function testFailSetPropety()
    {
        $this->createEnumMock()->prop = 'fail';
    }
}