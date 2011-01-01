/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
   Popup Window
   options example: 'height=565,width=400,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,status=no'
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
var newwindow='';
function popup(url,windowname,options){
	newwindow=window.open(url,windowname,options);
	if (window.focus) {newwindow.focus()}
}

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Insert smiley code
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function insertCode(code) {
	var cache = document.tb_form.form_textarea.value;
	this.code = code;
	document.tb_form.form_textarea.value = cache + code;
	document.tb_form.form_textarea.focus();
}

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Delete comment confirmation
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function confirmSubmit() {
	var agree=confirm("Delete this comment?");
	if (agree) {
		return true;
	} else {
		return false;
	}
}

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Purge comments confirmation
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function confirmPurge() {
	var agree=confirm("Do really want to purge comments?\nDid you backup the database?");
	if (agree) {
		return true;
	} else {
		return false;
	}
}

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Set wait GIF style to dispaly none when leaving page
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function unsetWaitGif() {
	var n = document.getElementById('waitgif');
	n.style['display'] = 'none';
}

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Validate comment form fields
	A variation of the script at: http://www.smartwebby.com/DHTML/email_validation.asp
	+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function validateForm(){
	var errormsg='<strong>Missing:</strong>&nbsp;&nbsp;';

	var n = document.getElementById('waitgif');
	n.style['display'] = 'inline';

	if(document.forms['tb_form'].form_author.value && document.forms['tb_form'].form_email.value  && document.forms['tb_form'].form_subscribe[0].checked==false) {
		// Subscribing without entering a comment
		return true;
	}
	
	var errors = 0;
	if(document.forms['tb_form'].form_author.value == ""){ 
		errormsg = errormsg + ' name&nbsp;&nbsp; ';
		errors = 1;
	}
	if(document.forms['tb_form'].form_email.value == ""){
		errormsg = errormsg + 'email&nbsp;&nbsp;&nbsp;';
		errors = 1;
	}
	if(document.forms['tb_form'].form_textarea.value == ""){
		errormsg = errormsg + ' comment text';
		errors = 1;
	}
	if (errors) {
		document.getElementById('tb-error').innerHTML = errormsg;
		var n = document.getElementById('waitgif');
	n.style['display'] = 'none';
		return false;
	} else {
		// document.getElementById('waitgif').style.display = "inline";
		return true;
	}
}

// **********************************************************************
// JS QuickTags version 1.2
// Copyright (c) 2002-2005 Alex King
// http://www.alexking.org/
// Licensed under the LGPL license
// http://www.gnu.org/copyleft/lesser.html
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************
var edButtons = new Array();
var edLinks = new Array();
var edOpenTags = new Array();

function edButton(id, display, tagStart, tagEnd, access, open) {
	this.id = id;				// used to name the toolbar button
	this.display = display;		// label on button
	this.tagStart = tagStart; 	// open tag
	this.tagEnd = tagEnd;		// close tag
	this.access = access;		
	this.open = open;			// set to -1 if tag does not need to be closed
}
/* 0 */
edButtons.push(
	new edButton(
		'ed_bold'
		,'B'
		,'<b>'
		,'</b>'
		,'b'
	)
);
/* 1 */
edButtons.push(
	new edButton(
		'ed_italic'
		,'I'
		,'<i>'
		,'</i>'
		,'i'
	)
);
/* 2 */
edButtons.push(
	new edButton(
		'ed_link'
		,'Link'
		,''
		,''
		,'a'
		,-1
	)
); // special case
/* 3 */
edButtons.push(
	new edButton(
		'ed_img'
		,'IMG'
		,''
		,''
		,'m'
		,-1
	)
); // special case
/* 4 */
edButtons.push(
	new edButton(
		'ed_ul'
		,'UL'
		,'<ul>\n'
		,'</ul>\n'
		,'u'
	)
);
/* 5 */
edButtons.push(
	new edButton(
		'ed_ol'
		,'OL'
		,'<ol>\n'
		,'</ol>\n'
		,'o'
	)
);
/* 6 */
edButtons.push(
	new edButton(
		'ed_li'
		,'LI'
		,'   <li>'
		,'</li>\n'
		,'l'
	)
);
/* 7 */
edButtons.push(
	new edButton(
		'ed_block'
		,'B-QUOTE'
		,'<blockquote>'
		,'</blockquote>'
		,'q'
	)
);
/* 8 */
edButtons.push(
	new edButton(
		'ed_code'
		,'CODE'
		,'<code>'
		,'</code>'
		,'c'
	)
);
/* 9 */
edButtons.push(
	new edButton(
		'ed_pre'
		,'PRE'
		,'<pre>'
		,'</pre>'
	)
);
/* 10 */
edButtons.push(
	new edButton(
		'ed_under'
		,'U'
		,'<u>'
		,'</u>'
	)
);
/* 11 */
edButtons.push(
	new edButton(
		'ed_strike'
		,'S'
		,'<s>'
		,'</s>'
	)
);
/* 12 */
edButtons.push(
	new edButton(
		'ed_big'
		,'Big'
		,'<big>'
		,'</big>'
	)
);
/* 13 */
edButtons.push(
	new edButton(
		'ed_small'
		,'Small'
		,'<small>'
		,'</small>'
	)
);
/* 14 */
edButtons.push(
	new edButton(
		'ed_center'
		,'Center'
		,'<center>'
		,'</center>'
	)
);
/* 15 */
edButtons.push(
	new edButton(
		'ed_font'
		,'Font'
		,'<font color="red">'
		,'</font>'
	)
);
/* 16 */
edButtons.push(
	new edButton(
		'ed_lightbox'
		,'IMG'
		,''
		,''
		,'m'
	)
); // special case
/* 17 */
edButtons.push(
	new edButton(
		'ed_lt'
		,'<'
		,'&lt;'
		,''
	)
);
/* 18 */
edButtons.push(
	new edButton(
		'ed_gt'
		,'>'
		,'&gt;'
		,''
	)
);
/* 19 */
edButtons.push(
	new edButton(
		'ed_hr'
		,'hr'
		,'<hr width="50%" align="center" />'
		,''
	)
);

