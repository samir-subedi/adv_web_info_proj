
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>



<?php
	include ("include/header_nav.php");
?>



<main>

	<h2>Contact Us</h2>

               
               <p>Fashionwave SHOP  306 WESTFIELD S/C 500 OXFOAD ST BONDI JUNCTION 2022 NSW </p>
               <p align="center" class="style3 style2"><strong>PHONE: +166 166 123</strong></p>
               <p align="center" class="style2 style3"><strong>E-mail: <a href="mailto:fashionwave.fashion@gmail.au" class="typelink">fashionwave.fashion@gmail.com.au</a></strong></p>
                             
                             
              

                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26494.501978104094!2d151.23304712451167!3d-33.89447611034395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x6d613af64d7a36aa!2sWestfield+Bondi+Junction!5e0!3m2!1sen!2sau!4v1462495790832" width="650" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
             

      <p>Please contact us using the following form</p>

    <form action="" method="post" name="form1" id="form1" onsubmit="MM_validateForm('name','','R','email','','RisEmail','comment','','R');return document.MM_returnValue">
 
      <table width="650px" border="1" align="center" cellpadding="4">
        <tr>
          <td width="33%" align="right"><strong>Your Name</strong></td>
          <td width="2%">&nbsp;</td>
          <td width="65%"><label>
            <input type="text" name="name" id="name" />
          </label></td>
        </tr>
        <tr>
          <td align="right"><strong>Email</strong></td>
          <td>&nbsp;</td>
          <td><label>
            <input name="email" type="text" id="email" size="30" />
          </label></td>
        </tr>
        <tr>
          <td align="right"><strong>Gender</strong></td>
          <td>&nbsp;</td>
          <td><label>
            <input type="radio" name="gender" id="radio" value="radio" />
          </label>
            <label>
            Male
            <input name="gender" type="radio" id="radio2" value="radio2" checked="checked" />
            Female</label></td>
        </tr>
        <tr>
          <td align="right"><strong>Country</strong></td>
          <td>&nbsp;</td>
          <td><label>
            <select name="country" id="country">
              <option value="Au" selected="selected">Australia</option>
              <option value="Nz">New Zealand</option>
              <option value="Fi">Fiji</option>
            </select>
          </label></td>
        </tr>
        <tr>
          <td align="right"><strong>Where do you hear about us</strong></td>
          <td>&nbsp;</td>
          <td><label>
            <input type="checkbox" name="wherehear" id="wherehear" />
          </label>
            <label>
            TV<br />
            <input type="checkbox" name="wherehear" id="wherehear" />
            Newspaper<br />
            </label>
            <label>
            <input type="checkbox" name="wherehear" id="wherehear" />
            Internet<br />
            </label>
            <label>
            <input name="checkbox4" type="checkbox" id="checkbox4" checked="checked" />
            Others</label></td>
        </tr>
        <tr>
          <td align="right"><strong>Comment</strong></td>
          <td>&nbsp;</td>
          <td><label>
            <textarea name="comment" cols="35" rows="8" id="comment"></textarea>
          </label></td>
        </tr>

        <tr>
          <td height="61" colspan="3" align="center"><label>
            <input type="submit" name="button" id="button" value="Submit" />
          </label>
            <label>
            <input type="reset" name="button2" id="button2" value="Reset" />
            </label></td>
          </tr>
      </table>
      </form>

</main>

<?php
	include ("include/footer.php");
?>


