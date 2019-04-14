<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
<div class="contentpage">
   <div class="row">
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
                  <div class="table-wrap">
                     <table>
                        <tr>
                           <td>Name </td>
                           <td>                              
                              <select name="student" class="student" id="select-children">
                                 <?php 
                                    foreach($run->getNameOfStud() as $row) {
                                    extract($row);
                                    echo '
                                    <option value="'.$stud_lrno.'" name="stud_name" '.(isset($_SESSION['child_lrno']) && $_SESSION['child_lrno'] === $stud_lrno ? 'selected' : '').'> '.$name.'  
                                    </option>
                                    ';
                                    }
                                 ?>
                              </select>
                           </td>
                        </tr>
                        <tr>
                           <td>Grade Level & Section</td>
                           <td><?php $run->getChildLevelSection(); ?></td>
                        </tr>
                        <tr>
                           <td>Number of Days Present</td>
                           <td><?php $run->getNoOfDaysPresent(); ?></td>
                        </tr>
                        <tr>
                           <td>Number of Days Absent</td>
                           <td><?php $run->getNoOfDaysAbsent(); ?></td>
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
                  <div class="eventcontent">
                      <table id="customParentTable" class="display">
                        <thead>
                           <tr>
                              <th>Date</th>
                              <th>Type</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $run->getAttDateRemarks(); ?> 
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

