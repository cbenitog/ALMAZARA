// uploads Center.
function uploadsCenter(fieldName)
{
	window.open("centers/uploads.center.php?field=" + fieldName, "", "status=0, toolbar=0, location=0, menubar=0, directories=0, resizeable=1, scrollbars=1, width=600, height=600");
}

// Attach file to an entry.
function attach(file, fileId, fieldName)
{
	window.opener.document.getElementById(fieldName).value = file;
	window.opener.document.getElementById(fieldName + "_id").value = fileId;
	window.close();
}

// Clear file field on file.
function clearFileField(fieldName)
{
	document.getElementById(fieldName).value = "";
	document.getElementById(fieldName + "_id").value = "";
}

// Accounts Center. Disables and enables buttons.
function removeDisabled()
{
	document.accountsForm.save.disabled = "";
	document.accountsForm.close.disabled = "";
	document.accountsForm.create.disabled = "disabled";	
}

// Check and uncheck delete checkboxes.
function CheckAllBoxes(theElement)
{
	var theForm = theElement.form, z = 0;
 	for(z=0; z<theForm.length;z++)
	{
  		if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall')
		{
  			theForm[z].checked = theElement.checked;
  		}
 	}
}

// Delete account.
function deleteAccount(url, message)
{
	var userAnswer = confirm(message);
	if (userAnswer == true)
	{
		ajax_get('accounts_center', url);	
	}
}

// Sector Navigation.
function toggleNav()
{
	if (Element.hasClassName('current', 'out'))
	{
		var newClass = 'over';	
	}
	else
	{
		var newClass = 'out';	
	}
	
	Element.toggleClassName('current', newClass);
	Effect.toggle('hiddenLinks', 'blind', {duration: 0.15});
}

// Ajax.
function ajax_get(area, thisUrl)
{
	new Ajax.Updater(area, thisUrl, { method: 'get' });
}

function ajax_post(area, thisUrl)
{
	new Ajax.Updater(area, thisUrl, {asynchronous:true, parameters:Form.serialize(document.accountsForm)});
}