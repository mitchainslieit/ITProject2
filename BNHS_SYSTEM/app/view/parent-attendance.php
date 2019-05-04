<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
    <div class="contentpage">
        <div class="row">
            <div id="attendance-container">
                    <div id="attendance-container-load">
                        <div class="attendance widget">
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
                                           <select name="student" class="student" id="select-attendance">
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
                                <div class="eventcontent" id="detail-attendance-child">
                                    <table id="table-attendance" class="display">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Subject</th>
                                                <th>Remarks</th>
                                                <th>Lrno</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $run->getAttDateRemarks(); ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2"><font    color="orange"><b>Number of Days Late</b></font></td>
                                                <td><b><u><?php $run->getNoOfDaysLate(); ?></u></b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><font color="red"><b>Number of Days Absent</b></font></td>
                                                <td><b><u><?php $run->getNoOfDaysAbsent(); ?></u></b></td>
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