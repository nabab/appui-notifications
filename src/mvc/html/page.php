<!-- HTML Document -->
<bbn-router class="appui-notfications"
            :autoload="false"
            :nav="true"
>
  <bbns-container url="list"
                  title="<?=_("Notifications list")?>"
                  :static="true"
                  :load="true"
                  component="appui-notifications-list"
                  icon="nf nf-fa-home"
                  :notext="true"
                  v-if="source.permissions.list"
  ></bbns-container>
  <bbns-container url="settings"
                  title="<?=_("Settings")?>"
                  :static="true"
                  :load="true"
                  component="appui-notifications-settings"
                  icon="nf nf-mdi-settings"
                  :notext="true"
                  v-if="source.permissions.settings"
  ></bbns-container>
  <bbns-container url="all"
                  title="<?=_("All notifications")?>"
                  :static="true"
                  :load="true"
                  icon="nf nf-mdi-table"
                  :notext="true"
                  v-if="source.permissions.all"
  ></bbns-container>
</bbn-router>