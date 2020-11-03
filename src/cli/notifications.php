<?php
$notification = new \bbn\appui\notifications($ctrl->db);
$list = $notification->get_unread();