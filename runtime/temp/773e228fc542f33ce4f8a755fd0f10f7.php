<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"E:\phpStudy\PHPTutorial\WWW\520jiehaoyun.com\addons\cms\view\default\show_product.html";i:1566056337;s:87:"E:\phpStudy\PHPTutorial\WWW\520jiehaoyun.com\addons\cms\view\default\common\layout.html";i:1566056337;s:88:"E:\phpStudy\PHPTutorial\WWW\520jiehaoyun.com\addons\cms\view\default\common\comment.html";i:1566056337;}*/ ?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class=""> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="renderer" content="webkit">
    <title><?php echo \think\Config::get("cms.title"); ?> - <?php echo \think\Config::get("cms.sitename"); ?></title>
    <meta name="keywords" content="<?php echo \think\Config::get("cms.keywords"); ?>"/>
    <meta name="description" content="<?php echo \think\Config::get("cms.description"); ?>"/>

    <link rel="stylesheet" media="screen" href="/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" media="screen" href="/assets/libs/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" media="screen" href="/assets/libs/fastadmin-layer/dist/theme/default/layer.css"/>
    <link rel="stylesheet" media="screen" href="/assets/addons/cms/css/swiper.min.css">
    <link rel="stylesheet" media="screen" href="/assets/addons/cms/css/common.css?v=<?php echo \think\Config::get("site.version"); ?>"/>

    <link rel="stylesheet" href="//at.alicdn.com/t/font_1104524_z1zcv22ej09.css">

    {__STYLE__}

    <!--[if lt IE 9]>
    <script src="/libs/html5shiv.js"></script>
    <script src="/libs/respond.min.js"></script>
    <![endif]-->

</head>
<body class="group-page">

