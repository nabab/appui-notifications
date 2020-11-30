<?php
$id_user = $model->inc->user->get_id();
$path_web = \bbn\mvc::get_user_data_path($id_user, 'appui-notifications') . 'web/' . $model->inc->user->get_osession('id_session');
$path_browser = \bbn\mvc::get_user_data_path($id_user, 'appui-notifications') . 'browser/' . $model->inc->user->get_osession('id_session');
$notifications = new \bbn\appui\notifications($model->db);
$ncfg = $notifications->get_class_cfg();
return [[
  'id' => 'appui-notifications-0',
  'frequency' => 1,
  'function' => function(array $data) use($path_web, $path_browser, $notifications, $id_user, $model, $ncfg){
    $res = [
      'success' => true,
      'data' => []
    ];
    if (count($data['clients'])) {
      end($data['clients']);
      $is_last = $data['client'] === key($data['clients']);
      if (is_dir($path_web)) {
        foreach (\bbn\file\dir::get_files($path_web) as $file) {
          if ($json = json_decode(file_get_contents($file), true)) {
            if (!isset($res['data']['web'])) {
              $res['data']['web'] = [];
            }
            $res['data']['web'][] = $json;
          }
          if ($is_last) {
            \bbn\file\dir::delete($file);
            if (!\bbn\file\dir::get_files($path_web)) {
              \bbn\file\dir::delete($path_web);
            }
          }
        }
      }
      if (is_dir($path_browser)) {
        foreach (\bbn\file\dir::get_files($path_browser) as $file) {
          if ($json = json_decode(file_get_contents($file), true)) {
            if (!isset($res['data']['browser'])) {
              $res['data']['browser'] = [];
            }
            $res['data']['browser'][] = $json;
          }
          if ($is_last) {
            \bbn\file\dir::delete($file);
            if (!\bbn\file\dir::get_files($path_browser)) {
              \bbn\file\dir::delete($path_browser);
            }
          }
        }
      }
      $unread = $model->get_model($model->plugin_url('appui-notifications').'/data/list', [
        'filters' => [
          'conditions' => [[
            'field' => $model->db->col_full_name($ncfg['arch']['notifications']['read'], $ncfg['table']),
            'operator' => "isnull"
          ], [
            'logic' => 'OR',
            'conditions' => [[
              'field' => $model->db->col_full_name($ncfg['arch']['notifications']['web'], $ncfg['table']),
              'operator' => "isnotnull"
            ], [
              'field' => $model->db->col_full_name($ncfg['arch']['notifications']['browser'], $ncfg['table']),
              'operator' => "isnotnull"
            ], [
              'field' => $model->db->col_full_name($ncfg['arch']['notifications']['mail'], $ncfg['table']),
              'operator' => "isnotnull"
            ], [
              'field' => $model->db->col_full_name($ncfg['arch']['notifications']['mobile'], $ncfg['table']),
              'operator' => "isnotnull"
            ]]
          ]]
        ],
        'limit' => 0,
        'start' => 0
      ]);
      $hash = md5(json_encode($unread['data']));
      if (isset($data['data']['unreadHash']) && ($hash !== $data['data']['unreadHash'])) {
        $res['data']['unreadHash'] = $hash;
        $res['data']['unread'] = $unread['data'];
        $res['data']['serviceWorkers'] = ['unreadHash' => $hash];
      }
    }
    return $res;
  }
]];