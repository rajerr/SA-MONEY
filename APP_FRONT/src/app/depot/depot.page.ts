import { FraisService } from './../services/frais.service';
import { AuthService } from './../services/auth.service';
import { TransactionsService } from './../services/transactions.service';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AlertController } from '@ionic/angular';


@Component({
  selector: 'app-depot',
  templateUrl: './depot.page.html',
  styleUrls: ['./depot.page.scss'],
})
export class DepotPage implements OnInit {

  segmentChanged(ev: any) {
    console.log('Segment changed', ev);
  }

  choix: string | any;
  depots : any = [];
  DepotForm: FormGroup | any;
  numeroCni: string | any;
  nomCompletEmet: string | any;
  telephoneEmet: string | any;
  nomCompletBenef: string | any;
  telephoneBenef: string | any;
  montantEnvoye: string | any;
  type: string | any = 'Depot';
  frais: number;
  montantTotal:number;

  constructor(
    private fraisService: FraisService,
    private transactuinService:TransactionsService,
    private formBuilder: FormBuilder,
    private router: Router,
    private alertCont: AlertController
  ) {
    console.log(this.fraisService.getFrais(50000));

   }

   getFrais(montant:number){
     this.frais = this.fraisService.getFrais(montant);
     this.montantTotal = Number(this.frais) + Number(montant);
   }

  ngOnInit() {
    this.choix = 'emetteur';

    this.DepotForm = this.formBuilder.group({
      numeroCni: ['', Validators.required],
      nomCompletEmet: ['', Validators.required],
      telephoneEmet: ['', Validators.required],
      nomCompletBenef: ['', Validators.required],
      telephoneBenef: ['', Validators.required],
      montantEnvoye: ['', Validators.required],
      typeTransaction:['Depot'],
    });
  }

  async onSubmit(){
    if (this.DepotForm.invalid){
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
                      <ion-label>Nom et Prenom Emetteur <p> ${this.nomCompletEmet}</p></ion-label>
                    </ion-item>
                    <ion-item>
                      <ion-label>Telephone Emetteur <p> ${this.telephoneEmet}</p></ion-label>
                    </ion-item>
                    <ion-item>
                    <ion-label>Nom et Prenom Emetteur <p> ${this.nomCompletBenef}</p></ion-label>
                  </ion-item>
                  <ion-item>
                    <ion-label>Telephone Emetteur <p> ${this.telephoneBenef}</p></ion-label>
                  </ion-item>
                    <ion-item>
                      <ion-label>Montant <p> ${this.montantTotal}</p></ion-label>
                    </ion-item>
                </ion-list>`,
      buttons:[
        {
          text:'Annuler'
        },
        {
          text:"confirmer",
          cssClass:'confirmer',
          handler:()=>{
            // console.log(this.DepotForm.value);
            this.transactuinService.depot(this.DepotForm.value).subscribe(async(depot)=>{
              // console.log(depot);
              this.depots = depot;
              const message = await this.alertCont.create({
                header:'Envoie reussi',
                subHeader:'Details',
                cssClass:'alert',
                mode:'ios',
                message:`Votre transfert de ${this.depots.montantEnvoye} à ${this.depots.nomCompletBenef} le ${this.depots.dateEnvoie || depot}`
                +`<ion-item>
                    <ion-label>Code Envoie <p> ${this.depots.codeTrans}</p></ion-label>
                  </ion-item>`,
                buttons:[
                  {
                    text:'cancel',
                    cssClass:'s'
                  },
                  {
                    text:'sms',
                    cssClass:'sms',
                    handler:()=>{
                      this.router.navigateByUrl('/user')
                    }
                  }
                ]
              });
              await message.present();
            },
            async () =>{
              const errormsg = await this.alertCont.create(({
                header:'Echec Envoie',
                subHeader:'Details',
                cssClass:'alert',
                mode:'ios',
                message:`Une erreur est survenue lors de transfer! </p><ion-icon name="ion-circle-outline" [color]="#e04055"></ion-icon>`
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