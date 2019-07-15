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
   <div id="attendance-container">
      <?php $lrno = !isset($_SESSION['child_lrno']) ? $run->getLRNOfStud() : $_SESSION['child_lrno']; ?>
      <div id="attendance-container-load">
         <div class="attendance widget">
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
                  <table id="customParentTable" class="display">
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
                     <tfoot>
                        <tr>
                           <td colspan="2"><font color="orange">Number of Days Late</font></td>
                           <td><b><u><?php $run->getNoOfDaysLate($lrno); ?></u></b></td>
                        </tr>
                        <tr>
                           <td colspan="2"><font color="red">Number of Days Absent</font></td>
                           <td><b><u><?php $run->getNoOfDaysAbsent($lrno); ?></u></b></td>
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
<?php if (isset($_SESSION['child_lrno'])) unset($_SESSION['child_lrno']); ?>

