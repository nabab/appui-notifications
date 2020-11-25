<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */
$ctrl->obj->url = APPUI_NOTIFICATIONS_ROOT . 'page';
$perms = [];
foreach ($ctrl->inc->perm->full_options(APPUI_NOTIFICATIONS_ROOT.'page/') as $p) {
  $perms[$p['code']] = true;
}
$notifications = new \bbn\appui\notifications($ctrl->db);
$ctrl
  ->set_icon('nf nf-mdi-comment_alert_outline')
  ->combo(_('Notifications'), [
    'permissions' => $perms,
    'cfg' => $notifications->get_class_cfg() 
  ]);