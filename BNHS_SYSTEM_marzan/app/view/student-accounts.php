<?php require 'app/model/student-funct.php'; $run = new studentFunct ?>

<div class="contentpage">
    <div class="row">
        <div class="eventwidget">
            <div class="contleft">
                <div class="header">
                    <p> 
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Statement of Accounts</span>
                    </p>
                </div>
                <div class="cont" id="soa">      
                    <div class="conthead">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Balance:  <b>&#8369</b> <?php $run->getBalance(); ?></p>

                    </div>
                    <div class="head" id="soahead">
                        <p id="hpheader"> 
                            <span><b>History of Payment</b></span></p><br>
                            <p class="align-left" id="hpheader"> <span> Year of Payment: <select name="year" id="filter-year">
                                <?php 
                                foreach ($run->getPayYear() as $row) {
                                    extract($row);
                                    echo '<option value='.$year.'>'.$year.'</option>';
                                }
                                ?>
                            </select>  
                        </p>
                        <div id="filter-year-stud">
                            <table id="student-payment-history" class="display">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th class="align-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $run->getPaymentHisto(); ?>
                                </tbody>
                                <tfoot>
                                    <?php $run->getTotal(); ?>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contright">
                <div class="widget">
                    <div class="header">
                        <p><i class="fas fa-file fnt"></i><span> Breakdown</span></p>
                    </div>
                    <div class="widgetcontent">
                        <table id = "breakdown">
                            <tr>
                                <th>Description</th>
                                <th class="align-right">Amount</th>
                            </tr>
                            <?php $run->getBreakdown();?>
                        </table>
                    </div>
                </div>
            </div>
        </div>