import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { FraisService } from './../services/frais.service';
import { Component, OnInit } from '@angular/core';
import { AlertController } from '@ionic/angular';

@Component({
  selector: 'app-calculateur',
  templateUrl: './calculateur.page.html',
  styleUrls: ['./calculateur.page.scss'],
})
export class CalculateurPage implements OnInit {

  montant : number;
  frais : number;
  
  constructor(
    private fraisService: FraisService,
    private alertConst : AlertController
  ) { 

  }
  

  ngOnInit() {
  }

 async getFraisMontant(montant:number){
  console.log(montant);

    this.frais = this.fraisService.getFrais(montant);
    this.montant = montant

    console.log(this.frais);
    console.log(this.montant);

    const alert = await this.alertConst.create({
      header:'Calculateur',
      cssClass:'alert',
      mode:'ios',
      message:`pour une transaction de ${this.montant}, le frais est égal à ${this.frais}`,
      buttons:[ 'Retour']
    });
    await alert.present();
  }
}
