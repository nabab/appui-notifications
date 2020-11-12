<?php
if (($notifications = new \bbn\appui\notifications($model->db))
  && ($id_user = $model->inc->user->get_id())
  && \bbn\str::is_uid($id_user)
) {
  return [
    'success' => true,
    'data' => array_map(function($o) use($notifications, $id_user){
      return array_merge([
        'id_option' => $o['id'],
        'text' => $o['text']
      ], $notifications->get_cfg($id_user, $o['id']));
    }, array_values(array_filter($model->inc->options->full_options('list', 'notifications', 'appui'), function($o) use($model){
      $id_perm = $model->db->select_one('bbn_options', 'id', ['code' => 'opt'.$o['id']]);
      return $id_perm && $model->inc->perm->has_deep($id_perm, 'options');
    })))
  ];
}
return ['success' => false];