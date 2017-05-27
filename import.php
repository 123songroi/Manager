<?php

    use Librarys\File\FileInfo;
    use Librarys\App\AppDirectory;
    use Librarys\App\AppLocationPath;
    use Librarys\App\AppParameter;
    use Librarys\App\AppURLCurl;

    define('LOADED',               1);
    define('EXISTS_FUNC_OVERRIDE', 1);
    define('EXISTS_FUNC_SKIP',     2);
    define('EXISTS_FUNC_RENAME',   3);
    define('MODE_IMPORT_CURL',     1);
    define('MODE_IMPORT_SOCKET',   2);

    require_once('incfiles' . DIRECTORY_SEPARATOR . 'global.php');

    if ($appUser->isLogin() == false)
        $appAlert->danger(lng('login.alert.not_login'), ALERT_LOGIN, 'user/login.php');

    $title   = lng('import.title_page');
    $themes  = [ env('resource.theme.file') ];
    $scripts = [ env('resource.javascript.more_input_url') ];
    $appAlert->setID(ALERT_IMPORT);
    require_once('incfiles' . SP . 'header.php');

    if ($appDirectory->isDirectoryExists() == false)
        $appAlert->danger(lng('home.alert.path_not_exists'), ALERT_INDEX, env('app.http.host'));
    else if ($appDirectory->isPermissionDenyPath())
        $appAlert->danger(lng('home.alert.path_not_permission', 'path', $appDirectory->getDirectory()), ALERT_INDEX, env('app.http.host'));

    $appLocationPath = new AppLocationPath($appDirectory, 'import.php');
    $appLocationPath->setIsPrintLastEntry(true);

    $appParameter = new AppParameter();
    $appParameter->add(AppDirectory::PARAMETER_DIRECTORY_URL, $appDirectory->getDirectoryEncode(), true);
    $appParameter->add(AppDirectory::PARAMETER_PAGE_URL,      $appDirectory->getPage(),            $appDirectory->getPage() > 1);

    $forms = [
        'urls'        => null,
        'filenames'   => null,
        'is_empty'    => true,
        'urls_count'  => 0,
        'exists_func' => EXISTS_FUNC_OVERRIDE,
        'mode_import' => MODE_IMPORT_CURL
    ];

    if (isset($_POST['import'])) {
        $forms['exists_func'] = intval($_POST['exists_func']);
        $forms['mode_import'] = intval($_POST['mode_import']);

        if (isset($_POST['urls']) == false || is_array($_POST['urls']) == false) {
            $appAlert->danger(lng('import.alert.data_empty_or_not_validate'));
        } else if ($forms['exists_func'] !== EXISTS_FUNC_OVERRIDE && $forms['exists_func'] !== EXISTS_FUNC_SKIP && $forms['exists_func'] !== EXISTS_FUNC_RENAME) {
            $appAlert->danger(lng('import.alert.exists_func_not_validate'));
        } else if ($forms['mode_import'] !== MODE_IMPORT_CURL && $forms['mode_import'] !== MODE_IMPORT_SOCKET) {
            $appAlert->danger(lng('import.alert.mode_import_not_validate'));
        } else {
            $isFailed            = false;
            $forms['is_empty']   = true;
            $forms['urls_count'] = count($_POST['urls']);

            foreach ($_POST['urls'] AS $index => $url) {
                if (empty($url) == false) {
                    $forms['is_empty'] = false;
                    $forms['urls'][$index] = addslashes($_POST['urls'][$index]);

                    if (isValidateURL($forms['urls'][$index]) == false) {
                        $isFailed = true;
                        $appAlert->danger(lng('import.alert.url_import_not_validate', 'url', $url));
                    }
                }

                if (isset($_POST['filenames'][$index]) && empty($_POST['filenames'][$index]) == false) {
                    $forms['filenames'][$index] = addslashes($_POST['filenames'][$index]);

                    if ($isFailed == false && empty($url) == false && empty($forms['filenames'][$index]) == false && FileInfo::isNameValidate($forms['filenames'][$index]) == false)
                        $appAlert->danger(lng('import.alert.name_url_import_not_validate', 'name', $forms['filenames'][$index]));
                }
            }

            if ($forms['is_empty']) {
                $appAlert->danger(lng('import.alert.not_input_urls'));
            } else if ($isFailed == false) {
                for ($i = 0; $i < $forms['urls_count']; ++$i) {
                    $url      = null;
                    $filename = null;

                    if (isset($forms['urls'][$i]))
                        $url = $forms['urls'][$i];

                    if ($url != null) {
                        if (isset($forms['filenames'][$i]))
                            $filename = $forms['filenames'][$i];

                        if (empty($filename))
                            $filename = baseNameURL($url);

                        $curl = new AppURLCurl($url);
                        $curl->setUseCurl($forms['mode_import'] === MODE_IMPORT_CURL);

                        if ($curl->curl() == false) {
                            $errorInt = $curl->getErrorInt();

                            if ($errorInt === AppURLCurl::ERROR_URL_NOT_FOUND)
                                $appAlert->danger(lng('import.alert.address_not_found', 'url', $url));
                            else if ($errorInt === AppURLCurl::ERROR_NOT_FOUND)
                                $appAlert->danger(lng('import.alert.file_not_found', 'url', $url));
                            else if ($errorInt === AppURLCurl::ERROR_AUTO_REDIRECT)
                                $appAlert->danger(lng('import.alert.auto_redirect_url_failed', 'url', $url));
                            else if ($errorInt === AppURLCurl::ERROR_CONNECT_FAILED)
                                $appAlert->danger(lng('import.alert.connect_url_failed', 'url', $url));
                            else
                                $appAlert->danger(lng('import.alert.error_unknown', 'url', $url));
                        } else {

                        }
                    }
                }
            }
        }

        $forms['urls']      = stripslashesArray($forms['urls']);
        $forms['filenames'] = stripslashesArray($forms['filenames']);
    }

    if ($forms['urls_count'] <= 0)
        $forms['urls_count'] = 1;
