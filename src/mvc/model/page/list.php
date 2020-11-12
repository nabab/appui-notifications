<?php
if (($notifications = new \bbn\appui\notifications($model->db))
  && ($id_user = $model->inc->user->get_id())
  && \bbn\str::is_uid($id_user)
) {
  return [
    'schema' => $notifications->get_class_cfg()['arch']
  ];
}