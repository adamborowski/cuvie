!function(Date,proto){var maskRe=/("|')((?:\\?.)*?)\1|([YMD])\3\3\3?|([YMDHhmsWS])(\4?)|[uUAZSwo]/g,dateRe=/(\d+)[-.\/](\d+)[-.\/](\d+)/,timeRe=/(\d+):(\d+)(?::(\d+))?(\.\d+)?(?:\s*(?:(a)|(p))\.?m\.?)?(\s*(?:Z|GMT|UTC)?(?:([-+]\d\d):?(\d\d)?)?)?/i,unescapeRe=/\\(.)/g,map={D:"Date",h:"Hours",m:"Minutes",s:"Seconds",S:"Milliseconds"};Date[proto].format=function(mask,_zone){mask=Date.masks[mask]||mask||Date.masks["default"];var undef,zonediff,date=this,origin=+date,get="get"+(mask.slice(0,4)=="UTC:"?(mask=mask.slice(4),"UTC"):""),zone=_zone==undef?date._z:_zone;if(zone!=undef&&get=="get"){get="getUTC";date.setTime(origin+36e5*zone);zonediff=60*zone}mask=mask.replace(maskRe,function(match,quote,text,MD,single,pad){text=MD=="Y"?date[get+"FullYear"]():MD?Date.names[date[get+(MD=="M"?"Month":"Day")]()+(match=="DDD"?24:MD=="D"?31:match=="MMM"?0:12)]:single=="Y"?date[get+"FullYear"]()%100:single=="W"?(quote=new Date(origin+(4-(date[get+"Day"]()||7))*864e5),Math.ceil(((quote.getTime()-quote["s"+get.slice(1)+"Month"](0,1))/864e5+1)/7)):single=="M"?date[get+"Month"]()+1:single=="H"?date[get+"Hours"]()%12||12:single?date[get+map[single]]():match=="u"?date/1e3>>>0:match=="U"?origin:match=="A"?Date[date[get+"Hours"]()>11?"pm":"am"]:match=="Z"?(quote=zonediff||get=="get"&&-date.getTimezoneOffset()||0,quote?(quote<0?(quote=-quote,"-"):"+")+(quote>599?"":"0")+(0|quote/60)+((quote%=60)?":"+(0|quote):""):"Z"):match=="w"?date[get+"Day"]()||7:match=="o"?new Date(origin+(4-(date[get+"Day"]()||7))*864e5)[get+"FullYear"]():quote?text.replace(unescapeRe,"$1"):match;if(match=="SS"&&text<100)text="0"+text;return!pad||text>9?text:"0"+text});if(zonediff!=undef)date.setTime(origin);return mask};Date.am="AM";Date.pm="PM";Date.masks={"default":"DDD MMM DD YYYY hh:mm:ss",iso:"UTC:YYYY-MM-DD'T'hh:mm:ss'Z'"};Date.names="JanFebMarAprMayJunJulAugSepOctNovDecJanuaryFebruaryMarchAprilMayJuneJulyAugustSeptemberOctoberNovemberDecemberSunMonTueWedThuFriSatSundayMondayTuesdayWednesdayThursdayFridaySaturday".match(/.[a-z]+/g);String[proto].date=Number[proto].date=function(format,zoneOut,zoneIn){var undef,m,year,month,d=new Date,n=+this||""+this;if(isNaN(n)){if(m=n.match(dateRe)){year=m[1]>99?1:3;month=Date.middleEndian?4-year:2;d.setFullYear(m[year],m[month]-1,m[6-month-year])}m=n.match(timeRe)||[0,0,0];d.setHours(m[6]&&m[1]<12?+m[1]+12:m[5]&&m[1]==12?0:m[1],m[2],m[3]|0,1e3*m[4]|0);if(m[7]){zoneIn=(m[8]|0)+(m[9]|0)/(m[8]<0?-60:60)}}else d.setTime(n<4294967296?n*1e3:n);if(zoneIn!=undef)d.setTime(d-(60*zoneIn+d.getTimezoneOffset())*6e4);return format?d.format(format,zoneOut):d}}(Date,"prototype");