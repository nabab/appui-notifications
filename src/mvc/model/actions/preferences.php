<?php
$notifications = new \bbn\appui\notifications($model->db);
if (!empty($model->data['id_option'])
  && isset($model->data['web'], $model->data['browser'], $model->data['mail'], $model->data['mobile'])
) {
  return ['success' => $notifications->set_cfg($model->data)];
}