(function($){"use strict";$(function(){var ClickNumber,timer,PageList,RankSliderDefaultPx,AjaxRequestCount,AjaxRequest,RankSlider,LinkID,Index,GoPos,PageName,PageNameTitle,PageNameTitle2,WhichPage,PgNum,EmptyBasket,BasketData,SafeCharData,Action,PopupJsonData;ClickNumber=0;AjaxRequestCount=0;timer=setInterval(SliderTimer,3000);RankSliderDefaultPx=924;PgNum=1;EmptyBasket=0;WhichPage=null;PageList=['Unique Rank','Guild Rank','Player Rank','Honor Rank','Pvp Rank','Thief Rank','Trader Rank','Hunter Rank','Son Olaylar'];$('div#GalleryPage > ul, ul#WhoIsOnlineList, ul#MarketItems').perfectScrollbar({wheelSpeed:10});$('.Tooltip').tooltipster({theme:'tooltipster-hitsro',contentAsHTML:true});$('.PurchasedItemList').tooltipster({theme:'tooltipster-hitsro',contentAsHTML:true,content:'Yükleniyor...',functionBefore:function(origin,continueTooltip){continueTooltip();if(origin.data('ajax')!=='cached'){$.ajax({type:'POST',url:'Profile/Ajax/PurchasedItemList.ajax',data:{PurchasedID:$(this).attr('id')},success:function(data){origin.tooltipster('content',data).data('ajax','cached');}});}}});$('.Corner').corner('5px');$('.CornerLeft').corner('5px left');$('.CornerRight').corner('5px right');$('ul#News > li > img').corner();$('div#Banners div#BannerList a').each(function(index){$('html body div.ContentWrapper div.ContentLeft div#Slider ul#SliderPaging').append('<li><a href="'+ index+'">'+ index+'<\/a><\/li>');});$('ul#SliderPaging li:first').addClass('active');$(document).on('click','ul#SliderPaging li a',function(){var SliderMarginPos=parseInt($(this).attr('href'),10)*229;$('html body div.ContentWrapper div.ContentLeft div#Slider div#Banners div#BannerList').animate({'margin-top':'-'+ SliderMarginPos});$('html body div.ContentWrapper div.ContentLeft div#Slider ul#SliderPaging li').removeClass('active');$(this).parent().addClass('active');return false;});$(document).on('hover','#Slider',function(){timer=setInterval(SliderTimer,3000);});$(document).on('click','div#LoginButton',function(){$('html body').prepend('<div id="Depressing"><div id="DepressingLoading"><img src="Media/Images/registerloader.gif"></div></div>');$.ajax({url:"Window/Login.window",dataType:"html",beforeSend:function(){$('html body div#Depressing div#DepressingLoading').center().corner();},success:function(data){$('html body div#Depressing').html(data);$('html body div#Depressing div#LoginPanel').center();},error:function(){alert('Bir sorun oluştu. Lütfen sayfayı yenileyip tekrar deneyin!');$('html body div#Depressing').remove();}});return false;});$(document).on('click','div#AllRanksButton a',function(e){e.preventDefault();if($(this).hasClass("isDown")){$("html body div#RankPage.ContentWrapper div.ContentLeftNoRight div#RankMenu").animate({marginTop:"-58px"},300);$(this).removeClass("isDown");}else{$("html body div#RankPage.ContentWrapper div.ContentLeftNoRight div#RankMenu").animate({marginTop:"0px"},500);$(this).addClass("isDown");}
return false;});$(document).on('click','div#UpPageRank a',function(){$('html, body').animate({scrollTop:400},500);return false;});$(document).on('click','div#RankMenu ul li a',function(){ClickNumber=ClickNumber+ 1;if(ClickNumber<2){RankSlider=$('div#RankSlider');LinkID=$(this).parent();Index=$('div#RankMenu ul li').index(LinkID);GoPos=(Index*RankSliderDefaultPx)*-1;PageName=PageList[Index];PageNameTitle=PageList[Index].replace(' ','')+'Title';PageNameTitle2=PageList[Index].replace(' ','')+'_Title';$('div#RankMenu ul li a').removeClass('ActiveRank');LinkID.find('a').addClass('ActiveRank');$('div.ContentLeftNoRight > h1').attr('id',PageNameTitle).html(PageName);$('div#FirstRankList > h1').attr('id',PageNameTitle2).find('span').html(PageName);if(Index===8){$('div#FirstRankList').hide();}else{$('div#FirstRankList').show();}
if(WhichPage===null){$('table.RankList tbody').html('<tr><td></td></tr><tr><td id="WaitToLoadRank"><img src="Media/Images/rankloader.gif" /><br />Yükleniyor, Lütfen bekleyin...</td></tr>');}else{WhichPage=null;}
RankSlider.animate({backgroundPositionX:GoPos+'px'},{step:function(now,fx){RankSlider.css("background-position",now+"px 0");},duration:300,complete:function(){window.location.hash=PageName.replace(' ','');ClickNumber=0;AjaxRequest=$.ajax({type:"POST",url:'Ajax/Ranks.ajax',data:{Page:PageName.replace(' ','')},beforeSend:function(){if(AjaxRequestCount>0){AjaxRequest.abort();}
AjaxRequestCount=AjaxRequestCount+ 1;},success:function(data){AjaxRequestCount=AjaxRequestCount- 1;$('table.RankList tbody').html(data);}});}});}
return false;});$(document).on('click','div#PrevPageRank a, div#NextPageRank a',function(){if($(this).parent().attr('id')==='PrevPageRank'){PgNum=PgNum- 1;if(PgNum<1){PgNum=1;}}else if($(this).parent().attr('id')==='NextPageRank'){if($(this).parent().attr('class')!=='RevivePage'){PgNum=PgNum+ 1;}}
AjaxRequest=$.ajax({type:"POST",url:'Ajax/Ranks.ajax',data:{Page:PageName.replace(' ',''),PgNum:PgNum},beforeSend:function(){if(AjaxRequestCount>0){AjaxRequest.abort();}
AjaxRequestCount=AjaxRequestCount+ 1;},success:function(data){AjaxRequestCount=AjaxRequestCount- 1;$('table.RankList tbody').html(data);}});$('div#UpPageRank a').trigger('click');return false;});$(document).on('click','#GoLeft a, #GoRight a',function(){var FindLiID,GoLinkID,PrevLinkID,NextLinkID;FindLiID=$(this).parent().attr('id');GoLinkID=$('div#RankMenu ul li a.ActiveRank').parent().attr('id');if(FindLiID==='GoLeft'){PrevLinkID=$('#'+ GoLinkID).prev().attr('id');$('#'+ PrevLinkID).find('a').trigger('click');}else if(FindLiID==='GoRight'){NextLinkID=$('#'+ GoLinkID).next().attr('id');$('#'+ NextLinkID).find('a').trigger('click');}});$(document).on('click','a#LoginButtonLink',function(){$('form#LoginPanelForm').trigger('submit');return false;});$(document).on('click','a#SendEmailForgotPasswordPanel',function(){$('form#ForgotPasswordForm').trigger('submit');return false;});$(document).on('click','div#CloseLoginPanel a',function(){$('div#Depressing').remove();});$(document).on('click','a#RecoverPasswordLink',function(){$('div#CloseLoginPanel a').trigger('click');$('body').prepend('<div id="Depressing"><div id="DepressingLoading"><img src="Media/Images/registerloader.gif"></div></div>');$.ajax({url:"Window/ForgotPassword.window",dataType:"html",beforeSend:function(){$('div#Depressing div#DepressingLoading').center().corner();},success:function(data){$('div#Depressing').html(data);$('div#Depressing div#ForgotPasswordPanel').center();},error:function(){alert('Bir sorun oluştu. Lütfen sayfayı yenileyip tekrar deneyin!');$('div#Depressing').remove();}});return false;});$(document).on('click','div#CloseForgotPasswordPanel a',function(){$('div#Depressing').remove();});$(document).on('click','a#GoLoginPanelLink',function(){$('div#CloseForgotPasswordPanel a').trigger('click');$('div#LoginButton a').trigger('click');return false;});$(document).on('click','div#LogoutButton a',function(){return(confirm('Sistemden çıkış yapmak istediğinize emin misiniz?'))?true:false;});$(document).on('click','div#RefreshIcon a',function(){WhichPage=$('div#RankMenu ul li a.ActiveRank').parent().attr('id');$('#'+ WhichPage+' a').trigger('click');PgNum=1;return false;});$(document).on('submit','form#LoginPanelForm',function(){var Serialize=$(this).serialize();$.ajax({url:"Ajax/Login.ajax",type:"POST",data:Serialize,dataType:"html",beforeSend:function(){$('div#LoginPanelAlertWindow').remove();$('div#LoginPanelWrapper img, a#LoginButtonLink').toggle();},success:function(data){var ReturnJsonData=jQuery.parseJSON(data);if(ReturnJsonData.LoginText==='OK'){location.reload();}else{$('div#LoginPanelWrapper').after('<div id="LoginPanelAlertWindow">'+ ReturnJsonData.LoginText+'</div>');$('div#LoginPanelWrapper img, a#LoginButtonLink').toggle();}},error:function(){alert('Bir sorun oluştu. Lütfen sayfayı yenileyip tekrar deneyin!');$('div#Depressing').remove();}});return false;});$(document).on('submit','form#ForgotPasswordForm',function(){var Serialize=$(this).serialize();$.ajax({url:"Ajax/ForgotPassword.ajax",type:"POST",data:Serialize,dataType:"html",beforeSend:function(){$('div#ForgotPasswordPanelAlertWindow').remove();$('div#ForgotPasswordPanelWrapper img, a#SendEmailForgotPasswordPanel').toggle();},success:function(data){var ReturnJsonData=jQuery.parseJSON(data);if(ReturnJsonData.Text==='OK')
{alert('Şifrenizi almak için gerekli talimatlar email adresinize gönderilmiştir. Lütfen email adresinizi kontrol ediniz!');ClosePopupWindow();}
else{$('div#ForgotPasswordPanelWrapper').after('<div id="ForgotPasswordPanelAlertWindow">'+ ReturnJsonData.Text+'</div>');$('div#ForgotPasswordPanelWrapper img, a#SendEmailForgotPasswordPanel').toggle();}},error:function(){alert('Bir sorun oluştu. Lütfen sayfayı yenileyip tekrar deneyin!');$('div#Depressing').remove();}});return false;});$(document).on('click','ul#MarketCategories li a,ul#MarketSubCategories li a',function(){var Filter=$(this).attr('id');$(this).toggleClass('MarketActive');$('ul#MarketItems').html('<li id="MarketLoader"><img src="Media/Images/marketloader.gif" /></li>');$.post('Market/Ajax/MarketFilter.ajax',{q:Filter},function(Data){$('ul#MarketItems').html(Data);});return false;});$(document).on('click','div#MarketPage.ContentLeft ul#MarketItems li a.AddBasket',function(){var ItemID=$(this).parents('li').attr('class');ItemID=ItemID.replace('Item_','');$(this).remove();if($('div#Basket ul#BasketItems li').hasClass('NoItem')===true)
{$('div#Basket ul#BasketItems li.NoItem').remove();$(BasketItems).after('<div class="SeperatorR UpBasketButton"></div>'+'<div id="BasketButtons">'+'<span><a href="" id="EmptyBasket">Sepeti Boşalt</a></span>'+'<span><a href="Market/Basket.html">Alışverişi tamamla</a></span>'+'</div>');}
$('ul#BasketItems').append('<li class="Item_'+ ItemID+'">Yuklenıyor...</li>');$.post('Market/Ajax/RightBasket.ajax',{ItemID:ItemID},function(data){$('ul#BasketItems li.Item_'+ ItemID).html(data);});return false;});$(document).on('click','ul#BasketItems li div.ItemRemove a',function(){var ItemID=$(this).parents('li').attr('class');ItemID=ItemID.replace('Item_','');if(EmptyBasket<1)Basket('DelItem',ItemID,0);$('ul#BasketItems li.Item_'+ ItemID).remove();$('ul#MarketItems li.Item_'+ ItemID+' span.IconList').after('<a class="AddBasket" href="" id="'+ ItemID+'">Sepete Ekle</a>');if($('ul#BasketItems li').length<1){$('ul#BasketItems').html('<li class="NoItem">Sepetinizde ürün bulunmuyor!</li>');$('.UpBasketButton, div#BasketButtons').remove();}
return false;});$(document).on('click','a#EmptyBasket',function(){$('ul#BasketItems li div.ItemRemove a').each(function(){EmptyBasket=1;$(this).trigger('click');});Basket('EmptyBasket',0,0);EmptyBasket=0;return false;});$(document).on('click','a#EmptyBasketForStepTwo',function(){Basket('EmptyBasket',0,0);location.href='Market';return false;});$(document).on('click','a#DeleteBasketItem',function(){var ItemID=$(this).parents('li').attr('class');ItemID=ItemID.replace('Item_','');Basket('DeleteItemaAndReCalculate',ItemID,0).success(function(data){BasketData=jQuery.parseJSON(data);$('b#TotalSlot').html(BasketData.Slot);$('b#TotalHitCash').html(BasketData.HitCash);});if($('div#MyBasket ul li').length<4)
{location.href='Market';}
else
{$(this).parents('li').remove();}
return false;});$(document).on('change','div#MyBasket.ContentLeft ul li span input',function(){var ItemID=$(this).parents('li').attr('class');ItemID=ItemID.replace('Item_','');if($(this).val()<1)
{$('div#MyBasket.ContentLeft ul li.Item_'+ ItemID+' span a#DeleteBasketItem').trigger('click');}
else
{Basket('UpdateItem',ItemID,$(this).val()).success(function(data){BasketData=jQuery.parseJSON(data);if(BasketData.DeleteItem==='Yes')
{$('div#MyBasket.ContentLeft ul li.Item_'+ ItemID+' span a#DeleteBasketItem').trigger('click');}
else
{$('div#MyBasket.ContentLeft ul li.Item_'+ ItemID+' > span:nth-child(3)').html(BasketData.ItemPrice+' HC');$('b#TotalSlot').html(BasketData.TotalSlot);$('b#TotalHitCash').html(BasketData.TotalHitCash);}});}});$(document).on('click','div#PurchasePage.ContentLeft ul li:last-child a:not(.Disabled)',function(){var $this,loadSpan,jsonData;$this=$(this);loadSpan=$this.parent().children('span');$this.addClass('Disabled');loadSpan.html('Lütfen bekleyin, Kontroller yapılıyor...');$.post('Market/Ajax/Bought.ajax',{CharID:$('ul li.CharSelection span select').val()},function(data){jsonData=jQuery.parseJSON(data);if(jsonData.Error==='NoError')
{location.href='Market/Purchased.html'}
else
{loadSpan.html(jsonData.Error);}
$this.removeClass('Disabled');});return false;});$(document).on('change','div#Profile span#SafeChar select',function(){var Serialize,$this;Serialize=$(this).serialize();$this=$(this);$('.SafeCharResult').remove();$this.after('<img class="SafeCharLoader" src="Media/Images/safecharloader.gif" alt="" />');$.post('Profile/Ajax/SafeChar.ajax',Serialize,function(data){$('.SafeCharLoader').remove();SafeCharData=jQuery.parseJSON(data);if(SafeCharData.SafeChar==='OK')
{$this.after('<small class="SafeCharResult">Karakteriniz bugdan kurtarıldı</small>');}
else
{$this.after('<small class="SafeCharError SafeCharResult">'+ SafeCharData.SafeChar+'</small>');}});});$(document).on('click','ul#ProfileMenu li:not(.NoWindow) a',function(){var Url=$(this).attr('href');OpenWindow('Profile/Window/'+ Url);return false;});$(document).on('click','.ClosePopupWindow a',ClosePopupWindow);$(document).on('click','a.PopupFormSubmit',function(){$('.PopupForm').trigger('submit');return false;});$(document).on('submit','form.PopupForm',function(){Action=$(this).attr('action');$('.PopupLoaderImage, a.PopupFormSubmit').toggle();$.post(Action,$(this).serialize(),function(data){PopupJsonData=jQuery.parseJSON(data);$('div.PopupAlert').remove();if(PopupJsonData.True==='Yes')
{ClosePopupWindow();alert(PopupJsonData.Message);location.href='index.html';}
else if(PopupJsonData.True==='CloseAndAlertEpin')
{ClosePopupWindow();UpdateHitCash(PopupJsonData.LastHitCash);alert(PopupJsonData.Message);}
else if(PopupJsonData.True==='CloseAndAlertGiftCode')
{ClosePopupWindow();alert(PopupJsonData.Message);}
else if(PopupJsonData.AlertHwan==='Yes')
{alert('Satın alacağınız ünvan şimdiki ünvanınızdan daha yüksek. Eğer satın alırsanız şuanki ünvanınız silinir! Yinede satın almak isterseniz tekrar "Satın Al" butonuna tıklayarak satın alabilirsiniz.');}
else if(PopupJsonData.HwanOK==='Yes')
{ClosePopupWindow();UpdateHitCash(PopupJsonData.LastHitCash);alert('Ünvan başarıyla satın alındı. Oyundaysanız teleport olun yada oyuna giriş yapın.');}
else
{$('div.PopupWindowWrapper').after('<div class="PopupAlert">'+ PopupJsonData.Message+'</div>');}
$('.PopupLoaderImage, a.PopupFormSubmit').toggle();});return false;});$(document).on('keydown','form.PopupForm input',function(e){if(e.which===13)$('a.PopupFormSubmit').trigger('submit');});$(document).on('click','.SpecialSelect',function(){var ID,$$;ID=$(this).attr('id');$$=$('#'+ ID);if($$.hasClass('SpecialSelectOpened'))
$$.removeClass('SpecialSelectOpened');else
$$.addClass('SpecialSelectOpened');});$(document).on('click','.SpecialSelect span:not(:first-child)',function(){var Val,Id,Name;Val=$(this).html();Id=$(this).attr('class').replace('OptID_','');Name=$(this).parents('.SpecialSelect').attr('id');$('select[name=\''+ Name+'\']').val(Id).change();$(this).parent().children('span:first-child').html(Val);});$(document).on('change','select[name="HwanCharID"]',function(){$('select[name="Hwan"]').html('');$('div#Hwan').html('<span>Yükleniyor...</span>');$.post('Profile/Ajax/LoadHwanSelect.ajax',$(this).serialize(),function(data){PopupJsonData=jQuery.parseJSON(data);PopupJsonData.unshift({ID:0,Title:'Lütfen bir ünvan seçin',HitCash:0});$('div#Hwan').html('');$.each(PopupJsonData,function(i,item){if(item.HitCash<1)
$('div#Hwan').append('<span class="OptID_'+ item.ID+'">'+ item.Title+'</span>');else
$('div#Hwan').append('<span class="OptID_'+ item.ID+'">'+ item.Title+' ('+ item.HitCash+' HC)</span>');$('select[name="Hwan"]').append('<option value="'+ item.ID+'">'+ item.Title+'</option>');});$(".SpecialSelect span:last-child").corner("bottom");});});$(document).on('click','li#BuyGold a, div.ProfileContent h1#ProfileContent_BuyGoldTitle span a',function(){$('ul#ProfileMenu, div#ProfileContent_BuyGold').slideToggle();$('ul.ProfileContent_List li span:nth-child(4) a').removeClass('ClickedCheck');$('ul.ProfileContent_List form input').remove();return false;});$(document).on('click','div#ProfileContent_BuyGold ul li span a',function(){var ID,$$;$$=$(this);ID=$$.attr('id').replace('GoldPacketID_','');if($$.hasClass('ClickedCheck')){$$.removeClass('ClickedCheck');$('input#inputGoldPacketID_'+ ID).remove();}else{$$.addClass('ClickedCheck');$('form#BuyGoldParams').append('<input type="checkbox" id="inputGoldPacketID_'+ ID+'" checked=checked name="GoldPacket[]" value="'+ ID+'">');}
return false;});$(document).on('click','div#ProfileContent_BuyGold div.ProfileContent_BuyButton a',function(){$('div.ProfileContent_BuyButton').after('<img src="Media/Images/loader.gif" class="BuyGoldLoader" alt="Yükleniyor..." />').addClass('Hidden');$.post('Profile/Ajax/BuyGold.ajax',$('form#BuyGoldParams').serialize(),function(data){$('.BuyGoldLoader').remove();$('div.ProfileContent_BuyButton').removeClass('Hidden');PopupJsonData=jQuery.parseJSON(data);if(PopupJsonData.Message=='ItsOkay')
{alert('Banka hesabınıza '+ PopupJsonData.TotalHC+'HC karşılığında '+ PopupJsonData.TotalMuchShort+' kadar gold gönderilmiştir.');$('form#BuyGoldParams input').remove();$('div#ProfileContent_BuyGold ul li span a').removeClass('ClickedCheck');UpdateHitCash(PopupJsonData.LastHitCash);}
else
{alert(PopupJsonData.Message);}});return false;});$(document).on('click','li#BuySP a, div.ProfileContent h1#ProfileContent_BuySkillPointTitle span a',function(){$('ul#ProfileMenu, div#ProfileContent_BuySkillPoint').slideToggle();$('ul.ProfileContent_List li span:nth-child(4) a').removeClass('ClickedCheck');$('ul.ProfileContent_List form input').remove();$('div.ProfileContent_CharSelectBox select').val(0);return false;});$(document).on('click','div#ProfileContent_BuySkillPoint ul li span a',function(){var ID,$$;$$=$(this);ID=$$.attr('id').replace('SPPacketID_','');if($$.hasClass('ClickedCheck'))
{$$.removeClass('ClickedCheck');$('input#inputSPPacketID_'+ ID).remove();}
else
{$$.addClass('ClickedCheck');$('form#BuySkillPointParams').append('<input type="checkbox" id="inputSPPacketID_'+ ID+'" checked=checked name="SPPacket[]" value="'+ ID+'">');}
return false;});$(document).on('click','div#ProfileContent_BuySkillPoint div.ProfileContent_BuyButton a',function(){$('div.ProfileContent_BuyButton').after('<img src="Media/Images/loader.gif" class="BuySPLoader" alt="Yükleniyor..." />').addClass('Hidden');$.post('Profile/Ajax/BuySkillPoint.ajax',$('form#BuySkillPointParams').serialize()+'&CharID='+ $('div#ProfileContent_CharSelectBox_BuySPCharID select').val(),function(data){$('.BuySPLoader').remove();$('div.ProfileContent_BuyButton').removeClass('Hidden');PopupJsonData=jQuery.parseJSON(data);if(PopupJsonData.Message==='ItsOkay')
{$('form#BuySkillPointParamsParams input').remove();$('div#ProfileContent_BuySkillPoint ul li span a').removeClass('ClickedCheck');$('div#ProfileContent_CharSelectBox_BuySPCharID select').val(0);alert('Seçtiğiniz karakterinize '+ PopupJsonData.TotalHC+'HC karşılığında '+ PopupJsonData.TotalMuch+' kadar SP gönderilmiştir.');UpdateHitCash(PopupJsonData.LastHitCash);}
else
{alert(PopupJsonData.Message);}});return false;});$(document).on('click','ul.RankContent > li:last-child > span span:nth-child(2) a',function(){$('html, body').animate({scrollTop:0},800);return false;});$(document).on('click','li#AdvRemover a, div.ProfileContent h1#ProfileContent_AdvRemoverTitle span a',function(){$('em#SelectionCharAjaxAlert, ul#AdvRemoverTable, ul#NoItemDataAlert, h1.ProfileContent_Heading1, ul#AdvRemove_Rules').remove();$('ul#ProfileMenu, div#ProfileContent_AdvRemover').slideToggle();return false;});$(document).on('click','li#PaymentNotify a, div.ProfileContent h1#ProfileContent_PaymentNotifyTitle span a',function(){$('ul#ProfileMenu, div#ProfileContent_PaymentNotify').slideToggle();return false;});$(document).on('click','li#ItemLock a, div.ProfileContent h1#ProfileContent_ItemLockTitle span a',function(){$('ul#NoItemDataAlert_ItemLock, ul#ItemLockTable, h1.ProfileContent_Heading1').remove();$('ul#ProfileMenu, div#ProfileContent_ItemLock').slideToggle();return false;});$(document).on('submit','form#ProfileContent_PaymentNotifyForm',function(){var form=$(this);form.children('img').show();$.post('Profile/Ajax/SendPaymentNotify.ajax',form.serialize(),function(data){PopupJsonData=jQuery.parseJSON(data);if(PopupJsonData.Text=='OK')
{$('form#ProfileContent_PaymentNotifyForm ul li input').not('input[name="senddate"]').val('');alert('Ödeme bildiriminiz başarıyla gönderildi.');}
else
{alert(PopupJsonData.Text);}
form.children('img').hide();});return false;});$(document).on('click','a#SendPaymentFormButton',function(){$('form#ProfileContent_PaymentNotifyForm').trigger('submit');return false;});$(document).on('change','select[name="paymenttype"]',function(){$('input[name="paymentnumber"]').parents('li').toggle();});$(document).on('click','a.ProfileContent_RemoverTick',function(){var _this,parentThis;_this=$(this);parentThis=_this.parent();if(confirm('Bu silahda bulunan ADV\'yi silmek istediğinize emin misiniz? Unutmayın bu işlemin geri dönüşü yoktur'))
{var thisid=_this.attr('id');_this.hide();parentThis.append('<img src="Media/Images/loader.gif" />');$.post('Profile/Ajax/RemoveAdv.ajax',{ItemID:thisid},function(data){PopupJsonData=jQuery.parseJSON(data);if(PopupJsonData.Message==='OK')
{UpdateHitCash(PopupJsonData.LastHitCash);alert('Adv silme işleminiz başarıyla yapıldı!');parentThis.parent().remove();}
else
{alert(PopupJsonData.Message);}
parentThis.find('img').remove();_this.show();});}
return false;});$(document).on('click','ul#SelectCharForAdvAlert li a',function(){$('em#SelectionCharAjaxAlert, ul#AdvRemoverTable, ul#NoItemDataAlert, h1.ProfileContent_Heading1, ul#AdvRemove_Rules').remove();$(this).after('<em id="SelectionCharAjaxAlert">&nbsp;&nbsp;&nbsp;<img src="Media/Images/loader.gif" alt="" /></em>');$.post('Profile/Ajax/SelectCharForAdv.ajax',{CharID:$(this).attr('id')},function(data){PopupJsonData=jQuery.parseJSON(data);if(PopupJsonData.Error!=='NoError')
$('em#SelectionCharAjaxAlert').html(PopupJsonData.Error);else
{$('em#SelectionCharAjaxAlert').remove();$('#SelectCharForAdvAlert').after(PopupJsonData.Html);$('ul.ProfileContent_Table').perfectScrollbar();}});return false;});$(document).on('click','ul#SelectCharForItemLock li a',function(){$('em#SelectionCharItemLockAjaxAlert, ul#ItemLockTable, ul#NoItemDataAlert_ItemLock, h1.ProfileContent_Heading1, ul#ItemLock_Rules').remove();$(this).after('<em id="SelectionCharItemLockAjaxAlert">&nbsp;&nbsp;&nbsp;<img src="Media/Images/loader.gif" alt="" /></em>');$.post('Profile/Ajax/SelectCharForItemLock.ajax',{CharID:$(this).attr('id')},function(data){PopupJsonData=jQuery.parseJSON(data);if(PopupJsonData.Error!=='NoError')
$('em#SelectionCharItemLockAjaxAlert').html(PopupJsonData.Error);else
{$('em#SelectionCharItemLockAjaxAlert').remove();$('#SelectCharForItemLock').after(PopupJsonData.Html);$('ul.ProfileContent_Table').perfectScrollbar();}});return false;});$(document).on('click','a[href="LockItem"]',function(){var Confirm,This,Parent,UL,Li,Json;This=$(this);Parent=This.parent();Li=This.parents('li');UL=This.parents('ul');Confirm=confirm("Bu Itemi kilitlemek istediğinize emin misiniz?\n\nUnutmayın! Tekrar kilit açmak için email adresinize gelen onay kodunu girmelisiniz.");if(Confirm)
{Parent.html('<img src="Media/Images/loginandpwrecoverloader.gif" />');$.post('Profile/Ajax/ItemLock.ajax',{Slot:This.attr('data-slot'),CharID:UL.attr('data-charid')},function(data){Json=jQuery.parseJSON(data);if(Json.Text==='OK')
{Li.children('span:first-child').children('img').attr('src','Media/Images/Icons/Items/'+ Json.LockIcon);alert('Item başarıyla kilitlendi!');Parent.html('<a href="UnLockItem" data-slot="'+ Json.Slot+'">Kilit Aç</a>');}
else
{alert(Json.Text);Parent.html('<a href="LockItem" data-slot="'+ Json.Slot+'">Kilitle</a>');}});}
return false;});$(document).on('click','a[href="UnLockItem"]',function(){var Confirm,This,Parent,UL,Li,Json;This=$(this);Parent=This.parent();Li=This.parents('li');UL=This.parents('ul');Confirm=confirm("Bu Itemin kilidini kaldırmak istediğinize emin misiniz?\nItemin kilidini kaldırmak için HitCash ödeceyeceksiniz.");if(Confirm)
{Parent.html('<img src="Media/Images/loginandpwrecoverloader.gif" />');$.post('Profile/Ajax/ItemUnLock.ajax',{Slot:This.attr('data-slot'),CharID:UL.attr('data-charid')},function(data){Json=jQuery.parseJSON(data);if(Json.Confirm!=='Yes')
{if(Json.Text!=='OK')
{alert(Json.Text);Parent.html('<a href="UnLockItem" data-slot="'+ Json.Slot+'">Kilit Aç</a>');}
else
{UpdateHitCash(Json.LastHitCash);Li.children('span:first-child').children('img').attr('src','Media/Images/Icons/Items/'+ Json.LockIcon);alert('Itemin kilidi başarıyla kaldırıldı');Parent.html('<a href="LockItem" data-slot="'+ Json.Slot+'">Kilitle</a>');}}
else
{if(confirm(Json.Text))
{$.post(Json.UnlockLink,function(data){alert(data);Parent.html('<a href="UnLockItem" data-slot="'+ Json.Slot+'">Kilit Aç</a>');});}}});}
return false;});});$('div#TeamSpeakUsersContent div#TsStatus').load('TeamSpeak.php');}(jQuery));function Times(totalSecsLeft){var offset;offset={totalsecs:totalSecsLeft,seconds:totalSecsLeft%60,minutes:Math.floor(totalSecsLeft/60)%60,hours:Math.floor(totalSecsLeft/60/60)%24,days:Math.floor(totalSecsLeft/60/60/24)%7,totalDays:Math.floor(totalSecsLeft/60/60/24),weeks:Math.floor(totalSecsLeft/60/60/24/7),months:Math.floor(totalSecsLeft/60/60/24/30),years:Math.floor(totalSecsLeft/60/60/24/365)};return offset;}
function SliderTimer(){"use strict";var $next=$('ul#SliderPaging li.active a').parent().next().children();if(!$next.length){$next=$('ul#SliderPaging li a').parent().find('a').first();}
$next.trigger('click');}
function Basket(Type,ItemID,Total){return $.post('Market/Ajax/Basket.ajax',{Type:Type,Item:ItemID,Total:Total});}
function OpenWindow(Url){$('html body').prepend('<div id="Depressing"><div id="DepressingLoading"><img src="Media/Images/registerloader.gif"></div></div>');$.ajax({url:Url+'.window',dataType:"html",beforeSend:function(){$('html body div#Depressing div#DepressingLoading').center().corner();},success:function(data){$('html body div#Depressing').html(data);$('html body div#Depressing div.PopupWindow').center();},error:function(){alert('Bir sorun oluştu. Lütfen sayfayı yenileyip tekrar deneyin!');$('html body div#Depressing').remove();}});}
function ClosePopupWindow(){$('div#Depressing').remove();}
function UpdateHitCash(HitCash){$('#HitCash').html('HitCash : '+ HitCash);}
(function($){$.fn.ctrl=function(key,callback){if(!$.isArray(key)){key=[key];}
callback=callback||function(){return false;}
return $(this).keydown(function(e){$.each(key,function(i,k){if(e.keyCode==k.toUpperCase().charCodeAt(0)&&e.ctrlKey){return callback(e);}});return true;});};$.fn.disableSelection=function(){this.ctrl(['a','s','c']);return this.attr('unselectable','on').css({'-moz-user-select':'-moz-none','-moz-user-select':'none','-o-user-select':'none','-khtml-user-select':'none','-webkit-user-select':'none','-ms-user-select':'none','user-select':'none'}).bind('selectstart',function(){return false;});};})(jQuery);