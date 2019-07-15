<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
    <div class="contentpage">
        <div class="row">
            <div class="widget">
                <div class="header">
                    <p>
                        <i class="fas fa-list-ol fnt"></i>
                        <span>Child Grades</span>
                    </p>
                    <p>School Year:
                        <?php $run->getSchoolYear(); ?>
                    </p>
                </div>
                <div class="eventcontent">
                    <div class="sample">
                        <div class="tl"><b>Child Name:</b>
                            <select name="student" class="student" id="select-child-grade">
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
                    <br>
                    <div class="cont3">
                        <div class="table-scroll">
                            <div class="table-wrap" id="table-grade-student">
                                <table id="grade-student" class="display">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>1st Grading</th>
                                            <th>2nd Grading</th>
                                            <th>3rd Grading</th>
                                            <th>4th Grading</th>
                                            <th>Final Grade</th>
                                            <th>Remarks</th>
                                            <th>Details</th>
                                            <th>lrno</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($run->getNameOfStud() as $row) {
                                            extract($row);
                                            $run->getChildGrade($stud_lrno); 
                                        }
                                        ?>
                                    </tbody>
                                          <tr>
                                             <td colspan="5" style="font-weight: 700;">GENERAL WEIGHTED AVERAGE (GWA): </td>
                                             <td>
                                                <?php
                                                    foreach($run->getNameOfStud() as $row) {
                                                        extract($row);
                                                        $run->getGeneralAverage($stud_lrno); 
                                                    }
                                                ?>
                                             </td>
                                             <td>
                                                <?php
                                                    foreach($run->getNameOfStud() as $row) {
                                                        extract($row);
                                                        $run->getGeneralAverageRemarks($stud_lrno); 
                                                    }
                                                ?>
                                             </td>
                                             <td></td>
                                         </tr>       
                                         <tr>
                                            <td colspan="5" style="font-weight: 700;">GRADE LEVEL STATUS (PROMOTION): </td>
                                            <td colspan="3">
                                                <?php
                                                    foreach($run->getNameOfStud() as $row) {
                                                        extract($row);
                                                        $run->getPromotion($stud_lrno); 
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <p style="text-align:left; color:blue;font-weight: 600; font-size: 18px; margin-left: 15px">LEGEND FOR GRADES</p>
            <div class="cont4" style="margin-left: 15px;">
                <table>
                    <tr>
                        <th>DESCRIPTION</th>
                        <th>GRADING</th>
                        <th>REMARKS</th>
                    </tr>
                    <tr>
                        <td>Outstanding</td>
                        <td>90-100</td>
                        <td><font color="green"><b>Passed</b></font></td>
                    </tr>
	                    <td>Very Satisfactory</td>
	                    <td>85-89</td>
	                    <td><font color="green"><b>Passed</b></font></td>
                    </tr>
                    <tr>
                        <td>Satisfactory</td>
                        <td>80-84</td>
                        <td><font color="green"><b>Passed</b></font></td>
                    </tr>
                    <tr>
                        <td>Fairly Satisfactory</td>
                        <td>75-79</td>
                        <td><font color="green"><b>Passed</b></font></td>
                    </tr>
                    <tr>
                        <td>Did Not Meet Expectations</td>
                        <td>74 and below</td>
                        <td><font color="red"><b>Failed</b></font></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>