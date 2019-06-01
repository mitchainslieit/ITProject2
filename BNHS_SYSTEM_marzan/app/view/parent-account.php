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
                        <p>School Year: <?php $run->getSchoolYear(); ?>
                               </div>
                               <div class="eventcontent">
                                <p><b>Miscellaneous Fee: <u> &#x20B1; <?php $run->getMiscellaneousFee(); ?></u></b></p>
                                <div class="tl"> <b>Child Name: </b>
                                    <select name="student" class="student" id="select-children">
                                        <?php 
                                        foreach($run->getNameOfStud() as $row) {
                                           extract($row);
                                           echo '
                                           <option value="'.$stud_lrno.'" name="stud_name"> '.$name.' - '.$section.'  </option>
                                           ';
                                       }
                                       ?>
                                   </select>
                                   <br>
                                   <b>Year of Payment: </b>
                                   <select name="year" class="year" id="select-year">
                                     <option value =""> No Selected </option> 
                                     <?php $run->filterPaymentYear(); ?>
                                   </select>
                               </div>
                               <div id="children-totals">
                                <div class="container">
                                    <div class="customContent">
                                       <b>LRN Number: </b><?php echo $run->getLRNOfStud(); ?><br>
                                       <b>Balance: </b><?php $run->getBalance(); ?>
                                       <table id="customParentTable" class="display">
                                        <thead>
                                            <tr>
                                                <th>Payment Date</th>
                                                <th>Amount Paid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $run->getPaymentHistory() ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td><b>TOTAL AMOUNT:</b></td>
                                                <td><b><font color="green"><?php $run->getTotalPayment(); ?></font></b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container contright">
                <div class="innercont1">
                    <div class="header">
                        <p>
                            <i class="fas fa-money-bill-alt fnt"></i>   Breakdown of Fees
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
        </div>
    </div>
</div>