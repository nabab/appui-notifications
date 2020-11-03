<?php
if (!empty($model->data['id']) && \bbn\str::is_uid($model->data['id'])) {
  $notifications = new \bbn\appui\notification($model->db);
  return ['success' => $notifications->read($model->data['id'])];
}