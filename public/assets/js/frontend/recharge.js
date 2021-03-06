define(['jquery', 'bootstrap', 'frontend'], function ($, undefined, Frontend) {
    var Controller = {
        recharge: function () {
            $(document).on("click", ".row-money label[data-type]", function () {
                $(".row-money label[data-type]").removeClass("active");
                $(this).addClass("active");
                $("#col-custom").toggleClass("hidden", $(this).data("type") === "fixed");
                $("input[name=money]").val($(this).data("value"));
                if ($(this).data("type") === 'custom') {
                    $("input[name=custommoney]").trigger("focus").trigger("change");
                }
            });
            $(document).on("click", ".row-paytype label", function () {
                $(".row-paytype label").removeClass("active");
                $(this).addClass("active");
                $("input[name=paytype]").val($(this).data("value"));
            });
            $(document).on("keyup change", ".custommoney", function () {
                $("input[name=money]").val($(this).val());
            });
            $("#recharge-form").on("submit", function () {
                var price = parseFloat($("input[name=money]").val());
                if (isNaN(price) || price <= 0) {
                    Layer.msg("充值金额不正确");
                    return false;
                }
            });
        }
    };
    return Controller;
});
