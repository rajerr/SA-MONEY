import { TransactionsService } from './../services/transactions.service';
import { Component, OnInit } from '@angular/core';
import { Transaction } from '../model/transaction';

@Component({
  selector: 'app-user',
  templateUrl: './user.page.html',
  styleUrls: ['./user.page.scss'],
})
export class UserPage implements OnInit {

  transactions: Transaction []=[];
  date: string;
  solde: number;
  constructor(private transService: TransactionsService) { }

  ngOnInit() {
    this.transService.getTransactionByUser().subscribe((transaction)=>{
      this.transactions = transaction;
      console.log(transaction);
      this.date = transaction[1]['compte']['dateCreation'];
      this.solde = transaction[1]['compte']['solde'];
      console.log(this.date);
      console.log(this.solde);
    })
  }

}
