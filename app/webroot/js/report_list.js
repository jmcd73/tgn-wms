/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function(){
        $('.accordion').accordion({
             heightStyle: "content",
         });
        $('.tabs').tabs();
         
         $( "a.report_list" )
            .button()
            .click(function( event ) {
               // event.preventDefault();
            });
         $( "a.add-icon" ).button({
            icons: {
                primary:  'ui-icon-circle-plus'
            },
            text: false
        }).css({'height': '32px', 'width' : '50px'});
       
  
});
