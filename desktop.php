<?php

    if (defined('LOADED') == false)
        exit;

    use Librarys\App\AppAssets;
    use Librarys\App\AppDirectory;
    use Librarys\App\Config\AppConfig;

    requireDefine('asset');

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Manager </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow, noodp, nodir"/>
        <meta name="Cache-Control" content="private, max-age=0, no-cache, no-store, must-revalidate"/>
        <meta name="Pragma" content="no-cache"/>
        <meta name="Expires" content="Thu, 01 Jan 1970 00:00:00 GMT">

        <link
            rel="icon"
            type="image/png"
            href="<?php echo AppAssets::makeURLResourceIcon(AppConfig::getInstance()->get('theme.directory'), env('resource.filename.icon.favicon_png')); ?>"/>

        <link
            rel="icon"
            type="image/x-icon"
            href="<?php echo AppAssets::makeURLResourceIcon(AppConfig::getInstance()->get('theme.directory'), env('resource.filename.icon.favicon_ico')); ?>"/>

        <link
            rel="shortcut icon"
            type="image/x-icon"
            href="<?php echo AppAssets::makeURLResourceIcon(AppConfig::getInstance()->get('theme.directory'), env('resource.filename.icon.favicon_ico')); ?>"/>

        <link
            rel="stylesheet"
            type="text/css"
            media="all"
            href="<?php echo AppAssets::makeURLResourceTheme(AppConfig::getInstance()->get('theme.directory'), 'theme_desktop'); ?>"/>

        <script
            type="text/javascript"
            src="<?php echo AppAssets::makeURLResourceJavascript(env('resource.filename.javascript.desktop.file.require'), env('resource.filename.javascript.desktop.directory.lib')); ?>"
            data-main="<?php echo AppAssets::makeURLResourceJavascript(env('resource.filename.javascript.desktop.file.bundle'), env('resource.filename.javascript.desktop.directory.base')); ?>"></script>
    </head>
    <body>
        <div id="container-full">
            <div id="header">
                <div id="logo">
                    <a href="<?php echo env('app.http.host'); ?>">
                        <span class="icomoon icon-home"></span>
                    </a>
                </div>
                <ul id="action">
                    <li login="true">
                        <a href="#">
                            <span class="icomoon icon-search"></span>
                        </a>
                    </li>
                    <li login="true">
                        <a href="#">
                            <span class="icomoon icon-mysql"></span>
                        </a>
                    </li>
                    <li login="true">
                        <a href="#">
                            <span class="icomoon icon-config"></span>
                        </a>
                    </li>
                    <li class="about" login="false">
                        <a href="#">
                            <span class="icomoon icon-about"></span>
                        </a>
                    </li>
                    <li login="true">
                        <a href="#">
                            <span class="icomoon icon-exit"></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="container">
                <div id="sidebar">
                    <div class="sidebar-file scroll-wrapper">
                        <div class="scroll-content">
                            <ul class="list-file">
                                <li>
                                    <p class="root">
                                        <span class="icomoon icon-spinner spinner-animation"></span>
                                        <span><?php echo AppDirectory::getInstance()->getSuperRoot(); ?></span>
                                    </p>

                                    <ul>
                                        <li>
                                            <p>
                                                <span class="icomoon icon-folder"></span>
                                                <span>incfiles</span>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <span class="icomoon icon-folder"></span>
                                                <span>system</span>
                                            </p>

                                            <ul>
                                                <li>
                                                    <p>
                                                        <span class="icomoon icon-folder"></span>
                                                        <span>incfiles</span>
                                                    </p>
                                                </li>
                                                <li>
                                                    <p>
                                                        <span class="icomoon icon-folder"></span>
                                                        <span>system</span>
                                                    </p>
                                                </li>
                                                <li>
                                                    <p>
                                                        <span class="icomoon icon-folder"></span>
                                                        <span>page</span>
                                                    </p>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p>
                                                <span class="icomoon icon-folder"></span>
                                                <span>page</span>
                                            </p>

                                            <ul>
                                                <li>
                                                    <p>
                                                        <span class="icomoon icon-folder"></span>
                                                        <span>incfiles</span>
                                                    </p>
                                                </li>
                                                <li>
                                                    <p>
                                                        <span class="icomoon icon-folder"></span>
                                                        <span>system</span>
                                                    </p>
                                                </li>
                                                <li>
                                                    <p>
                                                        <span class="icomoon icon-folder"></span>
                                                        <span>page</span>
                                                    </p>

                                                    <ul>
                                                        <li>
                                                            <p>
                                                                <span class="icomoon icon-folder"></span>
                                                                <span>incfiles</span>
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                <span class="icomoon icon-folder"></span>
                                                                <span>system</span>
                                                            </p>

                                                            <ul>
                                                                <li>
                                                                    <p>
                                                                        <span class="icomoon icon-folder"></span>
                                                                        <span>incfiles</span>
                                                                    </p>

                                                                    <ul>
                                                                        <li>
                                                                            <p>
                                                                                <span class="icomoon icon-folder"></span>
                                                                                <span>incfiles</span>
                                                                            </p>
                                                                        </li>
                                                                        <li>
                                                                            <p>
                                                                                <span class="icomoon icon-folder"></span>
                                                                                <span>system</span>
                                                                            </p>
                                                                        </li>
                                                                        <li>
                                                                            <p>
                                                                                <span class="icomoon icon-folder"></span>
                                                                                <span>page</span>
                                                                            </p>
                                                                        </li>
                                                                        <li>
                                                                            <p>
                                                                                <span class="icomoon icon-file"></span>
                                                                                <span>index.php</span>
                                                                            </p>

                                                                            <ul>
                                                                                <li>
                                                                                    <p>
                                                                                        <span class="icomoon icon-folder"></span>
                                                                                        <span>incfiles</span>
                                                                                    </p>
                                                                                </li>
                                                                                <li>
                                                                                    <p>
                                                                                        <span class="icomoon icon-folder"></span>
                                                                                        <span>system</span>
                                                                                    </p>
                                                                                </li>
                                                                                <li>
                                                                                    <p>
                                                                                        <span class="icomoon icon-folder"></span>
                                                                                        <span>page ijfgiojfdjgifjgijfidfgdfgfdgdfffffffffffffffffffffffffffffffffffg</span>
                                                                                    </p>
                                                                                </li>
                                                                                <li>
                                                                                    <p>
                                                                                        <span class="icomoon icon-file"></span>
                                                                                        <span>index.php</span>
                                                                                    </p>
                                                                                </li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <span class="icomoon icon-folder"></span>
                                                                        <span>system</span>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <span class="icomoon icon-folder"></span>
                                                                        <span>page</span>
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p>
                                                                        <span class="icomoon icon-file"></span>
                                                                        <span>index.php</span>
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                <span class="icomoon icon-folder"></span>
                                                                <span>page</span>
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p>
                                                                <span class="icomoon icon-file"></span>
                                                                <span>index.php</span>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <p>
                                                        <span class="icomoon icon-file"></span>
                                                        <span>index.php</span>
                                                    </p>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p>
                                                <span class="icomoon icon-folder"></span>
                                                <span>system</span>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                <span class="icomoon icon-file"></span>
                                                <span>index.php</span>
                                            </p>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-database scroll-wrapper">
                        <div class="scroll-content">

                        </div>
                    </div>
                </div>
                <div id="content">

                </div>
                <div id="login">
                    <form action="#" method="post" onsubmit="return false" autocomplete="off">
                        <ul>
                            <li class="input">
                                <input type="text" name="username" value="" lng="user.login.form.input_username_placeholder" autocomplete="off"/>
                                <span class="icomoon icon-user"></span>
                            </li>
                            <li class="input">
                                <input type="password" name="password" value="" lng="user.login.form.input_password_placeholder" autocomplete="off"/>
                                <span class="icomoon icon-key"></span>
                            </li>
                            <li class="button">
                                <button type="submit" name="login">
                                    <span lng="user.login.form.button_login"></span>
                                </button>
                                <a href="#">
                                    <span lng="user.login.form.forgot_password"></span>
                                </a>
                            </li>
                        </ul>
                    </form>
                </div>
                <div id="alert">
                    <ul></ul>
                </div>
                <div id="loading">
                    <div id="box">
                        <span class="icomoon icon-spinner spinner-animation"></span>
                        <span class="notice"><?php echo lng('default.loading'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>