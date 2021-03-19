import { TransactionsService } from './../services/transactions.service';
import { Component, OnInit } from '@angular/core';
import { Transaction } from '../model/transaction';

@Component({
  selector: 'app-commissions',
  templateUrl: './commissions.page.html',
  styleUrls: ['./commissions.page.scss'],
})
export class CommissionsPage implements OnInit {

  constructor(private transService: TransactionsService) { }
  transactions: Transaction [] = [];

  ngOnInit() {
    this.transService.getTransactionByAgence().subscribe((transaction)=>{
      console.log(transaction);
      this.transactions = transaction;
    })
  }
}
