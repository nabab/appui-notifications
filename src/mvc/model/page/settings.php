<?php
$notifications = new \bbn\appui\notifications($model->db);
$id_user = $model->inc->user->get_id();
return [
  'schema' => $notifications->get_class_cfg()['arch'],
  'global' => array_merge(['id_option' => $model->inc->options->from_code('cfg', 'notifications', 'appui')], $notifications->get_cfg($id_user)),
];