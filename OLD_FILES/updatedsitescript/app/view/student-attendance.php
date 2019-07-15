<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>
<?php
  if (isset($_POST['save-button'])){
  $run->applyReason($_POST['att_id'], $_POST['reason'], $_FILES['attachment']);
  }
  if (isset($_POST['delete-button'])){
      $run->deleteAttachment($_POST['att_id']);
    }
?>
<?php
  $this->conn = new Connection;
  $this->conn = $this->conn->connect();
?>

<div class="contentpage">
  <div class="row">
    <div id="widget">
      <div class="header">
        <p><i class="fas fa-check-square fnt"></i><span>Attendance</span></p>
      </div>
      <div class='widgetcontent'>
        <div class="widgetContent">
          <div class="cont2">
            <table id="student-attendance" class="display">
              <thead>
                <tr>
                  <th class="tleft">Date</th>
                  <th class="tleft">Subject</th>
                  <th class="tleft">Type</th>
                  <th class="tleft">Remarks</th>
                  <th class="tleft">Reason</th>
                  <th class="tleft">Attachment</th>
                  <th class="tleft">Apply Reason</th>
                </tr>
              </thead>
              <tbody>

<?php
 foreach($run->studAttendance() as $value){
 extract($value);
 echo '
 <tr>
        <td><span>' .$att_date. '</span></td>
        <td><span>' .$subj_name. '</span></td>
        <td><span>' .$type. '</span></td>
        <td><span>'.$att_remarks.'</span></td>
        <td><span>'.$remarks.'</span></td>
        <td><span> ' ;
        if($att_attachment == null){
          echo '';
        }else{
        echo'<p class="center attachment" style="font-size: 15px;"><a href="public/letter/'.$att_attachment.'" view>View Attachment</a></p>
        <div name="content">
          <button name="opener">
            <div class="tooltip">
              <i class="fas fa-window-close"></i>
              <span class="tooltiptext"></span>
            </div>
          </button>
          <div name="dialog" title="Delete attachment">
            <form action="student-attendance" method="POST" required>
              <p>Are you sure you want to delete this attachment?</p>

              <input type="hidden" name="att_id" value="'.$att_id.'">
              <button name="delete-button" class="customButton">Yes <i class="fas fa-save fnt"></i></button>
            </form>
          </div>  
        </div>';
      }
      echo'
        </span></td>
        <td colspan="5" class="action">
                        <div name="content">';
                  if($apply_reason != 'Parent'){
                    echo '
                      <button name="opener">
                                <div class="tooltip">
                                    <i class="fas fa-edit"></i>
                                </div>
                            </button>
                            <div name="dialog" title="Apply Reason for Late/Absent">
                                <form action="student-attendance" method="POST" enctype="multipart/form-data" required autocomplete="on">
                                <span style="float:left;"><b>Reason</b></span><br>    
                                    <input type="hidden" name="att_id" value="'.$att_id.'">
                                    <textarea type="text" name="reason" value="'.$remarks.'" id="" cols="35" rows="8" data-validation="length custom required" data-validation-length="max200" data-validation-error-msg="Enter less than 200 characters" placeholder="Input Reason">'.$remarks.'</textarea><br><br>

                                  <span style="float:left;"><b>File Attachment<b></span><br>
                                  <span style="float:left; class="attachment">Current File: '.$att_attachment.'</span><br>
                                    <input type="file" name="attachment" id="" placeholder="Attachment(optional)"><br>

                                <button name="save-button" class="customButton" style="float:right; background:#0089DA; color: #fff;">Save<i class="fas fa-save fnt"></i></button><br>
                                </form>
                    ';
                  } else{
                    echo '';
                  }
                            
                    echo '</div>
                        </div>
                </td>
        </tr>';
}
?>

<tr>
  <td colspan="5" style="color: orange;"><b>Number of days late</b></td>
  <td colspan="2" style="text-decoration: underline;"><b><?php $run->getLate(); ?></b></td>
</tr>
<tr>
  <td colspan="5" style="color: red;"><b>Number of days absent</b></td>
  <td colspan ="2" style="text-decoration: underline;"><b><?php $run->getAbsent(); ?></b></td>
</tr>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>