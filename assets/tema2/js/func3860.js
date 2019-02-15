document.oncontextmenu = function () {
    // return false;
};
(function ($) {
    var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var uTF8Encode = function (string) {
        string = string.replace(/\x0d\x0a/g, "\x0a");
        var output = "";
        for (var n = 0; n < string.length; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                output += String.fromCharCode(c);
            } else if ((c > 127) && (c < 2048)) {
                output += String.fromCharCode((c >> 6) | 192);
                output += String.fromCharCode((c & 63) | 128);
            } else {
                output += String.fromCharCode((c >> 12) | 224);
                output += String.fromCharCode(((c >> 6) & 63) | 128);
                output += String.fromCharCode((c & 63) | 128);
            }
        }
        return output;
    };
    var uTF8Decode = function (input) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;
        while (i < input.length) {
            c = input.charCodeAt(i);
            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            } else if ((c > 191) && (c < 224)) {
                c2 = input.charCodeAt(i + 1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            } else {
                c2 = input.charCodeAt(i + 1);
                c3 = input.charCodeAt(i + 2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }
        }
        return string;
    }
    $.extend({
        b64enc: function (input) {
            var output = "";
            var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
            var i = 0;
            input = uTF8Encode(input);
            while (i < input.length) {
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);
                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;
                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }
                output = output + keyString.charAt(enc1) + keyString.charAt(enc2) + keyString.charAt(enc3) + keyString.charAt(enc4);
            }
            return output;
        }, b64dec: function (input) {
            var output = "";
            var chr1, chr2, chr3;
            var enc1, enc2, enc3, enc4;
            var i = 0;
            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
            while (i < input.length) {
                enc1 = keyString.indexOf(input.charAt(i++));
                enc2 = keyString.indexOf(input.charAt(i++));
                enc3 = keyString.indexOf(input.charAt(i++));
                enc4 = keyString.indexOf(input.charAt(i++));
                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;
                output = output + String.fromCharCode(chr1);
                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }
            }
            output = uTF8Decode(output);
            return output;
        }
    });
})(jQuery);

/*
$.preload = function (callback) {
    var pic = [], i, imageList = [], loaded = 0, total, regex = new RegExp("url\((.*)\)", 'i'), spl;
    var cssSheets = document.styleSheets, path, myRules, Rule, match, txt, img, sheetIdx, ruleIdx;
    for (sheetIdx = 0; sheetIdx < cssSheets.length; sheetIdx++) {
        var sheet = cssSheets[sheetIdx];
        if (typeof sheet.href == 'string' && sheet.href.length > 0) {
            spl = sheet.href.split('/');
            spl.pop();
            path = spl.join('/') + '/';
        }
        else {
            path = './';
        }
        myRules = sheet.cssRules ? sheet.cssRules : sheet.rules;
        for (ruleIdx = 0; ruleIdx < myRules.length; ruleIdx++) {
            Rule = myRules[ruleIdx];
            txt = Rule.cssText ? Rule.cssText : Rule.style.cssText;
            match = regex.exec(txt);
            if (match != null) {
                img = match[1].substring(1, match[1].indexOf(')', 1));
                if (img.charCodeAt(0) == 34) {
                    img = img.split('"');
                    img = img[1];
                }
                if (img.substring(0, 4) == 'http') {
                    imageList[imageList.length] = img;
                }
                else if (match[1].substring(1, 2) == '/') {
                    var p2 = path.split('/');
                    p2.pop();
                    p2.pop();
                    p2x = p2.join("/");
                    imageList[imageList.length] = p2x + img;
                }
                else {
                    imageList[imageList.length] = path + img;
                }
            }
        }
    }

    total = imageList.length;
    for (i = 0; i < total; i++) {
        pic[i] = new Image();
        pic[i].onload = function () {
            loaded++;
            if (loaded == total) {
                if ($.isFunction(callback)) {
                    callback();
                }
            }
        };
        pic[i].src = imageList[i];
    }
};*/
