<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <!-- 优先使用 IE 最新版本和 Chrome -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <!-- 页面描述 -->
        <meta name="description" content="展示首页"/>
        <!-- 网页作者 -->
        <meta name="author" content="苏锐佳"/>
        <!-- 为移动设备添加 viewport -->
        <meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no">
        <!-- iOS 设备 begin -->
        <meta name="apple-mobile-web-app-title" content="标题">
        <!-- 添加到主屏后的标题（iOS 6 新增） -->
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <!-- 是否启用 WebApp 全屏模式，删除苹果默认的工具栏和菜单栏 -->
        <meta name="apple-itunes-app" content="app-id=myAppStoreID, affiliate-data=myAffiliateData, app-argument=myURL">
        <!-- 启用360浏览器的极速模式(webkit) -->
        <meta name="renderer" content="webkit">
        <!-- 避免IE使用兼容模式 -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- 针对手持设备优化，主要是针对一些老的不识别viewport的浏览器，比如黑莓 -->
        <meta name="HandheldFriendly" content="true">
        <!-- 微软的老式浏览器 -->
        <meta name="MobileOptimized" content="320">
        <!-- uc强制竖屏 -->
        <meta name="screen-orientation" content="portrait">
        <!-- QQ强制竖屏 -->
        <meta name="x5-orientation" content="portrait">
        <!-- UC强制全屏 -->
        <meta name="full-screen" content="yes">
        <!-- QQ强制全屏 -->
        <meta name="x5-fullscreen" content="true">
        <!-- UC应用模式 -->
        <meta name="browsermode" content="application">
        <!-- QQ应用模式 -->
        <meta name="x5-page-mode" content="app">
        <!-- windows phone 点击无高光 -->
        <meta name="msapplication-tap-highlight" content="no">
        <!-- iOS 设备 end -->
        <meta name="msapplication-TileColor" content="#000"/>
        <!-- Windows 8 磁贴颜色 -->
        <meta name="msapplication-TileImage" content="icon.png"/>

        <title>预警系统</title>

        @if(env('APP_DEBUG'))
            <link href="http://localhost:8080/build/css/app.css" rel="stylesheet">
        @else
            <link rel="stylesheet" href="{{ elixir('build/css/app.css') }}">
        @endif

        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
                'user' => [
                    'id' => Auth::user()?Auth::user()->id:null,
                    'name' => Auth::user()?Auth::user()->name:null,
                    'email' => Auth::user()?Auth::user()->email:null
                ]
            ]); ?>;
        </script>
    </head>
    <body>
        <div id="app">
            <app></app>
        </div>
        @if(env('APP_DEBUG'))
            <script src="http://localhost:8080/build/js/vendor-bundle.js"></script>
            <script src="http://localhost:8080/build/js/app.js"></script>
        @else
            <script src="{{ elixir('build/js/vendor-bundle.js') }}"></script>
            <script src="{{ elixir('build/js/app.js') }}"></script>
        @endif
    </body>
</html>