<header class="header">
    <!-- S 导航 -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo \think\Config::get("cms.indexurl"); ?>"><img src="/assets/addons/cms/img/logo.png" width="180" alt=""></a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <!--如果你需要自定义NAV,可使用channellist标签来完成,这里只设置了2级,如果显示无限级,请使用cms:nav标签-->
                    <?php $__7mFr5c3eHa__ = \addons\cms\model\Channel::getChannelList(["id"=>"nav","type"=>"top","condition"=>"1=isnav"]); if(is_array($__7mFr5c3eHa__) || $__7mFr5c3eHa__ instanceof \think\Collection || $__7mFr5c3eHa__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__7mFr5c3eHa__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?>
                    <!--判断是否有子级或高亮当前栏目-->
                    <li class="<?php if($nav['has_child']): ?>dropdown<?php endif; if($nav->is_active): ?> active<?php endif; ?>">
                        <a href="<?php echo $nav['url']; ?>" <?php if($nav['has_child']): ?> data-toggle="dropdown" <?php endif; ?>><?php echo $nav['name']; if($nav['has_child']): ?> <b class="caret"></b><?php endif; ?></a>
                        <ul class="dropdown-menu" role="menu">
                            <?php $__yK2nRbzf9m__ = \addons\cms\model\Channel::getChannelList(["id"=>"sub","type"=>"son","typeid"=>$nav['id'],"condition"=>"1=isnav"]); if(is_array($__yK2nRbzf9m__) || $__yK2nRbzf9m__ instanceof \think\Collection || $__yK2nRbzf9m__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__yK2nRbzf9m__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?>
                            <li><a href="<?php echo $sub['url']; ?>"><?php echo $sub['name']; ?></a></li>
                            <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__yK2nRbzf9m__; ?>
                        </ul>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__7mFr5c3eHa__; ?>
                </ul>
                <ul class="nav navbar-right hidden">
                    <ul class="nav navbar-nav">
                        <li><a href="javascript:;" class="addbookbark"><i class="fa fa-star"></i> 加入收藏</a></li>
                        <li><a href="javascript:;" class=""><i class="fa fa-phone"></i> 联系我们</a></li>
                    </ul>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form class="form-inline navbar-form" action="<?php echo addon_url('cms/search/index'); ?>" method="get">
                            <div class="form-search hidden-sm hidden-md">
                                <input class="form-control typeahead" name="search" data-typeahead-url="<?php echo addon_url('cms/search/typeahead'); ?>" type="text" id="searchinput" placeholder="搜索">
                            </div>
                        </form>
                    </li>
                    <li class="dropdown">
                        <?php if($user): ?>
                        <a href="<?php echo url('index/user/index'); ?>" class="dropdown-toggle" data-toggle="dropdown" style="padding-top: 10px;height: 50px;">
                            <span class="avatar-img"><img src="<?php echo cdnurl($user['avatar']); ?>" style="width:30px;height:30px;border-radius:50%;" alt=""></span>
                        </a>
                        <?php else: ?>
                        <a href="<?php echo url('index/user/index'); ?>" class="dropdown-toggle" data-toggle="dropdown">会员<span class="hidden-sm">中心</span> <b class="caret"></b></a>
                        <?php endif; ?>
                        <ul class="dropdown-menu">
                            <?php if($user): ?>
                            <li><a href="<?php echo url('index/user/index'); ?>"><i class="fa fa-user fa-fw"></i>会员中心</a></li>
                            <li><a href="<?php echo addon_url('cms/user/index', [':id'=>$user['id']]); ?>"><i class="fa fa-user fa-fw"></i>我的个人主页</a></li>
                            <li><a href="<?php echo url('index/cms.archives/my'); ?>"><i class="fa fa-list fa-fw"></i>我发布的文章</a></li>
                            <li><a href="<?php echo url('index/cms.archives/post'); ?>"><i class="fa fa-pencil fa-fw"></i>发布文章</a></li>
                            <li><a href="<?php echo url('index/user/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i>注销</a></li>
                            <?php else: ?>
                            <li><a href="<?php echo url('index/user/login'); ?>"><i class="fa fa-sign-in fa-fw"></i>登录</a></li>
                            <li><a href="<?php echo url('index/user/register'); ?>"><i class="fa fa-user-o fa-fw"></i>注册</a></li>
                            <?php endif; ?>

                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <!-- E 导航 -->

</header>



<style>
    .swiper-container {
        width: 100%;
        height: 300px;
        margin-left: auto;
        margin-right: auto;
    }

    .swiper-slide {
        background-size: cover;
        background-position: center;
    }

    .gallery-top {
        height: 80%;
        width: 100%;
    }

    .gallery-thumbs {
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .gallery-thumbs .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }
    .gallery-thumbs .swiper-slide-thumb-active {
        opacity: 1;
    }

    .article-image {
        height: 820px;
    }

    @media (max-width: 767px) {

        .article-image {
            height: 400px;
        }
    }

</style>

<div class="container" id="content-container">

    <div class="row">

        <main class="col-xs-12">

            <div class="panel panel-default article-content">
                <div class="panel-heading">
                    <ol class="breadcrumb">
                        <!-- S 面包屑导航 -->
                        <?php $__y8IKdf9QZ6__ = \addons\cms\model\Channel::getBreadcrumb(isset($__CHANNEL__)?$__CHANNEL__:[], isset($__ARCHIVES__)?$__ARCHIVES__:[], isset($__TAGS__)?$__TAGS__:[], isset($__PAGE__)?$__PAGE__:[]); if(is_array($__y8IKdf9QZ6__) || $__y8IKdf9QZ6__ instanceof \think\Collection || $__y8IKdf9QZ6__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__y8IKdf9QZ6__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                        <li><a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a></li>
                        <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__y8IKdf9QZ6__; ?>
                        <!-- E 面包屑导航 -->
                    </ol>
                </div>
                <div class="panel-body">
                    <div class="article-metas">
                        <h1 class="metas-title" <?php if($__ARCHIVES__['style']): ?>style="<?php echo $__ARCHIVES__['style_text']; ?>"<?php endif; ?>>
                            <?php echo $__ARCHIVES__['title']; ?>
                        </h1>
                        <!-- S 统计信息 -->
                        <div class="metas-body">
                            <span class="views-num">
                                <i class="fa fa-eye"></i> <?php echo $__ARCHIVES__['views']; ?> 阅读
                            </span>
                            <span class="comment-num">
                                <i class="fa fa-comments"></i> <?php echo $__ARCHIVES__['comments']; ?> 评论
                            </span>
                            <span class="like-num">
                                <i class="fa fa-thumbs-o-up"></i>
                                <span class="js-like-num"> <?php echo $__ARCHIVES__['likes']; ?> 点赞
                                </span>
                            </span>
                        </div>
                        <!-- E 统计信息 -->
                    </div>
                    <?php if((isset($__ARCHIVES__['price']) && $__ARCHIVES__['price']<=0) || $__ARCHIVES__['is_paid_part_of_content']): ?>
                    <div class="article-image mt-4">

                        <div class="swiper-container gallery-top">
                            <div class="swiper-wrapper">
                                <?php if(is_array(explode(',',$__ARCHIVES__['productdata'])) || explode(',',$__ARCHIVES__['productdata']) instanceof \think\Collection || explode(',',$__ARCHIVES__['productdata']) instanceof \think\Paginator): $i = 0; $__LIST__ = explode(',',$__ARCHIVES__['productdata']);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($i % 2 );++$i;?>
                                <div class="swiper-slide" style="background-image:url(<?php echo cdnurl($image); ?>)"></div>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">
                                <?php if(is_array(explode(',',$__ARCHIVES__['productdata'])) || explode(',',$__ARCHIVES__['productdata']) instanceof \think\Collection || explode(',',$__ARCHIVES__['productdata']) instanceof \think\Paginator): $i = 0; $__LIST__ = explode(',',$__ARCHIVES__['productdata']);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($i % 2 );++$i;?>
                                <div class="swiper-slide" style="background-image:url(<?php echo cdnurl($image); ?>)"></div>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="article-text">
                        <!-- S 正文 -->
                        <p>
                            <?php echo $__ARCHIVES__['content']; ?>
                        </p>
                        <!-- E 正文 -->
                    </div>
                    <?php endif; ?>

                    <!-- S 付费阅读 -->
                    <?php if(isset($__ARCHIVES__['price']) && $__ARCHIVES__['price']>0): ?>
                    <div class="article-pay">
                        <?php if($__ARCHIVES__['ispaid']): ?>
                        <div class="alert alert-success">
                            <strong>温馨提示!</strong> 以下是付费内容
                            <b>你可以随意修改付费可见的字段或内容，这里仅测试标题：<?php echo $__ARCHIVES__['title']; ?></b>
                            请直接修改模板中需要显示的付费字段
                        </div>
                        <?php else: ?>
                        <div class="alert alert-danger">
                            <strong>温馨提示!</strong> 你需要支付 <b>￥<?php echo $__ARCHIVES__['price']; ?></b> 元后才能查看付费内容
                            <a href="<?php echo addon_url('cms/order/submit', ['id'=>$__ARCHIVES__['id']]); ?>" class="btn btn-success"><i class="fa fa-wechat"></i> 立即支付</a>
                            <a href="<?php echo addon_url('cms/order/submit', ['id'=>$__ARCHIVES__['id'],'paytype'=>'alipay']); ?>" class="btn btn-primary"><i class="fa fa-money"></i> 支付宝支付</a>
                            <a href="<?php echo addon_url('cms/order/submit', ['id'=>$__ARCHIVES__['id'],'paytype'=>'balance']); ?>" class="btn btn-warning btn-balance" data-price="<?php echo $__ARCHIVES__['price']; ?>"><i class="fa fa-dollar"></i> 余额支付</a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <!-- E 付费阅读 -->

                    <div class="article-donate">
                        <a href="javascript:" class="btn btn-primary btn-like btn-lg" data-action="vote" data-type="like" data-id="<?php echo $__ARCHIVES__['id']; ?>" data-tag="archives"><i class="fa fa-thumbs-up"></i> 点赞(<span><?php echo $__ARCHIVES__['likes']; ?></span>)</a>
                        <a href="javascript:" class="btn btn-outline-primary btn-donate btn-lg" data-image="<?php echo cdnurl($config['donateimage']); ?>" data-action="donate" data-id="<?php echo $__ARCHIVES__['id']; ?>"><i class="fa fa-cny"></i> 打赏</a>
                    </div>

                    <div class="entry-meta">
                        <ul>
                            <!-- S 归档 -->
                            <li><?php echo __('Article category'); ?>：<a href="<?php echo $__CHANNEL__['url']; ?>"><?php echo $__CHANNEL__['name']; ?></a></li>
                            <li><?php echo __('Article tags'); ?>：<?php if(is_array($__ARCHIVES__['tagslist']) || $__ARCHIVES__['tagslist'] instanceof \think\Collection || $__ARCHIVES__['tagslist'] instanceof \think\Paginator): $i = 0; $__LIST__ = $__ARCHIVES__['tagslist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><a href="<?php echo $tag['url']; ?>" class="tag" rel="tag"><?php echo $tag['name']; ?></a><?php endforeach; endif; else: echo "" ;endif; ?></li>
                            <li><?php echo __('Article views'); ?>：<span><?php echo $__ARCHIVES__['views']; ?></span> 次浏览</li>
                            <li><?php echo __('Post date'); ?>：<?php echo datetime($__ARCHIVES__['publishtime']); ?></li>
                            <li><?php echo __('Article url'); ?>：<a href="<?php echo $__ARCHIVES__['fullurl']; ?>"><?php echo $__ARCHIVES__['fullurl']; ?></a></li>
                            <!-- S 归档 -->
                        </ul>

                        <ul class="article-prevnext">
                            <!-- S 上一篇下一篇 -->
                            <?php $prev = \addons\cms\model\Archives::getPrevNext("prev", $__ARCHIVES__['id'], $__CHANNEL__['id']);if($prev): ?>
                            <li>
                                <span><?php echo __('Prev'); ?> &gt;</span>
                                <a href="<?php echo $prev['url']; ?>"><?php echo $prev['title']; ?></a>
                            </li>
                            <?php endif;$next = \addons\cms\model\Archives::getPrevNext("next", $__ARCHIVES__['id'], $__CHANNEL__['id']);if($next): ?>
                            <li>
                                <span><?php echo __('Next'); ?> &gt;</span>
                                <a href="<?php echo $next['url']; ?>"><?php echo $next['title']; ?></a>
                            </li>
                            <?php endif;?>
                            <!-- E 上一篇下一篇 -->
                        </ul>
                    </div>

                    <div class="article-action-btn">
                        <div class="pull-left">
                            <!-- S 收藏 -->
                            <a class="product-favorite addbookbark mr-2" href="javascript:;">
                                <i class="fa fa-heart"></i> <?php echo __('Favourite'); ?>
                            </a>
                            <!-- E 收藏 -->
                            <!-- S 分享 -->
                            <span class="bdsharebuttonbox share-box bdshare-button-style0-16">
                            <a class="bds_more share-box-a" data-cmd="more">
                                <i class="fa fa-share"></i> <?php echo __('Share'); ?>
                            </a>
                        </span>
                            <!-- E 分享 -->
                        </div>
                        <div class="pull-right">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="related-article">
                        <div class="row">
                            <!-- S 相关文章 -->
                            <?php $__psZiTezIDj__ = \addons\cms\model\Archives::getArchivesList(["id"=>"relate","tags"=>$__ARCHIVES__['tags'],"model"=>$__ARCHIVES__['model_id'],"row"=>"4"]); if(is_array($__psZiTezIDj__) || $__psZiTezIDj__ instanceof \think\Collection || $__psZiTezIDj__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__psZiTezIDj__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$relate): $mod = ($i % 2 );++$i;?>
                            <div class="col-sm-3 col-xs-6">
                                <a href="<?php echo $relate['url']; ?>" class="img-zoom">
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <img src="<?php echo $relate['image']; ?>" alt="<?php echo $relate['title']; ?>" class="embed-responsive-item">
                                    </div>
                                </a>
                                <h5><?php echo $relate['title']; ?></h5>
                            </div>
                            <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__psZiTezIDj__; ?>
                            <!-- E 相关文章 -->
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="panel panel-default" id="comments">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __('Comment list'); ?>
                        <small>共有 <span><?php echo $__ARCHIVES__['comments']; ?></span> 条评论</small>
                    </h3>
                </div>
                <div class="panel-body">
                    <div id="comment-container">
    <!-- S 评论列表 -->
    <div id="commentlist">
        <?php $aid = $__ARCHIVES__['id']; $__COMMENTLIST__ = \addons\cms\model\Comment::getCommentList(["id"=>"comment","type"=>"archives","aid"=>"$aid","pagesize"=>"10"]); if(is_array($__COMMENTLIST__) || $__COMMENTLIST__ instanceof \think\Collection || $__COMMENTLIST__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__COMMENTLIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$comment): $mod = ($i % 2 );++$i;?>
        <dl id="comment-<?php echo $comment['id']; ?>">
            <dt><a href="<?php echo $comment['user']['url']; ?>" target="_blank"><img src='<?php echo $comment['user']['avatar']; ?>'/></a></dt>
            <dd>
                <div class="parent">
                    <cite><a href='<?php echo $comment['user']['url']; ?>' target="_blank"><?php echo $comment['user']['nickname']; ?></a></cite>
                    <small> <?php echo human_date($comment['createtime']); ?> <a href="javascript:;" data-id="<?php echo $comment['id']; ?>" title="@<?php echo $comment['user']['nickname']; ?> " class="reply">回复TA</a></small>
                    <p><?php echo $comment['content']; ?></p>
                </div>
            </dd>
            <div class="clearfix"></div>
        </dl>
        <?php endforeach; endif; else: echo "" ;endif; $__LASTLIST__=$__COMMENTLIST__; if($__COMMENTLIST__->isEmpty()): ?>
        <div class="loadmore loadmore-line loadmore-nodata"><span class="loadmore-tips">暂无评论</span></div>
        <?php endif; ?>
    </div>
    <!-- E 评论列表 -->

    <!-- S 评论分页 -->
    <div id="commentpager" class="text-center">
        <?php echo $__COMMENTLIST__->render(["type"=>"full"]); ?>
    </div>
    <!-- E 评论分页 -->

    <!-- S 发表评论 -->
    <div id="postcomment">
        <h3>发表评论 <a href="javascript:;">
            <small>取消回复</small>
        </a></h3>
        <form action="<?php echo addon_url('cms/comment/post'); ?>" method="post" id="postform">
            <?php echo token(); ?>
            <input type="hidden" name="type" value="archives"/>
            <input type="hidden" name="aid" value="<?php echo $__ARCHIVES__['id']; ?>"/>
            <input type="hidden" name="pid" id="pid" value="0"/>
            <div class="form-group">
                <textarea name="content" class="form-control" <?php if(!$user): ?>disabled placeholder="请登录后再发表评论" <?php endif; ?> id="commentcontent" cols="6" rows="5" tabindex="4"></textarea>
            </div>
            <?php if(!$user): ?>
            <div class="form-group">
                <a href="<?php echo url('index/user/login'); ?>" class="btn btn-primary">登录</a>
                <a href="<?php echo url('index/user/register'); ?>" class="btn btn-outline-primary">注册新账号</a>
            </div>
            <?php else: ?>
            <div class="form-group">
                <input name="submit" type="submit" id="submit" tabindex="5" value="提交评论(Ctrl+回车)" class="btn btn-primary"/>
                <span id="actiontips"></span>
            </div>
            <div class="checkbox">
                <label>
                    <input name="subscribe" type="checkbox" class="checkbox" tabindex="7" checked value="1"/> 有人回复时邮件通知我
                </label>
            </div>
            <?php endif; ?>
        </form>
    </div>
    <!-- E 发表评论 -->
</div>
                </div>
            </div>

        </main>

    </div>
</div>
<script data-render="script">
        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 5,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
        });
        var galleryTop = new Swiper('.gallery-top', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: galleryThumbs
            }
        });
