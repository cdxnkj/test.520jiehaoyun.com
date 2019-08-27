define(['jquery', 'bootstrap', 'frontend', 'form', 'template'], function ($, undefined, Frontend, Form, Template) {
    var validatoroptions = {
        invalid: function (form, errors) {
            $.each(errors, function (i, j) {
                Layer.msg(j);
            });
        }
    };
    var Controller = {

        index: function () {

            //本地验证未通过时提示
            // $("#register-form").data("validator-options", validatoroptions);
            //为表单绑定事件
            Form.api.bindevent($("#register-form"), function (data, ret) {
                setTimeout(function () {
                    location.href = ret.url ? ret.url : "/";
                }, 1000);
            });

            $('body').bind('click', function (event) {
                // IE支持 event.srcElement ， FF支持 event.target
                var evt = event.srcElement ? event.srcElement : event.target;
                if (evt.id == 'hideYsjy') return; // 如果是元素本身，则返回
                else {
                    $('#hideYsjy').hide(); // 如不是则隐藏元素
                }
                if (evt.id == 'hideHljy') return; // 如果是元素本身，则返回
                else {
                    $('#hideHljy').hide(); // 如不是则隐藏元素
                }
                if (evt.id == 'hideYsnl') return; // 如果是元素本身，则返回
                else {
                    $('#hideYsnl').hide(); // 如不是则隐藏元素
                }

            });
            //展开下拉
            $('.down-ico').closest('.controls').on('click', function (event) {
                event.stopPropagation();

                var _this = $(this); //option
                _this.find('.form_sel').toggle();
                _this.find('ul li p').each(function () {
                    if ($.trim(_this.find('input[type="hidden"]').val()) == $.trim($(this).text())){
                        $(this).css({'color': '#ddd', 'cursor': 'no-drop'});
                    }
                });
                return false;

            });
            //预产期子节点
            $('.down-ico').closest('.controls').find('ul li p').on('click', function (event) {

                var _this = $(this); //option
                if (_this.css('cursor') == 'no-drop') return false;
                console.log(_this.text());
                //找到禁止的选项
                var j;
                _this.closest('.controls').find('ul li p').each(function () {
                    if ($(this).css('cursor') == 'no-drop') j = $(this);
                });
                var v = _this.closest('.controls').find('.se_v'); //父级选项
                v.text(_this.text());
                _this.closest('.controls').find('input[type="hidden"]').val(_this.text());
                j.css({'color': 'rgba(0, 0, 0, 0.65)', 'cursor': 'pointer'});
            });


        },

        changepwd: function () {
            //本地验证未通过时提示
            $("#changepwd-form").data("validator-options", validatoroptions);

            //为表单绑定事件
            Form.api.bindevent($("#changepwd-form"), function (data, ret) {
                setTimeout(function () {
                    location.href = ret.url ? ret.url : "/";
                }, 1000);
            });
        },

    };
    return Controller;
});