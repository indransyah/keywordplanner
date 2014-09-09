//set path
ZeroClipboard.setMoviePath('ZeroClipboard.swf');
//create client
var clip = new ZeroClipboard.Client();
//event
clip.addEventListener('mousedown',function() {
	clip.setText(document.getElementById('box-content').value);
});
clip.addEventListener('complete',function(client,text) {
	alert('copied: ' + text);
});
//glue it to the button
clip.glue('copy');