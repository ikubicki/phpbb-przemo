
<table border="0" cellpadding="2" cellspacing="1" class="forumline" width="100%"> 
  <tr> 
    <td align="center" colspan="5"> 
   <span class="cattitle">{MODULE_NAME}</span> 
    </td> 
  </tr> 
  <tr>    
    <th colspan="1" align="center"><strong>{L_RANK}</strong></th>    
    <th colspan="1" align="center" width="10%"><strong>{L_USERNAME}</strong></th> 
    <th colspan="1" align="center" width="10%"><strong>{L_POSTS}</strong></th> 
    <th colspan="1" align="center" width="10%"><strong>{L_PERCENTAGE}</strong></th> 
    <th colspan="1" align="center" width="50%"><strong>{L_GRAPH}</strong></th> 
  </tr> 
  <!-- BEGIN users --> 
  <tr> 
    <td class="{users.CLASS}" align="left" width="10%"><span class="gen">{users.RANK}</span></td> 
    <td class="{users.CLASS}" align="left" width="10%"><span class="gen"><a href="{users.URL}">{users.USERNAME}</a></span></td> 
    <td class="{users.CLASS}" align="center" width="10%"><span class="gen">{users.POSTS}</span></td> 
    <td class="{users.CLASS}" align="center" width="10%"><span class="gen">{users.PERCENTAGE}%</span></td>    
    <td class="{users.CLASS}" align="left" width="50%"> 
   <table cellspacing="0" cellpadding="0" border="0" align="left"> 
     <tr> 
       <td align="right"><img src="{LEFT_GRAPH_IMAGE}" alt="" width="4" height="12" /></td> 
     </tr> 
   </table> 
   <table cellspacing="0" cellpadding="0" border="0" align="left" width="{users.BAR}%"> 
     <tr> 
       <td><img src="{GRAPH_IMAGE}" alt="" width="100%" height="12" /></td> 
     </tr> 
   </table> 
   <table cellspacing="0" cellpadding="0" border="0" align="left"> 
     <tr> 
       <td align="left"><img src="{RIGHT_GRAPH_IMAGE}" alt="" width="4" height="12" /></td> 
     </tr> 
   </table> 
    </td> 
  </tr> 
  <!-- END users --> 
</table> 
