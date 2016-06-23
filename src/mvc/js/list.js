// Javascript Document
$("div.appui-notifications-grid", ele).kendoGrid({
  dataSource: {
    data: data.notifications,
    schema: {
      model: {
        id: "id",
        fields: {
          id: {type: "number"},
          title: {type: "string"},
          content: {type: "string"},
          creation: {type: "date"}
        }
      }
    }
  },
  columns: [{
    field: "id",
    hidden: true,
  }, {
    title: data.lng.title,
    field: "title"
  }, {
    title: data.lng.message,
    field: "content",
    attributes: {
      style: "font-weight: normal;"
    },
    encoded: false
  }, {
    title: data.lng.creation,
    field: "creation",
    width: 100,
    template: function(e){
      return appui.fn.fdate(e.creation);
    }
  }, {
    title: " ",
    width: 50,
    template: function(e){
      return '<button class="k-button"><i class="adherent fa fa-check"> </i></button>'
    }
  }]
});
