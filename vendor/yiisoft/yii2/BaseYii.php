<?php
/**
 * User: 彩色珊瑚
 * Date: 2016/7/14
 * Time: 21:52
 * Email:lq8841149@163.com
 */

namespace yii;

use yii\di\Container;

class BaseYii
{

    /**
     * @var Container [[createObject()]]使用依赖注入(DI)容器。你可以使用[[Container::set]]
     * 设置需要依赖的类和初始属性值。
     * @see createObject()
     * @see Container
     */
    public static $container;

    /**
     * 根据给定的配置，创建一个新的对象
     *
     * 你可以吧这个方法看做是加强版的`new`操作
     * 这个方法可以根据一个类名或一个数组格式的配置或一个匿名函数
     * ```php
     * // 使用类名创建一个对象
     * $object = Yii::createObject('yii\db\Connection');
     *
     * // 使用数组格式的配置创建一个对象
     * $object = Yii::createObject([
     *     'class' => 'yii\db\Connection',
     *     'dsn' => 'mysql:host=127.0.0.1;dbname=demo',
     *     'username' => 'root',
     *     'password' => '',
     *     'charset' => 'utf8',
     * ]);
     *
     * // 使用两个构造函数的参数创建一个对象
     * $object = \Yii::createObject('MyClass', [$param1, $param2]);
     * ```
     *
     * 使用 [[\yii\di\Container|依赖注入容器]]
     * @param $type
     * @param array $params
     */
    public static function createObject($type,array $params=[])
    {

    }
}



























