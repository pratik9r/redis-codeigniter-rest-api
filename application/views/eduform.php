<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login Form</title>
     <!--link the bootstrap css file-->
     <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
     
     <style type="text/css">
     .colbox {
          margin-left: 0px;
          margin-right: 0px;
     }
     </style>
</head>
<body>


<div class="container" style="background-image: url('https://wallpapercave.com/wp/IvNXSvy.jpg');">
     <div class="row">
          <div class="col-lg-4 col-sm-4 well">
          <form name="ajax-form" action="javascript:void(0;)" style="text-align:left;" id="ajax-form" type="POST">
            <h1>ADMISSION OPEN FOR YEAR 2022-23</h1>
            <div class="form-group">
            <div class="row colbox">
               <div class="col-lg-8 col-sm-8">
                    <input class="form-control" id="parentsname" name="parentsname" placeholder="Parents Name" type="text" value="" />
               </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row colbox">
               <div class="col-lg-8 col-sm-8">
                    <input class="form-control" id="emaila" name="emaila" placeholder="E-mail" type="text" value="" />
               </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row colbox">
               <div class="col-lg-8 col-sm-8">
                    <input class="form-control" id="mobileno" name="mobileno" placeholder="Mobile Number" type="text" value="" />
               </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row colbox">
               <div class="col-lg-8 col-sm-8">
                    <select name="grades" class="form-control" id="grades">
                        <option value=""></option>
                        <option value="5th">5th grade</option>
                        <option value="6th">6th grade</option>
                        <option value="7th">7th grade</option>
                        <option value="8th">8th grade</option>
                        <option value="9th">9th grade</option>
                    </select>
                </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row colbox">
               <div class="col-lg-8 col-sm-8">
                    <input class="form-control"  type="submit" value="Enquire Now" style="background-color:antiquewhite"/>
               </div>
            </div>
            </div>
            <h3>CALL FOR ADMISSIONS</h3>
            <h3>9844433312/13/14</h3>
          </form>
          <div style="" id="how">
          <table style="border: 2px solid red;"><thead><tr><th style="border: 2px solid red;">Name</th><th style="border: 2px solid red;">Email</th><th style="border: 2px solid red;">Mobile Number</th><th style="border: 2px solid red;">Grades</th></tr></thead><tbody></tbody></table>
          </div>
         
          </div>
     </div>
</div>
     
<!--load jQuery library-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--load bootstrap.js-->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        $('#ajax-form').validate({
            rules:{
                parentsname:"required",
                emaila : {
                    required:true,
                    email:true 
                },
                mobileno: {
                    required:true,
                    digits:true,
                    minlength:10,
                    maxlength:10
                },
                grades:"required"
            },
            messages:{
                parentsname:"Please enter name",
                emaila:{
                    required:"Please enter email",
                    email:"Please enter valid email"
                },
                mobileno: {
                    required:"Please enter mobile number",
                    digits:"mobile no only include digits",
                    minlength:"mobile no should be of 10 digits",
                    maxlength:"mobile no should be of 10 digits"
                },
                grades:"Please select grades"
            },
            submitHandler:function(form){
               $.ajax({
                url:"educontroller/acceptform",
                type:"POST",
                data:$("#ajax-form").serialize(),
                dataType:"json",
                success:function(response){
                    
                    swal("form added sucessfully.");
                    

                    var tr ='';
                    $.each(response ,function(i,item){
                        tr += '<tr><td style="border: 2px solid red;">'+item.parentname+'</td><td style="border: 2px solid red;">'+item.email+'</td><td style="border: 2px solid red;">'+item.mobileno+'</td><td style="border: 2px solid red;">'+item.grades+'</td></tr>';
                    });

                    $('#how').append(tr);
                        

                   

                }
               })
            }
            
        })
    })
</script>
</body>
</html>