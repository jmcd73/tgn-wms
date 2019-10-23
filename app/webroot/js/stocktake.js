/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//var sscc = document.getElementById('sscc_barcode');
//
//sscc.value('please scan');
//
$(function(){
    // onload focus on barcode field
    $('#sscc_barcode').focus();
    $('#pallets').data('pl_count', 0);
    $('#clear_form').click(function(){
         var sscc_input = $('#sscc_barcode');
         var st  = $('#stocktake').data('stocktake', []);
         sscc_input.val("");
         sscc_input.focus();
         $('#location').html('');
         $('#pallets').html('');
    });
    
    $('#stocktake').data('stocktake', [{'location': '', 'sscc': '', 'item': ''}]);
    
    $('form').submit(function(event){
        var st  = $('#stocktake').data('stocktake');
        var sscc_input = $('#sscc_barcode');
        var barcode_val = sscc_input.val();
        var ret = input_type(barcode_val);
        // do ajax when location changes
        if (doAjax(ret, st)){
            // ajax
            window.console && console.log('doAjax');
            
            //window.console && console.log(st);
            post_url = $('#StockTakeUrl').val();
            $.ajax({
                type:"POST",
                data: {'data': st }, 
                url: post_url,
                success : function(data) {
                    //alert(data);// will alert "ok"
                    // delete what was in stocktake
                       $('#stocktake').data('stocktake', [{'location': ret['value'], 'sscc': '', 'item': ''}]);
                       st  = $('#stocktake').data('stocktake');
                        $('#location').html(ret['value']);
                        $('#pallets').html('');
                       window.console && console.log(st);
                },
                error : function() {
                    alert("false");
                }
            });

            
            // empty st
        } else {
        
        // st[location], st[sscc], st[item] = ret['value']
        
        // grab st again just incase ajax is done
        st  = $('#stocktake').data('stocktake');
        
        st = newRecord(st, ret);
        window.console && console.log('anewrecored');
        window.console && console.log(st);
        ubound = st.length - 1 ;
        
        window.console && console.log('ubound: ' + ubound);
        
        st[ubound][ret['type']] = ret['value'];
        
        if(ret['type'] == 'location') {
            $('#location').html(ret['value']);
        } else {
            
            $('#pallets').append( ret['type'] + ': ' + ret['value'] + '<br>');
        }
        
        
        
        window.console && console.log(st);
        
        }
        
            // clear field wait for next bc
         sscc_input.val("");
         sscc_input.focus();
        
        event.preventDefault();
        
    });
});

// var pallets = { 'location': MCA0101, pallets: [{sscc: , item:   }, {sscc: , item: }]


function newRecord(stocktake, ret_val){
    var ubound = stocktake.length - 1 ;
    
    var locationEmpty = false;
    var ssccEmpty = false;
    
    if ( ! stocktake[ubound]['location'] ) {
        locationEmpty = true;
    } 
    
    if ( ! stocktake[ubound]['sscc'] ) {
        
        ssccEmpty = true;
        
    }
    
    if ( locationEmpty || ssccEmpty ){
        return stocktake;
    }
    
    // new location
    if ( ret_val['type'] == 'location'){
        if ( stocktake[ubound]['location'] != ret_val['value'] ){
            len = stocktake.push({'location': ret_val['value'], 'sscc' : '', 'item': ''})
            return stocktake;
        }
    }
    
    //it's an sscc
    if ( ret_val['type'] == 'sscc' ){
        
        // it's the same value as already there
        if ( stocktake[ubound]['sscc'] == ret_val['value'] ){
            // sscc the same don't create new record
            return stocktake;
            
        } else {
            // sscc is different create new record
            // push new object into array
            // [ {loc: x, sscc: y, item: z}, {loc: x, sscc: y, item: z} ]???
            len = stocktake.push({'location': stocktake[ubound]['location'], 'sscc' : '', 'item': ''})
            return stocktake;
        }
        
        
    } else {
        return stocktake;
    }
    
}

function doAjax (ret_val, stocktake){
    
    ubound = stocktake.length - 1;
    
    if (! stocktake[ubound] ) {
        return false;
    }
    
    
    if ( ret_val['type'] == 'location' ){
        
        
        if ( ret_val['value'] ) {
            if ( stocktake[ubound]['sscc']){
                return ret_val['value'].toLowerCase() != stocktake[ubound]['location'].toLowerCase() ? true  : false;
            } else {
                return false;
            }
        
        }
   
    }
    
    return false;
    
}
function input_type(barcode_val){
     
    
            switch (true) {
             
                // sscc
                 case /^00\d{18}$/.test(barcode_val):
                     pl_num = barcode_val.substring(10,19);
                     return { 'type': 'sscc', 'value': barcode_val, 'pl_num' : pl_num };
                     break;
                 //item
                 case /^02\d{14}15\d+$/.test(barcode_val):
                     return  {'type': 'item', 'value': barcode_val };
                     break;
                    // count
                case /^\d+$/.test(barcode_val):
                    return { 'type': 'count', 'value': barcode_val };
                    break;
                case /^[a-zA-Z+$]\d*/.test(barcode_val):
                    return { 'type': 'location', 'value': barcode_val };    
                    break;
                 default:
                     return {'type': 'invalid', 'value' : barcode_val};
                     break;
             }
    
    
        
        
            
    
    
}