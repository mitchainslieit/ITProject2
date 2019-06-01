<?php require 'app/model/student-funct.php'; $run= new studentFunct ?>
<div class="contentpage">
    <div class="row">
        <div class="widget">
            <div class="header">
                <p>
                    <i class="fas fa-star-half-alt fnt"></i>
                    <span>Core Value</span>
                </p>
                <p>School Year:
                    <?php $run->getSchoolYear(); ?>
                </p>
            </div>
            <div class="eventcontent">
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
        <p style="text-align:left; color:blue;font-weight: 600; font-size: 18px;">LEGEND FOR CORE VALUES</p><br>
        <div class="cont4">
            <table id="legend">
                <tr>
                    <td><b>Non-numerical Rating</b></td>
                    <td colspan="2"><b>Marking</b></td>
                </tr>
                <tr>
                    <td>Always Observed</td>
                    <td colspan="2"><b>AO</font></b></td>
                </tr>
                <td>Sometimes Observed</td>
                <td colspan="2"><b>SO</font></b></td>
            </tr>
            <tr>
                <td>Rarely Observed</td>
                <td colspan="2"><b>RO</font></b></td>
            </tr>
            <tr>
                <td>Not Observed</td>
                <td colspan="2"><b>NO</font></b></td>
            </tr>
        </table>
    </div>
</div>
</div>