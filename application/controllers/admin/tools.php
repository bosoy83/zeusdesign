<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Tools extends Admin_controller {

  public function ckeditors_browser_image () {
    $ckes = CkeditorPicture::all (array ('order' => 'id DESC'));

    return $this->set_frame_path ('frame', 'pure')
                ->load_view (array (
                    'ckes' => $ckes
                  ));
  }
  public function ckeditors_upload_image () {
    $funcNum = $_GET['CKEditorFuncNum'];
    $upload = OAInput::file ('upload');

    if (!($upload && verifyCreateOrm ($img = CkeditorPicture::create (array ('name' => ''))) && $img->name->put ($upload, true)))
      echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction ($funcNum, '', '上傳失敗！');</script>";
    else
      echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction ($funcNum, '" . $img->name->url ('400h') . "', '上傳成功！');</script>";
  }
}