var extendedStart = edButtons.length;
// below here are the extended buttons
// removed the extended buttons for TalkBack

function edLink(display, URL, newWin) {
	this.display = display;
	this.URL = URL;
	if (!newWin) {
		newWin = 0;
	}
	this.newWin = newWin;
}

edLinks[edLinks.length] = new edLink('alexking.org'
                                    ,'http://www.alexking.org/'
                                    );

function edShowButton(button, i) {
	if (button.access) {
		var accesskey = ' accesskey = "' + button.access + '"'
	}
	else {
		var accesskey = '';
	}
	switch (button.id) {
		case 'ed_img':
			document.write('<input type="button" id="' + button.id + '" ' + ' class="ed_button" onclick="edInsertImage(tbCanvas);" value="' + button.display + '" />');
			break;
		case 'ed_lightbox':
			document.write('<input type="button" id="' + button.id + '" ' + ' class="ed_button" onclick="tbInsertLightbox(tbCanvas);" value="' + button.display + '" />');
			break;
		case 'ed_link':
			document.write('<input type="button" id="' + button.id + '" ' + ' class="ed_button" onclick="edInsertLink(tbCanvas, ' + i + ');" value="' + button.display + '" />');
			break;
		default:
			document.write('<input type="button" id="' + button.id + '" ' + ' class="ed_button" onclick="tbInsertTag(tbCanvas, ' + i + ');" value="' + button.display + '"  />');
			break;
	}
}

function edShowLinks() {
	var tempStr = '<select onchange="edQuickLink(this.options[this.selectedIndex].value, this);"><option value="-1" selected>(Quick Links)</option>';
	for (i = 0; i < edLinks.length; i++) {
		tempStr += '<option value="' + i + '">' + edLinks[i].display + '</option>';
	}
	tempStr += '</select>';
	document.write(tempStr);
}

function edAddTag(button) {
	if (edButtons[button].tagEnd != '') {
		edOpenTags[edOpenTags.length] = button;
		document.getElementById(edButtons[button].id).value = '/' + document.getElementById(edButtons[button].id).value;
	}
}

function edRemoveTag(button) {
	for (i = 0; i < edOpenTags.length; i++) {
		if (edOpenTags[i] == button) {
			edOpenTags.splice(i, 1);
			document.getElementById(edButtons[button].id).value = 		document.getElementById(edButtons[button].id).value.replace('/', '');
		}
	}
}

function edCheckOpenTags(button) {
	var tag = 0;
	for (i = 0; i < edOpenTags.length; i++) {
		if (edOpenTags[i] == button) {
			tag++;
		}
	}
	if (tag > 0) {
		return true; // tag found
	}
	else {
		return false; // tag not found
	}
}	


