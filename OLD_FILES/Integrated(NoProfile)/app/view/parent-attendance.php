<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
<?php
if (isset($_POST['save-button'])){
  $run->applyReason($_POST['att_id'], $_POST['reason'], $_FILES['attachment'], $_POST['lrno']);
}
?>
<?php
  $this->conn = new Connection;
  $this->conn = $this->conn->connect();
?>
<div class="contentpage">
    <div class="row">
        <div id="attendance-container">
            <div id="attendance-container-load">
                <div class="widget">
                    <div class="innercont1">
                        <div class="header">
                            <p>
                                <i class="fas fa-check-square fnt"></i>
                                <span>Date/s of Absences</span>
                            </p>
                            <p>School Year:
                                <?php $run->getSchoolYear(); ?>
                            </p>
                        </div>
                        <br>
                        <div class="cont3">
                            <div class="cont2">
                                <div class="tl1"> <b>Child Name: </b>
                                 <select name="student" class="student" id="select-child-attendance">
                                    <?php
                                    foreach($run->getNameOfStud() as $row) {
                                        extract($row);
                                        if (isset($_SESSION['child_lrno']) && $_SESSION['child_lrno'] === $stud_lrno) {
                                          echo '<option value="'.$stud_lrno.'" name="stud_name" selected> '.$name.' - '.$section.'  </option>';
                                        } else {
                                              echo '<option value="'.$stud_lrno.'" name="stud_name"> '.$name.' - '.$section.'  </option>';
                                        }
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="eventcontent">
                            <div class="table-scroll">
                                <div class="table-wrap" id="table-attendance-child">
                                        <table id="table-attendance" class="display">
                                            <thead style="text-align: center;">
                                               <tr>
                                                  <th>lrno</th>
                                                  <th>Date</th>
                                                  <th>Subject</th>
                                                  <th>Type</th>
                                                  <th>Remarks</th>
                                                  <th>Attendance Remarks</th>
                                                  <th>Attachment</th>
                                                  <th>Reason</th>
                                              </tr>
                                          </thead>
                                          <tbody style="text-align: center;">
                                            <?php
                                            foreach($run->getAttDateRemarks() as $value){
                                               extract($value);
                                               echo '
                                               <tr>
                                               <td>'.$stud_lrno.'</td>
                                               <td><span>' .$att_date. '</span></td>
                                               <td><span>' .$subj_name. '</span></td>
                                               <td><span>' .$type. '</span></td>
                                               <td><span>'.$remarks.'</span></td>
                                               <td><span>'.$att_remarks.'</span></td>
                                              <td><span> ' ;
        if($att_attachment == null){
          echo '';
        }else{
        echo'<p class="center attachment" style="font-size: 15px;"><a href="public/letter/'.$att_attachment.'" download> Download Attachment</a></p>
        <div name="content">
          <button name="opener">
            <div class="tooltip">
              <i class="fas fa-window-close"></i>
              <span class="tooltiptext"></span>
            </div>
          </button>
          <div name="dialog" title="Delete attachment">
            <form action="parent-attendance" method="POST" required>
              <p>Are you sure you want to delete this attachment?</p>
              <input type="hidden" name="lrno" value="'.$stud_lrno.'">
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
                    echo '
                      <button name="opener">
                                <div class="tooltip">
                                    <i class="fas fa-edit"></i>
                                    <span class="tooltiptext">Apply Reason for Late/Absent</span>
                                </div>
                            </button>
                            <div name="dialog" title="Apply Reason for Late/Absent">
                                <form action="parent-attendance" method="POST" enctype="multipart/form-data" required autocomplete="on">
                                <span style="float:left;"><b>Reason</b></span><br>
                                <input type="hidden" name="lrno" value="'.$stud_lrno.'">
                                    <input type="hidden" name="att_id" value="'.$att_id.'">
                                    <textarea type="text" name="reason" value="'.$remarks.'" id="" cols="35" rows="8" data-validation="length custom required" data-validation-length="max200" data-validation-error-msg="Enter less than 200 characters" placeholder="Input Reason">'.$remarks.'</textarea><br><br>

                                  <span style="float:left;"><b>File Attachment<b></span><br>
                                  <span style="float:left; class="attachment">Current File: '.$att_attachment.'</span><br>
                                    <input type="file" name="attachment" id="" placeholder="Attachment(optional)"><br>

                                <button name="save-button" class="customButton" style="float:right; background:#0089DA; color: #fff;">Save<i class="fas fa-save fnt"></i></button><br>
                                </form>
                    ';
                 
                            
                    echo '</div>
                        </div>
                </td>
                                       
                                               </tr>';
                                           
                                         } 
                                           ?>
                                      </tbody>
                                     <tfoot>
                                          <tr>
                                             <td colspan="6" style="color: orange; font-weight: 700; text-align: center;">Number of days late</td>
                                             <td colspan="2" style="text-decoration: underline;"><b><?php $run->getLate(); ?></b></td>
                                         </tr>
                                         <tr>
                                             <td colspan="6" style="color: red; font-weight: 700; text-align: center;">Number of days absent</td>
                                             <td colspan ="2" style="text-decoration: underline;"><b><?php $run->getAbsent(); ?></b></td>
                                         </tr>
                                     </tfoot>
                                  </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>