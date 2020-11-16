<div class="appui-notifications-tray bbn-unselectable">
  <div @click="isVisible = !isVisible"
        :title="notificationsTitle"
        class="bbn-p bbn-rel"
  >
    <i :class="['nf nf-mdi-comment_alert_outline', 'bbn-lg', {'bbn-right-sspace': !!unread}]"></i>
    <span v-if="unread"
          class="bbn-xs bbn-badge bbn-bg-blue bbn-white appui-notifications-tray-badge"
          v-text="unread"
    ></span>
  </div>
  <div v-if="isVisible"
       class="appui-notifications-tray-main bbn-widget bbn-flex-height"
       :style="{bottom: bottomCoord}"
  >
    <div class="bbn-header bbn-spadded bbn-no-border-top bbn-no-hborder bbn-flex-width">
      <div class="bbn-flex-fill bbn-l bbn-unselectable">
        <span class="bbn-b" v-text="_('NOTIFICATIONS')"></span>
        <span>(</span>
        <span v-text="unread"></span>
        <span>)</span>
      </div>
      <div class="bbn-vmiddle">
        <div>
          <i class="bbn-p nf nf-mdi-read bbn-m"
             @click="readAll"
             :title="_('Mark all notifications as read')"
          ></i>
        </div>
        <div>
          <i class="bbn-p nf nf-mdi-arrow_expand bbn-m bbn-hsmargin"
             @click="openNotifications"
             :title="_('Open notifications page')"
          ></i>
        </div>
        <div>
          <i class="bbn-p nf nf-mdi-window_close bbn-m"
            @click="isVisible = false"
            :title="_('Close')"
          ></i>
        </div>
      </div>
    </div>
    <div class="bbn-flex-fill bbn-background">
      <bbn-scroll axis="y">
        <bbn-list :source="current"
                  :component="$options.components.listItem"
                  :alternate-background="true"
                  ref="list"
        ></bbn-list>
      </bbn-scroll>
    </div>
  </div>
</div>