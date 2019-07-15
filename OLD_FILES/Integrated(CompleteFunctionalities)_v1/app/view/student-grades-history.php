<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>

<div class="contentpage">
    <div class="row">
        <div id="widget">
            <div class="header">
                <p><i class="fas fa-file fnt"></i><span>Transcript of Records</span></p>
            </div>
            <div class="widgetcontent">
                <table id="student-history-of-grades">
                    <thead>
                        <th>Subject</th>
                        <th>Grade</th>
                        <th>Remarks</th>
                    </thead>
                    <tbody>
                        <?php $run->getTranscript(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>