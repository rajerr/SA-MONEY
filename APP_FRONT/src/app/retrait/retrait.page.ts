import { Router } from '@angular/router';
import { TransactionsService } from './../services/transactions.service';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-retrait',
  templateUrl: './retrait.page.html',
  styleUrls: ['./retrait.page.scss'],
})
export class RetraitPage implements OnInit {

  segmentChanged(ev: any) {
    console.log('Segment changed', ev);
  }


  choix: string | any;
  retraits : any = [];
  RetraitForm: FormGroup | any;
  codeTrans: string|any;
  numeroCni: string | any;
  typeTransaction: string | any = 'Retrait';
  transaction : string |any;

  constructor(
    private transactionService:TransactionsService,
    private formBuilder: FormBuilder,
    private router: Router
    ) { 
      console.log(this.transactionService.getTransactionByCodeTrans(119292801));

    }


  ngOnInit() {
    this.choix = 'beneficiaire';


    this.RetraitForm = this.formBuilder.group({
      codeTrans: ['', Validators.required],
      numeroCni: ['', Validators.required],
      typeTransaction:['Retrait'],
    });
  }

  getTransactionByCodeTrans(){
    this.transactionService.allTransactions().subscribe((trans)=>{
      // console.log(trans);
      for (let i = 0; i < trans.length; i++) {
        const item = this.transaction[i];
        console.log(this.transaction);
        if (item["codeTrans"] === this.RetraitForm.codeTrans.value) {
          console.log(trans)
          return item;
        }
      }
      // this.transaction = trans;
    })
  }

  onSubmit():void{
    if (this.RetraitForm.invalid){
      return;
    }
    console.log(this.RetraitForm.value);
    this.transactionService.retrait(this.RetraitForm.value).subscribe((retrait)=>{
      console.log(retrait);
      this.retraits = retrait;
    })
  }
}
