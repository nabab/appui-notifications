(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-notifications'] + '/',
        mailSource: [{
          text: bbn._('Default'),
          value: 'default'
        }, {
          text: bbn._('Immediately'),
          value: 'immediately'
        }, {
          text: bbn._('Daily'),
          value: 'daily'
        }, {
          text: bbn._('No email'),
          value: false
        }],
        category: {},
        categoryOld: {},
        globalOld: bbn.fn.extend(true, {}, this.source.global)
      }
    },
    computed: {
      categoryIsSelected(){
        return !!Object.keys(this.category).length
      },
    },
    methods: {
      selectCategory(row){
        this.$set(this, 'category', row);
        this.$set(this, 'categoryOld', bbn.fn.extend(true, {}, row));
        this.$nextTick(() => {
          let table = this.getRef('table');
          if (table) {
            table.updateData();
          }
        });
      },
      save(row, afterSuccess){
        this.post(this.root + 'actions/preferences', row, d => {
          if ( d.success ){
            appui.success();
            if (bbn.fn.isFunction(afterSuccess)) {
              afterSuccess(row);
            }
          }
          else{
            appui.error();
          }
        });
      },
      saveIndividual(row){
        this.save(row, () => {
          this.$refs.table.updateData();
          this.$refs.table.editedRow = false;
          this.$refs.table.editedIndex = false;
        })
      },
      renderMail(row){
        bbn.fn.log('aaaa', row.mail, row)
        return bbn.fn.getField(this.mailSource, 'text', {value: row.mail}) || '<i class="nf nf-fa-close"></i>'
      }
    },
    watch: {
      'source.global': {
        deep: true,
        handler(newVal){
          if(newVal[this.source.schema.content.id_option]
            && this.globalOld[this.source.schema.content.id_option]
            && (newVal[this.source.schema.content.id_option] === this.globalOld[this.source.schema.content.id_option])
            && ((newVal.web !== this.globalOld.web)
              || (newVal.browser !== this.globalOld.browser)
              || (newVal.mail !== this.globalOld.mail)
              || (newVal.mobile !== this.globalOld.mobile)
            )
          ) {
            this.save(newVal)
            this.$set(this, 'category', {});
            this.$set(this, 'categoryOld', {});
            this.getRef('list').unselect();
            this.getRef('list').updateData();
          }
          this.globalOld = bbn.fn.extend(true, {}, newVal);
        }
      },
      category: {
        deep: true,
        handler(newVal){
          if(newVal[this.source.schema.content.id_option]
            && this.categoryOld[this.source.schema.content.id_option]
            && (newVal[this.source.schema.content.id_option] === this.categoryOld[this.source.schema.content.id_option])
            && ((newVal.web !== this.categoryOld.web)
              || (newVal.browser !== this.categoryOld.browser)
              || (newVal.mail !== this.categoryOld.mail)
              || (newVal.mobile !== this.categoryOld.mobile))
          ) {
            this.save(newVal)
            this.getRef('table').updateData();
          }
          this.categoryOld = bbn.fn.extend(true, {}, newVal);
        }
      }
    },
    components: {
      category: {
        template: `
          <div class="bbn-c bbn-xspadded bbn-bordered-bottom" v-text="source.text"></div>
        `,
        props: {
          source: {
            type: Object
          }
        }
      }
    }
  }
})();