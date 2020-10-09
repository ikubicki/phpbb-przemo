<table cellspacing="2" cellpadding="2" border="0" align="center">
   <tr> 
      <td valign="middle">{INBOX_IMG}</td>
      <td valign="middle"><span class="cattitle">{INBOX} &nbsp;</span></td>
      <td valign="middle">{SENTBOX_IMG}</td>
      <td valign="middle"><span class="cattitle">{SENTBOX} &nbsp;</span></td>
      <td valign="middle">{OUTBOX_IMG}</td>
      <td valign="middle"><span class="cattitle">{OUTBOX} &nbsp;</span></td>
      <td valign="middle">{SAVEBOX_IMG}</td>
      <td valign="middle"><span class="cattitle">{SAVEBOX}</span></td>
   </tr>
</table>

<br clear="all">

<table width="100%" cellspacing="2" cellpadding="2" border="0">
   <form method="post" action="{S_PRIVMSGS_ACTION}">
   <tr>
      <td valign="middle">{REPLY_PM_IMG}</td>
      <td width="100%">&nbsp;</td>
   </tr>
</table>

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
   <tr> 
      <th colspan="3" class="thHead" nowrap="nowrap">{BOX_NAME} :: {L_MESSAGE}</th>
   </tr>
   <tr> 
      <td class="row2"><span class="genmed">{L_FROM}:</span></td>
      <td width="100%" class="row2" colspan="2"><span class="genmed"><a href="{MESSAGE_FROM_URL}" class="name"{MESSAGE_FROM_STYLE}>{MESSAGE_FROM}</a></span></td>
   </tr>
   <tr> 
      <td class="row2"><span class="genmed">{L_TO}:</span></td>
      <td width="100%" class="row2" colspan="2"><span class="genmed"><a href="{MESSAGE_TO_URL}" class="name"{MESSAGE_TO_STYLE}>{MESSAGE_TO}</a></span></td>
   </tr>
   <tr> 
      <td class="row2"><span class="genmed">{L_POSTED}:</span></td>
      <td width="100%" class="row2" colspan="2"><span class="genmed">{POST_DATE}</span></td>
   </tr>
   <tr> 
      <td class="row2"><span class="genmed">{L_SUBJECT}:</span></td>
      <td width="100%" class="row2"><span class="genmed">{POST_SUBJECT}</span></td>
      <td nowrap="nowrap" class="row2" align="right"> {QUOTE_PM_IMG} {EDIT_PM_IMG}</td>
   </tr>
   <tr> 
      <td valign="top" colspan="3" class="row1">
         <span class="postbody">{MESSAGE}
         </span>
         <!-- BEGIN postrow -->
         {ATTACHMENTS}
         <!-- END postrow -->
      </td>
   </tr>
   <tr> 
      <td width="78%" height="28" valign="bottom" colspan="3" class="row1"> 
         <table cellspacing="0" cellpadding="0" border="0" height="18">
            <tr> 
               <td valign="middle" nowrap="nowrap">
                  {PROFILE_IMG} {PM_IMG} {EMAIL_IMG} {WWW_IMG}{YIM_IMG} {MSN_IMG}
               </td>
               <td valign="middle" width=177>
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber1" height="19">
                     <tr>
                        {CGG_OFF1}
                        <td>&nbsp;</td><td width="59" height="19"><div style="position:relative">{AIM_IMG}<div style="position:absolute;left:3px;top:-1px">{AIM_STATUS_IMG}</div></div></td>
                        {CGG_OFF2}
                        {CICQ_OFF1}
                        <td>&nbsp;</td><td width="59" height="19"><div style="position:relative">{ICQ_IMG}<div style="position:absolute;left:3px;top:-1px">{ICQ_STATUS_IMG}</div></div></td>
                        {CICQ_OFF2}
                     </tr>
                  </table>
               </td>
               <td colspan="3" height="28" align="right">
                  {S_HIDDEN_FIELDS}
                  <input type="submit" name="save" value="{L_SAVE_MSG}" class="liteoption">&nbsp; 
                  <input type="submit" name="delete" value="{L_DELETE_MSG}" class="liteoption">
                  <!-- BEGIN switch_attachments -->
                  &nbsp;<input type="submit" name="pm_delete_attach" value="{L_DELETE_ATTACHMENTS}" class="liteoption">
                  <!-- END switch_attachments -->
               </td>
            </tr>
         </table>
         <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
            <tr> 
               <td>{REPLY_PM_IMG}</td>
               <td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
            </tr>
            </form>
         </table>

         <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
            <tr> 
               <td valign="top" align="right"><span class="gensmall">{JUMPBOX}</span></td>
            </tr>
         </table>
      </td>
   </tr>
</table>