
/**
 * Theme: Moltran Admin Template
 * Author: Coderthemes
 * Nestable Component
 */

!function ($) {
    "use strict";

    var Nestable = function () {};

//    Nestable.prototype.updateOutput = function (e) {
//        var list = e.length ? e : $(e.target), output = list.data('output');
//        if (window.JSON) {
//            output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
//        } else {
//            output.val('JSON browser support required for this demo.');
//        }
//
//        $.ajax({
//            method: "POST",
//            url: "/admin/menu/save",
//            data: {
//                list: list.nestable('serialize')
//            }
//        }).fail(function (jqXHR, textStatus, errorThrown) {
//            alert("Unable to save new list order: " + errorThrown);
//        });
//    },
    //init
    Nestable.prototype.init = function () {
        // activate Nestable for list 1
//        $('#nestable_list_1').nestable({
//            group: 1
//        });

        // activate Nestable for list 2
        $('#nestable_list_2').nestable({
            group: 1
        }).on('change', function (e) {
            var list = e.length ? e : $(e.target), output = list.data('output');
//            if (window.JSON) {
//                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
//            } else {
//                output.val('JSON browser support required for this demo.');
//            }
            $.ajax({
                method: "POST",
                url: "/admin/menu/save",
                data: {
                    list: list.nestable('serialize')
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                alert("Unable to save new list order: " + errorThrown);
            });
        });

        // output initial serialised data
//                this.updateOutput($('#nestable_list_1').data('output', $('#nestable_list_1_output')));
//        this.updateOutput($('#nestable_list_2').data('output', $('#nestable_list_2_output')));

        $('#nestable_list_menu').on('click', function (e) {
            var target = $(e.target),
                    action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        $('#nestable_list_3').nestable();
    },
            //init
            $.Nestable = new Nestable, $.Nestable.Constructor = Nestable
}(window.jQuery),
//initializing 
        function ($) {
            "use strict";
            $.Nestable.init()
        }(window.jQuery);
$(document).ready(
        function () {

            $(".nicescroll").niceScroll();

        }

);