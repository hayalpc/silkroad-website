$('div#EventCalenderContent ul li:not(:first-child)').each(function(){var This,This2,ThisParent,getDate,unixTime,totalSecsLeft,Now,Json,Codename,setPost,Offset,Format,sName,Desc,Duration,Offset2,DurationTime,DurationTimeLeft,Name;ThisParent=$(this);This=ThisParent.children('span:nth-child(2)');This2=ThisParent.children('span:nth-child(1)');sName=This2.attr('data-sname');Name=This2.attr('data-name');Desc=This2.attr('data-description');Duration=This.attr('data-duration');Codename=This2.attr('data-codename');setInterval(function(){getDate=This.attr('data-countdown');unixTime=Math.ceil(new Date(getDate)/1000);
DurationTime=parseInt(unixTime)+ parseInt(Duration)+ parseInt(5);Now=Math.ceil(new Date()/1000);
totalSecsLeft=unixTime- Now;totalSecsLeft=totalSecsLeft<0?0:totalSecsLeft;DurationTimeLeft=DurationTime- Now;Offset=Times(totalSecsLeft);if(Offset.days>0)
Format=Offset.days+'gün '+ Offset.hours+'sa '+ Offset.minutes+'dk '+ Offset.seconds+'sn';else if(Offset.days<1&&Offset.hours>0)
Format=Offset.hours+'sa '+ Offset.minutes+'dk '+ Offset.seconds+'sn';else if(Offset.hours<1&&Offset.minutes>0)
Format=Offset.minutes+'dk '+ Offset.seconds+'sn';else if(Offset.minutes<1&&Offset.seconds>0)
Format='<em class="Red">'+ Offset.seconds+'sn</em>';else
{Offset2=Times(DurationTimeLeft);This2.html(sName+' <em class="Red">('+ Desc+')</em>');if(Offset2.days>0)
Format=Offset2.days+'gün '+ Offset2.hours+'sa '+ Offset2.minutes+'dk '+ Offset2.seconds+'sn';else if(Offset2.days<1&&Offset2.hours>0)
Format=Offset2.hours+'sa '+ Offset2.minutes+'dk '+ Offset2.seconds+'sn';else if(Offset2.hours<1&&Offset2.minutes>0)
Format=Offset2.minutes+'dk '+ Offset2.seconds+'sn';else if(Offset2.minutes<1&&Offset2.seconds==3)
{$.post('Ajax/GetNextTimeCalender.ajax',{Which:Codename},function(data){Json=jQuery.parseJSON(data);This.attr('data-countdown',Json.Date);This2.attr('data-unixtime',Json.UnixTime).html(Name);RefreshList();});Format='<em class="Red">'+ Offset2.seconds+'sn</em>';}
else if(Offset2.minutes<1&&Offset2.seconds>0)
Format='<em class="Red">'+ Offset2.seconds+'sn</em>';else
{This2.html(Name);}}
This.html(Format);},1000);});function RefreshList()
{var items=$('div#EventCalenderContent ul li:not(:first-child)').get();items.sort(function(a,b){var keyA=$(a).children('span:nth-child(1)').attr('data-unixtime');var keyB=$(b).children('span:nth-child(1)').attr('data-unixtime');return keyB-keyA;});var ul=$('div#EventCalenderContent ul li:first-child');$.each(items,function(i,li){ul.after(li);});}