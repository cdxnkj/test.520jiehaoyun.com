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
            var v = '';
            var s = '';
            $('.form_input ul>li[contenteditable="true"]').focus(function () {
                var _this = $(this);
                v = _this.text();
                s = _this.next('span').text();
                if (_this.text() == '您的姓名' || _this.text() == '您的电话') {
                    _this.text('');
                    _this.next('span').text('');

                }
            }).blur(function () {
                var _this = $(this);

                _this.text(v);
                _this.next('span').text(s);

            })


            $('body').bind('click', function (event) {
                // IE支持 event.srcElement ， FF支持 event.target
                var evt = event.srcElement ? event.srcElement : event.target;
                if (evt.id == 'hideYrs') return; // 如果是元素本身，则返回
                else {
                    $('#hideYrs').hide(); // 如不是则隐藏元素
                }
                if (evt.id == 'hideYcq') return;

                else {
                    $('#hideYcq').hide(); // 如不是则隐藏元素

                }
            });
            $('.form_input ul>li:first').on('click', function () {
                event.stopPropagation();

                $('.service_type').toggle();

                return false;

            });
            $('.form_input ul>li').eq(2).on('click', function () {
                var _this = $(this);

                event.stopPropagation();
                $('.yuchan_sel').toggle();
                //判断相同选项禁止点击

                $('.form_input .yuchan_sel p').each(function () {
                    if (_this.find('.se_v').attr('data-ycq') == $(this).attr('data-ycq')) {
                        $(this).css({'color': '#ddd', 'cursor': 'no-drop'});
                    }
                });
                return false;

            });
            //类型
            $('.service_type>p').on('click', function () {

                var _this = $(this);
                var v = _this.closest('.form_input').find('ul li').eq(0).find('.se_v');
                if (v.attr('data-type') == 'yuesao') {

                    v.text('育儿嫂').attr('data-type', 'yuersao');
                    _this.attr('data-type', 'yuesao').text('月嫂');
                }
                else {
                    v.text('月嫂').attr('data-type', 'yuesao');
                    _this.attr('data-type', 'yuersao').text('育儿嫂');
                }

            });

            //护理经验

            $('.yuchan_sel>p').on('click', function () {
                //找到禁止的选项
                var j;
                $('.form_input .yuchan_sel p').each(function () {
                    if ($(this).css('cursor') == 'no-drop')   j = $(this);
                });

                var _this = $(this); //option

                var v = _this.closest('.form_input').find('ul li').eq(2).find('.se_v'); //父级选项
                if (_this.css('cursor') == 'no-drop')   return false;
                v.attr('data-ycq', _this.attr('data-ycq')).text(_this.text());

                _this.attr('data-ycq', v.attr('data-ycq'));

                j.css({'color': 'rgba(0, 0, 0, 0.65)', 'cursor': 'pointer'});
            });

            /*   $('.form_input ul>li[contenteditable="true"]').bind('input porpertychange',function () {
                   if()
               });*/

        }


    };
    return Controller;
});