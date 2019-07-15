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
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php $run->getBalance(); ?></p>
                    </div>
                    <div class="head" id="soahead">
                        <?php if($run->getPayYear() !== false) { ?>
                        <p id="hpheader"> 
                            <span><b style="font-size: 22px;">Payment Transactions</b></span><br>
                            <p class="align-left" id="hpheader"> 
                                <span> Year of Payment: 
                                    <select name="year" id="filter-year">
                                    <?php
                                        foreach ($run->getPayYear() as $row) {
                                            extract($row);
                                            echo '<option value='.$year.'>'.$year.'</option>';
                                        }
                                    ?>
                                    </select>
                                </span>  
                        </p>
                        <div id="filter-year-stud">
                            <table id="student-payment-history" class="display">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
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
                     <?php } else { ?>
                        <div>No payments have been made yet</div>
                    <?php } ?>
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
    </span>
