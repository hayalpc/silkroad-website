
$(function () {
    getRidOffAutocomplete();

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '1']);
    _gaq.push(['_setDomainName', 'x.com']);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = '//google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();


    document.getElementById("loading").className = "loading-visible";
    var hideDiv = function () {
        document.getElementById("loading").className = "loading-invisible";
    };
    var oldLoad = window.onload;
    var newLoad = oldLoad ? function () {
        hideDiv.call(this);
        oldLoad.call(this);
    } : hideDiv;
    window.onload = newLoad;


    $("#selectchar0").selectbox();

    $('#part1').hover(function () {
        $('#smenu1>div').fadeIn(400);
        $('#menu1').css('background-position', '0 -60px');
    }, function () {
        $('#smenu1>div').fadeOut(400);
        $('#menu1').css('background-position', '0 0');
    });
    $('#part2').hover(function () {
        $('#smenu2>div').fadeIn(400);
        $('#menu2').css('background-position', '0 -60px');
    }, function () {
        $('#smenu2>div').fadeOut(400);
        $('#menu2').css('background-position', '0 0');
    });

    // $('#smenu1>div>div').add('#smenu2>div>div').hover(function () {
    //     $(this).addClass('sm_h');
    // }, function () {
    //     $(this).removeClass('sm_h');
    // });
    // $('#css3menu1>li>ul>li').hover(function () {
    //     $(this).addClass('sm_h');
    // }, function () {
    //     $(this).removeClass('sm_h');
    // });

    $('#menu3').hover(function () {
        $(this).css('background-position', '-12px -60px');
    }, function () {
        $(this).css('background-position', '-12px 0');
    });
    $('#menu4').hover(function () {
        $(this).css('background-position', '-10px -60px');
    }, function () {
        $(this).css('background-position', '-10px 0');
    });
    $('.box2_l').hover(function () {
        $(this).css({'background-position': '0 -34px', 'color': '#817865'});
    }, function () {
        $(this).css({'background-position': '0 0', 'color': '#b7a072'});
    });
    $('#ql1').add('#ql2').add('#ql3').hover(function () {
        $(this).css('background-position', '0 -37px');
    }, function () {
        $(this).css('background-position', '0 0');
    });
    $('#box4_l').add('#box4_c').add('#box4_r').hover(function () {
        $(this).css('background-position', '0 -83px');
    }, function () {
        $(this).css('background-position', '0 0');
    });
    $('#reg').add('#fpw').hover(function () {
        $(this).css('background-position', '0 -40px');
    }, function () {
        $(this).css('background-position', '0 0');
    });
    $('#login').hover(function () {
        $(this).css('background-position', '0 -49px');
    }, function () {
        $(this).css('background-position', '0 0');
    });
    $('#box3').hover(function () {
        $(this).css('background-position', '0 -69px');
    }, function () {
        $(this).css('background-position', '0 0');
    });
    $('#box4').hover(function () {
        $(this).css('background-position', '0 -69px');
    }, function () {
        $(this).css('background-position', '0 0');
    });
    $('#box5').hover(function () {
        $(this).css('background-position', '0 -69px');
    }, function () {
        $(this).css('background-position', '0 0');
    });
    $('#box6').hover(function () {
        $(this).css('background-position', '0 -69px');
    }, function () {
        $(this).css('background-position', '0 0');
    });
    $('#donate').add('#votp').add('#gkraft').add('#myacc').add('#mychr').add('#myitm').add('#myfrnd').hover(function () {
        $(this).css('text-decoration', 'underline');
        $(this).css('background', '#b7a072');
        $(this).css('color', '#1E0F08');
    }, function () {
        $(this).css('text-decoration', 'none');
        $(this).css('background', '#1E0F08');
        $(this).css('color', '#b7a072');
    });
    $('#loff').hover(function () {
        $(this).css('text-decoration', 'underline');
        $(this).css('background', '#544b3d');
        $(this).css('color', '#ca2d09');
    }, function () {
        $(this).css('text-decoration', 'none');
        $(this).css('background', '#1E0F08');
        $(this).css('color', '#544b3d');
    });
    $('#elder').add('#nikand').add('#crissa').add('#nolwen').hover(function () {
        $(this).css('text-decoration', 'underline');
    }, function () {
        $(this).css('text-decoration', 'none');
    });
    $('#server1').mouseover(function () {
        $('#infos1').show(400);
    }).mouseout(function () {
        $('#infos1').hide(400);
    });
    $('#fortres1').mouseover(function () {
        $('#infof1').show(400);
    }).mouseout(function () {
        $('#infof1').hide(400);
    });
    $('#server2').mouseover(function () {
        $('#infos2').show(400);
    }).mouseout(function () {
        $('#infos2').hide(400);
    });
    $('#fortres2').mouseover(function () {
        $('#infof2').show(400);
    }).mouseout(function () {
        $('#infof2').hide(400);
    });
    $('#server3').mouseover(function () {
        $('#infos3').show(400);
    }).mouseout(function () {
        $('#infos3').hide(400);
    });
    $('#fortres3').mouseover(function () {
        $('#infof3').show(400);
    }).mouseout(function () {
        $('#infof3').hide(400);
    });
    rdy();
    cu(49346);

    // $('.login').click(function () {
    //     var name = $('.name').val();
    //     var pass = $('.pas').val();
    //     document.getElementById("loading").className = "loading-visible";
    //     $.ajax({
    //         url: "mod/loginc.php",
    //         data: "name=" + name + "&pw=" + pass,
    //         success: function (msg) {
    //             if (msg == 'all_ok')
    //                 location = "news.htm";
    //             else if (msg.charCodeAt(0) == 'y'.charCodeAt(0)) {
    //
    //                 var email = msg.slice(1, msg.indexOf("&"))
    //                 var answer = confirm("Your account is not activated yet.\n Resend email " + email + " for activation?")
    //                 if (answer) {
    //                     document.getElementById("loading").className = "loading-invisible";
    //                     setTimeout("resendemail('" + msg.slice(1) + "')", 1);
    //                 }
    //                 else {
    //                     document.getElementById("loading").className = "loading-invisible";
    //                     setTimeout("gotonews()", 1);
    //                 }
    //             }
    //             else {
    //                 document.getElementById("loading").className = "loading-invisible";
    //                 alert("Error " + msg);
    //             }
    //         },
    //         error: function (msg) {
    //             document.getElementById("loading").className = "loading-invisible";
    //             alert("Error: " + msg);
    //         }
    //     });
    // });

    $(".dropdown dt").click(function () {
        $(".dropdown dd ul").toggle();
    });

    $(document).bind('click', function (e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("dropdown")) {
            $(".dropdown dd ul").hide();
        }
    });

});

