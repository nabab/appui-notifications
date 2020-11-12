<?php
if ($notifications = new \bbn\appui\notifications($model->db)) {
  if ((!empty($model->data['id']) && \bbn\str::is_uid($model->data['id']))
    || (!empty($model->data['ids']) && is_array($model->data['ids']))
  ) {
    return ['success' => $notifications->read($model->data['id'] ?? $model->data['ids'])];
  }
  else if (!empty($model->data['all'])) {
    return ['success' => $notifications->read_all()];
  }
}
return ['success' => false];