<?php

/**
 * User: sometimes
 * Date: 2016/10/23
 * Time: 9:59
 */

/**
 * 如果一个类的实例想要支持可定制的表示方式，则可以实现接口Arrayable
 *
 * 例如，如果一个类实现了接口Arrayable，那么该类的一个实例会通过调用[[toArray]]将自身转化为一个数组（包括实例自身嵌入的对象），这会让
 * 以后再将其转化为别的形式变得更容易，比如JSON,XML类的格式
 *
 * 方法[[fields]]和[[extraFields]]允许实现实现该接口的类，定制如果格式化数据并由[[toArrayx]]方法显示出来
 */
interface Arrayable
{

}