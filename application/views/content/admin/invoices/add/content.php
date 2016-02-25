<form action='<?php echo base_url (array ('admin', 'invoices'));?>' method='post' enctype='multipart/form-data'>
  <table class='table-form'>
    <tbody>

      <tr>
        <th>類 別：</th>
        <td>
          <select name='invoice_tag_id'>
            <option value='0'<?php echo (isset ($posts['invoice_tag_id']) ? $posts['invoice_tag_id'] : 0) == 0 ? ' selected': '';?>>其他</option>
      <?php if ($tags = InvoiceTag::all ()) {
              foreach ($tags as $tag) { ?>
                <option value='<?php echo $tag->id;?>'<?php echo (isset ($posts['invoice_tag_id']) ? $posts['invoice_tag_id'] : 0) == $tag->id ? ' selected': '';?>><?php echo $tag->name;?></option>
        <?php }
            }?>
          </select>
        </td>
      </tr>

      <tr>
        <th>負責人：</th>
        <td>
          <select name='user_id'>
      <?php if ($users = User::all (array ('select' => 'id, name'))) {
              foreach ($users as $user) { ?>
                <option value='<?php echo $user->id;?>'<?php echo (isset ($posts['user_id']) ? $posts['user_id'] : User::current ()->id) == $user->id ? ' selected': '';?>><?php echo $user->name;?></option>
        <?php }
            }?>
          </select>
        </td>
      </tr>

      <tr>
        <th>名 稱：</th>
        <td>
          <input type='text' name='name' value='<?php echo isset ($posts['name']) ? $posts['name'] : '';?>' placeholder='請輸入名稱..' maxlength='200' pattern='.{1,200}' required title='輸入名稱!' autofocus />
        </td>
      </tr>

      <tr>
        <th>窗 口：</th>
        <td>
          <input type='text' name='contact' value='<?php echo isset ($posts['contact']) ? $posts['contact'] : '';?>' placeholder='請輸入窗口..' maxlength='200' pattern='.{1,200}' required title='輸入窗口!' />
        </td>
      </tr>

      <tr>
        <th>數 量：</th>
        <td>
          <input type='number' name='quantity' value='<?php echo isset ($posts['quantity']) ? $posts['quantity'] : '';?>' placeholder='請輸入數量..'/>
        </td>
      </tr>

      <tr>
        <th>單 價：</th>
        <td>
          <input type='number' name='single_money' value='<?php echo isset ($posts['single_money']) ? $posts['single_money'] : '';?>' placeholder='請輸入單價..'/>
        </td>
      </tr>

      <tr>
        <th>總金額：</th>
        <td>
          <input type='number' name='all_money' value='<?php echo isset ($posts['all_money']) ? $posts['all_money'] : '';?>' placeholder='請輸入總金額..'/>
        </td>
      </tr>

      <tr>
        <th>封 面：</th>
        <td>
          <input type='file' name='cover' value='' />
        </td>
      </tr>

      <tr>
        <th>圖 片：</th>
        <td>
          <div class='ps'>
            <button type='button' class='icon-plus' data-i='0'></button>
          </div>
        </td>
      </tr>

      <tr>
        <th>結案日期：</th>
        <td>
          <input type='text' name='closing_at' value='<?php echo isset ($posts['closing_at']) ? $posts['closing_at'] : date ('Y-m-d');?>' placeholder='請選擇結案日期(yyyy-mm-dd)..' maxlength='200' pattern='.{1,200}' required title='輸入窗口!'/>
        </td>
      </tr>

      <tr>
        <th>是否完成：</th>
        <td>
          <div class='checkbox'>
            <input type='checkbox' id='is_finished' name='is_finished'<?php echo isset ($posts['is_finished']) && $posts['is_finished'] ? ' checked' : '';?> data-is_finished_name='<?php echo Invoice::$finishNames[Invoice::IS_FINISHED];?>' data-no_finished_name='<?php echo Invoice::$finishNames[Invoice::NO_FINISHED];?>'><span></span>
            <label for='is_finished'><?php echo Invoice::$finishNames[isset ($posts['is_finished']) && $posts['is_finished'] ? Invoice::IS_FINISHED : Invoice::NO_FINISHED];?></label>
          </div>
        </td>
      </tr>

      <tr>
        <th>備 註：</th>
        <td>
          <textarea name='memo' class='pure autosize' placeholder='請輸入備註..'><?php echo isset ($posts['memo']) ? $posts['memo'] : '';?></textarea>
        </td>
      </tr>

      <tr>
        <td colspan='2'>
          <a href='<?php echo base_url ('admin', 'invoices');?>'>回列表</a>
          <button type='reset' class='button'>重填</button>
          <button type='submit' class='button'>確定</button>
        </td>
      </tr>
    </tbody>
  </table>
</form>
