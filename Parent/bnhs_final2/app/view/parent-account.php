<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
<div class="contentpage">
    <div class="row">
        <div class="account widget">
            <div class="container contleft">
                <div class="innercont1">
                    <div class="header">
                        <p>
                            <i class="fas fa-history fnt"></i>
                            <span>History of Payment</span>
                        </p>
                    </div>
                    <div class="eventcontent">
                        <span>Miscellaneous Fee: &#x20B1; <?php $run->getMiscellaneousFee(); ?></span>
                        <span>Name: <?php $run->getNameOfStud(); ?></span>
                        <center>
                            <table>
                                <tr>
                                    <th>LRN No.</th>
                                    <th>Current Balance</th>
                                    <th>Amount Paid</th>
                                    <th>Payment Date</th>
                                </tr>
                            <tr>
                                <?php $run->getPaymentHistory(); ?>
                            </tr>
                        </table>
                        </center>
                        <div class="cont4">
                            <p>Showing 1 to 5 of 250 entries</p>
                            <div class="pagination">
                                <button class="btn previous">Previous</button>
                                <button class="btn active">1</button>
                                <button class="btn next">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container contright">
                <div class="innercont1">
                    <div class="header">
                        <p>
                            <i class="fas fa-money-bill-alt"></i>
                            <span>Breakdown of Fees</span>
                        </p>
                    </div>
                    <div class="eventcontent">
                        <div class="table-scroll">
                            <div class="table-wrap">
                                <table>
                                    <tr>
                                        <th>Breakdown</th>
                                        <th>Amount</th>
                                    </tr>
                                    <?php $run->getBreakdownOfFees(); ?>
                                    <tr>
                                        <td><b>TOTAL AMOUNT:</b></td>
                                        <td><b><font color="green"><?php $run->getTotalBDOF(); ?></font></b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </span>
            </span>
        </div>
    </div>
</div>
</div>
</div>

