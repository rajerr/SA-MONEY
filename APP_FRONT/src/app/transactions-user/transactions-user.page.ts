import { Transaction } from './../model/transaction';
import { TransactionsService } from './../services/transactions.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-transactions-user',
  templateUrl: './transactions-user.page.html',
  styleUrls: ['./transactions-user.page.scss'],
})
export class TransactionsUserPage implements OnInit {

  constructor(private transService:TransactionsService) { }

  transactions: Transaction []=[];
  dateEnvoie: string;
  typeTransaction: string;
  montantEnvoye: string;

  ngOnInit() {
    this.transService.getTransactionByUser().subscribe((transaction)=>{
      this.transactions = transaction;
      console.log(transaction[1]['compte']['solde']);

      // console.log(this.transactions);
      // for (let index of this.transactions) {
      //   console.log(index);
        
      // }


    })
  }
}
