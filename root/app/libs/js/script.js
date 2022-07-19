$(function () {

    if (window.location.pathname === '/cars/create') {
        Inputmask({
            mask: "V{1} 999 V{2} 9{1,3}",
            definitions: {
                "V": {
                    validator: "[а-я\\d]",
                    casing: "upper"
                }
            },
            clearIncomplete: true,
            autoUnmask: true
        }).mask('[name*="state_number"]');

        $('[name*="year_issue"]').inputmask({
            mask: '99-99-9999'
        });

        Inputmask({
            mask: "V{17}",
            definitions: {
                "V": {
                    validator: "[a-z\\d]",
                    casing: "upper"
                }
            },
            clearIncomplete: true,
            autoUnmask: true
        }).mask('[name*="chassis_number"], [name*="body_number"]');
    }

    if (window.location.pathname === '/cars') {
        $(".delete-object").on("click", function() {
            const id = $(this).attr("delete-id");

            bootbox.confirm({
                message: "<h4>Вы уверены?</h4>",
                buttons: {
                    confirm: {
                        label: "Да",
                        className: "btn-danger"
                    },
                    cancel: {
                        label: "Нет",
                        className: "btn-primary"
                    }
                },
                callback: function (result) {
                    if (result == true) {
                        $.post("/cars/delete", {
                            object_id: id
                        }, function(data){
                            location.reload();
                        }).fail(function() {
                            alert("Невозможно удалить.");
                        });
                    }
                }
            });

            return false;
        });
    }

    if (window.location.pathname === '/drivers/create') {

        $('[name*="birthday"]').inputmask({
            mask: '99-99-9999'
        });

        $('[name*="phone"]').inputmask({
            mask: '+7 (\\999) 999 99 99',
            showMaskOnFocus: false,
            showMaskOnHover: false,
            onBeforeMask: function (value, opts) {
                return value.replace(/^79/g, "");
            }
        });

        $('[name*="driving_license"]').inputmask({
            mask: '99 99 999999'
        });

        $('[name*="data_driving_license"]').inputmask({
            mask: '99-99-9999'
        });
    }

    if (window.location.pathname === '/drivers') {
        $(".delete-object").on("click", function () {
            const id = $(this).attr("delete-id");

            bootbox.confirm({
                message: "<h4>Вы уверены?</h4>",
                buttons: {
                    confirm: {
                        label: "Да",
                        className: "btn-danger"
                    },
                    cancel: {
                        label: "Нет",
                        className: "btn-primary"
                    }
                },
                callback: function (result) {
                    if (result == true) {
                        $.post("/drivers/delete", {
                            object_id: id
                        }, function (data) {
                            location.reload();
                        }).fail(function () {
                            alert("Невозможно удалить.");
                        });
                    }
                }
            });

            return false;
        });
    }
});