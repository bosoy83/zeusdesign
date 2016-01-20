<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Main extends Site_controller {

  public function x () {
    $this->load->library ('OAMail');
    
    OAMail::create ()->setFrom ('comdan66@gmail.com', 'COMDAN66')
                     ->addTo ('oa_wu@hiiir.com', 'OA')
                     ->setSubject ('dd')
                     ->setBody ('wwqe')
                     ->send ();

    // OAMail::sendMail (array (
    //     'mail' => 'comdan66@gmail.com',
    //     'name' => 'COMDAN66'
    //   ), 'xxxxxx', '222222', array ('oa_wu@hiiir.com'));
  }
  public function cmd () {
    $promos = array (array ('http://www.zeusdesign.com.tw/resource/site/images/works/web.jpg', '網頁設計', 'EDM, 活動網站, 官網'), array ('http://www.zeusdesign.com.tw/resource/site/images/works/web02.jpg', '平面設計', '包裝, 書籍, DM, CIS (名片,信紙,logo...等)'), array ('http://www.zeusdesign.com.tw/resource/site/images/works/web03.jpg', '攝影', '商業攝影,婚禮攝影'), array ('http://www.zeusdesign.com.tw/resource/site/images/works/web04.jpg', '設計專案', '平面＋網頁'));

    foreach (array_reverse ($promos) as $i => $p) {
      if (!verifyCreateOrm ($promo = Promo::create (array (
          'title' => $p[1],
          'content' => $p[2],
          'link' => 'http://www.zeusdesign.com.tw/works',
          'sort' => $i
        ))))
        continue;

      if (!$promo->cover->put_url ($p[0]))
        $promo->destroy ();
    }

    $banners = array (array ('http://www.zeusdesign.com.tw/resource/site/images/works/web.jpg',
              '網頁設計',
              '德國Bywp-嘉豪光學台灣總代理',
              'http://www.zeusdesign.com.tw/works'),
        array ('http://www.zeusdesign.com.tw/resource/site/images/works/web02.jpg',
              '平面設計',
              '台灣紡拓會國外展主視覺設計',
              'http://www.zeusdesign.com.tw/works'),
        array ('http://www.zeusdesign.com.tw/resource/site/images/works/web03.jpg',
              '商業攝影',
              '台灣紡拓會國外展主視覺設計',
              'http://www.zeusdesign.com.tw/works'),
        array ('http://www.zeusdesign.com.tw/resource/site/images/works/web04.jpg',
              '設計專案',
              'MySpotcam',
              ''));
    foreach (array_reverse ($banners) as $i => $b) {
      if (!verifyCreateOrm ($banner = Banner::create (array (
          'title' => $b[1],
          'content' => $b[2],
          'link' => $b[3],
          'sort' => $i
        ))))
        continue;

      if (!$banner->cover->put_url ($b[0]))
        $banner->destroy ();
    }

    // exit();
    $i = 0;
    foreach (array ('網頁設計 • Web Design' => array ('官方網站設計', '活動網站設計', 'Banner', 'EDM', 'UI & APP Design', 'RWD'), '平面設計 • Graphic Design' => array ('廣告設計', '書籍設計', '包裝設計'), '商業攝影 • Photography' => array ('商品攝影', '人像攝影', '婚禮紀錄/自助婚紗'), '專案設計 • Design Project' => array ()) as $key => $val) {
      if (!verifyCreateOrm ($tag = WorkTag::create (array ('work_tag_id' => 0, 'name' => $key, 'sort' => $i++)))) {
        echo "Tag Error!\n";
        exit ();
      }

      foreach ($val as $j => $value) {
        if (!verifyCreateOrm (WorkTag::create (array ('work_tag_id' => $tag->id, 'name' => $value, 'sort' => $j)))) {
          echo "Tag2 Error!\n";
          exit ();
        }
      }
    }
    echo "Tag OK!";

    $url = 'http://www.zeusdesign.com.tw/main/api';
    $str = download_web_file ($url);
    foreach (json_decode ($str, true) as $json) {
      $params = array (
          'title' => $json['title'],
          'content' => $json['content'],
          'is_enabled' => $json['is_enabled'],
        );

      if (!verifyCreateOrm ($work = Work::create ($params))) {
        echo "新增 " . $json['title'] . "失敗！\n";
        continue;
      }

      if (!$work->cover->put_url ($json['cover'])) {
        $work->destroy ();
        echo "上傳 " . $json['title'] . " cover 失敗！\n";
        continue;
      }

      foreach ($json['tags'] as $val)
        if ($tag = WorkTag::find_by_name ($val))
          if (!WorkTagMapping::find ('one', array ('conditions' => array ('work_id = ? AND work_tag_id = ?', $work->id, $tag->id))))
            if (!verifyCreateOrm (WorkTagMapping::create (array (
                'work_id' => $work->id,
                'work_tag_id' => $tag->id,
              )))) {
              echo "" . $json['title'] . " 新增 tag: " . $val . " 失敗！\n";
              continue;
            }

      foreach ($json['pics'] as $val)
        if (verifyCreateOrm ($pic = WorkPicture::create (array (
                              'work_id' => $work->id,
                              'name' => ''
                            ))))
          if (!$pic->name->put_url ($val)) {
              $pic->destroy ();
              echo "" . $json['title'] . " 新增 pic 失敗！\n";
              continue;
          }

      foreach ($json['blocks'] as $val) {
        if (!verifyCreateOrm ($block = WorkBlock::create (array (
                              'work_id' => $work->id,
                              'title' => $val['title']
                            )))) {

          echo "" . $json['title'] . " 新增 block title: " . $val['title'] . " 失敗！\n";
          continue;
        }

        foreach ($val['items'] as $val)
          if (!verifyCreateOrm ($item = WorkBlockItem::create (array (
                                'work_block_id' => $block->id,
                                'title' => $val['title'],
                                'link' => $val['link'],
                              )))) {

            echo "" . $json['title'] . " 新增 block title: " . $val['title'] . " item: " . $val['title'] . " 失敗！\n";
            continue;
          }
      }
    }
    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    var_dump ();
    exit ();
  }

  public function contacts () {
    $this->add_param ('_method', $this->get_method ())
         ->add_js (resource_url ('resource', 'javascript', 'jquery.validate_v1.9.0', 'jquery.validate.min.js'))
         ->add_js (resource_url ('resource', 'javascript', 'jquery.validate_v1.9.0', 'jquery.validate.lang.js'))
         ->load_view ();
  }
  public function abouts () {
    $this->add_param ('_method', $this->get_method ())
         ->load_view ();
  }
  public function index () {
    $this->add_param ('_method', $this->get_method ())
         ->load_view ();
  }
}
