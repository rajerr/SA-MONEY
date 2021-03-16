import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ConfirmDepotPageRoutingModule } from './confirm-depot-routing.module';

import { ConfirmDepotPage } from './confirm-depot.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ConfirmDepotPageRoutingModule
  ],
  declarations: [ConfirmDepotPage]
})
export class ConfirmDepotPageModule {}
