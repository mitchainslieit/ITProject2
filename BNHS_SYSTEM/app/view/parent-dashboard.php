<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
<div class="contentpage">
    <div class="row">
        <div class="dashboardWidget">
         
            <div class="contright">
                <div class="header">
                    <p> 
                        <i class="far fa-calendar-alt fnt"></i>
                        <span>Calendar</span>
                    </p>
                </div>
                <div class="eventcontent">
                    <div class="holidayBox">
                        <table id="eventDataTable">
                            <thead>
                                <tr>
                                    <th class="tleft title">Upcoming Holidays</th>
                                </tr>
                                <tr>
                                    <th class="tleft custPad2">Holiday Title</th>
                                    <th class="tleft custPad2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($run->showHolidays() as $row) {
                                    extract($row);
                                    echo'
                                    <tr>
                                    <td class="tleft custPad2 longTitle">'.$title.'</td>
                                    <td class="tleft custPad2">'.$date_start_1.'</td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="contleft">
                <div class="innercont2">
                    <div class="header">
                        <p> 
                            <i class="far fa-calendar-alt fnt"></i>
                            <span>Announcement</span>
                        </p>
                    </div>
                    <div class="eventcontent">
                        <div class="announcementBox">
                            <table id="announcementDataTable">
                                <thead>
                                    <tr>
                                        <th class="tleft title">Announcement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $run->getAnnouncements(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="eventBox">
                            <table id="eventDataTable">
                                <thead>
                                    <tr>
                                        <th class="tleft title">Events</th>
                                    </tr>
                                    <tr>
                                        <th class="tleft custPad2">Event Title</th>
                                        <th class="tleft custPad2">Event Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($run->showEvents() as $row) {
                                        extract($row);
                                        echo'
                                        <tr>
                                        <td class="tleft custPad2 longTitle">'.$title.'</td>
                                        <td class="tleft custPad2">'.$date_start_1.' - '.$date_end_1.'</td>
                                        </tr>';
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

