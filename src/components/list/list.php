<bbn-splitter class="appui-notifications-list"
              orientation="horizontal"
>
  <bbn-pane size="50%">
    <div class="bbn-flex-height">
      <div class="bbn-header bbn-spadded bbn-flex-width bbn-vmiddle">
        <bbn-context tag="i"
                     :source="filters"
                     class="nf nf-fa-filter bbn-m bbn-p"
                     title="<?=_('Filter notifications')?>"
        ></bbn-context>
        <span class="bbn-b bbn-flex-fill bbn-c"><?=_('LIST')?></span>
        <i class="nf nf-mdi-read bbn-m bbn-p"
           title="<?=_('Set all notifications as read')?>"
           @click="setAllRead"
        ></i>
        <i v-if="toRead.length"
           class="nf nf-mdi-marker_check bbn-m bbn-p bbn-left-sspace"
           title="<?=_('Set the selected notifications as read')?>"
           @click="setRead"
        ></i>
      </div>
      <div class="bbn-flex-fill bbn-bordered-right">
        <bbn-scroll axis="y">
          <bbn-list :source="root + 'data/list'"
                    :component="$options.components.listItem"
                    :alternate-background="true"
                    ref="list"
                    :filterable="true"
                    :pageable="true"
                    @hook:mounted="() => $nextTick(() => listMounted = true)"
          ></bbn-list>
        </bbn-scroll>
      </div>
      <bbn-pager v-if="listMounted"
                 :element="getRef('list')"
                 :buttons="false"
                 :force-mobile="true"
      ></bbn-pager>
    </div>
  </bbn-pane>
  <bbn-pane size="50%">
    <div v-if="hasSelected"
         class="appui-notifications-list-notification bbn-flex-height"
    >
      <div class="bbn-header bbn-spadded bbn-b bbn-c bbn-no-border-left bbn-ellipsis"><?=_('NOTIFICATION')?></div>
      <div class="bbn-flex-fill bbn-alt-background">
        <bbn-scroll>
          <div class="bbn-padded">
            <div class="bbn-box bbn-bottom-space">
              <div class="bbn-radius-top bbn-spadded bbn-c bbn-b bbn-bordered-bottom"
                  v-html="selected.title"
              ></div>
              <div class="bbn-lpadded"
                    v-html="selected.content"
              ></div>
            </div>
          <div class="bbn-box">
              <div class="bbn-radius-top bbn-spadded bbn-c bbn-b bbn-bordered-bottom"><?=_('NOTIFIED')?></div>
              <div class="bbn-spadded">
                <div class="appui-notifications-list-notification-notified">
                  <div>
                    <i :class="['nf nf-mdi-web', 'bbn-xxxl', {
                          'bbn-green': selected.web,
                          'bbn-red': !selected.web
                        }]"
                        title="<?=_('In-App')?>"
                    ></i>
                  </div>
                  <div>
                    <i :class="['nf nf-oct-browser', 'bbn-xxxl', {
                          'bbn-green': selected.browser,
                          'bbn-red': !selected.browser
                        }]"
                        title="<?=_('Browser')?>"
                    ></i>
                  </div>
                  <div>
                    <i :class="['nf nf-mdi-email', 'bbn-xxxl', {
                          'bbn-green': selected.mail,
                          'bbn-red': !selected.mail
                        }]"
                        title="<?=_('Mail')?>"
                    ></i>
                  </div>
                  <div>
                    <i :class="['nf nf-oct-device_mobile', 'bbn-xxxl', {
                          'bbn-green': selected.mobile,
                          'bbn-red': !selected.mobile
                        }]"
                        title="<?=_('Mobile')?>"
                    ></i>
                  </div>
                  <div v-if="selected.web">
                    <div class="bbn-c">
                      <i class="nf nf-mdi-calendar bbn-right-xspace"></i>
                      <span v-text="formatDate(selected.web, true)"></span>
                    </div>
                    <div class="bbn-c">
                      <i class="nf nf-mdi-clock bbn-right-xspace"></i>
                      <span v-text="formatTime(selected.web, true)"></span>
                    </div>
                  </div>
                  <div v-else>
                    <i class="nf nf-fa-close"></i>
                  </div>
                  <div v-if="selected.browser">
                    <div class="bbn-c">
                      <i class="nf nf-mdi-calendar bbn-right-xspace"></i>
                      <span v-text="formatDate(selected.browser, true)"></span>
                    </div>
                    <div class="bbn-c">
                      <i class="nf nf-mdi-clock bbn-right-xspace"></i>
                      <span v-text="formatTime(selected.browser, true)"></span>
                    </div>
                  </div>
                  <div v-else>
                    <i class="nf nf-fa-close"></i>
                  </div>
                  <div v-if="selected.mail">
                    <div class="bbn-c">
                      <i class="nf nf-mdi-calendar bbn-right-xspace"></i>
                      <span v-text="formatDate(selected.mail, true)"></span>
                    </div>
                    <div class="bbn-c">
                      <i class="nf nf-mdi-clock bbn-right-xspace"></i>
                      <span v-text="formatTime(selected.mail, true)"></span>
                    </div>
                  </div>
                  <div v-else>
                    <i class="nf nf-fa-close"></i>
                  </div>
                  <div v-if="selected.mobile">
                    <div class="bbn-c">
                      <i class="nf nf-mdi-calendar bbn-right-xspace"></i>
                      <span v-text="formatDate(selected.mobile, true)"></span>
                    </div>
                    <div class="bbn-c">
                      <i class="nf nf-mdi-clock bbn-right-xspace"></i>
                      <span v-text="formatTime(selected.mobile, true)"></span>
                    </div>
                  </div>
                  <div v-else>
                    <i class="nf nf-fa-close"></i>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
        </bbn-scroll>
      </div>
    </div>
    <div v-else
         class="bbn-middle bbn-overlay"
    >
      <span class="bbn-xl bbn-b"><i class="nf nf-fa-arrow_left bbn-right-space"></i><?=_('Select a notification')?></span>
    </div>
  </bbn-pane>
</bbn-splitter>
