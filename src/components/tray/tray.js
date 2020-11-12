(() => {
  return {
    props: {
      unread: {
        type: Number,
        default: 0,
        required: true
      }
    },
    data(){
      return {
        root: appui.plugins['appui-notifications'] + '/',
        isVisible: false,
        bottomCoord: ''
      }
    },
    computed: {
      notificationsTitle(){
        return this.unread ? bbn._('You have') + ' ' + this.unread + ' ' + bbn._('unread notifications') : bbn._('Notifications')
      }
    },
    methods: {
      openNotifications(){
        if (appui.plugins['appui-notifications']){
          bbn.fn.link(appui.plugins['appui-notifications'] + '/page/list');
          this.isVisible = false;
        }
      },
      onSelect(){},
      readAll(){
        let ids = bbn.fn.map(this.getRef('list').filteredData, d => {
          return d.data.id;
        })
        if (ids.length) {
          this.post(this.root + 'actions/read', {ids: ids}, d => {
            if (d.success) {
              this.isVisible = false;
              appui.success();
            }
            else {
              appui.error();
            }
          })
        }
      }
    },
    created(){
      appui.register('appui-notifications-tray', this);
    },
    mounted(){
      this.$nextTick(() => {
        let coord = this.$el.offsetParent.getBoundingClientRect();
        this.bottomCoord = `${coord.bottom - coord.top}px`;
      })
    },
    beforeDestroy(){
      appui.unregister('appui-appui-notifications-tray');
    },
    components: {
      listItem: {
        template: `
  <div class="bbn-bordered-bottom bbn-spadded bbn-p bbn-reactive appui-notifications-tray-item"
  >
    <div class="bbn-flex-width">
      <div class="bbn-flex-fill">
        <div class="bbn-grid-fields">
          <i class="nf nf-mdi-calendar bbn-middle"></i>
          <div class="bbn-s"
                v-text="formatDateTime(source.creation)"
          ></div>
          <i class="nf nf-mdi-format_title bbn-middle"></i>
          <div class="bbn-b"
                v-html="source.title"
          ></div>
          <i class="nf nf-mdi-tooltip_text bbn-middle"></i>
          <div class="bbn-ellipsis"
                v-text="html2text(source.content)"
          ></div>
        </div>
      </div>
      <div class="bbn-middle">
        <bbn-button icon="nf nf-mdi-marker_check"
                    :notext="true"
                    @click="read"
                    title="` + bbn._('Mark it as read') + `"
        ></bbn-button>
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
            cp: appui.getRegistered('appui-notifications-tray')
          }
        },
        methods: {
          html2text: bbn.fn.html2text,
          formatDateTime(date){
            if (date) {
              return moment(date).format('DD/MM/YYYY HH:mm')
            }
            return ''
          },
          read(){
            if (this.source.id) {
              this.post(this.cp.root + 'actions/read', {id: this.source.id}, d => {
                if (d.success) {
                  let list = this.cp.getRef('list');
                  if (bbn.fn.isVue(list)) {
                    this.cp.getRef('list').updateData();
                  }
                  appui.success();
                }
                else {
                  appui.error();
                }
              })
            }
          }
        }
      }
    }
  }
})()