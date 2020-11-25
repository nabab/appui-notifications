<?php
$notifications = new \bbn\appui\notifications($model->db);
$ucfg = $model->inc->user->get_class_cfg();
$ncfg = $notifications->get_class_cfg();
$grid = new \bbn\appui\grid($model->db, $model->data, [
  'table' => $ncfg['table'],
  'fields' => [
    $model->db->col_full_name($ncfg['arch']['notifications']['id'], $ncfg['table']),
    $model->db->col_full_name($ncfg['arch']['notifications']['id_content'], $ncfg['table']),
    $model->db->col_full_name($ncfg['arch']['notifications']['id_user'], $ncfg['table']),
    $model->db->col_full_name($ncfg['arch']['notifications']['web'], $ncfg['table']),
    $model->db->col_full_name($ncfg['arch']['notifications']['browser'], $ncfg['table']),
    $model->db->col_full_name($ncfg['arch']['notifications']['mail'], $ncfg['table']),
    $model->db->col_full_name($ncfg['arch']['notifications']['mobile'], $ncfg['table']),
    $model->db->col_full_name($ncfg['arch']['notifications']['read'], $ncfg['table']),
    $model->db->col_full_name($ncfg['arch']['content']['id_option'], $ncfg['tables']['content']),
    $model->db->col_full_name($ncfg['arch']['content']['title'], $ncfg['tables']['content']),
    $model->db->col_full_name($ncfg['arch']['content']['content'], $ncfg['tables']['content']),
    $model->db->col_full_name($ncfg['arch']['content']['creation'], $ncfg['tables']['content'])
  ],
  'join' => [[
    'table' => $ncfg['tables']['content'],
    'on' => [
      'conditions' => [[
        'field' => $model->db->col_full_name($ncfg['arch']['notifications']['id_content'], $ncfg['table']),
        'exp' => $model->db->col_full_name($ncfg['arch']['content']['id'], $ncfg['tables']['content'])
      ]]
    ]
  ], [
    'table' => $ucfg['table'],
    'on' => [
      'conditions' => [[
        'field' => $model->db->col_full_name($ucfg['arch']['users']['id'], $ucfg['table']),
        'exp' => $model->db->col_full_name($ncfg['arch']['notifications']['id_user'], $ncfg['table'])
      ]]
    ]
  ]],
  'order' => [[
    'field' => $model->db->col_full_name($ncfg['arch']['content']['creation'], $ncfg['tables']['content']),
    'dir' => 'DESC'
  ]]
]);
if ($grid->check()) {
  return $grid->get_datatable();
}