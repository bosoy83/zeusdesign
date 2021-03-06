<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Work_tags extends Admin_controller {
  private $tag = null;

  public function __construct () {
    parent::__construct ();

    if (in_array ($this->uri->rsegments (2, 0), array ('edit', 'update', 'destroy', 'sort')))
      if (!(($id = $this->uri->rsegments (3, 0)) && ($this->tag = WorkTag::find_by_id ($id, array ('conditions' => array ('work_tag_id = ?', 0))))))
        return redirect_message (array ('admin', $this->get_class ()), array (
            '_flash_message' => '找不到該筆資料。'
          ));

    $this->add_tab ('標籤列表', array ('href' => base_url ('admin', $this->get_class ()), 'index' => 1))
         ->add_tab ('新增標籤', array ('href' => base_url ('admin', $this->get_class (), 'add'), 'index' => 2));
  }

  public function index ($offset = 0) {
    $columns = array (array ('key' => 'name', 'title' => '名稱', 'sql' => 'name LIKE ?'), 
                      );
    $configs = array ('admin', $this->get_class (), '%s');
    $conditions = conditions ($columns, $configs);

    WorkTag::addConditions ($conditions, 'work_tag_id = ?', 0);

    $limit = 25;
    $total = WorkTag::count (array ('conditions' => $conditions));
    $offset = $offset < $total ? $offset : 0;

    $this->load->library ('pagination');
    $pagination = $this->pagination->initialize (array_merge (array ('total_rows' => $total, 'num_links' => 5, 'per_page' => $limit, 'uri_segment' => 0, 'base_url' => '', 'page_query_string' => false, 'first_link' => '第一頁', 'last_link' => '最後頁', 'prev_link' => '上一頁', 'next_link' => '下一頁', 'full_tag_open' => '<ul class="pagination">', 'full_tag_close' => '</ul>', 'first_tag_open' => '<li>', 'first_tag_close' => '</li>', 'prev_tag_open' => '<li>', 'prev_tag_close' => '</li>', 'num_tag_open' => '<li>', 'num_tag_close' => '</li>', 'cur_tag_open' => '<li class="active"><a href="#">', 'cur_tag_close' => '</a></li>', 'next_tag_open' => '<li>', 'next_tag_close' => '</li>', 'last_tag_open' => '<li>', 'last_tag_close' => '</li>'), $configs))->create_links ();
    $tags = WorkTag::find ('all', array (
        'offset' => $offset,
        'limit' => $limit,
        'order' => 'sort ASC',
        'include' => array ('mappings', 'tags'),
        'conditions' => $conditions
      ));

    return $this->set_tab_index (1)
                ->set_subtitle ('作品標籤列表')
                ->load_view (array (
                    'tags' => $tags,
                    'pagination' => $pagination,
                    'columns' => $columns
                  ));
  }
  public function add () {
    return redirect_message (array ('admin', $this->get_class ()), array (
        '_flash_message' => '請至新系統調整。'
      ));
    $posts = Session::getData ('posts', true);
    
    return $this->set_tab_index (2)
                ->set_subtitle ('新增作品標籤')
                ->load_view (array (
                    'posts' => $posts
                  ));
  }
  public function create () {
    return redirect_message (array ('admin', $this->get_class ()), array (
        '_flash_message' => '請至新系統調整。'
      ));
    if (!$this->has_post ())
      return redirect_message (array ('admin', $this->get_class (), 'add'), array (
          '_flash_message' => '非 POST 方法，錯誤的頁面請求。'
        ));

    $posts = OAInput::post ();

    if ($msg = $this->_validation_posts ($posts))
      return redirect_message (array ('admin', $this->get_class (), 'add'), array (
          '_flash_message' => $msg,
          'posts' => $posts
        ));

    $posts['work_tag_id'] = 0;
    $posts['sort'] = WorkTag::count (array ('conditions' => array ('work_tag_id = ?', 0)));

    $create = WorkTag::transaction (function () use ($posts) {
      return verifyCreateOrm ($tag = WorkTag::create (array_intersect_key ($posts, WorkTag::table ()->columns)));
    });

    if (!$create)
      return redirect_message (array ('admin', $this->get_class (), 'add'), array (
          '_flash_message' => '新增失敗！',
          'posts' => $posts
        ));
    
    $this->_clean_cell ();
    return redirect_message (array ('admin', $this->get_class ()), array (
        '_flash_message' => '新增成功！'
      ));
  }
  public function edit () {
    return redirect_message (array ('admin', $this->get_class ()), array (
        '_flash_message' => '請至新系統調整。'
      ));
    $posts = Session::getData ('posts', true);
    
    return $this->add_tab ('編輯標籤', array ('href' => base_url ('admin', $this->get_class (), 'edit', $this->tag->id), 'index' => 3))
                ->set_tab_index (3)
                ->set_subtitle ('編輯作品標籤')
                ->load_view (array (
                    'posts' => $posts,
                    'tag' => $this->tag
                  ));
  }
  public function update () {
    return redirect_message (array ('admin', $this->get_class ()), array (
        '_flash_message' => '請至新系統調整。'
      ));
    if (!$this->has_post ())
      return redirect_message (array ('admin', $this->get_class (), $this->tag->id, 'edit'), array (
          '_flash_message' => '非 POST 方法，錯誤的頁面請求。'
        ));

    $posts = OAInput::post ();

    if ($msg = $this->_validation_posts ($posts))
      return redirect_message (array ('admin', $this->get_class (), $this->tag->id, 'edit'), array (
          '_flash_message' => $msg,
          'posts' => $posts
        ));

    if ($columns = array_intersect_key ($posts, $this->tag->table ()->columns))
      foreach ($columns as $column => $value)
        $this->tag->$column = $value;

    $tag = $this->tag;
    $update = WorkTag::transaction (function () use ($tag) {
      return $tag->save ();
    });

    if (!$update)
      return redirect_message (array ('admin', $this->get_class (), $this->tag->id, 'edit'), array (
          '_flash_message' => '更新失敗！',
          'posts' => $posts
        ));
    
    $this->_clean_cell ();
    return redirect_message (array ('admin', $this->get_class ()), array (
        '_flash_message' => '更新成功！'
      ));
  }
  public function destroy () {
    return redirect_message (array ('admin', $this->get_class ()), array (
        '_flash_message' => '請至新系統調整。'
      ));
    
    $tag = $this->tag;
    
    $delete = WorkTag::transaction (function () use ($tag) {
      return $tag->destroy ();
    });

    if (!$delete)
      return redirect_message (array ('admin', $this->get_class ()), array (
          '_flash_message' => '刪除失敗！',
        ));

    $this->_clean_cell ();
    return redirect_message (array ('admin', $this->get_class ()), array (
        '_flash_message' => '刪除成功！'
      ));
  }
  public function sort ($id, $sort) {
    return redirect_message (array ('admin', $this->get_class ()), array (
        '_flash_message' => '請至新系統調整。'
      ));
    if (!in_array ($sort, array ('up', 'down')))
      return redirect_message (array ('admin', $this->get_class ()), array (
          '_flash_message' => '排序失敗！'
        ));

    $total = WorkTag::count (array ('conditions' => array ('work_tag_id = ?', 0)));

    switch ($sort) {
      case 'up':
        $sort = $this->tag->sort;
        $this->tag->sort = $this->tag->sort - 1 < 0 ? $total - 1 : $this->tag->sort - 1;
        break;

      case 'down':
        $sort = $this->tag->sort;
        $this->tag->sort = $this->tag->sort + 1 >= $total ? 0 : $this->tag->sort + 1;
        break;
    }

    WorkTag::addConditions ($conditions, 'sort = ? AND work_tag_id = ?', $this->tag->sort, 0);

    $tag = $this->tag;
    
    $update = WorkTag::transaction (function () use ($conditions, $tag, $sort) {
      if (($next = WorkTag::find ('one', array ('conditions' => $conditions))) && (($next->sort = $sort) || true))
        if (!$next->save ()) return false;
      if (!$tag->save ()) return false;

      return true;
    });

    if (!$update)
      return redirect_message (array ('admin', $this->get_class ()), array (
          '_flash_message' => '排序失敗！',
          'posts' => $posts
        ));
    return redirect_message (array ('admin', $this->get_class ()), array (
        '_flash_message' => '排序成功！'
      ));
  }
  private function _clean_cell () {
    clean_cell ('site_work_asides_cell', 'tags');
  }
  private function _validation_posts (&$posts) {
    if (!(isset ($posts['name']) && ($posts['name'] = trim ($posts['name']))))
      return '沒有填寫名稱！';

    return '';
  }
}
