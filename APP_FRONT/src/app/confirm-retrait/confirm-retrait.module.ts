import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ConfirmRetraitPageRoutingModule } from './confirm-retrait-routing.module';

import { ConfirmRetraitPage } from './confirm-retrait.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ConfirmRetraitPageRoutingModule
  ],
  declarations: [ConfirmRetraitPage]
})
export class ConfirmRetraitPageModule {}
