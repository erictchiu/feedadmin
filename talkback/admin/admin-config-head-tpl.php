<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Admin panels heading
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991. This script may contain copyrighted code from another source that was
	released under the GPL. See credits-copyrights.txt for more information.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/
defined('IS_VALID_INCLUDE') or exit('This page cannot be accessed directly');
require 'admin-head-tpl.php';

print<<<EOF

<title>{$lang['panel_config_title']}</title>
<style type="text/css">
	.required {
		color: red;
		font-size: 1.2em;
		float: left;
		}
	.section {
		margin-top: 10px;
		font-weight: bold;
		color: #000; 
		background: #FFC76F; 
		padding: 3px;
		text-align: center;
		}	
	td {
		padding: 5px 0 5px 3px;
		}
	td.option {
		width: 160px;
		}
	.option input, .option div {
		font-family: "courier new", courier, monospace;
		width: 155px;
		border: 1px solid #bbb;
		background: #F7EBD8;
		padding-left: 2px;
		font-size: 1em;
		}
	.option div {
		background: none;
		height: 20px;
		}
	.option-unsized div {
		border: 1px solid #bbb;
		font-size: 1em;
		display: inline; 
		padding: 3px;
		height: 20px;
		}
	.radio {
		 background: #eee;
		 padding: 2px;
		 }
	.checkbox {
		padding-left: 140px;
		}
	.nav .report-page {
		margin: .5em 0 .5em 0;
		}
	strong {
		font-size: .9em;
		}
</style>
</head>
<body>
<div id="wrapper">
EOF;

require 'admin-nav-tpl.php';

print<<<EOF

	<div id='edit-wrapper'>
EOF;
?>