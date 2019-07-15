<?php require 'app/model/parent_funct.php'; $run= new ParentFunct ?>
<div class="contentpage">
    <div class="row">
            <div class="attendance widget">
      <div class="innercont1">
         <div class="sample">
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
            </div>
         </div>
      </div>
   </div>
        <div class="account widget">
            <div class="container contleft">
                <div class="innercont1">
                    <div class="header">
                        <p>
                            <i class="fas fa-history fnt"></i>
                            <span>History of Payment</span>
                        </p>
                        <p>School Year: <?php $run->getSchoolYear(); ?></p>
                    </div>
                        <div class="eventcontent">
                                <span><b>Miscellaneous Fee: <u> &#x20B1; <?php $run->getMiscellaneousFee(); ?></u></b></span>
                        <div id="children-totals">
                            <div class="container">
                                <?php $lrno = !isset($_SESSION['child_lrno']) ? $run->getLRNOfStud() : $_SESSION['child_lrno']; ?>
                                    <span><b>LRN Number:</b> <?php echo $lrno; ?></span>
                                <div class="customContent">
                                    <table id="customParentTable" class="display">
                                            <thead>
                                                <tr>
                                                    <th>Payment Date</th>
                                                    <th>Current Balance</th>
                                                    <th>Amount Paid</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $run->getPaymentHistory($lrno); ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2"><b>TOTAL AMOUNT:</b></td>
                                                    <td><b><font color="green"><?php $run->getTotalPayment($lrno); ?></font></b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <?php if (isset($_SESSION['child_lrno'])) unset($_SESSION['child_lrno']); ?>
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
        </div>
    </div>
    </div>
</div>
</div>
</div>

