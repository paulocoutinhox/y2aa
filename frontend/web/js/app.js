// Language class
var Language = new function () {

    this.change = function (id) {
        $.ajax({
            type: 'GET',
            url: frontendBaseURL + '/language/change',
            data: {'id': id},
            success: function (response, status, xhr) {
                window.location.href = '';
            }
        });
    };

};

// Util class
var Util = new function () {

    this.changeElementText = function (element, text) {
        if (element) {
            if ($(element).is('input')) {
                $(element).val(text);
            } else {
                $(element).text(text);
            }
        }
    };

    this.showLoadingModal = function (show) {
        if (show) {
            $('.loading-modal').modal('show');
        } else {
            $('.loading-modal').modal('hide');
        }
    };

    this.showErrorMessage = function (data) {
        var responseMessage = data.message;
        var responseData = data.data;

        var showGenericMessage = true;

        if (responseMessage) {
            if (responseMessage === "validate") {
                var message = translations['Frontend.Message.Dialog.Validate'];
                var field = Object.keys(responseData.errors)[0];
                message = message.replace(/{errors}/g, "<br><br><ul><li>" + responseData.errors[field][0] + "</li></ul>");

                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: translations['Frontend.Title.Dialog'],
                    message: message,
                    buttons: [{
                        label: translations['Frontend.Button.Dialog.OK'],
                        action: function (dialogRef) {
                            dialogRef.close();
                        }
                    }]
                });

                showGenericMessage = false;
            }
        }

        if (showGenericMessage) {
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DANGER,
                title: translations['Frontend.Title.Dialog'],
                message: translations['Frontend.Message.Dialog.GenericError'],
                buttons: [{
                    label: translations['Frontend.Button.Dialog.OK'],
                    action: function (dialogRef) {
                        dialogRef.close();
                    }
                }]
            });
        }
    };

};

// Customer class
var Customer = new function () {

    this.checkAndSendToMobile = function () {
        $.ajax({
            type: 'GET',
            url: frontendBaseURL + '/customer/check',
            dataType: 'json',
            success: function (response, status, xhr) {
                try {
                    // send to mobile
                    var success = response.success;

                    if (success) {
                        var message = response.message;
                        var data = response.data;

                        if (data) {
                            var params = data.customer;

                            if (typeof AndroidApp != 'undefined') {
                                AndroidApp.updateCustomerData(JSON.stringify(params));
                            } else {
                                setupWebViewJavascriptBridge(function (bridge) {
                                    bridge.callHandler('updateCustomerData', JSON.stringify(params), function (response) {
                                    });
                                });
                            }
                        }
                    }
                } catch (e) {
                    // ignore
                }
            }
        });
    };

    this.autoRefreshData = function () {
        setTimeout(function () {
            Customer.checkAndSendToMobile();
            Customer.autoRefreshData();
        }, 15000);
    };

};

// JS Integration
function setupWebViewJavascriptBridge(callback) {
    if (window.WebViewJavascriptBridge) {
        return callback(WebViewJavascriptBridge);
    }
    if (window.WVJBCallbacks) {
        return window.WVJBCallbacks.push(callback);
    }
    window.WVJBCallbacks = [callback];
    var WVJBIframe = document.createElement('iframe');
    WVJBIframe.style.display = 'none';
    WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';
    document.documentElement.appendChild(WVJBIframe);
    setTimeout(function () {
        document.documentElement.removeChild(WVJBIframe)
    }, 0)
}

// PWA - Only register a service worker if it's supported
if ('serviceWorker' in navigator) {
    console.log('PWA supported!');

    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
            .then((reg) => {
                console.log('Service worker registered.', reg);
            });
    });
} else {
    console.log('PWA not supported!');
}

// Auto start cart data update
window.addEventListener('load', () => {
    setTimeout(function () {
        // enable send data to mobile to catch customer data and send to firebase for example
        Customer.checkAndSendToMobile();
        Customer.autoRefreshData();
    }, 100);
});