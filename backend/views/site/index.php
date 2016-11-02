<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$this->params['breadcrumbs'][] = ['label' => '后台界面', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-3 ">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            管理员信息
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li><span class="glyphicon glyphicon-user"></span> 亲爱的
                                    <small> <?= Yii::$app->getUser()->identity->username; ?></small>
                                </li>
                                <li><span class="glyphicon glyphicon-user"></span> 现在是:
                                    <small>2016年10月31日 18:31</small>
                                </li>
                                <li><span class="glyphicon glyphicon-user"></span> 太阳不错，到处看看吧</li>
                                <li><span class="glyphicon glyphicon-user"></span> 上一次登陆：
                                    <small>2016年09月28日</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            最新动态
                            <a href="###" class="pull-right"> 更多<span class="glyphicon glyphicon-cog"></span></a>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                                <li><a href="">不知道填充什么好</a> <span class="pull-right">2016-02-13</span></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div id="myCarousel" class="carousel slide">
                <!-- 轮播（Carousel）指标 -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <!-- 轮播（Carousel）项目 -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="images/test1.jpg" alt="First slide" class="img-responsive img-thumbnail">
                    </div>
                    <div class="item">
                        <img src="images/test2.jpg" alt="Second slide" class="img-responsive img-thumbnail">
                    </div>
                    <div class="item">
                        <img src="images/test3.jpg" alt="Third slide" class="img-responsive img-thumbnail">
                    </div>
                </div>
                <!-- 轮播（Carousel）导航 -->
                <a class="carousel-control left" href="#myCarousel"
                   data-slide="prev">&lsaquo;
                </a>
                <a class="carousel-control right" href="#myCarousel"
                   data-slide="next">&rsaquo;
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    空闲1
                </div>
                <div class="panel-body">
                    预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留
                    预留
                    预留
                    预留
                    预留
                    预留
                    预留
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    空闲1
                </div>
                <div class="panel-body">
                    预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留
                    预留
                    预留
                    预留
                    预留
                    预留
                    预留
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    空闲1
                </div>
                <div class="panel-body">
                    预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留
                    预留
                    预留
                    预留
                    预留
                    预留
                    预留
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    空闲1
                </div>
                <div class="panel-body">
                    预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留
                    预留
                    预留
                    预留
                    预留
                    预留
                    预留
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    空闲1
                </div>
                <div class="panel-body">
                    预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留
                    预留
                    预留
                    预留
                    预留
                    预留
                    预留
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    空闲1
                </div>
                <div class="panel-body">
                    预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留预留
                    预留
                    预留
                    预留
                    预留
                    预留
                    预留
                </div>
            </div>
        </div>
    </div>
</div>
