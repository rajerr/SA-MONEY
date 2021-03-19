import { TransactionsService } from './../services/transactions.service';
import { AuthService } from './../services/auth.service';
import { Component, OnInit } from '@angular/core';
import { Transaction } from '../model/transaction';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.page.html',
  styleUrls: ['./admin.page.scss'],
})
export class AdminPage implements OnInit {
  
  transactions: Transaction []=[];
  date: string;
  solde: number;
  constructor(private transService: TransactionsService) {}

  ngOnInit() {
    this.transService.getTransactionByUser().subscribe((transaction)=>{
      this.transactions = transaction;
      console.log(transaction);
      this.date = transaction[1]['compte']['dateCreation'];
      this.solde = transaction[1]['compte']['solde'];
      console.log(this.date);
      console.log(this.solde);
      // console.log(this.transactions);
      // for (let index of this.transactions) {
      //   console.log(index);
        
      // }
    })
  }

}