function getRidOffAutocomplete(){
    var timer = window.setTimeout( function(){
        $('.clearAutoComplete').prop('disabled',false);
        clearTimeout(timer);
    }, 1000);
}

function showPost(the_id) {
    document.getElementById(the_id).style.display = "block";
    document.getElementById(the_id + "show").style.display = "none";
}

function hidePost(the_id) {
    document.getElementById(the_id).style.display = "none";
    document.getElementById(the_id + "show").style.display = "block";
}

function rdy() {

}

function cu(ct) {
    var newDate = new Date();
    newDate.setDate(newDate.getDate());
    var seconds = new Date().getSeconds();
    var minutes = new Date().getMinutes();
    var hours = new Date().getHours();
    if (ct > 60 * 60 * 24 - 2) {
        ct = 0;
        secs = parseInt(ct);
        hh = secs / 3600;
        hh = parseInt(hh);
        mmt = secs - (hh * 3600);
        mm = mmt / 60;
        mm = parseInt(mm);
        ss = mmt - (mm * 60);
        if (ss < 10) {
            ss = "0" + ss;
        }
        if (mm < 10) {
            mm = "0" + mm;
        }
        if (hh < 10) {
            hh = "0" + hh;
        }
        $('#svtm').html(hours.toString() + ":" + minutes.toString() + ":" + seconds.toString());
        $('#svdt').html($('#svdt').attr('alt'));
        setTimeout('cu(' + ct + ')', 1000);
    }
    else {
        ct = ct + 1;
        secs = parseInt(ct);
        hh = secs / 3600;
        hh = parseInt(hh);
        mmt = secs - (hh * 3600);
        mm = mmt / 60;
        mm = parseInt(mm);
        ss = mmt - (mm * 60);
        if (ss < 10) {
            ss = "0" + ss;
        }
        if (mm < 10) {
            mm = "0" + mm;
        }
        if (hh < 10) {
            hh = "0" + hh;
        }
        $('#svtm').html(hours.toString() + ":" + minutes.toString() + ":" + seconds.toString());
        setTimeout('cu(' + ct + ')', 1000);
    }
}