?>

    <?php $appAlert->display(); ?>
    <?php $appLocationPath->display(); ?>

    <div class="form-action">
        <div class="title">
            <span><?php echo lng('import.title_page'); ?></span>
        </div>
        <form action="import.php<?php echo $appParameter->toString(); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $boot->getCFSRToken()->getName(); ?>" value="<?php echo $boot->getCFSRToken()->getToken(); ?>"/>

            <ul class="form-element">
                <?php for ($i = 0; $i < $forms['urls_count']; ++$i) { ?>
                    <li class="input"<?php if ($i === $forms['urls_count'] - 1) { ?> id="template-input-url"<?php } ?> name="url_<?php echo $i; ?>">
                        <span><?php echo lng('import.form.input.label_import', 'count', $i + 1); ?></span>
                        <input type="text" name="urls[]" value="<?php if ($forms['urls'] != null && isset($forms['urls'][$i])) echo htmlspecialchars($forms['urls'][$i]); ?>" placeholder="<?php echo lng('import.form.placeholder.input_url'); ?>"/>
                        <input type="text" name="filenames[]" value="<?php if ($forms['filenames'] != null && isset($forms['filenames'][$i])) echo htmlspecialchars($forms['filenames'][$i]); ?>" placeholder="<?php echo lng('import.form.placeholder.input_filename'); ?>"/>
                    </li>
                <?php } ?>

                <li class="radio-choose">
                    <span><?php echo lng('import.form.input.label_exists_func'); ?></span>
                    <ul class="radio-choose-tab">
                        <li>
                            <input type="radio" name="exists_func" value="<?php echo EXISTS_FUNC_OVERRIDE; ?>" id="exists_func_override"<?php if ($forms['exists_func'] === EXISTS_FUNC_OVERRIDE) { ?> checked="checked"<?php } ?>/>
                            <label for="exists_func_override">
                                <span><?php echo lng('import.form.input.exists_func_override'); ?></span>
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="exists_func" value="<?php echo EXISTS_FUNC_SKIP; ?>" id="exists_func_skip"<?php if ($forms['exists_func'] === EXISTS_FUNC_SKIP) { ?> checked="checked"<?php } ?>/>
                            <label for="exists_func_skip">
                                <span><?php echo lng('import.form.input.exists_func_skip'); ?></span>
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="exists_func" value="<?php echo EXISTS_FUNC_RENAME; ?>" id="exists_func_rename"<?php if ($forms['exists_func'] == EXISTS_FUNC_RENAME) { ?> checked="checked"<?php } ?>/>
                            <label for="exists_func_rename">
                                <span><?php echo lng('import.form.input.exists_func_rename'); ?></span>
                            </label>
                        </li>
                    </ul>
                </li>

                <li class="radio-choose">
                    <span><?php echo lng('import.form.input.label_mode_import'); ?></span>
                    <ul class="radio-choose-tab">
                        <li>
                            <input type="radio" name="mode_import" value="<?php echo MODE_IMPORT_CURL; ?>" id="mode-import-curl"<?php if ($forms['mode_import'] == MODE_IMPORT_CURL) { ?> checked="checked"<?php } ?>/>
                            <label for="mode-import-curl">
                                <span><?php echo lng('import.form.input.mode_import_curl'); ?></span>
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="mode_import" value="<?php echo MODE_IMPORT_SOCKET; ?>" id="mode-import-socket"<?php if ($forms['mode_import'] == MODE_IMPORT_SOCKET) { ?> checked="checked"<?php } ?>/>
                            <label for="mode-import-socket">
                                <span><?php echo lng('import.form.input.mode_import_socket'); ?></span>
                            </label>
                        </li>
                    </ul>
                </li>

                <li class="button">
                    <button type="button" onclick="javascript:MoreInputUrl.onAddMoreInputUrl('template-input-url', 'url_', 'label_index');">
                        <span><?php echo lng('import.form.button.more'); ?></span>
                    </button>
                    <button type="submit" name="import" id="button-save-on-javascript">
                        <span><?php echo lng('import.form.button.import'); ?></span>
                    </button>
                    <a href="index.php<?php echo $appParameter->toString(); ?>">
                        <span><?php echo lng('import.form.button.cancel'); ?></span>
                    </a>
                </li>
            </ul>
        </form>
    </div>

    <ul class="alert">
        <li class="info">
            <span><?php echo lng('import.alert.tips'); ?></span>
        </li>
    </ul>

    <ul class="menu-action">
        <li>
            <a href="create.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-folder-create"></span>
                <span><?php echo lng('home.menu_action.create'); ?></span>
            </a>
        </li>
        <li>
            <a href="upload.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-folder-upload"></span>
                <span><?php echo lng('home.menu_action.upload'); ?></span>
            </a>
        </li>
    </ul>

