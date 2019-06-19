<table border="0" cellpadding="2" cellspacing="1" class="forumline" width="100%"> 
  <tr> 
    <td class="catHead" align="center" colspan="5"> 
   <span class="cattitle">{MODULE_NAME}</span> 
    </td> 
  </tr> 
  <tr>    
    <th class="thCornerL" align="center"><strong>{L_RANK}</strong></th>    
    <th class="thTop" align="center" width="10%"><strong>{L_WORD}</strong></th> 
    <th class="thTop" align="center" width="10%"><strong>{L_COUNT}</strong></th> 
    <th class="thTop" align="center" width="10%"><strong>{L_PERCENTAGE}</strong></th> 
    <th class="thCornerR" align="center" width="50%"><strong>{L_GRAPH}</strong></th> 
  </tr> 
  <!-- BEGIN words --> 
  <tr> 
    <td class="{words.CLASS}" align="left" width="10%"><span class="gen">{words.RANK}</span></td> 
    <td class="{words.CLASS}" align="left" width="10%"><span class="gen">{words.WORD}</span></td> 
    <td class="{words.CLASS}" align="center" width="10%"><span class="gen">{words.COUNT}</span></td> 
    <td class="{words.CLASS}" align="center" width="10%"><span class="gen">{words.PERCENTAGE}%</span></td>    
    <td class="{words.CLASS}" align="left" width="50%"> 
   <table cellspacing="0" cellpadding="0" border="0" align="left"> 
     <tr> 
       <td align="right"><img src="{LEFT_GRAPH_IMAGE}" alt="" width="4" height="12" /></td> 
     </tr> 
   </table> 
   <table cellspacing="0" cellpadding="0" border="0" align="left" width="{words.BAR}%"> 
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
  <!-- END words --> 
</table> 
