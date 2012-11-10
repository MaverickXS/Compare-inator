<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title> <? if ($page_title!=''){ echo $page_title .' - '; } ?>Compare-inator </title>
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Carter+One' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/bootstrap-responsive.min.css">
		<link rel="stylesheet" href="/css/styles.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/common-inator.js"></script>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-24270263-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </head>

    <body>
        <div class="container">
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <a href="/" class="brand pull-left">Compare-inator</a>
                        <ul class="nav pull-left">
                            <li<? if ($active_link==''){ ?> class="active"<? } ?>><a href="/"><span class="icon-home icon-white"></span> Home</a></li>
                            <li<? if ($active_link=='user'){ ?> class="active"<? } ?>><a href="/user_list/"><span class="icon-user icon-white"></span> Users</a></li>
                            <li<? if ($active_link=='game'){ ?> class="active"<? } ?>><a href="/game_list/"><span class="icon-headphones icon-white"></span> Games</a></li>
                        </ul>
                        <form class="navbar-search pull-left"><input type="search" class="search-query" placeholder="Search" /></form>

                        <ul class="nav pull-right">
                            <? if ($logged_in){ ?>
                                <li class="navbar-text<? if ($active_link=='login'){ ?> active<? } ?>">Game on, <strong><a href="/dashboard/"><?=$user['username'];?></a></strong>!</li>
                                <li><a href="/logout/"><span class="icon-off icon-white"></span> Logout</a></li>
                            <? } else { ?>
                                <li<? if ($active_link=='login'){ ?> class="active"<? } ?>><a href="/login/"><span class="icon-off icon-white"></span> Login</a></li>
                                <li<? if ($active_link=='register'){ ?> class="active"<? } ?>><a href="/register/"><span class="icon-pencil icon-white"></span> Register</a></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <h1><?=$page_title;?></h1>