<?php require_once('incfiles' . SP . 'footer.php'); ?>

<?php
/* define('ACCESS', true);

    include_once 'function.php';

    if (IS_LOGIN) {
        $title = 'Tải lên tập tin';

        include_once 'header.php';

        echo '<div class="title">' . $title . '</div>';

        if ($dir == null || !is_dir(processDirectory($dir))) {
            echo '<div class="list"><span>Đường dẫn không tồn tại</span></div>
            <div class="title">Chức năng</div>
            <ul class="list">
                <li><img src="icon/list.png"/> <a href="index.php' . $pages['paramater_0'] . '">Danh sách</a></li>
            </ul>';
        } else {
            $dir = processDirectory($dir);

            if (isset($_POST['submit'])) {
                $isEmpty = true;

                foreach ($_POST['url'] AS $entry) {
                    if (!empty($entry)) {
                        $isEmpty = false;
                        break;
                    }
                }

                if ($isEmpty) {
                    echo '<div class="notice_failure">Chưa nhập url nào cả</div>';
                } else {
                    for ($i = 0; $i < count($_POST['url']); ++$i) {
                        if (!empty($_POST['url'][$i])) {
                            $_POST['url'][$i] = processImport($_POST['url'][$i]);

                            if (!isURL($_POST['url'][$i]))
                                echo '<div class="notice_failure">URL <strong class="url_import">' . $_POST['url'][$i] . '</strong> không hợp lệ</div>';
                            else if (import($_POST['url'][$i], $dir . '/' . basename($_POST['url'][$i])))
                                echo '<div class="notice_succeed">Nhập khẩu tập tin <strong class="file_name_import">' . basename($_POST['url'][$i]) . '</strong>, <span class="file_size_import">' . size(filesize($dir . '/' . basename($_POST['url'][$i]))) . '</span> thành công</div>';
                            else
                                echo '<div class="notice_failure">Nhập khẩu tập tin <strong class="file_name_import">' . basename($_POST['url'][$i]) . '</strong> thất bại</div>';
                        }
                    }
                }
            }

            echo '<div class="list">
                <span>' . printPath($dir, true) . '</span><hr/>
                <form action="import.php?dir=' . $dirEncode . $pages['paramater_1'] . '" method="post">
                    <span class="bull">&bull;</span>URL 1:<br/>
                    <input type="text" name="url[]" size="18"/><br/>
                    <span class="bull">&bull;</span>URL:<br/>
                    <input type="text" name="url[]" size="18"/><br/>
                    <span class="bull">&bull;</span>URL 3:<br/>
                    <input type="text" name="url[]" size="18"/><br/>
                    <span class="bull">&bull;</span>URL 4:<br/>
                    <input type="text" name="url[]" size="18"/><br/>
                    <span class="bull">&bull;</span>URL 5:<br/>
                    <input type="text" name="url[]" size="18"/><br/>
                    <input type="submit" name="submit" value="Nhập khẩu"/>
                </form>
            </div>

            <div class="tips"><img src="icon/tips.png"/> Không có http:// đứng trước cũng được, nếu có https:// phải nhập vào</div>

            <div class="title">Chức năng</div>
            <ul class="list">
                <li><img src="icon/create.png"/> <a href="create.php?dir=' . $dirEncode . $pages['paramater_1'] . '">Tạo mới</a></li>
                <li><img src="icon/upload.png"/> <a href="upload.php?dir=' . $dirEncode . $pages['paramater_1'] . '">Tải lên tập tin</a></li>
                <li><img src="icon/list.png"/> <a href="index.php?dir=' . $dirEncode . $pages['paramater_1'] . '">Danh sách</a></li>
            </ul>';
        }

        include_once 'footer.php';
    } else {
        goURL('login.php');
    }*/

?>
