<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
<div class="contentpage">
   <div class="row">
     <div class="attendance widget">
      <div class="innercont1">
         <div class="sample">
            <div class="tl"> <b>Child Name: </b>
         <select name="student" class="student" id="select-children">
            <?php 
            foreach($run->getNameOfStud() as $row) {
               extract($row);
               echo '
               <option value="'.$stud_lrno.'" name="stud_name"> '.$name.' - '.$section.'  </option>
               ';
            }
            ?>
         </select>
      </div>
         </div>
      </div>
   </div>
      <br>
      <div id="attendance-container">
      <?php $lrno = !isset($_SESSION['child_lrno']) ? $run->getLRNOfStud() : $_SESSION['child_lrno']; ?>
         <div id="attendance-container-load">
            <div class="attendance widget">
               <div class="innercont1">
                  <div class="header">
                     <p> 
                        <i class="fas fa-book fnt"></i>
                        <span>Attendance Report</span>
                     </p>
                     <p>School Year: <?php $run->getSchoolYear(); ?></p>
                  </div>
                  <div class="eventcontent">

                     <a href="<?php echo URL ?>"><img src="public/images/common/logo.png"></a>
                     <div class="table-scroll ">
                        <div class="table-wrap" id="table-attendance-children">
                           <table class ="attendance-child" id="attendance-child">
                              <tr>
                                 <td>Grade Level & Section</td>
                                 <td><?php $run->getChildLevelSection($lrno); ?></td>
                              </tr>
                              <tr>
                                 <td>Number of Days Late</td>
                                 <td><?php $run->getNoOfDaysLate($lrno); ?></td>
                              </tr>
                              <tr>
                                 <td>Number of Days Absent</td>
                                 <td><?php $run->getNoOfDaysAbsent($lrno); ?></td>
                              </tr>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>   
            </div>
            <div class="attendance widget">
               <div class="innercont1">
                  <div class="header">
                     <p> 
                        <i class="fas fa-book fnt"></i>
                        <span>Date/s of Absences</span>
                     </p>
                     <p>School Year: <?php $run->getSchoolYear(); ?></p>
                  </div>
                  <div class="eventcontent" id="detail-attendance-child">
                     <table id="detail-attendance" class="display">
                        <thead>
                           <tr>
                              <th>Date</th>
                              <th>Subject</th>
                              <th>Remarks</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $run->getAttDateRemarks($lrno); ?> 
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>   
      </div>
   </div> 
</div>
<?php if (isset($_SESSION['child_lrno'])) unset($_SESSION['child_lrno']); ?>

