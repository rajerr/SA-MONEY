import { Router } from '@angular/router';
import { TransactionsService } from './../services/transactions.service';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { AlertController } from '@ionic/angular';

@Component({
  selector: 'app-bloquer-transaction',
  templateUrl: './bloquer-transaction.page.html',
  styleUrls: ['./bloquer-transaction.page.scss'],
})
export class BloquerTransactionPage implements OnInit {

  segmentChanged(ev: any) {
    console.log('Segment changed', ev);
  }


  choix: string | any;
  Form: FormGroup | any;
  codeTrans: string|any;
  numeroCni: string | any;
  nomCompletEmet: string | any;
  telephoneEmet: string | any;
  nomCompletBenef: string | any;
  telephoneBenef: string | any;
  montantRetire: string | any;
  dateEnvoie:string|any;
  typeTransaction: string | any = 'Retrait';
  transactions : any = [];

  constructor(
    private transactionService:TransactionsService,
    private alertCont: AlertController,
    private formBuilder: FormBuilder,
    private router: Router
  ) { }

  getTransactionByCode():void{
    this.transactions = this.transactionService.getTransactionByCodeTrans(this.Form.value).subscribe((trans)=>{
    console.log(trans);
    this.transactions = trans;
    this.nomCompletEmet= trans["nomCompletEmet"];
    this.telephoneEmet= trans["telephoneEmet"];
    this.nomCompletBenef= trans["nomCompletBenef"];
    this.telephoneBenef= trans["telephoneBenef"];
    this.montantRetire= trans["montantRetire"];
    this.dateEnvoie= trans["dateEnvoie"];
    this.numeroCni= trans["numeroCni"]
    this.choix = "beneficiaire"
  })
}
  ngOnInit() {
    this.Form = this.formBuilder.group({
      codeTrans: ['', Validators.required],
    });
  }
 async onAnnuler(){
   if (this.Form.invalid) {
     return;
   }
    const alert = await this.alertCont.create({
      header:'Confirmation',
      cssClass:'alert',
      mode:'ios',
      message:`<ion-list justify-content-center>                   
                      <ion-label>Etes-vous sur de vouloir annuler cette transaction?? <p> ${this.codeTrans}</p> de transaction </ion-label>
                </ion-list>`,
      buttons:[
        {
          text:'Annuler'
        },
        {
          text:"confirmation",
          cssClass:'confirmer',
          handler:()=>{
            // console.log(this.DepotForm.value);
            this.transactionService.bloquerTransaction(this.Form.value).subscribe(async(transaction)=>{
              console.log(transaction);
              this.transactions = transaction;
              this.router.navigateByUrl('/admin')

            },
            async () =>{
              const errormsg = await this.alertCont.create(({
                header:'Echec',
                subHeader:'Details',
                cssClass:'alert',
                mode:'ios',
                message:`votre transaction a déjà été rétiré !</p><ion-icon name="ion-circle-outline" [color]="#e04055"></ion-icon>`
              }));
              await errormsg.present();
            })
          }
        }
      ]
    });
    await alert.present();
  }
}
