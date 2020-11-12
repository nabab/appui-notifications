<?php
if ($notifications = new \bbn\appui\notifications($model->db)) {
  return $notifications->get_list_by_user($model->inc->user->get_id(), $model->data);
}
return ['success' => false];