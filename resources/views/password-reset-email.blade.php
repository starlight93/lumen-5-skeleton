<table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" style="font-family:'Microsoft YaHei'" width="800">
   <tbody>
      <tr>
         <td>
            <table align="left" bgcolor="green" border="0" cellpadding="0" cellspacing="0" height="78" style="font-family:'Microsoft YaHe            i'" width="800">
               <tbody>
                  <tr>
                     <td align="left" border="0" height="26" style="padding-left:20px" valign="middle" width="64"><a href="https://www.fajarfirmansyah.com/">
                        <img alt="{{$data->pengirim}}" border="0" height="54" src="https://unud.kmnu.or.id/assets/logo-compressed.png" /></a>
                        <img alt="{{$data->pengirim}}" border="0" height="50" src="https://unud.kmnu.or.id/assets/logo-tulisan-big.png" /></a>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
         
      </tr>
      <tr style="padding:28px 18px;display:inline-block;">
      <td>
         <table align="center" border="0" cellpadding="0" cellspacing="0" style="font-family:'Microsoft YaHei'" width="763">
            <tbody>
               <tr>
                  <td>Permintaan Reset Password
                  </td>
               </tr>
               <tr style="margin-top:12px;display:block">
                  <td style="color: #666666;font-size: 14px;">Klik Link di bawah ini atau akses di browser anda URL {{$data->url}} </td>
               </tr>
                  <tr align="center" style="margin:40px 0;display:block;">
                     <td style="border:1px solid #A4D3FB;" valign="middle" width="238">
                        <span style="width:35%;display:inline-block;float:left;height:100%;padding: 10px 0;background:#77c568;color: white;">
                           Link
                        </span> 
                        <span style="width:65%;display:inline-block;letter-spacing: 5px;height:100%;padding: 10px 0;color: #40f61c;">
                           <a href="{{$data->url}}" target="_blank">Klik Disini</a>
                        </span></td></tr>
               <tr>
                  <td colspan="2" height="14" style="padding-bottom:16px;border-bottom:1px dashed #e5e5e5;font-family:'Microsoft YaHei'" width="720">
                    {{$data->pengirim}}
                </td>
               </tr>
               <tr>
                  <td colspan="2" height="14" style="padding:8px 0 28px;color:#999999;font-size:12px;font-family:'Microsoft YaHei'" width="720">This is system message and please do not reply</td>
               </tr>
            </tbody>
         </table>
      </td>
      </tr>
      <tr style="background-color: #F4F4F4;color: #999999;height: 100px;line-height: 100px;padding-left:20px;font-size: 13px;display:block;">
      <td>{{$data->footer}}</td>
      </tr>
   </tbody>
</table>