/*$(document).ready(function() {
	genstuff();
	feedback();
});
function genstuff() {
	$("#submit").css("disabled");
}
function feedback()
{
	$("#landlord").submit(
		function (event) {
			event.preventDefault();
			// collect form data
			$firstname = $("#firstname").val();
			$lastname = $("#lastname").val();
			$mobile = $("#mobile").val();
			$datereg = $("#registeredon").val();
			$id = $("#id").val();
			$passport = $("#passportno").val();
			$paddress = $("#postaladdress").val();
			
			$errors = false;
			
			if($firstname == '') {
				displayError('Please enter the FirstName','#fname');
				$errors = true;
			}		</table>
	        </form>
			
			if($lastname == '') {
				displayError('Please enter the LastName','#lname');
				$errors = true;
			}
			
			if($mobile == '') {
				displayError('Please enter the Mobile Number','#mobil');
				$errors = true;
			}
			
			if($datereg == '') {
				displayError('Please enter Registration Date','#datereg');
				$errors = true;
			}
			
			if(($passport == '')&&($id =='')) {
				displayError('Please provide the Passport number or the IDNumber',,'#idn');
				$errors = true;
			}
			
			if($paddress == '') {
				displayError('Please enter Postal Address','#pa');
				$errors = true;
			}
			
			if(!$errors) {
			// correct		</table>
		        </form>
						displaySuccess('update Successful','.submit');
					} else {
						// display error
						displayError('Server error: ' + data,'.submit');
					}
				});
	}
$("#plot").submit(
		function (event) {
			
			
			
			
			});


function displayError(msg,to){
	var elem = $('<div>',{
		'class'	: 'errorMessage',
		html	: msg,
		style	: 'z-index: 3000'
	});
	
	elem.click(function(){
		$(this).fadeOut(function(){
			$(this).remove();
		});
	});
	
	setTimeout(function(){
		elem.click();
	},5000);
	
	elem.hide().appendTo(to).slideDown();
}

function displaySuccess(msg,to){
	var elem = $('<div>',{
		'class'	: 'successMessage',
		html	: msg,
		style	: ''
	});
	
	$(to).html(elem);
	//elem.hide().appendTo(to).slideDown();
}

function isInt (val)
{
	inputVal = val.toString();
	
	for (var i = 0 ; i < inputVal.length ; i++)
	{
		var oneChar = inputVal.charAt(i)
		
		if(i == 0 && oneChar == "-")
		{
			continue;
		}
		
		if(oneChar < "0" || oneChar > "9")
		{
			return false;
		}
	}
	
	return true;
}*/