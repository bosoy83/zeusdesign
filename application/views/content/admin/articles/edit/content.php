<form action='<?php echo base_url (array ('admin', 'articles', $article->id));?>' method='post' enctype='multipart/form-data'>
  <input type='hidden' name='_method' value='put' />
  <table class='table-form'>
    <tbody>

      <tr>
        <th>作者：</th>
        <td>
          <select name='user_id'>
      <?php if ($users = User::all (array ('select' => 'id, name'))) {
              foreach ($users as $user) { ?>
                <option value='<?php echo $user->id;?>'<?php echo (isset ($posts['user_id']) ? $posts['user_id'] : $article->user_id) == $user->id ? ' selected': '';?>><?php echo $user->name;?></option>
        <?php }
            }?>
          </select>
        </td>
      </tr>

      <tr>
        <th>標 題：</th>
        <td>
          <input type='text' name='title' value='<?php echo isset ($posts['title']) ? $posts['title'] : $article->title;?>' placeholder='請輸入標題..' maxlength='200' pattern='.{1,200}' required title='輸入標題!' autofocus />
        </td>
      </tr>

      <tr>
        <th>封 面：</th>
        <td>
          <?php echo (string)$article->cover ? img ($article->cover->url ('100x100c'), false, 'class="cover"') : '';?>
          <input type='file' name='cover' value='' />
        </td>
      </tr>

<?php if ($tags = ArticleTag::all ()) { ?>
        <tr>
          <th>標 籤：</th>
          <td>
      <?php $tag_ids = isset ($posts['tag_ids']) ? $posts['tag_ids'] : column_array ($article->mappings, 'article_tag_id');
            foreach ($tags as $tag) { ?>
              <label><input type='checkbox' name='tag_ids[]' value='<?php echo $tag->id;?>'<?php echo $tag_ids && in_array ($tag->id, $tag_ids) ? ' checked' : '';?>/><div><?php echo $tag->name;?></div></label>
      <?php } ?>
          </td>
        </tr>
<?php }?>

      <tr>
        <th>內 容：</th>
        <td>
          <!-- <textarea name='content' class='cke' placeholder='請輸入內容..'><?php echo isset ($posts['content']) ? $posts['content'] : $article->content;?></textarea> -->
        </td>
      </tr>

      <tr>
        <th>是否公開：</th>
        <td>
          <select name='is_visibled'>
      <?php if ($visibleNames = Article::$visibleNames) {
              foreach ($visibleNames as $key => $name) { ?>
                <option value='<?php echo $key;?>'<?php echo (isset ($posts['is_visibled']) ? $posts['is_visibled'] : $article->is_visibled) == $key ? ' selected': '';?>><?php echo $name;?></option>
        <?php }
            }?>
          </select>
        </td>
      </tr>

      <tr>
        <td colspan='2'>
          <a href='<?php echo base_url ('admin', 'articles');?>'>回列表</a>
          <button type='reset' class='button'>重填</button>
          <button type='submit' class='button'>確定</button>
        </td>
      </tr>
    </tbody>
  </table>
</form>
