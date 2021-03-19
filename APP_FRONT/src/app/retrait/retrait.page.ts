import { Router } from '@angular/router';
import { TransactionsService } from './../services/transactions.service';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AlertController } from '@ionic/angular';

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
    ) { 
   console.log(this.transactionService.getTransactionByCodeTrans(445451405));

    }

    getTransactionByCode():void{
        this.transactions = this.transactionService.getTransactionByCodeTrans(this.RetraitForm.value).subscribe((trans)=>{
        console.log(trans);
        this.transactions = trans;
        this.nomCompletEmet= trans["nomCompletEmet"];
        this.telephoneEmet= trans["telephoneEmet"];
        this.nomCompletBenef= trans["nomCompletBenef"];
        this.telephoneBenef= trans["telephoneBenef"];
        this.montantRetire= trans["montantRetire"];
        this.dateEnvoie= trans["dateEnvoie"];
        this.choix = "beneficiaire"

      })
    }

  ngOnInit() {

    this.RetraitForm = this.formBuilder.group({
      codeTrans: ['', Validators.required],
      numeroCni: ['', Validators.required],
      typeTransaction:['Retrait'],
    });
  }

  async onSubmit(){
    if (this.RetraitForm.invalid){
      return;
    }
    const alert = await this.alertCont.create({
      header:'Confirmation',
      cssClass:'alert',
      mode:'ios',
      message:`<ion-list justify-content-center>
                    <ion-item>                     
                      <ion-label>CNI Emetteur <p> ${this.numeroCni}</p></p></ion-label>
                    </ion-item>
                    <ion-item>
                      <ion-label>Code Transfert <p> ${this.codeTrans}</p></ion-label>
                    </ion-item>
                    <ion-item>
                      <ion-label>Montant Retire <p> ${this.montantRetire}</p></ion-label>
                    </ion-item>
                    <ion-item>
                    <ion-label> Date Envoie <p> ${this.dateEnvoie}</p></ion-label>
                    </ion-item>
                    <ion-item>
                    <ion-label> Emetteur <p> ${this.nomCompletEmet}</p></ion-label>
                    </ion-item>
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
            this.transactionService.retrait(this.RetraitForm.value).subscribe(async(retrait)=>{
              console.log(retrait);
              this.retraits = retrait;
              this.router.navigateByUrl('/admin')
            },
            async () =>{
              const errormsg = await this.alertCont.create(({
                header:'Erreur',
                subHeader:'Details',
                cssClass:'alert',
                mode:'ios',
                message:`la transaction a déja été annulé ou rérité impossible de retirer! </p><ion-icon name="ion-circle-outline" [color]="#e04055"></ion-icon>`
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
