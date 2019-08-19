define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'yuesao/index' + location.search,
                    add_url: 'yuesao/add',
                    edit_url: 'yuesao/edit',
                    del_url: 'yuesao/del',
                    multi_url: 'yuesao/multi',
                    table: 'yuesao',
                }
            });


            var table = $("#table");
            // 绑定TAB事件
            $('.panel-heading ul[data-field] li a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var field = $(this).closest("ul").data("field");
                var value = $(this).data("value");
                console.log(field);
                console.log(value);

                $("select[name='" + field + "'] option[value='" + value + "']", table.closest(".bootstrap-table").find(".commonsearch-table")).prop("selected", true);
                table.bootstrapTable('refresh', {pageNumber: 1});
                return false;
            });
            $('.btn-add').data("area", ['95%','95%'])
            $('.btn-edit').data("area", ['95%','95%']);

            $.fn.bootstrapTable.locales[Table.defaults.locale]['formatSearch'] = function(){return "快速搜索姓名";};
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'name', title: __('Name')},
                        {field: 'type', title: __('Type'), searchList: {"yuesao":__('Type yuesao'),"yuersao":__('Type yuersao')}, formatter: Table.api.formatter.label},
                        {field: 'phone', title: __('Phone')},
                        {field: 'id_card', title: __('Id_card')},
                        {field: 'birth', title: __('Birth'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'baby_data', title: __('Baby_data'), searchList: {"yhyy":__('Baby_data yhyy'),"yhwy":__('Baby_data yhwy'),"ly":__('Baby_data ly'),"so":__('Baby_data so')}, formatter: Table.api.formatter.normal},
                        {field: 'work_experience', title: __('Work_experience')},
                        {field: 'schooling_data', title: __('Schooling_data'), searchList: {"cz":__('Schooling_data cz'),"gz":__('Schooling_data gz'),"dz":__('Schooling_data dz'),"bk":__('Schooling_data bk'),"ssys":__('Schooling_data ssys')}, formatter: Table.api.formatter.normal},
                        {field: 'character', title: __('Character')},
                        {field: 'family', title: __('Family')},
                        {field: 'age_job', title: __('Age_job'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'holder', title: __('Holder'), searchList: {"sfz":__('Holder sfz'),"yys":__('Holder yys'),"my":__('Holder my'),"ys":__('Holder ys'),"cr":__('Holder cr'),"xrtn":__('Holder xrtn'),"chkfs":__('Holder chkfs'),"bjam":__('Holder bjam'),"yy":__('Holder yy'),"byy":__('Holder byy'),"cs":__('Holder cs'),"hs":__('Holder hs'),"jszg":__('Holder jszg'),"hz":__('Holder hz'),"gatx":__('Holder gatx'),"jz":__('Holder jz')}, operate:'FIND_IN_SET', formatter: Table.api.formatter.label},
                        {field: 'services_num', title: __('Services_num')},
                        {field: 'preterm_birth_num', title: __('Preterm_birth_num')},
                        {field: 'twins', title: __('Twins')},
                        {field: 'newborn_option_data', title: __('Newborn_option_data'), searchList: {"xsrjchl":__('Newborn_option_data xsrjchl'),"xsrcjjbgc":__('Newborn_option_data xsrcjjbgc'),"sbtzcrhl":__('Newborn_option_data sbtzcrhl'),"xrtn":__('Newborn_option_data xrtn'),"xsrzj":__('Newborn_option_data xsrzj')}, operate:'FIND_IN_SET', formatter: Table.api.formatter.label},
                        {field: 'maternal_options_data', title: __('Maternal_options_data'), searchList: {"cfjchl":__('Maternal_options_data cfjchl'),"tscfhl":__('Maternal_options_data tscfhl'),"cfcjjbgc":__('Maternal_options_data cfcjjbgc'),"jcyzc":__('Maternal_options_data jcyzc'),"tlyzc":__('Maternal_options_data tlyzc'),"chkfz":__('Maternal_options_data chkfz'),"chbfd":__('Maternal_options_data chbfd'),"chjlam":__('Maternal_options_data chjlam'),"jcrfhl":__('Maternal_options_data jcrfhl')}, operate:'FIND_IN_SET', formatter: Table.api.formatter.label},
                        {field: 'medical_ins', title: __('Medical_ins')},
                        {field: 'medical', title: __('Medical'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'medical_data', title: __('Medical_data'), searchList: {"qualified":__('Medical_data qualified'),"unqualified":__('Medical_data unqualified')}, formatter: Table.api.formatter.normal},
                        {field: 'unqualified_why', title: __('Unqualified_why')},
                        {field: 'medical_end', title: __('Medical_end'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'training_records', title: __('Training_records')},
                        {field: 'id_card_images', title: __('Id_card_images'), events: Table.api.events.image, formatter: Table.api.formatter.images},
                        {field: 'life_images', title: __('Life_images'), events: Table.api.events.image, formatter: Table.api.formatter.images},
                        {field: 'service_images', title: __('Service_images'), events: Table.api.events.image, formatter: Table.api.formatter.images},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'switch', title: __('Switch'), formatter: Table.api.formatter.toggle},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
            table.on('post-body.bs.table', function (e, settings, json, xhr) {
                $(".btn-editone").data("area", ["95%","95%"]);
            });
        },

        recyclebin: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    'dragsort_url': ''
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: 'yuesao/recyclebin' + location.search,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'name', title: __('Name'), align: 'left'},
                        {
                            field: 'deletetime',
                            title: __('Deletetime'),
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            formatter: Table.api.formatter.datetime
                        },
                        {
                            field: 'operate',
                            width: '130px',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'Restore',
                                    text: __('Restore'),
                                    classname: 'btn btn-xs btn-info btn-ajax btn-restoreit',
                                    icon: 'fa fa-rotate-left',
                                    url: 'yuesao/restore',
                                    refresh: true
                                },
                                {
                                    name: 'Destroy',
                                    text: __('Destroy'),
                                    classname: 'btn btn-xs btn-danger btn-ajax btn-destroyit',
                                    icon: 'fa fa-times',
                                    url: 'yuesao/destroy',
                                    refresh: true
                                }
                            ],
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            require(['upload'], function(Upload){
                Upload.api.plupload($(".plupload"), function(data, ret){
                    Toastr.success("成功111111111");
                }, function(data, ret){
                    Toastr.success("失败");
                });
            });
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});