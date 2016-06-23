<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var $this \bbn\mvc\model*/
$notif = new \bbn\appui\notification($this->db);
return [
  'notifications' => $notif->get_list(),
  'lng' => [
    'title' => _("Title"),
    'message' => _("Message"),
    'creation' => _("Creation"),
    'mark_as_read' => _("Mark as read"),
  ]
];
