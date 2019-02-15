// Main - Issue Banner
$(function () {
    $("#issue-banner li").eq(0).find("a").addClass("ad-active");
    $("#issue-banner .txt h3").html($("#issue-banner li").eq(0).find("input[name='issue_show_name']").val());
    $("#issue-banner .txt p").html($("#issue-banner li").eq(0).find("input[name='issue_show_txt']").val());
    $("#issue-banner .issue-img a img").attr("src", $("#issue-banner li").eq(0).find("input[name='issue_banner_img']").val());
    $("#BbannerLink").attr("href", $("#issue-banner li").eq(0).find("input[name='issue_show_lnk']").val());
    $("#BbannerLink").attr("target", $("#issue-banner li").eq(0).find("input[name='issue_target']").val());

    $("#issue-banner li:last").addClass("end");
    $("#issue-banner li").eq(4).removeClass("end");
    $("#issue-banner li").eq(4).addClass("noline");

    $("#issue-banner li").mouseover(function () {
        index = $(this).index();
        $("#BbannerLink").attr("href", $("#issue-banner li").eq(index).find("input[name='issue_show_lnk']").val());
        $("#BbannerLink").attr("target", $("#issue-banner li").eq(index).find("input[name='issue_target']").val());

        for (var i = 0; i < $("#issue-banner li").length; i++) {
            $("#issue-banner li").eq(i).find("a").removeClass();
        }
        $(this).find("a").addClass("ad-active");
        $("#issue-banner .issue-img a img").attr("src", $(this).find("input[name='issue_banner_img']").val());
        $("#issue-banner .txt h3").html($(this).find("input[name='issue_show_name']").val());
        $("#issue-banner .txt p").html($(this).find("input[name='issue_show_txt']").val());
        $("#issue-banner .txt a").html($(this).find("input[name='issue_show_lnk']").val());

        if ($("#issue-banner .txt p").text() == "") {
            $("#issue-banner .txt p").css({ display: "none" });
        } else {
            $("#issue-banner .txt p").css({ display: "block" });
        }
        clearInterval(list_interval);

        index = $(this).index() + 1;
        //
    });

    $("#issue-banner li").mouseout(function () {
        clearInterval(list_interval);
        list_interval = setInterval(RollingItemList, 3000);
        //
    });

    $("#BbannerLink").mouseover(function () {
        clearInterval(list_interval);
        //
    });

    $("#BbannerLink").mouseout(function () {
        clearInterval(list_interval);
        list_interval = setInterval(RollingItemList, 3000);
        //
    });

    list_interval = setInterval(RollingItemList, 3000);
});

var index = 0;

function RollingItemList() {
    if ((index + 1) > $("#issue-banner li").length) {
        index = 0;
    }
    $("#BbannerLink").attr("href", $("#issue-banner li").eq(index).find("input[name='issue_show_lnk']").val());
    $("#BbannerLink").attr("target", $("#issue-banner li").eq(index).find("input[name='issue_target']").val());

    for (var i = 0; i < $("#issue-banner li").length; i++) {
        $("#issue-banner li").eq(i).find("a").removeClass();
    }
    $("#issue-banner li").eq(index).find("a").addClass("ad-active");
    $("#issue-banner .issue-img a img").attr("src", $("#issue-banner li").eq(index).find("input[name='issue_banner_img']").val());
    $("#issue-banner .txt h3").html($("#issue-banner li").eq(index).find("input[name='issue_show_name']").val());
    $("#issue-banner .txt p").html($("#issue-banner li").eq(index).find("input[name='issue_show_txt']").val());
    if ($("#issue-banner .txt p").text() == "") {
        $("#issue-banner .txt p").css({ display: "none" });
    } else {
        $("#issue-banner .txt p").css({ display: "block" });
    }
    index = index + 1
}
