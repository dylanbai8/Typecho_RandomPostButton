<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class RandomPostButton_Action extends Typecho_Widget implements Widget_Interface_Do
{
    public function action()
    {
        $db = Typecho_Db::get();
        $options = Typecho_Widget::widget('Widget_Options');
        $prefix = $db->getPrefix();
        
        // 获取随机一篇文章
        $post = $db->fetchRow($db->select()->from($prefix . 'contents')->where('type = ?', 'post')->where('status = ?', 'publish')->order('RAND()')->limit(1));
        
        if ($post) {
            // 构建文章的URL
            $permalink = Typecho_Router::url('post', array('cid' => $post['cid'], 'slug' => $post['slug']), $options->index);
            $this->response->throwJson(array('url' => $permalink));
        } else {
            $this->response->throwJson(array('url' => $options->index));
        }
    }
}
