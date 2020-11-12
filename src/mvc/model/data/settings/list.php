<?php
if (!empty($model->data['data']['id_option'])
  && ($notifications = new \bbn\appui\notifications($model->db))
  && ($id_user = $model->inc->user->get_id())
  && \bbn\str::is_uid($id_user)
) {
  $data = array_map(function($o) use($notifications, $id_user){
    return array_merge([
      'id_option' => $o['id'],
      'text' => $o['text']
    ], $notifications->get_cfg($id_user, $o['id']));
  }, array_values(array_filter($model->inc->options->full_options($model->data['data']['id_option']), function($o) use($model){
    $id_perm = $model->db->select_one('bbn_options', 'id', ['code' => 'opt'.$o['id']]);
    return $id_perm && $model->inc->perm->has($id_perm, 'options');
  })));
  return [
    'success' => true,
    'data' => $data,
    'total' => count($data)
  ];
}
return ['success' => false];