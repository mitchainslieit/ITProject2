<?php require 'app/model/student-funct.php'; $run= new studentFunct ?>
<div class="contentpage">
    <div class="row">
        <div class="coreValues">
            <div class="header">
                <p>
                    <i class="fas fa-star-half-alt fnt"></i>
                    <span>Core Value</span>
                </p>
                <p>School Year:
                    <?php $run->getSchoolYear(); ?>
                </p>
            </div>
            <div class="        " style="padding: 15px 0;">
                <table id="grade-student">
                    <tr>
                        <th>CORE VALUES</th>
                        <th>1ST GRADING</th>
                        <th>2ND GRADING</th>
                        <th>3RD GRADING</th>
                        <th>4TH GRADING</th>
                    </tr>
                    <?php $run->getCV($_SESSION['accid']); ?>
                </table>
            </div>
        </div>
        <p style="text-align:left; color:blue;font-weight: 600; font-size: 18px; padding-left: 15px; padding-top: 15px; ">LEGEND FOR CORE VALUES</p>
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
</div>