<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

$menu['admin'] = array (
    '管理後台' => array (
        '首頁' => array ('role' => 'members', 'icon' => 'icon-home', 'href' => base_url ('admin'), 'class' => 'main', 'method' => 'index', 'target' => '_self'),
        '訪客留言' => array ('role' => 'members', 'icon' => 'icon-comment', 'href' => base_url ('admin', 'contacts'), 'class' => 'contacts', 'method' => '', 'target' => '_self'),
        '使用者設定' => array ('role' => 'admins', 'icon' => 'icon-user2', 'href' => base_url ('admin', 'users'), 'class' => 'users', 'method' => '', 'target' => '_self'),
      ),
    '部落格' => array (
        '文章分類' => array ('role' => 'members', 'icon' => 'icon-tags', 'href' => base_url ('admin', 'article_tags'), 'class' => 'article_tags', 'method' => '', 'target' => '_self'),
        '文章管理' => array ('role' => 'members', 'icon' => 'icon-file-text2', 'href' => base_url ('admin', 'articles'), 'class' => 'articles', 'method' => '', 'target' => '_self'),
          '上傳工具' => array ('role' => 'members', 'icon' => 'icon-file-text2', 'href' => base_url ('admin', 'articles'), 'class' => 'tools', 'method' => '', 'target' => '_self', 'no_show' => true),
      ),
    '官網上搞' => array (
        '作品分類' => array ('role' => 'members', 'icon' => 'icon-tags', 'href' => base_url ('admin', 'work_tags'), 'class' => 'work_tags', 'method' => '', 'target' => '_self'),
          '子分類' => array ('role' => 'members', 'icon' => 'icon-tags', 'href' => base_url ('admin', 'work_tags'), 'class' => 'work_tag_tags', 'method' => '', 'target' => '_self', 'no_show' => true),
        '作品管理' => array ('role' => 'members', 'icon' => 'icon-images', 'href' => base_url ('admin', 'works'), 'class' => 'works', 'method' => '', 'target' => '_self'),
        'Banner管理' => array ('role' => 'members', 'icon' => 'icon-images', 'href' => base_url ('admin', 'banners'), 'class' => 'banners', 'method' => '', 'target' => '_self'),
        'Promo管理' => array ('role' => 'members', 'icon' => 'icon-images', 'href' => base_url ('admin', 'promos'), 'class' => 'promos', 'method' => '', 'target' => '_self'),
      ),
    '帳務' => array (
        '帳務類別' => array ('role' => 'members', 'icon' => 'icon-tags', 'href' => base_url ('admin', 'invoice_tags'), 'class' => 'invoice_tags', 'method' => '', 'target' => '_self'),
        '帳務管理' => array ('role' => 'members', 'icon' => 'icon-file-text2', 'href' => base_url ('admin', 'invoices'), 'class' => 'invoices', 'method' => '', 'target' => '_self'),
      ),
    '樣板產生器' => array (
        '分類' => array ('role' => 'members', 'icon' => 'icon-tags', 'href' => base_url ('admin'), 'class' => '', 'method' => '', 'target' => '_self'),
        '列表' => array ('role' => 'members', 'icon' => 'icon-list2', 'href' => base_url ('admin'), 'class' => '', 'method' => '', 'target' => '_self'),
        '製作' => array ('role' => 'members', 'icon' => 'icon-plus', 'href' => base_url ('admin'), 'class' => '', 'method' => '', 'target' => '_self'),
      ),
  );