</script>

<footer>
    <div class="container-fluid" id="footer">
        <div class="container">
            <div class="row footer-inner">
                <div class="col-md-3 col-sm-3">
                            <div class="footer-logo">
                                <a href="#"><i class="fa fa-bookmark"></i></a>
                            </div>
                            <p class="copyright"><small>© 2017. All Rights Reserved. <br>
                                    FastAdmin
                                </small>
                            </p>
                        </div>
                        <div class="col-md-5 col-md-push-1 col-sm-5 col-sm-push-1">
                            <div class="row">
                                <div class="col-xs-4">
                                    <ul class="links">
                                        <li><a href="#">关于我们</a></li>
                                        <li><a href="#">发展历程</a></li>
                                        <li><a href="#">服务项目</a></li>
                                        <li><a href="#">团队成员</a></li>
                                    </ul>
                                </div>
                                <div class="col-xs-4">
                                    <ul class="links">
                                        <li><a href="#">新闻</a></li>
                                        <li><a href="#">资讯</a></li>
                                        <li><a href="#">推荐</a></li>
                                        <li><a href="#">博客</a></li>
                                    </ul>
                                </div>
                                <div class="col-xs-4">
                                    <ul class="links">
                                        <li><a href="#">服务</a></li>
                                        <li><a href="#">圈子</a></li>
                                        <li><a href="#">论坛</a></li>
                                        <li><a href="#">广告</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-md-push-1 col-sm-push-1">
                            <div class="footer-social">
                                <a href="#"><i class="fa fa-weibo"></i></a>
                                <a href="#"><i class="fa fa-qq"></i></a>
                                <a href="#"><i class="fa fa-wechat"></i></a>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</footer>

