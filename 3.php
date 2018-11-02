<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
jQuery().ready(function(){
jQuery('html').on("click","#test",function(){
	alert(1);
// The relevant data is after 'base64,'.
//var pngData = dataUrl.split('base64,')[1];
var pngData = '';
// Put the data in a regular multipart message with some text.
var mail = [
  'Content-Type: multipart/mixed; boundary="foo_bar_baz"\r\n',
  'MIME-Version: 1.0\r\n',
  'From: sarvesh@offshorewebmaster.com\r\n',
  'To: sdpatel.2110@gmail.com\r\n',
  'Subject: Subject Text\r\n\r\n',

  '--foo_bar_baz\r\n',
  'Content-Type: text/plain; charset="UTF-8"\r\n',
  'MIME-Version: 1.0\r\n',
  'Content-Transfer-Encoding: 7bit\r\n\r\n',



   '--foo_bar_baz--'
].join('');

// Send the mail!
$.ajax({
  type: "POST",
  url: "https://www.googleapis.com/upload/gmail/v1/users/me/messages/send?uploadType=media",
  contentType: "message/rfc822",
  beforeSend: function(xhr, settings) {
    xhr.setRequestHeader('Authorization','Bearer ya29.GltCBkYtfDXOhBVeeNSj89lGYFljZ1HvUad85ngh_ihBixR_pM9g45Sa2bAcjq_Ng0dbHvhCWN4VZRMn8WU_P_GS_ho6tuTxAJJqIk902KAOZ-jfJXA27XTo95y6');
  },
  data: mail
}); 
});
});
</script>
<div id="test">sdsdsddsdsd</div>
<div id="canvas"></div>