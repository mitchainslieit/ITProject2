<?php require 'app/model/faculty-funct.php'; $getFactFunct = new FacultyFunct(); ?>
<?php
    if(isset($_POST['submit-grades'])) {
        $getFactFunct->submitGrades($_POST);
    } else if(isset($_POST['submit-core-values'])) {
        $getFactFunct->submitCoreValues($_POST);
    }
?>
    <div class="contentpage">
        <div class="row">
            <div class="newwidget widget">
                <div class="classattendance header">
                    <p>
                        <i class="fas fa-th"></i>
                        <span>History of Grades</span>
                    </p>
                    <p>School Year: <?php $getFactFunct->getSchoolYear(); ?></p>
                </div>
                <div class="gradesContent widgetcontent">
                    <div class="tabs">
                        <ul>
                            <li><a href="#section1">Subjects Handled</a></li>
                            <?php if ($getFactFunct->checkIfOldAdviser() === true) { ?>
                                <li><a href="#section2">Classes Handled</a></li>
                            <?php } ?>
                        </ul>                       
                        <div id="section1">
                            <div class="selects">
                                <div class="cont">
                                    <h3>Year: </h3>
                                    <select id="grades-history-select-year" class="form-control">
                                        <?php $getFactFunct->getAllHandledSubject_year(); ?>
                                    </select>
                                </div>
                                <div class="cont">
                                    <h3>Section: </h3>
                                    <select id="grades-history-select-section" class="form-control">
                                        <?php $getFactFunct->getAllHandledSubject_section(); ?>
                                    </select>
                                </div>
                                <div class="cont">
                                    <h3>Subject: </h3>
                                    <select id="grades-history-select-subject" class="form-control">
                                        <?php $getFactFunct->getAllHandledSubject_subject(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="widget">
                                <table id="grades-history-subject-handled">
                                    <thead>
                                        <tr>
                                           <th>Student Name</th> 
                                           <th>1st Quarter</th>
                                           <th>2nd Quarter</th>
                                           <th>3rd Quarter</th>
                                           <th>4th Quarter</th>
                                           <th>Subject</th>
                                           <th>Section</th>
                                           <th>year</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $getFactFunct->getAllHandledSubject(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if ($getFactFunct->checkIfOldAdviser() === true) { ?>
                            <div id="section2">
                                <div class="selects">
                                    <div class="cont">
                                        <h3>Year: </h3>
                                        <select id="grades-history-handled-select-year" class="form-control">
                                            <?php $getFactFunct->getAllHandledClasses_year(); ?>
                                        </select>
                                    </div>
                                    <div class="cont">
                                        <h3>Section: </h3>
                                        <select id="grades-history-handled-select-section" class="form-control">
                                            <?php $getFactFunct->getAllHandledClasses_section(); ?>
                                        </select>
                                    </div>
                                    <div class="cont">
                                        <h3>Subject: </h3>
                                        <select id="grades-history-handled-select-subject" class="form-control">
                                            <?php $getFactFunct->getAllHandledClasses_subject(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="widget">
                                    <table id="grades-history-classes-handled">
                                        <thead>
                                            <tr>
                                               <th>Student Name</th> 
                                               <th>1st Quarter</th>
                                               <th>2nd Quarter</th>
                                               <th>3rd Quarter</th>
                                               <th>4th Quarter</th>
                                               <th>Subject</th>
                                               <th>Teacher</th>
                                               <th>Section</th>
                                               <th>year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $getFactFunct->getAllHandledClasses(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>