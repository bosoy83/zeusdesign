<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Article extends OaModel {

  static $table_name = 'articles';

  static $has_one = array (
  );

  static $has_many = array (
    array ('mappings', 'class_name' => 'ArticleTagMapping'),
    array ('tags', 'class_name' => 'ArticleTag', 'through' => 'mappings'),
  );

  static $belongs_to = array (
    array ('user', 'class_name' => 'User'),
  );

  const NO_VISIBLED = 0;
  const IS_VISIBLED = 1;

  static $visibleNames = array(
    self::NO_VISIBLED => '隱藏',
    self::IS_VISIBLED => '公開',
  );
  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

    OrmImageUploader::bind ('cover', 'ArticleCoverImageUploader');
  }
  
  public function mini_content ($length = 100) {
    if (!isset ($this->content)) return '';
    return $length ? mb_strimwidth (remove_ckedit_tag ($this->content), 0, $length, '…','UTF-8') : remove_ckedit_tag ($this->content);
  }
}