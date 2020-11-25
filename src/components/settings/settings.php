<div class="appui-notifications-settings bbn-overlay bbn-flex-height">
  <div class="bbn-header bbn-spadded bbn-middle">
    <strong class="bbn-right-space"><?=_('GLOBAL SETTINGS')?>:</strong>
    <span class="bbn-right-sspace"><?=_('In-App')?></span>
    <bbn-checkbox v-model="source.global.web"
                  :value="true"
                  :novalue="false"
                  class="bbn-right-space"
    ></bbn-checkbox>
    <span class="bbn-right-sspace"><?=_('Browser')?></span>
    <bbn-checkbox v-model="source.global.browser"
                  :value="true"
                  :novalue="false"
                  class="bbn-right-space"
    ></bbn-checkbox>
    <span class="bbn-right-sspace"><?=_('Mail')?></span>
    <bbn-dropdown :source="mailSource"
                  v-model="source.global.mail"
                  class="bbn-right-space"
    ></bbn-dropdown>
    <span class="bbn-right-sspace"><?=_('Mobile')?></span>
    <bbn-checkbox :disabled="true"
                  v-model="source.global.mobile"
                  :value="true"
                  :novalue="false"
    ></bbn-checkbox>
  </div>
  <div class="bbn-flex-fill">
    <bbn-splitter orientation="horizontal">
      <bbn-pane :size="200" class="bbn-bordered-right">
        <bbn-splitter orientation="vertical">
          <bbn-pane :size="150">
            <div class="bbn-flex-height">
              <div class="bbn-header bbn-spadded bbn-c bbn-b bbn-s bbn-no-border-top bbn-no-border-right"><?=_('CATEGORY SETTINGS')?></div>
              <div class="bbn-flex-fill">
                <div class="bbn-overlay bbn-middle bbn-alt-background">
                  <div v-if="categoryIsSelected"
                       class="bbn-grid-fields bbn-spadded bbn-vmiddle"
                  >
                    <span><?=_('In-App')?></span>
                    <bbn-checkbox v-model="category.web"
                                  :value="true"
                                  :novalue="false"
                    ></bbn-checkbox>
                    <span><?=_('Browser')?></span>
                    <bbn-checkbox v-model="category.browser"
                                  :value="true"
                                  :novalue="false"
                    ></bbn-checkbox>
                    <span><?=_('Mail')?></span>
                    <bbn-dropdown :source="mailSource"
                                  v-model="category.mail"
                    ></bbn-dropdown>
                    <span><?=_('Mobile')?></span>
                    <bbn-checkbox :disabled="true"
                                  v-model="category.mobile"
                                  :value="true"
                                  :novalue="false"
                    ></bbn-checkbox>
                  </div>
                  <div v-else><?=_('No category selected')?></div>
                </div>
              </div>
            </div>
          </bbn-pane>
          <bbn-pane>
            <div class="bbn-flex-height">
              <div class="bbn-header bbn-spadded bbn-c bbn-b bbn-s bbn-no-border-right"><?=_('CATEGORIES LIST')?></div>
              <div class="bbn-flex-fill">
                <bbn-scroll>
                  <bbn-list :source="root + 'data/settings/categories'"
                            :component="$options.components.category"
                            children=""
                            source-value="id_option"
                            @select="selectCategory"
                            ref="list"
                  ></bbn-list>
                </bbn-scroll>
              </div>
            </div>
          </bbn-pane>
        </bbn-splitter>
      </bbn-pane>
      <bbn-pane>
        <div class="bbn-flex-height">
          <div v-if="categoryIsSelected"
               class="bbn-header bbn-b bbn-c bbn-s bbn-spadded bbn-no-border-top bbn-no-border-bottom bbn-no-border-left"
          >
            <span v-text="category.text.toUpperCase() + ' '"></span><?=_('NOTIFICATIONS')?>
          </div>
          <div class="bbn-flex-fill">
            <bbn-table v-if="categoryIsSelected"
                       :source="root + 'data/settings/list'"
                       :data="{id_option: category.id_option}"
                       editable="inline"
                       :pageable="true"
                       :server-paging="false"
                       :expanded="true"
                       @saverow="saveIndividual"
                       ref="table"
                       :autobind="false"
            >
              <bbns-column title="<?=_('Name')?>"
                          field="text"
                          cls="bbn-c"
                          :editable="false"
              ></bbns-column>
              <bbns-column title="<?=_('In-App')?>"
                          field="web"
                          type="boolean"
                          cls="bbn-c"
                          :options="{
                            value: true,
                            novalue: false
                          }"
              ></bbns-column>
              <bbns-column title="<?=_('Browser')?>"
                          field="browser"
                          type="boolean"
                          cls="bbn-c"
                          :options="{
                            value: true,
                            novalue: false
                          }"
              ></bbns-column>
              <bbns-column title="<?=_('Mail')?>"
                          field="mail"
                          cls="bbn-c"
                          :render="renderMail"
                          :source="mailSource"
              ></bbns-column>
              <bbns-column title="<?=_('Mobile')?>"
                          field="mobile"
                          type="boolean"
                          cls="bbn-c"
                          :editable="false"
                          :options="{
                            value: true,
                            novalue: false
                          }"
              ></bbns-column>
              <bbns-column :buttons="[]"
                            :width="80"
                            cls="bbn-c"
              ></bbns-column>
            </bbn-table>
            <div v-else
                 class="bbn-middle bbn-overlay"
            >
              <span class="bbn-xl bbn-b"><i class="nf nf-fa-arrow_left bbn-right-space"></i><?=_('Select a category')?></span>
            </div>
          </div>
        </div>
      </bbn-pane>
    </bbn-splitter>
  </div>
</div>