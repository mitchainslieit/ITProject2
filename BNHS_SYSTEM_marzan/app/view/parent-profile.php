<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
<div class="contentpage">
    <div class="row">
        <div class="widget">
            <div class="header">
                <p>
                    <i class="fas fa-user-cog fnt"></i>
                    <span>My Profile</span>
                </p>
            </div>

            <div class="eventcontent profileContent">
                <div class="container">
                    <div class="cont cont1">
                      <div class="container">
                          <div class="profile">
                            <img id="blah"src="public/images/profile.png"> 
                            <div class="overlay">
                                <input id="imgInp" type="file">
                                <p><i class="fas fa-pen"></i>   Change </p>
                            </div>
                        </div>  
                    </div>
                </div>
                <div class="cont cont2">
                   <table id="profileDataTable">  
                        <thead>
                            <tr>    
                                <td><b>Name:</b></td>
                                <td><?php $run->getWholeName(); ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Username:</b></td>
                               <td><?php $run->getUsername(); ?></td>
                            </tr>
                            <tr>
                                <td><b>Position:</b></td>
                                <td><?php $run->getPosition(); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    
                </div>
        <style>
            body {
              margin: 0;
          }
          .container {
              width: 100%;
              height: auto;
          }
          .profile {
              margin: 20px auto;
              max-width: 200px;
              position: relative;
              border-radius: 50%;
          }
          .profile:hover .overlay {
              background-color: rgba(0, 0, 0, 0.5);
          }
          .profile:hover .overlay p {
              display: block;
          }
          .profile img {
              display: block;
              width: 100%;
              border-radius: 50%;
              height: auto;
          }
          .profile .overlay {
              position: absolute;
              width: 100%;
              bottom: 0;
              overflow: hidden;
              height: 100%;
              border-radius: 50%;
          }
          .profile .overlay input {
              width: 100%;
              position: absolute;
              opacity: 0;
              bottom: 20px;
              z-index: 2;
              cursor: pointer;
          }
          .profile .overlay p {
              position: absolute;
              bottom: 10px;
              font-weight: bold;
              text-align: center;
              color: #fff;
              width: 100%;
              display: none;
          }

      </style>

      <script>
       function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this);
    }) 

</script>


</div>

</div>
</div>
</div>