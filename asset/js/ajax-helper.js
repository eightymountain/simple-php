const ajax = (function () {
    'use strict';
    let option = { // set default option
        dateType: "json",
        cache: false,
        processData: true,
        // contentType: 'application/json; charset=utf-8',
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    };

    let baseUrl = '';

    function run(method, url, param, successCallback, errCallback, opt) {

        if (typeof opt === 'object') {
            for (let k in option) {
                if (opt.hasOwnProperty(k)) {
                    option[k] = opt[k];
                }
            }
        }

        $.ajax({
            type: method,
            url: baseUrl + url,
            data: param,
            ...option,
            success: function (response) {
                if (typeof (successCallback) === 'function') {
                    successCallback(response);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(`http status:${jqXHR.status}, error:${errorThrown}`);
                console.log(jqXHR.responseText);
                let err = JSON.parse(jqXHR.responseText).errors;
                if (!err) {
                    return false;
                }
                if (typeof (errCallback) === 'function') {
                    errCallback(err);
                } else {
                    alert(err[Object.keys(err)[0]])
                }
            },
        });
    }

    function serialize(obj) {
        let str = [];
        for (let p in obj) {
            if (obj.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        }
        return str.join("&");
    }

    return {
        get: function (url, param, successCallback, errCallback, opt) {
            url = url + '?' + serialize(param);
            run('GET', url, null, successCallback, errCallback, opt);
        },
        post: function (url, param, successCallback, errCallback, opt) {
            run('POST', url, param, successCallback, errCallback, opt);
        },
        promise: function (option = {}) {
            var opt = {
                type: option.method,
                dataType: 'json',
            };
            if (option.method.toLowerCase() === 'get') {
                opt.url = option.url + '?' + serialize(option.param);
            } else {
                opt.url = option.url;
                opt.data = serialize(option.param);
            }

            return new Promise((resolve, reject) => {
                $.ajax(
                    opt
                ).done(function (result, status, responseObj) {
                    resolve(result);
                }).fail(function (result, status, responseObj) {
                    reject(result);
                });

            });
        },
    };
}());
