import { User } from './../model/user';
import { TransactionsService } from './../services/transactions.service';
import { Component, OnInit } from '@angular/core';
import { Transaction } from '../model/transaction';

@Component({
  selector: 'app-transactions-admin',
  templateUrl: './transactions-admin.page.html',
  styleUrls: ['./transactions-admin.page.scss'],
})
export class TransactionsAdminPage implements OnInit {

  segmentChanged(ev: any) {
    console.log('Segment changed', ev);
  }

  choix: string | any;
  transactions: Transaction []=[];
  data: Transaction []=[];
  dateEnvoie: string;
  typeTransaction: string;
  montantEnvoye: string;
  user:User;
  frais:number;
  constructor(private transService: TransactionsService) { }

  ngOnInit() {
    this.choix = 'mestransactions';

    this.transService.getTransactionByAgence().subscribe((transaction)=>{
      console.log(transaction[1]['compte']['solde']);
      this.transactions = transaction;
    })

    this.transService.getTransactionByUser().subscribe((trans)=>{
      // console.log(trans);
      this.data = trans;
    })
  }

}
