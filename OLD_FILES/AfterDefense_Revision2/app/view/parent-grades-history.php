<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
<div class="contentpage">
    <div class="row">
        <div class="widget">
            <div class="header">
                <p>
                    <i class="fas fa-list-ol fnt"></i>
                    <span>Children's Transcript of Record</span>
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

                    <div class="tl"><b>School Year:</b>
                        <select name="year" class="year" id="select-year">
                            <option value =""> No Selected </option> 
                            <?php
                                $run->getAllYearsHistory($stud_lrno); 
                            ?>  
                        </select>
                    </div>
                <br>
                <div class="cont3">
                    <div class="table-scroll">
                        <div class="table-wrap" id="table-grade-student">
                            <table id="grade-student-history" class="display">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Final Grade</th>
                                        <th>Remarks</th>
                                        <th>School Year</th>
                                        <th>lrno</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($run->getNameOfStud() as $row) {
                                        extract($row);
                                        $run->getAllChildTranscript($stud_lrno); 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
