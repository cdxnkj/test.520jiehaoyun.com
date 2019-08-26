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
            //获取验证码
            Controller.getCode('#res .get-code');
            //为表单绑定事件
            Form.api.bindevent($("#register-form"), function (data, ret) {
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
                if (evt.id == 'hideYcq') return; // 如果是元素本身，则返回
                else {
                    $('#hideYcq').hide(); // 如不是则隐藏元素
                }

            });
            //获取验证码
            Controller.getCode('#res .get-code');
            //展开下拉
            $('.down-ico').closest('.controls').on('click', function () {
                event.stopPropagation();

                var _this = $(this); //option
                $('.yuchan_sel').toggle();
                $('#hideYcq p').each(function () {
                    if ($.trim(_this.find('.se_v').attr('data-ycq')) == $.trim($(this).attr('data-ycq'))) {
                        $(this).css({'color': '#ddd', 'cursor': 'no-drop'});
                    }
                });
                return false;

            });
            //预产期子节点
            $('.yuchan_sel>p').on('click', function () {
                //找到禁止的选项
                var j;
                $('.yuchan_sel p').each(function () {
                    if ($(this).css('cursor') == 'no-drop') j = $(this);
                });

                var _this = $(this); //option

                var v = _this.closest('.controls').find('.se_v'); //父级选项
                if (_this.css('cursor') == 'no-drop') return false;
                v.attr('data-ycq', _this.attr('data-ycq')).text(_this.text());
                $('input[type="hidden"][name="baby_ycq"]').val(_this.text());

                _this.attr('data-ycq', v.attr('data-ycq'));

                j.css({'color': 'rgba(0, 0, 0, 0.65)', 'cursor': 'pointer'});
            });


        },
        /**
         * 验证码倒计时
         */
        resetCode: function () {
            //倒计时
            $('.cli-code').text(60 + '(s)');

            var second = 59;
            var timer = null;
            timer = setInterval(function () {
                second -= 1;
                if (second > 0) {
                    $('.get-code').html(second + '(s)').css("pointer-events", "none");
                } else {
                    clearInterval(timer);
                    $('.get-code').text('获取验证码').css('pointer-events', '');
                    // $('#J_resetCode').hide();
                }
            }, 1000);


        },
        /**
         * 获取验证码
         * @param el  节点元素
         */
        getCode:function(el){
            //发送验证码
            $(el).on('click', function () {
                var phone = $('#res').find('input[name="mobile"]').val();
                if (!(/^1[3456789]\d{9}$/.test(phone))) {
                    Toastr.error("手机号码有误");
                    return false;
                }
                var loads = Layer.load(2);
                Controller.resetCode();
                $.post('user/getCode', {phone: phone}, function (ret) {
                    Layer.close(loads);
                    if (ret.code == 1) {
                        Layer.msg(ret.msg);
                    }
                    Layer.msg(ret.msg);

                })

                return false;

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