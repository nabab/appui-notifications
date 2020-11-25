<bbn-table :source="root + 'data/all'"
           :pageable="true"
           :showable="true"
           class="bbn-overlay"
           ref="table"
>
  <bbns-column :field="cfg.arch.notifications.id"
               title="<?=_('ID')?>"
               :hidden="true"
  ></bbns-column>
  <bbns-column :field="cfg.arch.notifications.id_content"
               title="<?=_('ID Content')?>"
               :hidden="true"
  ></bbns-column>
  <bbns-column :field="cfg.arch.content.id_option"
               title="<?=_('ID Option')?>"
               :hidden="true"
  ></bbns-column>
  <bbns-column :field="cfg.arch.content.creation"
               title="<?=_('Creation')?>"
               type="datetime"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column :field="cfg.arch.notifications.id_user"
               title="<?=_('User')?>"
               :source="users"
  ></bbns-column>
  <bbns-column :field="cfg.arch.content.title"
               title="<?=_('Title')?>"
  ></bbns-column>
  <bbns-column :field="cfg.arch.content.content"
               title="<?=_('Content')?>"
  ></bbns-column>
  <bbns-column :field="cfg.arch.notifications.read"
               title="<?=_('Read')?>"
               type="datetime"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column :field="cfg.arch.notifications.web"
               title="<?=_('In-App')?>"
               type="datetime"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column :field="cfg.arch.notifications.browser"
               title="<?=_('Browser')?>"
               type="datetime"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column :field="cfg.arch.notifications.mail"
               title="<?=_('Mail')?>"
               type="datetime"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column :field="cfg.arch.notifications.mobile"
               title="<?=_('Mobile')?>"
               type="datetime"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column :buttons="[{
                  text: '<?=_('Delete')?>',
                  notext: true,
                  action: remove,
                  icon: 'nf nf-fa-trash'
                }]"
                cls="bbn-c"
                width="50"
  ></bbns-column>
</bbn-table>