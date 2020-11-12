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
  ></bbns-container>
  <bbns-container url="settings"
                  title="<?=_("Settings")?>"
                  :static="true"
                  :load="true"
                  component="appui-notifications-settings"
                  icon="nf nf-mdi-settings"
                  :notext="true"
  ></bbns-container>
</bbn-router>