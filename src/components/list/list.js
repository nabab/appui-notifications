(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-notifications'] + '/',
        selected: {},
        currentFilter: 'all',
        listMounted: false,
        toRead: []
      }
    },
    computed: {
      hasSelected(){
        return !!Object.keys(this.selected).length
      },
      items(){
        return this.listMounted ? this.getRef('list').filteredData : []
      },
      filters(){
        let filters = [{
          text: bbn._('Show all notifications'),
          value: 'all',
          action: () => this.currentFilter = 'all'
        }, {
          text: bbn._('Show unread notifications'),
          value: 'unread',
          action: () => this.currentFilter = 'unread'
        }, {
          text: bbn._('Show read notifications'),
          value: 'read',
          action: () => this.currentFilter = 'read'
        }];
        filters.splice(bbn.fn.search(filters, {value: this.currentFilter}), 1);
        return filters;
      }
    },
    methods: {
      html2text: bbn.fn.html2text,
      formatDate(date, unix){
        if (date) {
          let mom = unix ? moment.unix(date) : moment(date);
          return mom.format('DD/MM/YYYY')
        }
        return ''
      },
      formatDateTime(date, unix){
        if (date) {
          let mom = unix ? moment.unix(date) : moment(date);
          return mom.format('DD/MM/YYYY HH:mm')
        }
        return ''
      },
      formatTime(date, unix){
        if (date) {
          let mom = unix ? moment.unix(date) : moment(date);
          return mom.format('HH:mm')
        }
        return ''
      },
      openNotification(notification){
        this.$set(this, 'selected', notification);
        if (!notification[this.source.schema.notifications.read]) {
          this.post(this.root + 'actions/read', {id: notification[this.source.schema.notifications.id]}, d => {
            if (d.success) {
              this.$set(notification, this.source.schema.notifications.read, moment().format('x'));
            }
          })
        }
      },
      setRead(){
        this.confirm(bbn._('Are you sure you want to set the selected notifications as read?'), () => {
          this.post(this.root + 'actions/read', {ids: this.toRead}, d => {
            if (d.success) {
              let mom = moment().format('x');
              bbn.fn.each(this.toRead, id => {
                let prop = 'data.' + this.source.schema.notifications.id,
                    not = bbn.fn.getRow(this.items, {[prop]: id});
                if (not && bbn.fn.isNull(not.data[this.source.schema.notifications.read])) {
                  this.$set(not.data, this.source.schema.notifications.read, mom);
                }
              });
              this.toRead.splice(0);
              appui.success();
            }
            else {
              appui.error();
            }
          })
        })
      },
      setAllRead(){
        this.confirm(bbn._('Are you sure you want to set all notifications as read?'), () => {
          this.post(this.root + 'actions/read', {all: true}, d => {
            if (d.success) {
              let mom = moment().format('x');
              bbn.fn.each(this.items, item => {
                if (item.data && bbn.fn.isNull(item.data.read)) {
                  this.$set(item.data, 'read', mom);
                }
              })
              appui.success();
            }
            else {
              appui.error();
            }
          })
        })
      }
    },
    created(){
      appui.register('appui-notifications', this);
    },
    beforeDestroy(){
      appui.unregister('appui-notifications');
    },
    watch: {
      currentFilter(newVal){
        let list = this.getRef('list');
        if (list) {
          switch (newVal) {
            case 'all':
              list.currentFilters.conditions.splice(0)
              break;
            case 'read':
              list.currentFilters.conditions.splice(0, list.currentFilters.conditions.length, {
                field: this.source.schema.notifications.read,
                operator: 'isnotnull'
              });
              break;
            case 'unread':
              list.currentFilters.conditions.splice(0, list.currentFilters.conditions.length, {
                field: this.source.schema.notifications.read,
                operator: 'isnull'
              });
              break;
          }
        }
      }
    },
    components: {
      listItem: {
        template: `
<div :class="['bbn-bordered-bottom', 'bbn-spadded', 'bbn-p', 'bbn-reactive', 'appui-notifications-list-item', {
        'bbn-state-selected': isSelected,
        'bbn-tertiary': !isSelected && !source.read
      }]"
>
  <div class="bbn-flex-width">
    <div class="bbn-flex-fill" @click="cp.openNotification(source)">
      <div class="bbn-grid-fields">
        <i class="nf nf-mdi-calendar bbn-middle"></i>
        <div class="bbn-s"
              v-text="cp.formatDateTime(source.creation)"
        ></div>
        <i class="nf nf-mdi-format_title bbn-middle"></i>
        <div class="bbn-b"
              v-html="source.title"
        ></div>
        <i class="nf nf-mdi-tooltip_text bbn-middle"></i>
        <div class="bbn-ellipsis"
              v-text="cp.html2text(source.content)"
        ></div>
      </div>
    </div>
    <div v-if="!source.read"
          class="bbn-middle"
    >
      <bbn-checkbox v-model="checked"
                    :value="true"
                    :novalue="false"
      ></bbn-checkbox>
    </div>
  </div>
</div>
        `,
        props: {
          source: {
            type: Object
          }
        },
        data(){
          return {
            cp: appui.getRegistered('appui-notifications'),
            checked: false
          }
        },
        computed: {
          isSelected(){
            return this.source[this.cp.source.schema.notifications.id] === this.cp.selected[this.cp.source.schema.notifications.id];
          }
        },
        watch: {
          checked(newVal){
            if (newVal) {
              if (!this.cp.toRead.includes(this.source[this.cp.source.schema.notifications.id])) {
                this.cp.toRead.push(this.source[this.cp.source.schema.notifications.id]);
              }
            }
            else {
              if (this.cp.toRead.includes(this.source[this.cp.source.schema.notifications.id])) {
                this.cp.toRead.splice(this.cp.toRead.indexOf(this.source[this.cp.source.schema.notifications.id]), 1);
              }
            }
          }
        }
      }
    }
  }
})()