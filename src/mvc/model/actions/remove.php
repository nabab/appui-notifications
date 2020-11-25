<?php
if (($notifications = new \bbn\appui\notifications($model->db))
  && ($ncfg = $notifications->get_class_cfg())
  && !empty($model->data[$ncfg['arch']['notifications']['id']])
  && \bbn\str::is_uid($model->data[$ncfg['arch']['notifications']['id']])
) {
  return ['success' => $notifications->delete($model->data[$ncfg['arch']['notifications']['id']])];
}
return ['success' => false];