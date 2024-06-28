<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * RandomPostButton 插件
 *
 * @package RandomPostButton
 * @version 1.0
 * @author chatgpt
 * @link https://github.com/dylanbai8
 */

class RandomPostButton_Plugin implements Typecho_Plugin_Interface
{
    // 激活插件
    public static function activate()
    {
        Helper::addAction('randomPost', 'RandomPostButton_Action');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('RandomPostButton_Plugin', 'footer');
    }

    // 禁用插件
    public static function deactivate()
    {
        Helper::removeAction('randomPost');
    }

    // 插件配置面板
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $description = new Typecho_Widget_Helper_Form_Element_Text('description', null, '/{cid}.html', '使用帮助 (此处仅作帮助教程，无实质功能。)', '教程：1.复制上面内容；2.设置--永久链接--选择[个性化定义]--粘贴配置--保存设置。<br>仅支持 {cid} 和 {slug} 参数。');
        $form->addInput($description);
    }

    // 个人用户配置面板
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    // 在footer输出JavaScript代码
    public static function footer()
    {
        $options = Helper::options();
        $url = $options->index . '/action/randomPost';
        echo <<<EOT
<style>
#random-post-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 38px; /* 设置按钮宽度 */
    height: 90px; /* 设置按钮高度 */
    padding: 10px;
    background-color: #008CBA;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    z-index: 1000;
    writing-mode: vertical-lr; /* 纵向显示文本 */
    text-align: center; /* 文字居中显示 */
}
</style>
<button id="random-post-button">文章抽签</button>
<script>
document.getElementById('random-post-button').addEventListener('click', function() {
    fetch('$url').then(function(response) {
        return response.json();
    }).then(function(data) {
        window.location.href = data.url;
    });
});
</script>
EOT;
    }
}
