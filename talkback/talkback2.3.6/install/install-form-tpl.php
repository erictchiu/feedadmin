<?php
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Configuration settings entry template
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Copyright 2006 by Richard Williamson (aka OldGuy). 
	Website: http://www.scripts.oldguy.us/talkback - noldguy@gmail.com

	TalkBack Comments is licensed under the terms of the GNU General Public License,
	June 1991.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
*/

$h1 = "<a href='help.php?";
$h2 = "&language={$language}&height=250&width=400&This=true&TB_iframe=true' title='{$lang['ach_panel_title']}' class='thickbox  help'>&nbsp;&nbsp;&nbsp;&nbsp;</a>";

print "
	{$lang['install_preface']}
	<noscript>You must enable Javascript to use the help buttons.</noscript>
	<form action='{$_SERVER['REQUEST_URI']}' method='post'>
		<input type='hidden' name='action' value='update' />
		<input type='hidden' name='language_file' value='" .LANGUAGE_FILE. "' />
		<input type='hidden' name='language' value='$language' />
		<input type='hidden' name='docroot'  value='" . DOC_ROOT . "'/>
		<input type='hidden' name='tbpath'   value='" . TB_PATH . "'/>
		";
print<<<EOF
		<table cellspacing="0" cellpadding="0">
<!-- mySQL settings -->
		<tr><td colspan="2" >&nbsp;</td></tr>
		<tr><td colspan="2" class="section">{$lang['header_database']}</td></tr>
		<tr><td class='option'><input name="dbhost" type="text" value="localhost" size="20" /></td>
			<td><span class="required">*</span> 
			{$lang['dbhost']}
			{$h1}name=ach_dbhost$h2</td></tr>
		<tr><td class='option'><input name="dbuser" type="text" value="" size="20" /></td>
			<td><span class="required">*</span> 
			{$lang['dbuser']} 
			{$h1}name=ach_dbuser$h2</td></tr>
		<tr><td class='option'><input name="dbpassword" type="text" value="" size="20" /></td>
			<td>{$lang['dbpassword']}
			{$h1}name=ach_dbpassword$h2</td></tr>
		<tr><td class='option'><input name="dbname" type="text" value="" size="20" /></td>
			<td><span class="required">*</span> 
			{$lang['dbname']}
			{$h1}name=ach_dbname$h2</td></tr>
		<tr><td class='option'><input name="dbprefix" type="text" value="tb_" size="20" /></td>
			<td><span class="required">*</span> 
			{$lang['dbprefix']}
			{$h1}name=ach_dbprefix$h2</td></tr>
			
<!-- Site settings -->
		<tr><td colspan="2" class="section">{$lang['header_site']}</td></tr>
		<tr><td class='option'><input name="site_name" type="text" value="" size="20" /></td>
			<td><span class="required">*</span> 
			{$lang['site_name']}
			{$h1}name=ach_site_name$h2</td></tr>
		<tr><td class='option'><input name="site_url" type="text" value="http://{$_SERVER['HTTP_HOST']}" size="20" /></td>
			<td><span class="required">*</span> 
			{$lang['site_url']}
			{$h1}name=ach_site_url$h2</td></tr>
		
<!-- Administrator settings -->
		<tr><td colspan="2" class="section">{$lang['header_admin']}</td></tr>
		<tr><td class='option'><input name="admin_login" type="text" value="" size="20" /></td>
			<td><span class="required">*</span> 
			{$lang['admin_login']}
			{$h1}name=ach_admin_login$h2</td></tr>
		<tr><td class='option'><input name="admin_password" type="text" value="" size="20" /></td>
			<td><span class="required">*</span> 
			{$lang['admin_password']}
			{$h1}name=ach_admin_password$h2</td></tr>
		<tr><td class='option'><input name="admin_name" type="text" value="" size="20" /></td>
			<td>{$lang['admin_name']}
			{$h1}name=ach_admin_name$h2</td></tr>
		<tr><td class='option'><input name="admin_email" type="text" value="" size="20" /></td>
			<td><span class="required">*</span> {$lang['admin_email']}
			{$h1}name=ach_admin_email$h2</td></tr>
			
		<tr><td colspan="2"><input type="submit" value="{$lang['submit']}" /></td></tr>
		</table>
	</form>
</div>
</div>
</body>
</html>
EOF;
?>