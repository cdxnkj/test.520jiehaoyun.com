define(['jquery', 'bootstrap', 'frontend', 'form', 'template'], function ($, undefined, Frontend, Form, Template) {
    var validatoroptions = {
        invalid: function (form, errors) {
            $.each(errors, function (i, j) {
                Layer.msg(j);
            });
        }
    };
    var Controller = {
        login: function () {


            //本地验证未通过时提示
            $("#login-form").data("validator-options", validatoroptions);

            $(document).on("change", "input[name=type]", function () {
                var type = $(this).val();
                $("div.form-group[data-type]").addClass("hide");
                $("div.form-group[data-type='" + type + "']").removeClass("hide");
                $('#resetpwd-form').validator("setField", {
                    captcha: "required;length(4);integer[+];remote(" + $(this).data("check-url") + ", event=resetpwd, " + type + ":#" + type + ")",
                });
                $(".btn-captcha").data("url", $(this).data("send-url")).data("type", type);
            });

            //为表单绑定事件
            Form.api.bindevent($("#login-form"), function (data, ret) {
                setTimeout(function () {
                    location.href = ret.url ? ret.url : "/";
                }, 1000);
            });

            Form.api.bindevent($("#resetpwd-form"), function (data) {
                Layer.closeAll();
            });

            $(document).on("click", ".btn-forgot", function () {
                var id = "resetpwdtpl";
                var content = Template(id, {});
                Layer.open({
                    type: 1,
                    title: __('Reset password'),
                    area: ["450px", "355px"],
                    content: content,
                    success: function (layero) {
                        Form.api.bindevent($("#resetpwd-form", layero), function (data) {
                            Layer.closeAll();
                        });
                    }
                });
            });
        },
        register: function () {
            var form_arr = new Array();
            //发送验证码
            $('#res .cli-code').on('click', function () {
               var loads =  Layer.load(2);
                if (!(/^1[3456789]\d{9}$/.test($(this).closest('li').prev('li').find('span:last').text()))) {
                    Toastr.error("手机号码有误");
                    return false;
                }

                Controller.resetCode();
                // Fast.api.ajax()/

            })
            $('.send-register').on('click', function () {


                form_arr = [];
                $('#res ul li[data-cod!="code"]').each(function () {
                    var v = $.trim($(this).find('span:last').text());
                    if (v == '') {
                        Toastr.error('请将信息填写完整');
                        form_arr = [];
                        return false;
                    }
                    else {

                        form_arr.push(v);

                    }
                });
                console.log(Controller.repPhone());

            });



        },
        resetCode: function () {
            //倒计时
            $('.cli-code').text(60+'(s)');

            var second = 59;
            var timer = null;
            timer = setInterval(function () {
                second -= 1;
                if (second > 0) {
                    $('.cli-code').html(second+'(s)').css("pointer-events","none");
                } else {
                    clearInterval(timer);
                    $('.cli-code').text('获取验证码').css('pointer-events','');
                    // $('#J_resetCode').hide();
                }
            }, 1000);


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
        profile: function () {
            // 给上传按钮添加上传成功事件
            $("#plupload-avatar").data("upload-success", function (data) {
                var url = Fast.api.cdnurl(data.url);
                $(".profile-user-img").prop("src", url);
                Toastr.success(__('Upload successful'));
            });
            Form.api.bindevent($("#profile-form"));
            $(document).on("click", ".btn-change", function () {
                var that = this;
                var id = $(this).data("type") + "tpl";
                var content = Template(id, {});
                Layer.open({
                    type: 1,
                    title: "修改",
                    area: ["400px", "250px"],
                    content: content,
                    success: function (layero) {
                        var form = $("form", layero);
                        Form.api.bindevent(form, function (data) {
                            location.reload();
                            Layer.closeAll();
                        });
                    }
                });
            });
        }
    };
    return Controller;
});