var _alertColor="#FF3300"; var _noAlertColor=""; function trim(data){ return data.replace(/^\s*/, "").replace(/\s*$/, "");}
function isBlank(mid){ var data=$(mid).val().toString(); if (data=='') return true; return false;}
function isNotBlank(mid,msg){ var data=$(mid).val().toString(); if (trim(data)==''){ alert(msg); $(mid).trigger('focus'); return false;}
return true;}
function limitLength(mid,minlength,maxlength,msg){ var txt=$(mid).val().toString(); if (!(txt.length>minlength && txt.length<maxlength)){ alert(msg); $(mid).trigger('focus'); return false;}
return true;}
function rangeValidate(mid,lower,higher,msg){ if (!($(mid).val()>lower && $(mid).val()<higher)){ alert(msg); $(mid).trigger('focus'); return false;}
return true;}
function isVisible(obj){ var bool=true; var ob='#'+($(obj).attr('id').toString()); $(ob).parents().each(function() { var visible=trim($(this).css('display')).toUpperCase(); if (visible=='NONE') bool= false;}); return bool;}
function process_mandatoryonvalue(row,val,msg){ var myArr=row.split(':'); var fieldsArr=myArr[0].split('#'); var vval=myArr[1]; val=trim(val); for(var i=0;i<fieldsArr.length;i++){ fieldsArr[i]=trim(fieldsArr[i]); if (fieldsArr[i]!=''){ var fieldid='#'+fieldsArr[i]; var fieldVal=$(fieldid).val(); if( isVisible($(fieldid))!=false &&( fieldVal==vval || (fieldVal=='' && vval=='_BLANK') || (fieldVal!='' && vval=='_NOTBLANK')
) ){ if(val==''){ alert(msg); return false;}
}
}
}
return true;}
function checkAllMandatoryFields(){ var bool=true; $('*[mandatory]').each(function() { var val=trim($(this).val()); if (val=='' && isVisible(this)!=false){ var str=$(this).attr('mandatory'); alert(str+ " is mandatory."); $(this).trigger('focus'); bool=false; return bool;}
}); if(bool==false) return bool; $(':checkbox[mandatory]').each(function() { var val=$(this).attr('checked'); if (val==false && isVisible(this)!=false){ var str=$(this).attr('mandatory'); alert(str+ " is mandatory."); $(this).trigger('focus'); bool=false; return bool;}
}); if(bool==false) return bool; $('*[mandatoryon]').each(function() { var val=trim($(this).val()); var masterfield=$(this).attr('mandatoryon').toString(); var master=trim($(masterfield).val().toString()); if(isVisible(this)==true){ if (master!='' && val==''){ var str=$(this).attr('mandatoryonmsg'); alert(str+ " "); $(this).trigger('focus'); bool=false; return bool;}
else{ if(master=='' && val!=''){ $(this).val('');}
}
}
}); if(bool==false) return bool; $('*[mandatoryonvalue]').each(function() { var val=trim($(this).val().toString()); var mandatoryString=trim($(this).attr('mandatoryonvalue').toString()); var msg=trim($(this).attr('mandatoryonvaluemsg').toString()); var mandatoryArray=mandatoryString.split(','); msg+=" is mandatory."; for(var i=0;i<mandatoryArray.length;i++){ if (process_mandatoryonvalue(trim(mandatoryArray[i]),val,msg)==false){ if(isVisible(this)==true)
$(this).trigger('focus'); bool=false; return bool;}
}
}); if(bool==false) return bool; $('*[onlyRegular]').each(function() { var val=trim($(this).val()).toUpperCase(); var re=trim($(this).attr('onlyRegular').toString()).toUpperCase(); if(isVisible(this)==true){ if (val.search(re)==-1 && val!=''){ alert("Not a Valid Input!!"); $(this).trigger('focus'); bool=false; return bool;}
}
}); if(bool==false) return bool; $('*[iscopyof]').each(function() { var verify=$(this).val().toString(); var masterfield=$(this).attr('iscopyof').toString(); var master=$(masterfield).val().toString(); if(isVisible(this)==true){ if (master!=verify){ var str=$(this).attr('iscopyofmsg'); alert(str+ " "); $(this).trigger('focus'); bool=false; return bool;}
}
}); return bool;}
function clearAndHide(mid){ var midArr=mid.split('#'); for(var i=0;i<midArr.length;i++){ if ((midArr[i])){ if (trim(midArr[i])!=''){ mid='#'+trim(midArr[i]); $(mid).find('input').each(function() { $(this).val(''); $(this).trigger('change');}); $(mid).find('textarea').each(function() { $(this).val(''); $(this).trigger('change');}); $(mid).find('select').each(function() { $(this).val(''); $(this).trigger('change');}); $(mid).hide();}
}
}
}
$(document).ready(function(){ $(':checkbox[showhide]').click(function(){ $(this).trigger('change');}); $(':checkbox[showhide]').change(function(){ if (!($(this).attr('showhide'))) return true; var val=$(this).attr('checked'); var tmp=$(this).attr('showhide').toString(); var inputArr=tmp.split(','); var matched=0; var defaultEntry=-1; for(var tx=0;tx<inputArr.length;tx++){ var inputRow=inputArr[tx]; var ret=shoHideEntryCheckBox(val,inputRow); if (ret==1) matched+=1; if (ret==-1) defaultEntry=tx;}
if (matched==0 && defaultEntry>-1){ var inputRow=inputArr[defaultEntry]; var ret=shoHideEntryCheckBox('_DEFAULT',inputRow);}
return true;}).trigger('change'); function shoHideEntryCheckBox(val,inputRow){ var matched=0; var dataArr=inputRow.split(':'); if(dataArr.length==3) { var dataVal=trim(dataArr[0]); var data; var sho_hide=trim(dataArr[1]).toUpperCase(); var mid=trim(dataArr[2]); if(dataVal=="_CHECKED") data=true; if(dataVal=="_UNCHECKED") data=false; if(val==data ){ matched++; if(sho_hide=='HIDE'){ clearAndHide(mid);}
else{ if(sho_hide=='SHOW'){ mid=mid.substring(1); var mymidArr=mid.split('#'); var str='#'+mymidArr.join(',#'); $(str).show();}
}
}
else{ if(data=='_DEFAULT') return -1;}
}
return matched;}
$('select[showhide]').change(function(){ if (!($(this).attr('showhide'))) return true; var val=trim($(this).val().toString()); var tmp=$(this).attr('showhide').toString(); var inputArr=tmp.split(','); var matched=0; var defaultEntry=-1; for(var tx=0;tx<inputArr.length;tx++){ var inputRow=inputArr[tx]; var ret=shoHideEntry(val,inputRow); if (ret==1) matched+=1; if (ret==-1) defaultEntry=tx;}
if (matched==0 && defaultEntry>-1){ var inputRow=inputArr[defaultEntry]; var ret=shoHideEntry('_DEFAULT',inputRow);}
return true;}).trigger('change'); function shoHideEntry(val,inputRow){ var matched=0; var dataArr=inputRow.split(':'); if(dataArr.length==3) { var data=trim(dataArr[0]); var sho_hide=trim(dataArr[1]).toUpperCase(); var mid=trim(dataArr[2]); if(val==data || ( data=='_BLANK' && val=='')){ matched++; if(sho_hide=='HIDE'){ clearAndHide(mid);}
else{ if(sho_hide=='SHOW'){ mid=mid.substring(1); var mymidArr=mid.split('#'); var str='#'+mymidArr.join(',#'); $(str).show();}
}
}
else{ if(data=='_DEFAULT') return -1;}
}
return matched;}
$('textarea[maxlength]').keyup(function(){ var max = parseInt($(this).attr('maxlength')); var msgID=''; if (max=='') return true; if($(this).val().length > max){ $(this).val($(this).val().substr(0, $(this).attr('maxlength')));}
if ($(this).attr('msgID'))
msgID=$(this).attr('msgID').toString(); if (msgID!=''){ msgID='#'+msgID; $(msgID).html('(No more than <b>' + max + '</b> characters - <b>'+ (max - $(this).val().length) +'</b> left )'); $(msgID).css('color',_alertColor);}
}); $('input[onlyNumeric]').keyup(function(){ $(this).css('background',_noAlertColor); var decimal=$(this).attr('onlyNumeric'); var msg="Only Integer Values allowed (decimal point or any other characters not allowed)."; var val=$(this).val(); var old_val=val; val=val.replace(/[0-9]*/g, ""); if (decimal=='d')
{val=val.replace(/\./, ""); msg="Only Numeric Values allowed.";}
if (val!=''){ old_val=old_val.replace(/([^0-9].*)/g, "")
$(this).val(old_val); alert(msg);}
}); $('input[onlyNumeric]').change(function(){ var tval=trim($(this).val()); if (tval=='') return true; reg=/^0*/; tval=tval.replace(reg,'')
if (tval!='')
val=parseInt(tval); else
val=0; var min=parseInt($(this).attr('min')); var max=parseInt($(this).attr('max')); var msg=""; if(min!='' && max !=''){ msg='Input value should be in range of '+min + ' to ' + max + '.' ;}
else{ if(min!=''){msg='Input value should be greter than or equal to'+min +'.';}
else{ if(max!=''){msg='Input value should be less than or equal to '+ max +'.';}
}
}
if(min!=''){ if (min>val) { alert(msg); $(this).val(''); $(this).css('background',_alertColor);}
}
if (max!=''){ if (val>max) { alert(msg); $(this).val(''); $(this).css('background',_alertColor);}
}
}); $('input[onlyEmail]').keyup(function(){ $(this).css('background',_noAlertColor);}); $('input[onlyEmail]').change(function(){ str=($(this).val()); var err=false; if (trim(str)=='') return true; var filter=/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i; if ( filter.test(str) ) { err=false;}
else { err=true;}
if(err){ alert(str + ' is not a valid email address.'); $(this).val(''); $(this).css('background',_alertColor);}
});}); 