<div id="floatbtn">
    <!-- S 浮动按钮 -->

    <?php if(isset($config['wxapp'])&&$config['wxapp']): ?>
    <a href="javascript:;">
        <i class="iconfont icon-wxapp"></i>
        <div class="floatbtn-wrapper">
            <div class="qrcode"><img src="<?php echo cdnurl($config['wxapp']); ?>"></div>
            <p>微信小程序</p>
            <p>微信扫一扫体验</p>
        </div>
    </a>
    <?php endif; ?>

    <a class="hover" href="<?php echo url('index/cms.archives/post'); ?>" target="_blank">
        <i class="iconfont icon-pencil"></i>
        <em>立即<br>投稿</em>
    </a>

    <?php if($config['qrcode']): ?>
    <a href="javascript:;">
        <i class="iconfont icon-qrcode"></i>
        <div class="floatbtn-wrapper">
            <div class="qrcode"><img src="<?php echo cdnurl($config['qrcode']); ?>"></div>
            <p>微信公众账号</p>
            <p>微信扫一扫加关注</p>
        </div>
    </a>
    <?php endif; if(isset($__ARCHIVES__)): ?>
    <a id="feedback" class="hover" href="#comments">
        <i class="iconfont icon-feedback"></i>
        <em>发表<br>评论</em>
    </a>
    <?php endif; ?>

    <a id="back-to-top" class="hover" href="javascript:;">
        <i class="iconfont icon-backtotop"></i>
        <em>返回<br>顶部</em>
    </a>
    <!-- E 浮动按钮 -->
</div>


<script type="text/javascript" src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/libs/fastadmin-layer/dist/layer.js"></script>
<script type="text/javascript" src="/assets/libs/art-template/dist/template-native.js"></script>
<script type="text/javascript" src="/assets/addons/cms/js/bootstrap-typeahead.min.js"></script>
<script type="text/javascript" src="/assets/addons/cms/js/swiper.min.js"></script>
<script type="text/javascript" src="/assets/addons/cms/js/cms.js?r=<?php echo $site['version']; ?>"></script>
<script type="text/javascript" src="/assets/addons/cms/js/common.js?r=<?php echo $site['version']; ?>"></script>

{__SCRIPT__}

</body>
</html>