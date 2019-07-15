<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>  
<div class="contentpage">
  <div class="row">  
    <div class="dashboard widget">
      <div class="container contright">
        <div class="innercont1">
          <div class="header">
            <p> 
              <i class="fas fa-calendar-check fnt"></i>
              <span>Events</span>
            </p>  
          </div>
          <div class="eventcontent">
            <table>
              <tr>
                <th>Date</th>
                <th>Event</th>   
              </tr>
              <span><?php $run->getAnnouncements(); ?></span>
              </table>
            </div>
          </div>
        </div>
              <div class="container contleft">
        <div class="header">
          <p> 
            <i class="far fa-calendar-alt fnt"></i>
            <span>Event Calendar</span>
          </p>
        </div>
        <div class="eventcontent">
          <div class="cont4">
          <div id="calendar"></div>
        </div>
        </div>
      </div>  
      </div>  
    </div>  
  </div>


