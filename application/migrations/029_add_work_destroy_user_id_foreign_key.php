<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Migration_Add_work_destroy_user_id_foreign_key extends CI_Migration {
  public function up () {
    $this->db->query (
      "ALTER TABLE `works` ADD CONSTRAINT `fk_works_destroy_user_id` FOREIGN KEY (`destroy_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE"
    );
  }
  public function down () {
    $this->db->query (
      "ALTER TABLE `works` DROP FOREIGN KEY `fk_works_destroy_user_id`"
    );
  }
}