import { FraisService } from './../services/frais.service';
import { AuthService } from './../services/auth.service';
import { TransactionsService } from './../services/transactions.service';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';

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
  // montant: string | any;
  montantEnvoye: string | any;
  // frais: string | any;
  type: string | any = 'Depot';
  frais: number;
  montantTotal:number;

  constructor(
    private fraisService: FraisService,
    private transactuinService:TransactionsService,
    private formBuilder: FormBuilder,
    private router: Router
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

  onSubmit():void{
    if (this.DepotForm.invalid){
      return;
    }
    console.log(this.DepotForm.value);
    this.transactuinService.depot(this.DepotForm.value).subscribe((depot)=>{
      console.log(depot);
      this.depots = depot;
    })
  }
}