function edQuickLink(i, thisSelect) {
	if (i > -1) {
		var newWin = '';
		var newWindow = document.getElementById('tb-link-target').innerHTML;
		if (newWindow == 1) {
			newWin = ' target="_blank"';
		}
		var tempStr = '<a href="' + edLinks[i].URL + '"' + newWin + '>' 
		            + edLinks[i].display
		            + '</a>';
		thisSelect.selectedIndex = 0;
		edInsertContent(tbCanvas, tempStr);
	}
	else {
		thisSelect.selectedIndex = 0;
	}
}


function edToolbar() {
	document.write('<div id="ed_toolbar"><span>');
	for (i = 0; i < extendedStart; i++) {
		edShowButton(edButtons[i], i);
	}

		
	for (i = extendedStart; i < edButtons.length; i++) {
		edShowButton(edButtons[i], i);
	}
	document.write('</span>');
//	edShowLinks();
	document.write('</div>');
}

// insertion code

function tbInsertTag(myField, i) {
	//IE support
	if (document.selection) {
		myField.focus();
	    sel = document.selection.createRange();
		if (sel.text.length > 0) {
			sel.text = edButtons[i].tagStart + sel.text + edButtons[i].tagEnd;
		}
		else {
			if (!edCheckOpenTags(i) || edButtons[i].tagEnd == '') {
				sel.text = edButtons[i].tagStart;
				edAddTag(i);
			}
			else {
				sel.text = edButtons[i].tagEnd;
				edRemoveTag(i);
			}
		}
		myField.focus();
	}
	//MOZILLA/NETSCAPE support
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var cursorPos = endPos;
		var scrollTop = myField.scrollTop;
		if (startPos != endPos) {
			myField.value = myField.value.substring(0, startPos)
			              + edButtons[i].tagStart
			              + myField.value.substring(startPos, endPos) 
			              + edButtons[i].tagEnd
			              + myField.value.substring(endPos, myField.value.length);
			cursorPos += edButtons[i].tagStart.length + edButtons[i].tagEnd.length;
		}
		else {
			if (!edCheckOpenTags(i) || edButtons[i].tagEnd == '') {
				myField.value = myField.value.substring(0, startPos) 
				              + edButtons[i].tagStart
				              + myField.value.substring(endPos, myField.value.length);
				edAddTag(i);
				cursorPos = startPos + edButtons[i].tagStart.length;
			}
			else {
				myField.value = myField.value.substring(0, startPos) 
				              + edButtons[i].tagEnd
				              + myField.value.substring(endPos, myField.value.length);
				edRemoveTag(i);
				cursorPos = startPos + edButtons[i].tagEnd.length;
			}
		}
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
		myField.scrollTop = scrollTop;
	}
	else {
		if (!edCheckOpenTags(i) || edButtons[i].tagEnd == '') {
			myField.value += edButtons[i].tagStart;
			edAddTag(i);
		}
		else {
			myField.value += edButtons[i].tagEnd;
			edRemoveTag(i);
		}
		myField.focus();
	}
}

function edInsertContent(myField, myValue) {
	//IE support
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = myValue;
		myField.focus();
	}
	//MOZILLA/NETSCAPE support
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var scrollTop = myField.scrollTop;
		myField.value = myField.value.substring(0, startPos)
		              + myValue 
                      + myField.value.substring(endPos, myField.value.length);
		myField.focus();
		myField.selectionStart = startPos + myValue.length;
		myField.selectionEnd = startPos + myValue.length;
		myField.scrollTop = scrollTop;
	} else {
		myField.value += myValue;
		myField.focus();
	}
}

function edInsertLink(myField, i, target) {
	defaultValue = 'http://';
	if (target == 1) {
		target = 'target="_blank"';
	} else {
		target = '';
	}
	var URL = prompt('Enter the URL' ,defaultValue);
	var TEXT = prompt('Enter the link text' ,'');
	if (URL && TEXT) {
		edButtons[i].tagStart = '<a href="' + URL + '" ' + target + '>' + TEXT + '</a>';
		tbInsertTag(myField, i);
	}
}

function edInsertImage(myField) {
	var myValue = prompt('Enter the URL of the image', 'http://');
	if (myValue) {
		myValue = '<img src="' 
				+ myValue 
				+ '" alt="' + prompt('Enter a description of the image', '') 
				+ '" />';
		edInsertContent(myField, myValue);
	}
}

function tbInsertLightbox(myField) {
	var myValue = prompt('Enter the URL of the image', 'http://');
	if (myValue) {
		myValue = '<a href="' 
				+ myValue 
				+ '" title="' + prompt('Enter caption (optional)', '') 
				+ '" class="thickbox">{image}</a>';
		edInsertContent(myField, myValue);
	}
}

