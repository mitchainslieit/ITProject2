<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
    <div class="contentpage">
        <div class="row">
            <div class="widget">
                <div class="header">
                    <p>
                        <i class="fas fa-star-half-alt fnt"></i>
                        <span>Child Core Value</span>
                    </p>
                    <p>School Year:
                        <?php $run->getSchoolYear(); ?>
                    </p>
                </div>
                <div class="eventcontent">
                    <div class="sample">
                        <div class="tl"><b>Child Name:</b>
                            <select name="student" class="student" id="select-core-value">
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
                    <?php $lrno = !isset($_SESSION['child_lrno']) ? $run->getLRNOfStud2() : $_SESSION['child_lrno']; ?>
                            <div class="cont3" id="table-core-value">
                                <table id="coreValue-student">
                                    <thead>
                                        <tr>
                                            <th>Core Values</th>
                                            <th>1st Grading</th>
                                            <th>2nd Grading</th>
                                            <th>3rd Grading</th>
                                            <th>4th Grading</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $run->getCV($lrno); ?>   
                                        </tr> 
                                    </tbody>       
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <br>
            <p style="text-align:left; color:blue;font-weight: 600; font-size: 18px; padding-left: 30px;">LEGEND FOR CORE VALUES</p>
            <div class="cont4" style="padding-left: 50px">
                <table>
                    <tr>
                        <th colspan="2">Non-numerical Rating</th>
                        <th>Marking</th>
                    </tr>
                    <tr>
                        <td>Always Observed</td>
                        <td colspan="2"><b>AO</b></td>
                    </tr>
                        <td>Sometimes Observed</td>
                        <td colspan="2"><b>SO</b></td>
	                </tr>
                    <tr>
                        <td>Rarely Observed</td>
                        <td colspan="2"><b>RO</b></td>
                    </tr>
                    <tr>
                        <td>Not Observed</td>
                        <td colspan="2"><b>NO</b></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php if (isset($_SESSION['child_lrno'])) unset($_SESSION['child_lrno']); ?>